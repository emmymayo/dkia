

export default{
    
    props:['cbt','cbt_questions'],
    emits:['finished'],
    data(){
        return {
            questions:[],
            initializing:true,
            show_test:false,
            started:false,
            is_timed:true,
            seconds_left:0,
            timer_id:null,
            hours:0,
            mins:0,
            secs:0,
            current_question:0,
            student_results:[],
            test_ended:false,
            show_score:false,
            test_score:null,
            test_percent:null,
        }

    },
    methods:{
        async init(){
            await this.setStudentResults();
            this.initializing =false;
        },
        async startTest(){
            let secs_left = this.cbt.duration * 60;
            
            
                for(let i = 0;i<this.student_results.length;i++){
                    let student_result = this.student_results[i];
                    if(student_result.seconds_left==-1){
                        // End test if you find -1
                       return this.submit(true);
                        
                    }
                    if(secs_left==0){
                        this.is_timed=false;
                    }
                    if(student_result.seconds_left!=null && student_result.seconds_left > 0 ){
                        secs_left = student_result.seconds_left < secs_left ? student_result.seconds_left : secs_left;
                       
                    }
    
                }
            
            
            if(this.is_timed && !this.test_ended){
                this.seconds_left = secs_left;
                this.setTime();
                await this.updateAnswer(this.current_question,null,this.seconds_left)
                this.startTimer();
            }
            this.setShowTest(true);

            

        },
        setTime(){
            this.hours = parseInt(this.seconds_left/3600) ;
            this.mins = parseInt(this.seconds_left/60) > 59 ? '00' : parseInt(this.seconds_left/60) ;
            this.secs = parseInt(this.seconds_left%60) <10 ? '0'+parseInt(this.seconds_left%60) : parseInt(this.seconds_left%60);
        },
        startTimer(){
            if(this.seconds_left <= 1){
                this.timeUp();
                return;
            }
            // Prevent calling interval more than once
            if(this.timer_id != null){return;}
            this.timer_id = setInterval( this.decrementTime, 1000);
            

        },
        stopTimer(){
            clearInterval(this.timer_id);
        },
        decrementTime(){
            this.seconds_left = this.seconds_left - 1;
            this.setTime();
        },
        setShowTest(value){
            this.show_test = value;
        },
        setShowScore(value){
            this.show_score = value
        },
        setTestEnded(value){
            this.test_ended = value
        },
        async submit(quick_submit=false){
            if(!quick_submit){
                if(!confirm('Are you sure you want to end this test?')){
                    return;
                }
            }
            
            this.stopTimer();
            await this.updateAnswer(this.current_question,null,-1);
            this.setTestEnded(true);
            let test_result = await this.getScore();
            this.test_score = test_result.score;
            this.test_percent = (test_result.score/test_result.total)*100; 
            this.setShowScore(true);


        },
        to1Dp(value){
            return Math.round(value*10 + Number.EPSILON)/10 ;
        },
        async getScore(){
            let url = `/student-cbt-results/calculate?cbt_id=${this.cbt.id}`;
            try{
                let response = await axios.get(url);
                return response.data;
            }catch(error){
                toastr.error('Something went wrong');
                return null;
            }
        },
        async timeUp(){
            await this.submit(true);
        },
        async setStudentResults(){
            let url = `/student-cbt-results?cbt_id=${this.cbt.id}`;
            
            try{
                let response = await axios.get(url);
                this.student_results = response.data;
                for (let index = 0; index < this.student_results.length; index++) {
                    const student_result = this.student_results[index];
                    this.questions.forEach((question,index) => {
                        if(question.id === student_result.cbt_question_id){
                          
                            this.setSelectedOption(index,student_result.answer);
                        }
                    });
                    
                }

            }catch(error){
                toastr.error('Something went wrong.');
            }
        },
        
        async next(){
            // Assign before incrementing so update can provide after switching questions
            let question_index = this.current_question;
            this.current_question+=1;
            await this.updateAnswer(question_index,null,this.seconds_left);
        },
        async prev(){
            // Assign before incrementing so update can provide after switching questions
            let question_index = this.current_question;
            this.current_question-=1;
            await this.updateAnswer(question_index,null,this.seconds_left);
        },
        async setCurrentQuestion(index){
            this.current_question=index;
            await this.updateAnswer(index,null,this.seconds_left);
        },
        async bonusButton(){
            toastr.info('Proceed');
            await this.updateAnswer(index,null,this.seconds_left);
        },
        async updateAnswer(question_index, option_id = null, seconds_left=''){
            if(this.test_ended){
                return;
            }
            // Update selected answer
            // Update seconds Left by leaving option_id null

            // set updateStatus pending to show indicator if option_id is not null
            if(option_id!==null){
                this.questions[question_index].updatePending = true;
            }
            let url = `/student-cbt-results`;
            let data = {
                'cbt_id' : this.cbt.id,
                'cbt_question_id' : this.questions[question_index].id,
                'answer' : option_id ,
                'seconds_left' : seconds_left,
            }
            try{
                let response = await axios.patch(url, data);
                // set updateStatus success to show indicator if option_id is not null
                if(option_id!==null){
                    this.questions[question_index].updatePending = false;
                }
              
            }catch(error){
               toastr.error('Something went wrong')
            }
            // ignore if no valid option id
            if(option_id !== null){
                console.log('setting option'+option_id)
                this.setSelectedOption(question_index,option_id)
            }
            
            // Update every 45 seconds
            //setTimeout(this.updateAnswer(question_index,null,this.seconds_left),45000);
            
            
        },
        setSelectedOption(question_index,option_id){
            this.questions[question_index].selected_option = option_id;
        },
        getOptionNumbering(value){
            switch (value) {
                case 0:
                    return 'A. '
                    break;
                case 1:
                    return 'B. '
                    break;
                case 2:
                    return 'C. '
                    break;
            
                case 3:
                    return 'D. '
                    break;
                case 4:
                    return 'E. '
                    break;
            
                default:
                    break;
            }
        },
        shuffle(){
            let unshuffled = JSON.parse(JSON.stringify(this.cbt_questions));
            console.log(unshuffled);
            this.questions = unshuffled
            .map((value) => ({ value, sort: Math.random() }))
            .sort((a, b) => a.sort - b.sort)
            .map(({ value }) => value)
        }
        

    },
    created(){
         this.shuffle();
         this.init();

    },
    template:`
    <div class="bg-white p-2 " style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:9999;overflow-y-auto">
    <button v-if="test_ended" class="btn btn-default" @click="$emit('finished')"> Back </button>
        <table class="small table table-responsive-sm table-hover my-2">
            <tr>
                <th>Name</th>
                <td>{{cbt.name}}</td>
                <th>Subject</th>
                <td>{{cbt.subject.name}}</td>
            </tr>
            <tr>
                <th>Exam</th>
                <td>{{cbt.exam.name}}</td>
                <th>Duration (mins)</th>
                <td>{{cbt.duration}}</td>
            </tr>
        </table>
        <div v-if="!show_test && initializing==false" class="d-flex justify-content-center">
            <button @click="startTest" class="btn btn-success">Continue</button>
        </div>
        <div v-if="initializing" class="d-flex justify-content-center">
            <span class="lead text-center">Initializing...</span>
        </div>
        <div v-if="show_score" class="d-flex justify-content-center">
            <span class="h3 text-success">Score: {{to1Dp(test_percent)}}%</span>
        </div>
        <div v-show="show_test" >
            
            <div class="d-flex justify-content-end">
                <button @click="submit(false)" class="btn btn-success">Finish</button>
            </div>
            <div v-if="is_timed" class="text-center display-4 text-lg lead">{{hours}}:{{mins}}:{{secs}}</div>
            <div class="my-2">
                <span class="btn " 
                    :class="{'btn-info':current_question==index,
                            'bg-warning': questions[index].updatePending
                            
                            }"
                    @click="setCurrentQuestion(index)" v-for="(question,index) in questions" :key="index">
                {{index+1}}
                </span>
            </div>
            

            <div id="question_panel" class="mx-1 mx-md-3">
                <p class="my-1" id="current_question_instruction">Instruction: {{questions[current_question].instruction}}<p>
                <p class="" id="current_question"><span class="font-weight-bold">Question{{current_question+1}}. 
                    </span>{{questions[current_question].question}} 
                    (<span class="small">
                        {{questions[current_question].marks}} mark<span v-if="questions[current_question].marks>1">s</span>
                    </span>)
                <p>

                <div id="question_options" class="pl-3 mt-2">
                    <p  class="shadow d-block text-left btn" 
                        :class="{'bg-primary':questions[current_question].selected_option == option.id}"
                        @click="updateAnswer(current_question,option.id,seconds_left)"
                        v-for="(option,index) in questions[current_question].answers" :key="index">
                        {{getOptionNumbering(index)}}
                        {{option.value}}
                    </p>
                    <p v-if="questions[current_question].answers.length==0">
                        No Option? 
                        <button  @click="bonusButton" class="btn btn-warning">Click here</button>
                       
                    </p>
                </div>

                <div class="d-flex justify-content-between">
                    <button v-if="current_question>0"  @click="prev" class="btn btn-info">Prev</button>
                    <span v-else   >...</span>
                    <button v-if="current_question<(questions.length-1)" @click="next" class="btn btn-info">Next</button>
                </div>
            </div>
        </div>
    </div>
    `
}