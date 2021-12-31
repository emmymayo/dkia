
import Paginator from '../../../utilities/pagination.js';
import Loader from '../../../utilities/loader.js';
import ViewCbtResult from './view.js';
export const CbtResultApp = {
    components:{
      'view-cbt-result':ViewCbtResult,
      'paginator':Paginator,
      'loader': Loader
    },
    data(){
        return {
            app_loading:false,
            viewManager: new Map(), //Map for Handling visibility of different Views using v-show, only one should be visible at a time
            cbtType: new Map(),
            cbts:[],
            classes:[],
            sections:[],
            students:{data:[]},
            selected_cbt:null,
            selected_section:null,
            selected_class:null,
            student_cbt_results:[],
            result_component:''
        }
    },
    methods:{
        /* Called when Vue App is created */
        boot(){
          
          this.registerViews();
        },
        /* Called when App is mounted */
        async initApp(){
          //this.fetchStudentCbts();
          this.initClasses();
        },
        async getRequests(url,query = ''){
            try {
                let response = await axios.get(url+query);
                return response;
              } catch (error) {
                console.dir(error);
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
        /* register views to viewManager map */
        registerViews(){
          this.viewManager.set('home',true);
          this.viewManager.set('view-result',false);
          
        },
        /* set a specified view (html block) visible based on @id in the array of registered view in the @viewManger */
        toggleView(view='home'){
          
            for(const key of this.viewManager.keys()){
                key==view ? this.viewManager.set(key,true)
                            : this.viewManager.set(key,false);
            }
        },
        async initClasses(){
            let response = await this.getRequests('/classes/all');
            this.classes = response.data;
            
        },
        async getCbts(){
            let url = `/cbts?section_id=${this.selected_section}&active_exam=true`;
            let response = await this.getRequests(url);
            this.cbts = response.data;
        },
        async getUserSections(){
            let url = '/sections/classes/'+this.selected_class+'/user';
            let response = await this.getRequests(url);
            this.sections = response.data;
        },
        async getCbtSectionStudents(page=1){
            let url = `/cbt-results/cbts/sections?cbt_id=${this.selected_cbt}&section_id=${this.selected_section}&page=${page}`;
            let response = await this.getRequests(url);
            this.students = response.data;
        },
        async viewResult(student_id){
            let url = `/cbt-results?student_id=${student_id}&section_id=${this.selected_section}&cbt_id=${this.selected_cbt}`;
            let response = await this.getRequests(url);
            this.student_cbt_results = response.data;
            this.result_component = 'view-cbt-result';
            this.toggleView('view-result');
        }

    
        
        
    },

    watch:{
       selected_class(value){
        if(value==null){return;}
            this.getUserSections();
       },
       selected_section(value){
        if(value==null){return;}
            this.getCbts();
       },
       selected_cbt(value){
            this.getCbtSectionStudents();
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

