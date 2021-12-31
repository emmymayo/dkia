
const NoticeApp = {
    
    data(){
        return {
            app_loading:false,
            token:document.getElementById('_token').value,
            notices:[],
            roles:[],
            selected_notice:{},
            view_selected_notice:{role:{}},
            new_notice:{},
            show_notices:true,
            edit_notice:false,
            view_notice:false
            
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
        showNotices(){this.show_notices=true;},
        hideNotices(){this.show_notices=false;},
      
        showEditNotice(){this.edit_notice=true;},
        hideEditNotice(){this.edit_notice=false;},

        showViewNotice(){this.view_notice=true;},
        hideViewNotice(){this.view_notice=false;},
        
        openEditNotice(){this.hideNotices(); this.showEditNotice()},
        closeEditNotice(){this.hideEditNotice(); this.showNotices()},

        openViewNotice(){this.hideNotices(); this.showViewNotice()},
        closeViewNotice(){this.hideViewNotice(); this.showNotices()},
        
        async initAll(){
            this.initNotices();
            this.initRoles();
        },
        
        
        async initNotices(){
            let response = await this.getRequests('/notices');
            this.notices = response.data;
            console.log(response.data);
        },
        async initRoles(){
            let response = await this.getRequests('/roles');
            this.roles = response.data;
            console.log(response.data);
        },
        async getNotice(id){
            let response = await this.getRequests('/notices/'+id);
            return response.data;
        },
        async addNotice(){
            let url = "/notices";
            let data = {
                "_token" : this.token,
                "title"  : this.new_notice.title,
                "message"  : this.new_notice.message,
                "role_id"  : this.new_notice.role_id,
                "expires_at"  : this.new_notice.expires_at

            };
            let response = await this.postRequests(url,data);
            if(response.data.message!="success"){
                toastr.error('Something went wrong.');
                return;
            }
            // proceed if successful
            //notify and refresh
            toastr.success('Added Successfully.');
            this.initNotices();
        },
        async editNotice(notice_id){
            //assign parameter to app global variable
            this.selected_notice = await this.getNotice(notice_id);
            this.openEditNotice();
        },
        async updateNotice(){
            let url = `/notices/${this.selected_notice.id}`;
            let data = {
                "_token" : this.token,
                "title"  : this.selected_notice.title,
                "message"  : this.selected_notice.message,
                "role_id"  : this.selected_notice.role_id,
                "expires_at"  : this.selected_notice.expires_at,

            };
            let response = await this.putRequests(url,data);
            if(response.data.message!="success"){
                toastr.error('Something went wrong.');
                return;
            }
            // proceed if successful
            //notify and refresh
            toastr.success('Updated Successfully.');
            this.initNotices();
        },
        async deleteNotice(id){
            if(!confirm("Are you sure you want to delete this notice?")){
                return;
            }
            let url = `/notices/${id}`;
            let response = await this.deleteRequests(url);
            if(response.data.message!="success"){
                toastr.error('Something went wrong.');
                return;
            }
            // proceed if successful
            //notify and refresh
            toastr.success('Deleted Successfully.');
            this.initNotices();

        },
        viewNotice(notice){
            this.view_selected_notice = notice;
            this.openViewNotice();
        },
        formatDate(date){
            let new_date = new Date(date).toLocaleDateString();
            return new_date;
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

const notice_app= Vue.createApp(NoticeApp);


if(document.querySelector('#notice-app')){
    notice_app.mount('#notice-app');
}
