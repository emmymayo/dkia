

const ExamRegistration = {
    
    data(){
        return {
            app_loading:false,
            my_class:null,
            my_section:null,
            classes:[{name:'Loading Classes...'}],
            active_exam:[],
            subjects:[],
            sections: [],
            students: [],
            showStudents: false,
            showExamRegistrationModal: false,
            
            selected_student:null,
            registered_subjects:[],
            registered_subjects_id:[],
            selected_subjects:[],
            subject_registration_message:'',
            reg_token:''

            
            
        }
    },
    methods:{
        
        async getRequests(url,query = ''){
            try {
                return response = await axios.get(url+query);
                
              } catch (error) {
                console.error(error);
                toastr.error('Something went wrong.');
              }
        },
        async postRequests(url,params = {}){
            try {
                return response = await axios.post(url,params);
                
              } catch (error) {
                console.error(error);
                toastr.error('Something went wrong.');
              }
        },

        //initialize class dropdown on load
        async initClasses(){
            response = await this.getRequests('/classes/all');
            this.classes = response.data;
        },
        //initialize subjects on load
        async initSubjects(){
            response = await this.getRequests('/exams-registration/subjects');
            this.subjects = response.data;
        },
        
        //initialize active exam on load
        async initActiveExam(){
            response = await this.getRequests('/exams-registration/active-exam');
            this.active_exam = response.data;
        },
        //load sections
        async loadClassSections(class_id){
            url = '/sections/classes/'+class_id+'/user';
            
            response = await this.getRequests(url);
            this.sections = response.data;
        },

        async loadStudents(){
            url = '/students/section/'+this.my_section;
           
            response = await this.getRequests(url);
            this.showStudents = true;
            this.students = response.data;
            
            
        },

        async initRegistrationModal(token,student_id){
            this.reg_token = token;
            registered_subjects_url = `/exams-registration/student/${student_id}/section/
                                        ${this.my_section}/registered
                                      `;
            reg_subject_response = await this.getRequests(registered_subjects_url);
            //retrieve registered subjects                 
            this.registered_subjects = reg_subject_response.data ;
            //flatten the response to an array of subject id
            this.registered_subjects_id = [];
            this.registered_subjects.forEach(value=>this.registered_subjects_id.push(value.subject_id));
            
            selected_student_url = `/students/${student_id}/find`  ;              
            selected_student_response = await this.getRequests(selected_student_url);
                                              
            this.selected_student = selected_student_response.data;
            this.subject_registration_message = '';
            
            this.$nextTick( ()=>$('#exam-registration-modal').modal('show'));
            
        },

        async registerSubject(subject_id){
            
            let payload = {'subject_id':subject_id,'student_id':this.selected_student.id,
                            'section_id':this.my_section, '_token':this.reg_token};
            let response = await this.postRequests('/exams-registration',payload);
            if(response.data.message=='fail'){
                //reload modal to reset checks
                this.initRegistrationModal(this.selected_student.id);
                toastr.error('Something went wrong.');
                
            }
            else{
                    this.subject_registration_message = response.data.action;
                    toastr.success('Action completed successfully');
                    
            }
        }

        



    },

    watch:{
        my_class(class_id){
            
            this.sections = [{name:'Loading...'}];
            this.loadClassSections(class_id);
        }
    },
    created(){
        this.initClasses();
        this.initSubjects();
        this.initActiveExam();

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

const exam_reg_app = Vue.createApp(ExamRegistration);
/*components
app.component('posts', {
    props:['post'],
    template:`<h3>{{post.title}}</h3> 
              <p>{{post.content}}</p>`
});
*/


if(document.querySelector('#exam-reg')){
    exam_reg_app.mount('#exam-reg');
}


//Exam result entry Vue App

const ExamEntry = {
    
    data(){
        return {
            app_loading:false,
            my_class:null,
            my_section:null,
            my_subject:null,
            classes:[{name:'Loading Classes...'}],
            active_exam:[],
            subjects:[],
            sections: [],
            entries: [],
            assessments: [],
            showEntries: false,
            cass1:null,
            cass2:null,
            cass3:null,
            cass4:null,
            tass:null,
            selected_subjects:[],
            entries_for_upload:[],
            show_entries:false

           
            
            
        }
    },
    methods:{
        
        async getRequests(url,query = ''){
            try {
                return response = await axios.get(url+query);
                
              } catch (error) {
                console.error(error);
                toastr.error('Something went wrong.');
                
              }
        },
        async postRequests(url,params = {}){
            try {
                return response = await axios.post(url,params);
                
              } catch (error) {
                console.error(error);
                toastr.error('Something went wrong.');
              }
        },

        //initialize class dropdown on load
        async initClasses(){
            response = await this.getRequests('/classes/all');
            this.classes = response.data;
        },
        
        async getSubjects(section_id){
            let url = `/subjects/get/user/${section_id}`;
            let response = await this.getRequests(url);
            this.subjects = response.data;
        },
        //initialize active exam on load
        async initActiveExam(){
            response = await this.getRequests('/exams-registration/active-exam');
            this.active_exam = response.data;
        },
        //load sections
        async loadClassSections(class_id){
            url = '/sections/classes/'+class_id;
            
            response = await this.getRequests(url);
            this.sections = response.data;
        },

        async loadStudentEntries(){
            url = `/exams-entry/section/${this.my_section}/subject/${this.my_subject}`;
            
            response = await this.getRequests(url);
            
            this.entries = response.data.data;
            this.assessments = response.data.assessments;
            
            this.show_entries = true;
           
            
            
        },

        async bulkUpdate(token){
            entries  = this.entries;
            for(let i=0;i<entries.length;i++){
                mark_id = entries[i].id;
                payload = {
                    '_token':token,'mark_id':entries[i].id,
                    'cass1':entries[i].cass1,
                    'cass2':entries[i].cass2,
                    'cass3':entries[i].cass3,
                    'cass4':entries[i].cass4,
                    'tass':entries[i].tass
                };
                
                let response = await this.postRequests(`/exams-entry/${mark_id}/update`,payload);
                if(response.data.message=='success'){
                    toastr.success('Updated entry '+(i+1));
                }else{toastr.error('Failed entry '+(i+1));}
                
            }
            
        }

        



    },

    watch:{
        my_class(class_id){
            
            this.sections = [{name:'Loading...'}];
            this.loadClassSections(class_id);
        },
        my_section(section_id){
            
            this.getSubjects(section_id);
        }

    },
    created(){
        this.initClasses();
        
        this.initActiveExam();

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

const exam_entry_app = Vue.createApp(ExamEntry);
/*components
app.component('posts', {
    props:['post'],
    template:`<h3>{{post.title}}</h3> 
              <p>{{post.content}}</p>`
});
*/

if(document.querySelector('#exam-entry')){
    exam_entry_app.mount('#exam-entry');
}


//Exam result entry Viewer Vue App

const ExamEntryView = {
    
    data(){
        return {
            app_loading:false,
            my_class:null,
            my_section:null,
            my_subject:null,
            classes:[{name:'Loading Classes...'}],
            active_exam:[],
            subjects:[],
            sections: [],
            entries: [],
            assessments: [],
            showEntries: false,
            cass1:0,
            cass2:0,
            cass3:0,
            cass4:0,
            tass:0,
            selected_subjects:[],
       

           
            
            
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

        //initialize class dropdown on load
        async initClasses(){
            response = await this.getRequests('/classes/all');
            this.classes = response.data;
        },
        async getSubjects(section_id){
            let url = `/subjects/get/user/${section_id}`;
            let response = await this.getRequests(url);
            this.subjects = response.data;
        },
        //initialize active exam on load
        async initActiveExam(){
            response = await this.getRequests('/exams-registration/active-exam');
            this.active_exam = response.data;
        },
        //load sections
        async loadClassSections(class_id){
            url = '/sections/classes/'+class_id;
            
            response = await this.getRequests(url);
            this.sections = response.data;
        },

        async loadStudentEntries(){
            url = `/exams-entry/section/${this.my_section}/subject/${this.my_subject}`;
            
            response = await this.getRequests(url);
           
            this.entries = response.data.data;
            this.assessments = response.data.assessments;
            this.showEntries = true;
             
        },
       

    },

    watch:{
        my_class(class_id){
           
            this.sections = [{name:'Loading...'}];
            this.loadClassSections(class_id);
        },
        my_section(section_id){
            this.getSubjects(section_id);
        }

    },
    created(){
        this.initClasses();
        //this.initSubjects();
        this.initActiveExam();

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

const exam_entry_view_app = Vue.createApp(ExamEntryView);
/*components
app.component('posts', {
    props:['post'],
    template:`<h3>{{post.title}}</h3> 
              <p>{{post.content}}</p>`
});
*/

if(document.querySelector('#exam-entry-view')){
    exam_entry_view_app.mount('#exam-entry-view');
}


//Exam result checker Vue App

const ExamReportChecker = {
    
    data(){
        return {
            app_loading:false,
            my_class:null,
            my_section:null,
   
            classes:[{name:'Loading Classes...'}],
            active_exam:[],
            selected_exam:null,
            students:[],
            sections: [],
            entries: [],
            show_students: false,
            

           
            
            
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

        //initialize class dropdown on load
        async initClasses(){
            response = await this.getRequests('/classes/all');
            this.classes = response.data;
        },
       
        //initialize active exam on load
        async initActiveExam(){
            response = await this.getRequests('/exams-registration/active-exam');
            this.active_exam = response.data;
            
        },
        //load sections
        async loadClassSections(class_id){
            url = '/sections/classes/'+class_id;
            
            response = await this.getRequests(url);
            this.sections = response.data;
        },
        async loadStudents(){
            url = '/students/section/'+this.my_section;
            //console.log(url);
            response = await this.getRequests(url);
            this.show_students = true;
            this.students = response.data;
            
            
        }


    },

    watch:{
        my_class(class_id){
            
            this.sections = [{name:'Loading...'}];
            this.loadClassSections(class_id);
        }
    },
    created(){
        this.initClasses();
        
        this.initActiveExam();

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

const exam_report_checker_app= Vue.createApp(ExamReportChecker);


if(document.querySelector('#exam-report-checker')){
    exam_report_checker_app.mount('#exam-report-checker');
}




//Exam result data Vue App

const ExamReportData = {
    
    data(){
        return {
            app_loading:false,
            my_class:null,
            my_section:null,
   
            classes:[{name:'Loading Classes...'}],
            active_exam:[],
            students:[],
            sections: [],
            entries: [],
            show_students: false,
            show_record: false,
            selected_student:{}
         
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
        showStudents(){this.show_students=true;},
        hideStudents(){this.show_students=false;},
        showRecord(){this.show_record=true;},
        hideRecord(){this.show_record=false;},
        openStudents(){
            this.hideRecord();
            this.showStudents();
        },
        openRecord(){
            this.hideStudents();
            this.showRecord();
        },
        closeRecord(){
            this.hideRecord();
            this.showStudents();
        },

        //initialize class dropdown on load
        async initClasses(){
            response = await this.getRequests('/classes/all');
            this.classes = response.data;
        },
       
        //initialize active exam on load
        async initActiveExam(){
            response = await this.getRequests('/exams-registration/active-exam');
            this.active_exam = response.data;
            
        },
        //load sections
        async loadClassSections(class_id){
            url = '/sections/classes/'+class_id+'/user';
            
            response = await this.getRequests(url);
            this.sections = response.data;
        },
        async loadStudents(){
            url = '/students/section/'+this.my_section;
            //console.log(url);
            response = await this.getRequests(url);
            
            this.students = response.data;
            this.openStudents();
            
        },
        async showDataEntry(token,student_id){
            //fetch things from back
            url = '/exams-record/'+student_id+'/'+this.my_section ;
            response = await this.getRequests(url);
            this.selected_student = response.data;
            
            this.openRecord();
        },

        async updateData(token){
            console.log(this.selected_student);
            url = '/exams-record/'+this.selected_student.student_id+'/'+
                    this.selected_student.section_id+'/update' ;
            params = {'_token':token, 'attendance':this.selected_student.attendance,
                        'comment1':this.selected_student.comment1,
                        'comment2':this.selected_student.comment2,
                        'skills':this.selected_student.skills};
            response = await this.postRequests(url,params);
            if(response.data.message =='success'){
                toastr.success('Updated successfully.');
            }else{
                toastr.error('Something went wrong. Try again.');
            }

        }

    },

    watch:{
        my_class(class_id){
            
            this.sections = [{name:'Loading...'}];
            this.loadClassSections(class_id);
        }
    },
    created(){
        this.initClasses();
        
        this.initActiveExam();

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

const exam_report_data_app= Vue.createApp(ExamReportData);


if(document.querySelector('#exam-report-data')){
    exam_report_data_app.mount('#exam-report-data');
}
