
//Attendance Roll Call Vue App

const RollCall = {
    
    data(){
        return {
            app_loading:false,
            my_class:null,
            my_section:null,
            exams:[],
            classes:[{name:'Loading Classes...'}],
            active_exam:[],
            students:[],
            sections: [],
            entries: [],
            show_rolls: false,
            roll_date:null,
            my_exam:null,
            init_roll_count:1,
            init_roll_max:1,
            show_init_info:false,
            init_finished_count:1,
            init_finished_max:1,
            show_finished_info:false
         
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
        showRolls(){this.show_rolls=true;},
        hideRolls(){this.show_rolls=false;},
        showInitInfo(){this.init_roll_count=0; this.show_init_info=true;},
        hideInitInfo(){this.show_init_info=false; },
        showFinishedInfo(){this.init_finished_count=0; this.show_finished_info=true;},
        hideFinishedInfo(){this.show_finished_info=false; },
       

        //initialize class dropdown on load
        async initClasses(){
            response = await this.getRequests('/classes/all');
            this.classes = response.data;
        },
        async initExams(){
            response = await this.getRequests('/exams/find/all');
            this.exams = response.data;
        },
       
        //initialize active exam on load
        async initActiveExam(){
            response = await this.getRequests('/exams-registration/active-exam');
            //this.active_exam = response.data;
            this.my_exam = response.data.id;
            
        },
        //load sections
        async loadClassSections(class_id){
            url = '/sections/classes/'+class_id+'/user';
            
            response = await this.getRequests(url);
            this.sections = response.data;
        },
        async loadRolls(token){
            url = '/students/section/'+this.my_section;
            //console.log(url);
            response = await this.getRequests(url);
            
            students = response.data;
            this.init_roll_max = students.length;
            this.showInitInfo();
            
            for(let i = 0;i<students.length;i++){
                url ='/attendances/student/'+students[i].id+'/'+this.my_section ;
                payload = {'_token':token,
                            'exam_id':this.my_exam,
                            'date':this.roll_date} ;
                response = await this.postRequests(url,payload);
                students[i].roll = response.data;
                
                this.init_roll_count++ ;
                

            }
            //notify
            this.init_roll_max ==this.init_roll_count?toastr.success('Done')
                                        :toastr.error('Something went wrong. Try again');
            this.students = students;
            
            this.hideInitInfo();
            
            this.showRolls();
            
           
            
        },

        async submitRoll(token){
            students  = this.students;
            this.init_finished_max = students.length;
            this.showFinishedInfo();
            for(let i=0;i<students.length;i++){
                student_id = students[i].id;
                url ='/attendances/student/'+students[i].id+'/'+this.my_section+'/update' ;
                payload = {'_token':token,
                            'exam_id':this.my_exam,
                            'date':this.roll_date,
                            'morning':students[i].roll.morning,
                            'afternoon':students[i].roll.afternoon,
                            'remark':students[i].roll.remark,
                        } ;
                
                let response = await this.postRequests(url,payload);
                if(response.data.message=='success'){
                    this.init_finished_count++;
                } 
            }
            this.init_finished_max ==this.init_finished_count? toastr.success('Completed successfully')
                                    :toastr.error("Something went wrong. Try again.");
            this.hideFinishedInfo();
        },
        

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
        this.initExams();

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

const roll_call_app= Vue.createApp(RollCall);


if(document.querySelector('#roll-call')){
    roll_call_app.mount('#roll-call');
}


//Attendance Roll Call Vue App

const RollView = {
    
    data(){
        return {
            app_loading:false,
            my_class:null,
            my_section:null,
            exams:[],
            classes:[{name:'Loading Classes...'}],
            active_exam:[],
            students:[],
            sections: [],
          
            show_rolls: false,
            roll_date:null,
            my_exam:null,
            init_roll_count:1,
            init_roll_max:1,
            show_init_info:false,
            
         
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
        showRolls(){this.show_rolls=true;},
        hideRolls(){this.show_rolls=false;},
        showInitInfo(){this.init_roll_count=0; this.show_init_info=true;},
        hideInitInfo(){this.show_init_info=false; },
       

        //initialize class dropdown on load
        async initClasses(){
            response = await this.getRequests('/classes/all');
            this.classes = response.data;
        },
        async initExams(){
            response = await this.getRequests('/exams/find/all');
            this.exams = response.data;
        },
       
        //initialize active exam on load
        async initActiveExam(){
            response = await this.getRequests('/exams-registration/active-exam');
            //this.active_exam = response.data;
            this.my_exam = response.data.id;
            
        },
        //load sections
        async loadClassSections(class_id){
            url = '/sections/classes/'+class_id+'/user';
            
            response = await this.getRequests(url);
            this.sections = response.data;
        },
        async loadRolls(token){
            url = '/students/section/'+this.my_section;
            
            response = await this.getRequests(url);
            
            students = response.data;
            this.init_roll_max = students.length;
            this.showInitInfo();
            
            for(let i = 0;i<students.length;i++){
                url ='/attendances/student/'+students[i].id+'/'+this.my_section ;
                payload = {'_token':token,
                            'exam_id':this.my_exam,
                            'date':this.roll_date} ;
                response = await this.postRequests(url,payload);
                students[i].roll = response.data;
                
                this.init_roll_count++ ;
                

            }
            this.init_roll_max ==this.init_roll_count? toastr.success('Done')
                                            :toastr.error('Something went wrong. Try again');
            this.students = students;
            
            this.hideInitInfo();
            
            this.showRolls();
           
           
            
        },

        
        

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
        this.initExams();

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

const roll_view_app= Vue.createApp(RollView);


if(document.querySelector('#roll-view')){
    roll_view_app.mount('#roll-view');
}
