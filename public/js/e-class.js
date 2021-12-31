
const EClassApp = {
    
    data(){
        return {
            app_loading:false,
            token:document.getElementById('_token').value,
            classes:[],
            sections:[],
            new_sections:[],
            edit_sections:[],
            selected_class:null,
            selected_new_class:null,
            selected_edit_class:null,
            selected_section:null,
            eclasses:{data:{}},
            selected_eclass:{section:{}},
            new_eclass:{},
            show_eclasses:true,
            edit_eclass:false
            
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
        async putRequests(url,params = {}){
            try {
                return response = await axios.put(url,params);
                
              } catch (error) {
                console.error(error);
                toastr.error('Something went wrong.');
              }
        },
        async deleteRequests(url,params = {}){
            try {
                return response = await axios.delete(url,params);
                
              } catch (error) {
                console.error(error);
                toastr.error('Something went wrong.');
              }
        },
        showEClasses(){this.show_eclasses=true;},
        hideEClasses(){this.show_eclasses=false;},
      
        showEditEClass(){this.edit_eclass=true;},
        hideEditEClass(){this.edit_eclass=false;},

        
        
        openEditEClass(){this.hideEClasses(); this.showEditEClass()},
        closeEditEClass(){this.hideEditEClass(); this.showEClasses()},

       
        
        async initAll(){
            this.initClasses();
        },
        async initClasses(){
            let response = await this.getRequests('/classes/all');
            this.classes = response.data;
        },
       
        //load sections accessible by authenticated user
        async loadClassSections(class_id){
           let url = '/sections/classes/'+class_id+'/user';
           let response = await this.getRequests(url);
           return response.data;
        },
        async getSectionEClasses(page=1){
            let url = `/e-classes?page=${page}&section_id=${this.selected_section}`;
            let response = await this.getRequests(url);
            this.eclasses = response.data;
            
        },
        async getEClass(id){
            let response = await this.getRequests('/e-classes/'+id);
            return response.data;
        },
        async LoadSectionEClasses(){
            await this.getSectionEClasses();
            
        },
        async create(){
            let url = "/e-classes";
            let data = {
                "_token" : this.token,
                "topic"  : this.new_eclass.topic,
                "section_id"  : this.new_eclass.section_id,
                "start_time"  : this.new_eclass.start_time,
                "duration"  : this.new_eclass.duration,
                "password"  : this.new_eclass.password

            };
            let response = await this.postRequests(url,data);
            console.log(response);
            if(response.data.message!="success"){
                toastr.error('Something went wrong.');
                return;
            }
            // proceed if successful
            //notify and refresh
            toastr.success('Created Successfully.');
            this.getSectionEClasses();
        },
        async edit(id){
            //assign parameter to app global variable
            this.selected_eclass = await this.getEClass(id);
            this.openEditEClass();
        },
        async update(){
            let url = `/e-classes/${this.selected_eclass.id}`;
            let data = {
                "_token" : this.token,
                "topic"  : this.selected_eclass.topic,
                "section_id"  : this.selected_eclass.section_id,
                "start_time"  : this.selected_eclass.start_time,
                "duration"  : this.selected_eclass.duration,
                "password"  : this.selected_eclass.password

            };
            let response = await this.putRequests(url,data);
            if(response.data.message!="success"){
                toastr.error('Something went wrong.');
                return;
            }
            // proceed if successful
            //notify and refresh
            toastr.success('Updated Successfully.');
            this.getSectionEClasses();
        },
        async deleteEClass(id){
            if(!confirm("Are you sure you want to delete this E-class?")){
                return;
            }
            let url = `/e-classes/${id}`;
            let response = await this.deleteRequests(url);
            if(response.data.message!="success"){
                toastr.error('Something went wrong.');
                return;
            }
            // proceed if successful
            //notify and refresh
            toastr.success('Deleted Successfully.');
            this.getSectionEClasses();

        },
        async start(eclass_id){
            let response = await this.getRequests(`/e-classes/${eclass_id}/retrieve`);
            if(response.data){
                console.log(response.data);
                window.open(response.data.start_url,target="_blank");
            }

        },
        join(url){
            window.open(url,target="_blank");
        },
        copyJoinLink(url){
            navigator.clipboard.writeText(url);
            toastr.info('Copied to Clipboard');
        },
        copyPassword(password){
            navigator.clipboard.writeText(password);
            toastr.info('Copied to Clipboard');
        },
        
        formatDate(date){
            let new_date = new Date(date).toLocaleString();
            return new_date;
        }

    },

    watch:{
       async selected_class(class_id){
          this.sections = await this.loadClassSections(class_id);
       },

       async selected_new_class(class_id){
          this.new_sections = await this.loadClassSections(class_id);
       },

       async selected_edit_class(class_id){
          this.edit_sections = await this.loadClassSections(class_id);
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

const eclass_app= Vue.createApp(EClassApp);


if(document.querySelector('#e-class-app')){
    eclass_app.mount('#e-class-app');
}
