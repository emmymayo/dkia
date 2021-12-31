
//School Settings Vue App



const ManagePins = {
    
    data(){
        return {
            app_loading:false,
            exams:[],
            active_exam:[],
            selected_exam:null,
            pins:[],
            show_pins:false,
            t_pag_curr:0,
            t_pag_last:0,
            t_pag_to:0,
            t_pag_from:0,
            t_pag_total:0
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
        showPins(){this.show_pins=true;},
        hidePins(){this.show_pins=false;},
        
        async initAll(){
            this.initActiveExam();
            this.initExams();
            
            
        },
        
        async initExams(){
            let response = await this.getRequests('/exams/find/all');
            this.exams = response.data;
        },
        async initActiveExam(){
            let response = await this.getRequests('/exams-registration/active-exam');
            this.active_exam = response.data;
            this.selected_exam = response.data.id;
            
        },

        async loadPins(page=1){
            //console.log(this.selected_exam);
            let url = '/pins/exam/'+this.selected_exam+'?page='+page;
            let response = await this.getRequests(url);
            
            this.pins = response.data.data;
            this.showPins();
            

            this.t_pag_last = response.data.last_page;
            this.t_pag_curr = response.data.current_page;
            this.t_pag_from = response.data.from;
            this.t_pag_to = response.data.to;
            this.t_pag_total = response.data.total;
        },

        async resetPin(token,pin_id){
            if(!confirm('Are you sure you want to reset this pin')){
                return;
            }
            url = '/pins/reset/'+pin_id;
            payload = {'_token':token};
            let response = await this.postRequests(url,payload);
            if(response.data.message=="success"){
                //reload pins
                
                this.loadPins(this.t_pag_curr);
                return toastr.success('Pin reset successfully.');
               
            }
            return toastr.error('Something went wrong. Try again.');
        },
        async revokePin(token,pin_id){
            if(!confirm('Are you sure you want to revoke this pin')){
                return;
            }
            url = '/pins/revoke/'+pin_id;
            payload = {'_token':token};
            let response = await this.postRequests(url,payload);
            if(response.data.message=="success"){
                
                  //reload pins
               this.loadPins(this.t_pag_curr);
               return toastr.success('Pin revoked successfully.');
              
            }
            return toastr.error('Something went wrong. Try again.');
        },
       
        async removePin(token,pin_id){
            if(!confirm('Are you sure you want to delete this pin')){
                return;
            }
            url = '/pins/remove/'+pin_id;
            payload = {'_token':token};
            let response = await this.postRequests(url,payload);
            if(response.data.message=="success"){
                  //reload pins
               this.loadPins(this.t_pag_curr);
               return  toastr.success('Pin removed successfully.');
            }
            return toastr.error('Something went wrong. Try again.');
        }
       
    
        

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

const manage_pins_app= Vue.createApp(ManagePins);


if(document.querySelector('#manage-pins')){
    manage_pins_app.mount('#manage-pins');
}
