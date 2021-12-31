
import Paginator from '../../utilities/pagination.js'
export default{
    components:{'paginator':Paginator},
    props:['cbt'],
    data(){
        return {
            questions:{data:[]},
            questions_page:1,
            new_question:{
                'cbt_id':this.cbt.id,
                'question':'',
                'instruction':'',
                'marks':1
            },
            q_errorBag:{},
            selected_question:{},
            selected_question_answers:{},
            sq_errorBag:{},
            new_option:{'value':'', 'correct':0},
        }
    },
    methods:{
        async getQuestions(cbt_id,page=1, paginate=true){
            toastr.info('Fetching Data...',{timeout:10000})
            let url = "/cbt-questions?cbt_id="+cbt_id;
            url+= paginate? '&page='+page : '' ;
            return axios.get(url)
                    .then((response)=>{
                        toastr.clear();
                        return response.data;
                    })
                    .catch((error)=>{
                        toastr.clear();
                        toastr.error('Something went wrong');
                    });
            
        },
        async fetchCbtQuestions(page=1){
            this.questions_page = page;
            this.questions = await this.getQuestions(this.cbt.id,page);
        },
        async saveQuestion(){
            toastr.info('Saving Data...',{timeout:10000})
            let url = `/cbt-questions`;
            let data = this.new_question;
            axios.post(url,data)
                 .then((response)=>{
                    toastr.success('Question saved successfully.');
                    toastr.clear();
                    this.new_question.question='';
                    this.new_question.instruction='';
                    this.fetchCbtQuestions(this.questions_page);
                })
                 .catch((error)=>{
                    toastr.clear();
                    toastr.error('Something went wrong');
                    console.dir(error);
                    this.q_errorBag = error.response.data.errors;
                })
        },
        async updateQuestion(){
            toastr.info('Updating Data...',{timeout:10000})
            let url = `/cbt-questions/${this.selected_question.id}`;
            let data = this.selected_question;
            axios.put(url,data)
                 .then((response)=>{
                    toastr.success('Question updated successfully.');
                    toastr.clear();
                   
                    this.fetchCbtQuestions(this.questions_page);
                })
                 .catch((error)=>{
                    toastr.clear();
                    toastr.error('Something went wrong');
                    this.sq_errorBag = error.response.data.errors;
                })
        },
        async deleteQuestion(id){
            if(!confirm('Are you sure you want to delete this question?')){
                return;
            }
            toastr.info('Deleting Data...',{timeout:10000})
            let url = `/cbt-questions/${id}`;
            axios.delete(url)
                 .then((response)=>{
                    toastr.success('Question deleted successfully.');
                    toastr.clear();
                   
                    this.fetchCbtQuestions(this.questions_page);
                })
                 .catch((error)=>{
                    toastr.clear();
                    toastr.error('Something went wrong');
                   
                })
        },
        async fetchOptions(question_id){
            try{
                toastr.info('Loading...',{timeout:10000})
                let response = await axios.get('/cbt-answers?cbt_question_id='+question_id);
                toastr.clear();
                return response.data;
            }catch(error){
                toastr.clear();
                toastr.error('Something went wrong');
            }
        },
        async manageQuestion(question){
            this.selected_question = question;
            this.selected_question_answers = await this.fetchOptions(this.selected_question.id)
            $('#manage_question').modal('show');
            
        },
        async addOption(){
            toastr.info('Saving option...',{timeout:10000});
            let url = `/cbt-answers`;
            let data = {
                'cbt_question_id' : this.selected_question.id,
                'value' : this.new_option.value,
                'correct' : this.new_option.correct,
            };
            try{
                let response = await axios.post(url, data);
                if(response.data.message=='success'){
                    this.selected_question_answers = await this.fetchOptions(this.selected_question.id);
                    toastr.clear();
                    toastr.success('Option added successfully.');
                    //clear new question entry
                    this.new_option={};
                }

            }catch (error){
                toastr.clear();
                toastr.error('Something went wrong');
            }
        },
        async deleteOption(id){
            if(!confirm('Are you sure you want to delete this option?')){
                return;
            }
            toastr.info('Deleting Data...',{timeout:10000})
            let url = `/cbt-answers/${id}`;
            try{
                let response = await axios.delete(url);
                if(response.data.message=='success'){
                    this.selected_question_answers = await this.fetchOptions(this.selected_question.id);
                    toastr.clear();
                    toastr.success('Option deleted successfully.');
                }

            }catch (error){
                toastr.clear();
                toastr.error('Something went wrong');
            }
        },
        async updateOption(option){
            console.log(option);
            toastr.info('Updating Data...',{timeout:10000})
            let url = `/cbt-answers/${option.id}`;
            let data = {
                'value':option.value,
                'correct':option.correct,
            }
            try{
                let response = await axios.put(url,data);
                if(response.data.message=='success'){
                    this.selected_question_answers = await this.fetchOptions(this.selected_question.id);
                    toastr.clear();
                    toastr.success('Option updated successfully.');
                }

            }catch (error){
                toastr.clear();
                toastr.error('Something went wrong');
            }
        },
        getCbtType(type){
            switch (type) {
                case 1:
                    return 'Mock'
                    break;
                case 2:
                    return 'CASS 1'
                    break;
                case 3:
                    return 'CASS 2'
                    break;
                case 4:
                    return 'CASS 3'
                    break;
                case 5:
                    return 'CASS 4'
                    break;
                case 5:
                    return 'TASS'
                    break;
            
                default:
                    break;
            }
        }
    },
    created(){
       
        this.fetchCbtQuestions()
    },
    template: `
    
    
        <table class="table table-responsive hover  my-2">
            <tr>
                <th>Name</th>
                <td>{{cbt.name}}</td>
            </tr>
            <tr>
                <th>Exam</th>
                <td>{{cbt.exam.name}}</td>
            </tr>
            <tr>
                <th>Subject</th>
                <td>{{cbt.subject.name}}</td>
            </tr>
            <tr>
                <th>Duration (mins)</th>
                <td>{{cbt.duration}}</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>{{getCbtType(cbt.type)}}</td>
            </tr>
        </table>
        <div class="my-1 px-1">
            <button type="button" data-toggle="modal" data-target="#new_question" class="btn btn-primary float-right"> New Question </button>
        </div>
       
        <template v-if="questions.data.length>0">
            
            <table class="table small table-responsive-sm table-hover my-2">
                <tr>
                    <th> #</th>
                    <th> Question</th>
                    <th> Instruction</th>
                    <th> Marks</th>
                    <th> ...</th>
                </tr>
                <tr v-for="(question,index) in questions.data" :key="question.id">
                    <td> {{index+1}}</td>
                    <td> {{question.question}}</td>
                    <td> {{question.instruction}}</td>
                    <td> {{question.marks}}</td>
                    <td class="dropdown small">
                        <a class="btn" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">

                            <button @click="manageQuestion(question)" class="dropdown-item"><i class="fa fa-edit"></i> Manage</button>
                            
                            <button @click="deleteQuestion(question.id)" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                            
                        </div>
                    </td>
                </tr>

            </table>
            <paginator :resource="questions" @get-page="fetchCbtQuestions"></paginator>
        </template>

        <div class="modal fade" tabindex="-1" id="new_question">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >New Question</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body ">
                        <div>
                            <p class="text-danger " v-for="error of q_errorBag">{{error[0]}}</p>
                        </div>
                        <div class="form-group">
                            <label for="question">Question </label>
                            <textarea id="question" v-model="new_question.question" row="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="instruction">Instruction  </label>
                            <textarea id="instruction" v-model="new_question.instruction" row="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="marks">Marks </label>
                            <input type="number"  id="marks" v-model="new_question.marks"  class="form-control" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button @click="saveQuestion" type="button" class="btn btn-primary">Save </button>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="modal fade" tabindex="-1" id="manage_question">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Manage Question</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body ">
                        <div>
                            <p class="text-danger " v-for="error of sq_errorBag">{{error[0]}}</p>
                        </div>
                        <div class="form-group">
                            <label for="question">Question </label>
                            <textarea id="question" v-model="selected_question.question" row="6" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="instruction">Instruction  </label>
                            <textarea id="instruction" v-model="selected_question.instruction" row="6" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="marks">Marks </label>
                            <input type="number"  id="marks" v-model="selected_question.marks"  class="form-control" />
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button @click="updateQuestion" type="button" class="btn btn-primary">Update Question </button>
                        </div>

                        <div v-if="selected_question_answers.length>0" class="my-2">
                            <h4 class="lead">Options</h4>
                            <table class="table small table-responsive-sm table-hover">
                                <tr>
                                    <th>Value</th>
                                    <th>Correct</th>
                                    <th>...</th>
                                </tr>
                                <tr v-for="(answer,index) in selected_question_answers" :key="index">
                                    <td>
                                        <input class="form-control" v-model="selected_question_answers[index].value" />
                                    </td>
                                    <td>
                                        <select v-model="selected_question_answers[index].correct" class="form-control" >
                                            <option value="1" >Yes</option>
                                            <option value="0" >No</option>
                                        </select>
                                    </td>
                                    
                                    <td class="dropdown small">
                                        <a class="btn" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                
                                            <button @click="updateOption(selected_question_answers[index])" class="dropdown-item"><i class="fa fa-paper-plane"></i> Update</button>
                                            
                                            <button @click="deleteOption(selected_question_answers[index].id)" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                                            
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div v-if="selected_question_answers.length<5">
                        <h4 class="lead">Add New Options</h4>
                            <table class="table small table-responsive-sm table-hover">
                                <tr>
                                    <th>Value</th>
                                    <th>Correct</th>
                                    <th>...</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="form-control" v-model="new_option.value" />
                                    </td>
                                    <td>
                                        <select v-model="new_option.correct" class="form-control" >
                                            <option value="1" >Yes</option>
                                            <option value="0" >No</option>
                                        </select>
                                    </td>
                                    
                                    <td >
                                        <button @click="addOption" class="btn btn-primary"> Add Option </button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    
    `
}