/* 
    Type Information --- Type 1 = Mock, Type 2 = Cass1, Type 3 = cass2, Type 4 = cass3, Type 5 = cass4, Type 6 = tass
 */

    export default {
        props:['subjects','exams','cbt'],
        emits:['updated'],
        data(){
            return {
                id:this.cbt.id,
                name:this.cbt.name,
                exam_id:this.cbt.exam_id,
                subject_id:this.cbt.subject_id,
                duration:this.cbt.duration,
                type:this.cbt.type,
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
                let url = `/cbts/${this.id}`;
                let data = {
                    'name':this.name,
                    'exam_id':this.exam_id,
                    'subject_id':this.subject_id,
                    'duration':this.duration,
                    'type':this.type,
                };
    
                axios.put(url,data)
                    .then((response)=>{
                        toastr.clear();
                        toastr.success('Cbt Updated Successfully');
                        this.$emit('updated');
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
                    console.log(response.data);
                } catch(error){
                    
                }
                
            }
        },
        created(){
            this.initCassConfig();
        },
        template:`
         <form v-on:submit.prevent="save">
            <h3 class="text-dark-gray text-center mx-auto my-2 lead"> Update CBT Data. </h3>
            <div class="my-3 mx-md-5 px-2 row justify-content-center">
                <div>
                    <p class="text-danger " v-for="error of errorBag">{{error[0]}}</p>
                </div>
                <div class="row ">
                    <div class="col-md-4 form-group">
                        <label for="name"> Name </label>
                        <input id="name" type="text" v-model="name" class="form-control" required />
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="exam"> Exam </label>
                        <select id="exam" v-model="exam_id" class="form-control" required>
                            
                            <option :value="exam.id" v-for="exam in exams" :key="exam.id">{{exam.name}} </option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="subject"> Subject </label>
                        <select v-model="subject_id" class="form-control" required>
                            
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
                                :value="type.id" v-for="type in cbtTypes" :key="type.id">{{type.name}} 
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <button class="btn btn-primary float-right" @click="save" type="button"> Save </button>
                    </div>
                </div>
            </div>
        </form>
        
        `
    
    }