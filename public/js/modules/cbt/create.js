/* 
    Type Information --- Type 1 = Mock, Type 2 = Cass1, Type 3 = cass2, Type 4 = cass3, Type 5 = cass4, Type 6 = tass
 */

export default {
    props:['subjects','exams'],
    emits:['saved'],
    data(){
        return {
            name:'',
            exam_id:null,
            subject_id:null,
            duration:null,
            type:null,
            cass_config:[],
            cbtTypes:[
                {'id':1, 'name':'Mock', 'key': 'mock' },
                {'id':2, 'name':'CASS 1', 'key': 'cass1' },
                {'id':3, 'name':'CASS 2', 'key': 'cass2' },
                {'id':4, 'name':'CASS 3', 'key': 'cass3' },
                {'id':5, 'name':'CASS 4', 'key': 'cass4'},
                {'id':6, 'name':'TASS', 'key': 'tass' },
            ],
            errorBag:{},
            
        }
    },
    methods:{
         save(){
            toastr.info("Saving data...",{timeout:10000});
            let url = "/cbts";
            let data = {
                'name':this.name,
                'exam_id':this.exam_id,
                'subject_id':this.subject_id,
                'duration':this.duration,
                'type':this.type,
            };

            axios.post(url,data)
                .then((response)=>{
                    toastr.clear();
                    toastr.success('Cbt Created Successfully');
                    this.$emit('saved');
                })
                .catch((error)=>{
                    toastr.clear();
                    toastr.error('Something Went wrong');
                    this.errorBag = error.response.data.errors;
                });
            
        },
        async initCassConfig(){
            try{
                let response = await axios.get('/configs?config_key=settings.cass');
                this.cass_config = response.data;
            } catch(error){
                
            }
            
            
        }
    },
    created(){
        this.initCassConfig();
    },
    template:`
     <form v-on:submit.prevent="save">
        <h3 class="text-dark-gray text-center mx-auto my-2 lead"> Carefully fill the form to create a new Computer-Based Test. </h3>
        <div class="my-3 mx-md-5 px-2 row justify-content-center">
            <div>
                <p class="text-danger " v-for="error of errorBag">{{error[0]}}</p>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="name"> Name </label>
                    <input id="name" type="text" v-model="name" class="form-control" required />
                </div>
                <div class="col-md-4 form-group">
                    <label for="exam"> Exam </label>
                    <select id="exam" v-model="exam_id" class="form-control" required>
                        <option value=""> </option>
                        <option 
                            :value="exam.id" v-for="exam in exams" :key="exam.id">{{exam.name}} </option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label for="subject"> Subject </label>
                    <select v-model="subject_id" class="form-control" required>
                        <option value=""> </option>
                        <option :value="subject.id" v-for="subject in subjects" :key="subject.id">{{subject.name}} </option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label for="duration"> Duration (minutes) </label>
                    <input id="duration" type="number" v-model="duration" class="form-control" required />
                </div>
                <div class="col-md-4 form-group">
                    <label for="type"> Type </label>
                    <select v-model="type" class="form-control" required>
                        <option v-show="cass_config.indexOf(type.key)!=-1 || type.key=='mock'" 
                        :value="type.id" v-for="type in cbtTypes" :key="type.id">{{type.name}} </option>
                    </select>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-primary" @click="save" type="button"> Save </button>
                </div>
            </div>
        </div>
    </form>
    
    `

}