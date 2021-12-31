
//School timetable Vue App



const SchoolTimetable = {
    
    data(){
        return {
            app_loading:false,
            timetables:[],
            timeslots:[],
            entries:[],
            entry_timetable_id:null,
            entry_timetable:{},
            entry_timetable_name:null,
            classes:[],
            exams:[],
            sections:[],
            selected_class:null,
            selected_timetable:{data:{}},
            new_timetable:{},
            selected_timeslot:{},
            new_timeslot:{},
            selected_entry:{timetable_timeslot:{}},
            new_entry:{},
            entry_timeslots:[],
            show_timetables:false,
            show_edit_timetable:false,
            show_add_timetable:false,
            show_timeslots:false,
            show_edit_timeslot:false,
            show_add_timeslot:false,
            show_entries:false,
            show_edit_entry:false,
            show_add_entry:false,
            token:document.getElementById('_token').value
            

         
        }
    },
    methods:{
        
        async getRequests(url,query = ''){
            try {
                return response = await axios.get(url+query);
                
              } catch (error) {
                console.dir(error);
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
        async putRequests(url,params = {}){
            try {
                return response = await axios.put(url,params);
                
              } catch (error) {
                console.error(error);
                toastr.error('Something went wrong. Try again.');
              }
        },

        async deleteRequests(url,params={}){
            try {
                return response = await axios.delete(url,params);
                
              } catch (error) {
                console.error(error);
                toastr.error('Something went wrong. Try again.');
              }
        },
        
        async initAll(){
            
            this.getTimetables();
            this.showTimetables();
            await this.getExams();  
            await this.getClasses();
            
        },
        async getClasses(){
          let response = await this.getRequests('/classes/all');
          this.classes = response.data;
        },
        async getExams(){
          let response = await this.getRequests('/exams/find/all');
          this.exams = response.data;
        },

        async loadClassSections(class_id){
          let url = '/sections/classes/'+class_id+'/user';
          
          let response = await this.getRequests(url);
          this.sections = response.data;
        },
        showTimetables(){this.show_timetables=true;},
        hideTimetables(){this.show_timetables=false;},
        showEditTimetable(){this.show_edit_timetable=true;},
        hideEditTimetable(){this.show_edit_timetable=false;},
        showAddTimetable(){this.show_add_timetable=true;},
        hideAddTimetable(){this.show_add_timetable=false;},
        showTimeslots(){this.show_timeslots=true;},
        hideTimeslots(){this.show_timeslots=false;},
        showEditTimeslot(){this.show_edit_timeslot=true;},
        hideEditTimeslot(){this.show_edit_timeslot=false;},
        showAddTimeslot(){this.show_add_timeslot=true;},
        hideAddTimeslot(){this.show_add_timeslot=false;},
        showEntries(){this.show_entries=true;},
        hideEntries(){this.show_entries=false;},
        showEditEntry(){this.show_edit_entry=true;},
        hideEditEntry(){this.show_edit_entry=false;},
        showAddEntry(){this.show_add_entry=true;},
        hideAddEntry(){this.show_add_entry=false;},
         //initialize subjects on load
        async getTimetables(page=1){
            
            let response = await this.getRequests('/timetables?page='+page);
            this.timetables = response.data;
              
        },
        async getTimetable(id){
           let url = `/timetables/${id}`;
           let response = await this.getRequests(url);
           this.selected_timetable = response.data;
           
        },
        async getSection(id){
           let url = `/sections/get/${id}`;
           let response = await this.getRequests(url);
           return response.data;
        },
       async editTimetable(id){
        
            await this.getTimetable(id);
            if(this.selected_timetable.data.scheduleable_type=='sections'){
                let timetable_section = await this.getSection(this.selected_timetable.data.scheduleable_id);
                this.selected_class = timetable_section.classes_id;
                await this.loadClassSections(timetable_section.id);
                
            }
            //hide timetable index before loading edit form
            this.hideTimetables();
            this.showEditTimetable();
        },
        closeEditTimetable(){
          this.hideEditTimetable()
          this.initAll();
        },
        async updateTimetable(){
          
          let timetable = this.selected_timetable.data 
          let data = { '_token':this.token,
                        'name':timetable.name, 
                        'type':timetable.scheduleable_type,
                        'id':timetable.scheduleable_id,};
          let url = `/timetables/${timetable.id}`;
          let response = await this.putRequests(url,data);
          if (response.data.message=='success'){
            return toastr.success('Timetable Updated Successfully')
          }
          return toastr.error('Something went wrong. Please try again.');

        },

        newTimetable(){
          this.hideTimetables();
          //clear previous value if any
          this.new_timetable={};
          this.showAddTimetable();
        },
        async addTimetable(){
          
          let url=`/timetables`;
          let data = {'_token':this.token,
                      'name':this.new_timetable.name,
                      'type':this.new_timetable.scheduleable_type,
                      'id':this.new_timetable.scheduleable_id
                    };
            
            let response = await this.postRequests(url,data);
            if(response.data.message=='success'){
              return toastr.success('Timetable added successfully');
            }
            return toastr.error('Something went wrong. Please try again');
        },
        closeAddTimetable(){
          this.hideAddTimetable()
          this.initAll();
        },

        async deleteTimetable(id){
          if(!confirm('Are you sure you want to delete this timetable? Ensure you delete all entries before proceeding.'))
          {
              return;
          }
          let url = `/timetables/${id}`;
          let data = {'_token':this.token};
          let response = await this.deleteRequests(url,data);
          if(response.data.message == 'success'){
            toastr.success('Timetable deleted successfully');
            toastr.info('Refreshing...');
            this.initAll();
          }
          else{
            toastr.error('Something went wrong, Consider deleting timetable entries if any');
          }

        },

      async getTimeslots(page=1){
            
          let response = await this.getRequests('/timetable-timeslots?page='+page);
          this.timeslots = response.data;
            
      },
      async getTimeslot(id){
         let url = `/timetable-timeslots/${id}`;
         let response = await this.getRequests(url);
         this.selected_timeslot = response.data;
         
         
      },

      async openTimeslots(){
         await this.getTimeslots();
         this.hideTimetables();
         this.showTimeslots();
      },

      closeTimeslots(){
        this.hideTimeslots();
        this.showTimetables();
      },

      newTimeslot(){
        this.hideTimeslots()
        //clear previous value if any
        this.new_timeslot={};
        this.showAddTimeslot();
      },
      closeAddTimeslot(){
        this.hideAddTimeslot();
        this.openTimeslots();
      },
      async addTimeslot(){
        let url=`/timetable-timeslots`;
          let data = {'_token':this.token,
                      'name':this.new_timeslot.name,
                      'from':this.new_timeslot.from,
                      'to':this.new_timeslot.to
                    };
            
            let response = await this.postRequests(url,data);
            if(response.data.message=='success'){
              
              return toastr.success('Time slot added successfully');
            }
            return toastr.error('Something went wrong. Please try again');
        
      },

      async editTimeslot(id){
        await this.getTimeslot(id);
        this.hideTimeslots();
        this.showEditTimeslot();
      },
      async closeEditTimeslot(){
        this.hideEditTimeslot();
        this.openTimeslots();
      },

      async updateTimeslot(){
        let timeslot = this.selected_timeslot 
          let data = { '_token':this.token,
                        'name':timeslot.name, 
                        'from':timeslot.from,
                        'to':timeslot.to,};
          let url = `/timetable-timeslots/${timeslot.id}`;
          let response = await this.putRequests(url,data);
          if (response.data.message=='success'){
            return toastr.success('Time slot Updated Successfully')
          }
          return toastr.error('Something went wrong. Please try again.');

      },
      async deleteTimeslot(id){
        if(!confirm('Are you sure you want to delete this time slot? '+ 
          'Ensure you delete all entries asigned to this time slot before proceeding.'))
        {
            return;
        }
        let url = `/timetable-timeslots/${id}`;
        let data = {'_token':this.token};
        let response = await this.deleteRequests(url,data);
        if(response.data.message == 'success'){
          toastr.success('Timeslot deleted successfully');
          toastr.info('Refreshing...');
          this.openTimeslots();
        }
        else{
          toastr.error('Something went wrong, Consider deleting timetable entries assigned to this time slot if any');
        }

      },
      async getEntries(page=1){
        let timetable_id = this.entry_timetable.id;
        let url = `/timetable-records?timetable_id=${timetable_id}&page=${page}`;
        let response = await this.getRequests(url);
        this.entries = response.data;
       
      },

      async getEntry(id){
        let url = `/timetable-records/${id}`;
        let response = await this.getRequests(url);
        this.selected_entry = response.data;
        //set date property for input type date
        this.selected_entry.date = this.selected_entry.day;
        
      },

      async loadEntries(timetable){
        this.entry_timetable = timetable;
        
        await this.getEntries();
        this.hideTimetables();
        this.showEntries();
      },
      closeEntries(){
        this.hideEntries();
        this.showTimetables();
      },
      async getEntryTimeslots(paginate=false){
        let response = await this.getRequests('/timetable-timeslots');
        this.entry_timeslots = response.data;
      
      },
      async editEntry(id){
         await this.getEntry(id);
         
        await this.getEntryTimeslots();
         this.hideEntries();
         this.showEditEntry();
      },
      parseDate(date){
        return (new Date(date));
      },
      async closeEditEntry(){
        this.hideEditEntry();
        this.loadEntries(this.entry_timetable);
      },
      async updateEntry(){
        let entry = this.selected_entry ;
        
        let day = this.entry_timetable.scheduleable_type=='sections'
                          ?entry.day
                          :entry.date;
          let data = { '_token':this.token,
                        'day':day, 
                        'entry':entry.entry,
                        'timeslot_id':entry.timetable_timeslot_id,
                      };
          let url = `/timetable-records/${entry.id}`;
          let response = await this.putRequests(url,data);
          if (response.data.message=='success'){
            return toastr.success('Timetable Entry Updated Successfully')
          }
          return toastr.error('Something went wrong. Please try again.');

      },
      async newEntry(){
        await this.getEntryTimeslots();
        this.new_entry= {};
        this.hideEntries();
        this.showAddEntry();
      },
      async closeAddEntry(){
        this.hideAddEntry();
        this.loadEntries(this.entry_timetable);
      },
      async addEntry(){
        let day = this.entry_timetable.scheduleable_type=='sections'
                          ?this.new_entry.day
                          :this.new_entry.date;
        let url=`/timetable-records`;
          let data = {'_token':this.token,
                      'day':day,
                      'entry':this.new_entry.entry,
                      'timetable_id':this.entry_timetable.id,
                      'timeslot_id':this.new_entry.timeslot_id
                    };
            
            let response = await this.postRequests(url,data);
            if(response.data.message=='success'){
              
              return toastr.success('Timetable entry added successfully');
            }
            return toastr.error('Something went wrong. Please try again');
        
      },
      async deleteEntry(id){
        if(!confirm('Are you sure you want to delete this timetable entry? '))
        {
            return;
        }
        let url = `/timetable-records/${id}`;
        let data = {'_token':this.token};
        let response = await this.deleteRequests(url,data);
        if(response.data.message == 'success'){
          toastr.success('Timetable entry deleted successfully');
          toastr.info('Refreshing...');
          this.loadEntries(this.entry_timetable.id);
        }
        else{
          toastr.error('Something went wrong');
        }

      },
         
    },

    watch:{
       selected_class(class_id){
         this.loadClassSections(class_id);
       }
    },
    mounted(){
        this.initAll();
    },
    created(){
        
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

const school_timetable_app= Vue.createApp(SchoolTimetable);


if(document.querySelector('#school-timetable')){
    school_timetable_app.mount('#school-timetable');
}

//View  timetable Vue App

const SchoolTimetableViewer = {
    
    data(){
        return {
            app_loading:false,
            timetables:[],
            timeslots:[],
            timetable_timeslots:[],
            entries:[],
            timetable_value:'',
            timetable_id:null,
            timetable_type:null,
            show_timetable:false,
            days:['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'],
            dates:[]
            

         
        }
    },
    methods:{
        
        async getRequests(url,query = ''){
            try {
                return response = await axios.get(url+query);
                
              } catch (error) {
                console.dir(error);
                toastr.error('Something went wrong. Try again.');
              }
        },
        
        
        async initAll(){
            
            this.getTimetables();
            
            
        },
       
         //initialize subjects on load
        async getTimetables(){
            
            let response = await this.getRequests('/timetables');
            this.timetables = response.data;
            
        },

        async getTimetableTimeslots(timetable_id){
          let response = await this.getRequests(`/timetable-timeslots/timetables/${timetable_id}`);
          this.timetable_timeslots = response.data;
        },

        async getDailyClassTimetableEntries(day,timetable_id){
            let response = await this.getRequests('/timetable-records?'+'timetable_id='+timetable_id+
                                                  '&day='+day);
            return response.data;
        },
        async getDateExamTimetableEntries(date,timetable_id){
            let response = await this.getRequests('/timetable-records?'+'timetable_id='+timetable_id+
                                                  '&day='+date);
            return response.data;
        },
        async getTimetableEntries(timetable_id){
            let response = await this.getRequests('/timetable-records?'+'timetable_id='+timetable_id);
            return response.data;
        },
        async loadClassTimetable(timetable_id){
          await this.getTimetableTimeslots(timetable_id);
          let days = this.days;
          for(let i=0;i<days.length;i++){
            let entry = await this.getDailyClassTimetableEntries(days[i],timetable_id);
            this.entries.push(entry);
          }
          console.log(this.timetable_timeslots);
          console.log(this.entries);
        },
        async getExamDates(timetable_id){

        },
        async loadExamTimetable(timetable_id){
          await this.getTimetableTimeslots(timetable_id);
          let entries = await this.getTimetableEntries(timetable_id);
          //get distinct dates
          let dates = [];
          entries.forEach(element => {
            if(!dates.includes(element.day)){
              dates.push(element.day);
            }
          });
          //parse dates
         
          //sort dates cuz it wont sort without parsing
          dates.sort(function(a,b){return (new Date(a))-(new Date(b));});
          this.dates = dates;
          this.entries = entries;
          
 
        },
        async loadTimetable(){
          //timetable value is in the form id|scheaduleable_type 
          let timetable = this.timetable_value.split('|');
           this.timetable_id = timetable[0];
          this.timetable_type = timetable[1];
          
          toastr.info('Fetching timetable...');
          //clear previous entries
          this.entries=[];
          this.dates=[];
          if(this.timetable_type=='sections'){
            await this.loadClassTimetable(this.timetable_id);
          }else{
            await this.loadExamTimetable(this.timetable_id);
          }
          this.show_timetable=true;
        },
        parseDate(date){
            let day = new Date(date).toDateString();
            
            return day;
        },
        printTimetable(){
            
            var a = window.open('','','height=1024, width=786');
            //get print area
            a.document.write('<html>');
            a.document.write(document.head.innerHTML);
            a.document.write('<body>');
            a.document.write(document.getElementById('printable').innerHTML);

            a.document.write('</body>');
            a.document.write('</html>');
            a.document.close();
            //give some time for dom to load
            setTimeout(()=>{a.print()},2500);
        },
         
    },

    watch:{
       
    },
    mounted(){
        this.initAll();
    },
    created(){
        
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

const school_timetable_viewer_app= Vue.createApp(SchoolTimetableViewer);


if(document.querySelector('#school-timetable-viewer')){
    school_timetable_viewer_app.mount('#school-timetable-viewer');
}
