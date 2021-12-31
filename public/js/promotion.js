
//Student Promotions Vue App

const StudentPromotions = {
    
    data(){
        return {
            app_loading:false,
            exams:[],
            classes:[],
            my_class:null,
            my_section:null,
            sections:[],
            next_class:null,
            next_section:null,
            all_sections:[],
            students:[],
            show_students:false
            
         
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
        
        async initAll(){
            this.initClasses();

            
        },
        //initialize class dropdown on load
        async initClasses(){
            let response = await this.getRequests('/classes/all');
            this.classes = response.data;
        },
        async getMySections(class_id){
            let response = await this.getRequests(`/sections/classes/${class_id}/user`);
            this.sections = response.data;
        },
        async getAllSections(class_id){
           
            let response = await this.getRequests(`/sections/classes/${class_id}`);
            this.all_sections = response.data;
        },
        async loadStudents(){
            url = '/students/section/'+this.my_section;
            
            response = await this.getRequests(url);
            
            this.students = response.data;
            this.show_students = true;
        },
        async promoteStudent(token,student_id,index){
            let next_section = this.next_section;
            let url = '/promotions';
            let payload = {'_token':token, 'student_id':student_id,
                                'next_section':next_section};
            let response = await this.postRequests(url,payload);
            if(response.data.message=='success'){
                this.students[index].done=true;
                toastr.success('Promoted Successfully');
            }
            else {
                toastr.error('Something went wrong.');
            }

        },
        

    },

    watch:{
        my_class(class_id){
            this.getMySections(class_id);
        },
        next_class(class_id){
            this.getAllSections(class_id);
        }
       
    },
    created(){
        this.initAll();
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

const student_promotions_app= Vue.createApp(StudentPromotions);


if(document.querySelector('#student-promotions')){
    student_promotions_app.mount('#student-promotions');
}
