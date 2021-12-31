
//Assign Teacher Vue App

const AssignTeacher = {
    
    data(){
        return {
            app_loading:false,
            teachers:[],
            subjects:[],
            selected_teacher:{},
            assign_section_class:null,
            assign_subject_section:null,
            assign_subject_class:null,
            classes:[],
            sections:[],
            assign_subject_sections:[],
            teacher_sections:[],
            teacher_section_subjects:[],
            show_teachers:false,
            show_subjects:false,
            show_assign_sections:false,
            show_assign_subjects:false
            
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
        showTeachers(){this.show_teachers=true;},
        hideTeachers(){this.show_teachers=false;},
        showSubjects(){this.show_subjects=true;},
        hideSubjects(){this.show_subjects=false;},
        showAssignSections(){this.show_assign_sections=true;},
        hideAssignSections(){this.show_assign_sections=false;},
        showAssignSubjects(){this.show_assign_subjects=true;},
        hideAssignSubjects(){this.show_assign_subject=false;},
        openTeachers(){
            this.show_assign_sections=false;
            this.show_assign_subjects=false;
            this.showTeachers();
        },
        
        async initAll(){
            this.initTeachers();
            //this.initSubjects();    
            this.initClasses();
            this.showTeachers();    
        },
        
        async initClasses(){
            response = await this.getRequests('/classes/all');
            this.classes = response.data;
        },
        async initSubjects(){
            response = await this.getRequests('/subjects/get/all');
            this.subjects = response.data;
        },
        async initTeachers(){
            response = await this.getRequests('/teachers/get/all');
            this.teachers = response.data;
        },
         //load sections
         async loadClassSections(class_id){
            url = '/sections/classes/'+class_id;
            response = await this.getRequests(url);
            this.sections = response.data;
            this.setTeacherSections();
        },
         async loadAssignSubjectSections(class_id){
            url = '/sections/classes/'+class_id;
            response = await this.getRequests(url);
            this.assign_subject_sections = response.data;
            //this.setTeacherSections();
        },
         async loadTeacherSections(teacher_id){
            url = `/teachers/${teacher_id}/sections`;
            response = await this.getRequests(url);
            this.teacher_sections = response.data;
           
            
        },
        setTeacherSections(){
             sections = this.sections;
             teacher_sections = this.teacher_sections;
            for(let i=0;i<sections.length;i++){
               
               for(let j=0;j<teacher_sections.length;j++){
                
                   if(sections[i].id===teacher_sections[j].section_id){
                    
                       this.sections[i].checked=true;
                       break;
                   }
                   else{
                    this.sections[i].checked=false;
                   }
                   
               }  
            }
          
        },
         async loadTeacherSectionSubjects(teacher_id){
            let section_id = this.assign_subject_section;
            url = `/teachers/${teacher_id}/sections/${section_id}`;
            response = await this.getRequests(url);
            this.teacher_section_subjects = response.data;
           
            
        },
        setTeacherSectionSubjects(){
             let subjects = this.subjects;
             teacher_section_subjects = this.teacher_section_subjects;
            for(let i=0;i<subjects.length;i++){
               
               for(let j=0;j<teacher_section_subjects.length;j++){
                
                   if(subjects[i].id===teacher_section_subjects[j].subject_id){
                   
                       this.subjects[i].checked=true;
                       break;
                   }
                   else{
                    this.subjects[i].checked=false;
                   }
                   
               }  
            }
          
        },
        async loadAssignSection(teacher){
            this.assign_section_class="";
            this.sections=[];
            await this.loadTeacherSections(teacher.id);
            
            this.selected_teacher = teacher;
            this.hideTeachers();
            this.showAssignSections();
        },
        async toggleTeacherSection(token,section_id){
            let teacher_id = this.selected_teacher.id;
            let url = `/teachers/${teacher_id}/sections/toggle`;
            let payload = {'_token':token,
                            'section_id':section_id};
                let response = await this.postRequests(url,payload);
                if(response.data.message=='success'){
                    await this.loadAssignSection(this.selected_teacher);
                    toastr.success('Done.');
                }else{
                    toastr.error('Something went wrong.');
                }
        },

        async loadAssignSubject(teacher){
            this.selected_teacher = teacher;
            this.assign_subject_sections=[];
            this.assign_subject_section=null,
            this.assign_subject_class=null,
            this.hideTeachers();
            this.hideSubjects();
            this.showAssignSubjects();
        },
        async loadSubjects(teacher_id){
            this.hideSubjects();
            await this.initSubjects();
            await this.loadTeacherSectionSubjects(teacher_id);
            this.setTeacherSectionSubjects();
            this.showSubjects();
        },
        async toggleTeacherSectionSubject(token,subject_id){
            let teacher_id = this.selected_teacher.id;
            let section_id = this.assign_subject_section;
            let url = `/teachers/${teacher_id}/sections/${section_id}/toggle`;
            let payload = {'_token':token,
                            'subject_id':subject_id};
                let response = await this.postRequests(url,payload);
                if(response.data.message=='success'){
                    await this.loadSubjects(teacher_id);
                   toastr.success('Done.');
                }else{
                    toastr.error('Something went wrong.');
                }

        },
        

    },

    watch:{
        assign_section_class(class_id){ 
            if(class_id==''){return;}
            this.loadClassSections(class_id);
        },
        assign_subject_class(class_id){ 
            if(class_id==''){return;}
            this.loadAssignSubjectSections(class_id);
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
    },
}

const assign_teacher_app= Vue.createApp(AssignTeacher);


if(document.querySelector('#assign-teacher')){
    assign_teacher_app.mount('#assign-teacher');
}
