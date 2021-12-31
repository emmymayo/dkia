
//Student Promotions Vue App

const SubjectRegistration = {
    
    data(){
        return {
            app_loading:false,
            subjects:[],
            registered_subjects:[],
            active_exam:null,
            show_subjects:false,
            student_id:document.getElementById('student_id').value,
            section_id:document.getElementById('section_id').value
            
         
        }
    },
    methods:{
        
        async getRequests(url,query = ''){
            try {
                return response = await axios.get(url+query);
                
              } catch (error) {
                console.error(error);
                toastr.error('Something went wrong. Try again.');
              }
        },
        async postRequests(url,params = {}){
            try {
                return response = await axios.post(url,params);
                
              } catch (error) {
                console.error(error);
                toastr.error('Something went wrong. Try again.');
              }
        },
        
        async initAll(){
            
            this.initSubjects();
            this.getRegisteredSubjects();
            
        },
         //initialize subjects on load
         async initSubjects(){
            response = await this.getRequests('/exams-registration/subjects');
            this.subjects = response.data;
            
        },
         
         async getRegisteredSubjects(){
            registered_subjects_url = `/students/${this.student_id}/subjects/registered/json`;
            let response = await this.getRequests(registered_subjects_url);
            this.registered_subjects = response.data;
            this.setSubjects();
            this.show_subjects=true;
            
        },
        
        //initialize active exam on load
        async initActiveExam(){
            response = await this.getRequests('/exams-registration/active-exam');
            this.active_exam = response.data;
        },
        setSubjects(){
            let subjects = this.subjects;
            let registered_subjects = this.registered_subjects;
            for(let i=0;i<subjects.length;i++){
                for(let j=0;j<registered_subjects.length;j++){
                    if(subjects[i].id==registered_subjects[j].id){
                        subjects[i].registered = true;
                        break
                    }
                    else{subjects[i].registered = false;}
                }
            }

        },
        async registerSubject(token,subject_id){
            
            let payload = {'subject_id':subject_id,'student_id':this.student_id,
                            'section_id':this.section_id, '_token':token};
            let response = await this.postRequests('/exams-registration',payload);

            if(response.data.message=='success'){
                this.getRegisteredSubjects();
                toastr.success('Done');
            }
            else{
                toastr.error('Something went wrong. Try again.');
                    
            }
        }
        
        

    },

    watch:{
       
    },
    mounted(){
        this.initAll();
    },
    created(){
        
        axios.interceptors.request.use((config) => {
            // trigger 'loading=true' event here
            this.app_loading = true;
            return config;
          }, (error) => {
            // trigger 'loading=false' event here
            this.app_loading = false;
            return Promise.reject(error);
          });
        
          axios.interceptors.response.use((response) => {
            // trigger 'loading=false' event here
            this.app_loading= false;
            return response;
          }, (error) => {
            // trigger 'loading=false' event here
            this.app_loading = false;
            return Promise.reject(error);
          });
    },
}

const subject_registration_app= Vue.createApp(SubjectRegistration);


if(document.querySelector('#reg-subjects')){
    subject_registration_app.mount('#reg-subjects');
}
