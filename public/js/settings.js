
//School Settings Vue App

const SchoolSettings = {
    
    data(){
        return {
            app_loading:false,
            exams:[],
            active_exam:[],
            settings:[],
            sessions:[]
            
         
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
            this.initSettings();
            this.initExams();
            this.initSessions();
        },
        //initialize class dropdown on load
        async initSessions(){
            response = await this.getRequests('/settings/sessions/all');
            this.sessions = response.data;
        },
        async initSettings(){
            response = await this.getRequests('/settings/all');
            this.settings = response.data;
        },
        async initExams(){
            response = await this.getRequests('/exams/find/all');
            this.exams = response.data;
        },
       
       
        async updateSettings(token){
           
            settings = this.settings;
            total_count = settings.length;
            count = 1
            for(let i = 0;i<settings.length;i++){
                if(settings[i].key=='school.logo'){
                    continue;
                }
                url ='/settings/update';
                payload = {'_token':token,
                            'key':settings[i].key,
                            'value':settings[i].value} ;
                //console.log(payload);
                response = await this.postRequests(url,payload);
                //if successful
                if(response.data.message=='success'){
                    count++;
                }
                

            }
            toastr.success('Updated successfully');
            //initialize 
            this.initAll();
        },

        
        

    },

    watch:{
       
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

const school_settings_app= Vue.createApp(SchoolSettings);


if(document.querySelector('#school-settings')){
    school_settings_app.mount('#school-settings');
}
