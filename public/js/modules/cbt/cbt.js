import  CreateCBT  from "./create.js"; 
import  EditCBT  from "./edit.js"; 
import  ViewCBT  from "./view.js"; 
import  AssignSections  from "./assign-sections.js"; 
import Paginator from '../../utilities/pagination.js';
import Loader from '../../utilities/loader.js';
export const CbtApp = {
    components:{
      'create-cbt':CreateCBT,
      'edit-cbt':EditCBT,
      'view-cbt':ViewCBT,
      'assign-sections':AssignSections,
      'paginator':Paginator,
      'loader': Loader
    },
    data(){
        return {
            app_loading:false,
            viewManager: new Map(), //Map for Handling visibility of different Views using v-show, only one should be visible at a time
            cbtType: new Map(),
            filter_exam_id:null,
            filter_subject_id:null,
            cbts:{data:{}},
            cbt_page:1, //Maintain state of page across methods
            exams:[],
            subjects:[],
            classes:[],
            cbt_search:'',
            cbt:{},
            selected_cbt:{},
            edit_cbt_component:null,
            view_cbt_component:null,
            assign_sections_component:null,
            cass_config:[]

              
        }
    },
    methods:{
        /* Called when Vue App is created */
        boot(){
          
          this.registerViews();
          this.registerCbtTypes();
        },
        /* Called when App is mounted */
        async initApp(){
          this.cbts = await this.getCbts();
          await this.initExams();
          await this.initSubjects();
          await this.initCassConfig();
          
        },
        async getRequests(url,query = ''){
            try {
                let response = await axios.get(url+query);
                return response;
              } catch (error) {
                console.error(error);
                toastr.error('Something went wrong.');
              }
        },
        async postRequests(url,params = {}){
            try {
                let response = await axios.post(url,params);
                return response;
              } catch (error) {
                console.error(error);
                toastr.error('Something went wrong.');
              }
        },
        async putRequests(url,params = {}){
            try {
                let response = await axios.put(url,params);
                return response;
              } catch (error) {
                console.error(error);
                toastr.error('Something went wrong.');
              }
        },
        async deleteRequests(url,params = {}){
            try {
                let response = await axios.delete(url,params);
                return response;
              } catch (error) {
                console.dir(error);
                toastr.error('Something went wrong.');
              }
        },
        async getCbts(page=1,paginate=true){
            this.cbt_page = page;
            //Build url to dynamically while excluding empty filter parameters
            let url = '/cbts?' ; 
                url+= paginate? 'page='+this.cbt_page+'&' : '' ;
                url+= this.filter_exam_id!=null && this.filter_exam_id !='' ? 'exam_id='+this.filter_exam_id+'&' : '' ;
                url+= this.filter_subject_id!=null && this.filter_subject_id !=''? 'subject_id='+this.filter_subject_id+'&' : '' ;
                url+= this.cbt_search!=''? 'search='+this.cbt_search+'&' : '' ;
            let response = await this.getRequests(url);
            return response.data;
        },

        async togglePublished(id,status){
            let published = !status; 
            let response = await this.putRequests('/cbts/'+id,{published:published});
            if(response.data.message == 'success'){
              toastr.success('Toggled Successfully');
            }
            //refresh cbt 2
            await this.fetchCbtPage(this.cbt_page);
        },
        async fetchCbtPage(page=1){
            this.cbt_page = page;
            this.cbts = await this.getCbts(this.cbt_page,true);
        },
        async resetFilters(){
          this.cbt_search=''; 
          this.filter_exam_id='';
          this.filter_subject_id='';
        },
        async initExams(){
          let response = await this.getRequests('/exams/find/all');
          this.exams = response.data;
        },
       async initSubjects(){
        let response = await this.getRequests('/exams-registration/subjects');
        this.subjects = response.data;
        
        },
       async initClasses(){
        let response = await this.getRequests('/classes/all');
        this.classes = response.data;
        
        },
       async initCassConfig(){
        let response = await this.getRequests('/configs?config_key=settings.cass');
        this.cass_config = response.data;
        
        },
        /* register views to viewManager map */
        registerViews(){
          this.viewManager.set('home',true);
          this.viewManager.set('view-cbt',false);
          this.viewManager.set('create-cbt',false);
          this.viewManager.set('edit-cbt',false);
          this.viewManager.set('view-cbt',false);
          this.viewManager.set('assign-sections',false);
        },
        registerCbtTypes(){
          this.cbtType.set(1,'Mock');
           this.cbtType.set(2,'Cass 1');
          this.cbtType.set(3,'Cass 2');
          this.cbtType.set(4,'Cass 3');
          this.cbtType.set(5,'Cass 4');
          this.cbtType.set(6,'Tass');
          
          
        },
        /* set a specified view (html block) visible based on @id in the array of registered view in the @viewManger */
        toggleView(view='home'){
          
            for(const key of this.viewManager.keys()){
                key==view ? this.viewManager.set(key,true)
                            : this.viewManager.set(key,false);
            }
        },
        getCbtType(key){
           return this.cbtType.get(key);
        },
        async getCbt(id){
          let url = `/cbts/${id}`;
          let response = await this.getRequests(url);
          return response.data;
        },
        async viewCbt(id){
          this.selected_cbt  = await this.getCbt(id);
          
          this.view_cbt_component = 'view-cbt';
          this.toggleView('view-cbt');
        },
        async assignSections(id){
          this.selected_cbt  = await this.getCbt(id);
          await this.initClasses();
          this.assign_sections_component = 'assign-sections';
          this.toggleView('assign-sections');
        },
        async editCbt(id){
          let response = await this.getCbt(id);
          this.selected_cbt = response;
         
          this.edit_cbt_component = 'edit-cbt';
          this.toggleView('edit-cbt');
        },
        async deleteCbt(id){
          if(!confirm('This will delete all associated questions. Proceed?')){
            return;
          }

          let response = await this.deleteRequests('/cbts/'+id);
      
          if(response.data.message=='success'){
            toastr.success('CBT removed successfully');
            this.fetchCbtPage(this.cbt_page);
          }
        },
        async resetCbt(id){
          if(!confirm('This will clear all student cbt entries. Proceed?')){
            return;
          }

          let response = await this.putRequests('/cbts/'+id+'/reset');
        
          if(response.data.message=='success'){
            toastr.success('CBT reset successful');
            this.fetchCbtPage(this.cbt_page);
          }
        }
        
        
    },

    watch:{
       cbt_search(value){
          this.fetchCbtPage()
       },
       filter_exam_id(value){
          this.fetchCbtPage()
       },
       filter_subject_id(value){
          this.fetchCbtPage()
       },
    },
    mounted(){
      /* Initialize app */
      this.initApp();
    },
    created(){
      /* Boot App */
        this.boot();
        
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
    }
}

