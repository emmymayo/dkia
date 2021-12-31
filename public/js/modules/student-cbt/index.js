
import Paginator from '../../utilities/pagination.js';
import Loader from '../../utilities/loader.js';
import TakeTest from './cbt-test.js';
export const StudentCbtApp = {
    components:{
      
      'paginator':Paginator,
      'loader': Loader,
      'take-test': TakeTest
    },
    data(){
        return {
            app_loading:false,
            viewManager: new Map(), //Map for Handling visibility of different Views using v-show, only one should be visible at a time
            cbtType: new Map(),
            cbts:{data:[]},
            cbt_page:1,
            test_component:null,
            test_cbt:{},
            test_questions:{},

              
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
          this.fetchStudentCbts();
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
          this.viewManager.set('take-test',false);
          
        },
        /* set a specified view (html block) visible based on @id in the array of registered view in the @viewManger */
        toggleView(view='home'){
          
            for(const key of this.viewManager.keys()){
                key==view ? this.viewManager.set(key,true)
                            : this.viewManager.set(key,false);
            }
        }, 
        registerCbtTypes(){
            this.cbtType.set(1,'Mock');
            this.cbtType.set(2,'Cass 1');
            this.cbtType.set(3,'Cass 2');
            this.cbtType.set(4,'Cass 3');
            this.cbtType.set(5,'Cass 4');
            this.cbtType.set(6,'Tass');
          },
        getCbtType(key){
            return this.cbtType.get(key);
         },
        async fetchStudentCbts(page=1){
            this.cbt_page = page;
            let url = '/student-cbts?page='+page;
            let response = await this.getRequests(url);
            this.cbts  = response.data;
        },
        async getCbtQuestions(cbt_id){
          let url = `/cbt-questions?cbt_id=${cbt_id}`;
          let response = await this.getRequests(url);
          return response.data;
        },
        async takeTest(cbt){
          this.test_questions = await this.getCbtQuestions(cbt.id);
          this.test_cbt = cbt;
          this.test_component = 'take-test';
          this.toggleView('take-test');
        },
        finishTest(){
          this.toggleView('home');
          this.test_component='';
        }
        
        
    },

    watch:{
       
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

