
//Broad sheet Vue App



const BroadsheetApp = {
    
    data(){
        return {
            app_loading:false,
            exams:[],
            active_exam:[],
            // passed whole selected exam object
            selected_exam:{},
            selected_class:null,
            //passed the whole section object so name and class can be accessed
            selected_section:{},
            subjects:[],
            classes:[],
            sections:[],
            students:[],
            section_marks:[],
            grade_systems:[],
            broadsheet_section:{classes:{}},
            broadsheet_exam:{session:{}},
            show_broadsheet:false,
            
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
        showBroadsheet(){this.show_broadsheet=true;},
        hideBroadsheet(){this.show_broadsheet=false;},
        async initAll(){
            this.initExams();  
            this.initClasses(); 
            this.initGradeSystem();
        },
        
        async initExams(){
            let response = await this.getRequests('/exams/find/all');
            this.exams = response.data;
            console.log(this.exams)
        },
        async initClasses(){
            let response = await this.getRequests('/classes/all');
            this.classes = response.data;
        },
        async initGradeSystem(){
            let response = await this.getRequests('/gradesystems');
            this.grade_systems = response.data;
        },
        //load sections accessible by authenticated user
        async loadClassSections(class_id){
           let url = '/sections/classes/'+class_id+'/user';
           let response = await this.getRequests(url);
            this.sections = response.data;
        },
        //get the subjects students registered in the section for the given exam
        async getClassSubjects(exam_id,section_id){
           let url = `/subjects/exams/${exam_id}/sections/${section_id}`;
           let response = await this.getRequests(url);
            this.subjects = response.data;
        },      
        async getClassStudents(exam_id,section_id){
           let url = `/students/exams/${exam_id}/sections/${section_id}`;
            let response = await this.getRequests(url);
            return response.data;
        },
        async getStudentMarks(student_id,exam_id,section_id){
            let url = `/marks/get?student_id=${student_id}&exam_id=${exam_id}&section_id=${section_id}`;
            let response = await this.getRequests(url);
            return response.data;
        },
        async loadBroadsheet(){
            toastr.info('Please wait...');
            this.broadsheet_section = this.selected_section;
            this.broadsheet_exam = this.selected_exam;
            await this.getClassSubjects(this.selected_exam.id,this.selected_section.id);
            let students = await this.getClassStudents(this.selected_exam.id,this.selected_section.id);
            
            //clear array
            this.section_marks = [];
            //get each student marks comprising all subjects
            for(student of students){
                let mark = await this.getStudentMarks(student.id,this.selected_exam.id,this.selected_section.id);
                this.section_marks.push(mark);
                
            }
             this.section_marks.sort((a,b)=>{
                 return this.subjectsSum(b) - this.subjectsSum(a);
             });
            this.showBroadsheet();
            
           
        },
        subjectsSum(marks){
            
            var sum = 0;
            for(mark of marks){
                sum += typeof mark.cass1 != 'undefined'? parseFloat(mark.cass1): 0;
                sum += typeof mark.cass2 != 'undefined'? parseFloat(mark.cass2): 0;
                sum += typeof mark.cass3 != 'undefined'? parseFloat(mark.cass3): 0;
                sum += typeof mark.cass4 != 'undefined'? parseFloat(mark.cass4): 0;
                sum += typeof mark.tass != 'undefined'? parseFloat(mark.tass): 0;
            }
            
            return sum;
        },
        subjectsAverage(marks){
            var sum = 0;
            var length = marks.length;
            sum = this.subjectsSum(marks);
            
            return sum<=0? sum:sum/length;
        },
        formattedPosition(rank){
            let st = [1,21,31,41,51,61,71,81,91,101,121,131,141,151,161,171,181,191,201,221];
            let nd = [2,22,32,42,52,62,72,82,92,102,122,132,142,152,162,172,182,192,202,222];
            let rd = [3,23,33,43,53,63,73,83,93,103,123,133,143,153,163,173,183,193,203,223];
            if(st.includes(rank)){return rank+'st';}
            else if(nd.includes(rank)){return rank+'nd';}
            else if(rd.includes(rank)){return rank+'rd';}
            else{return rank+'th';}
            
        },
        getGrade(value){
            for(grade of this.grade_systems){
                if(value>=grade.from && value<= grade.to){
                    return grade.grade;
                }
            }
        },
        printBroadsheet(){
            
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
        termText(term){
            if(term==1){
                return 'First';
            }
            else if(term==2){
                return 'Second';
            }
            else if(term==3){
                return 'Third';
            }
        }


    },

    watch:{
       selected_class(class_id){
           this.loadClassSections(class_id);
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

const broadsheet_app= Vue.createApp(BroadsheetApp);


if(document.querySelector('#broadsheet')){
    broadsheet_app.mount('#broadsheet');
}
//Broad sheet Vue App



const GradeSystemApp = {
    
    data(){
        return {
            app_loading:false,
            token:document.getElementById('_token').value,
            grade_systems:[],
            selected_gradesystem:{},
            new_gradesystem:{},
            show_gradesystems:true,
            edit_gradesystem:false
            
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
        showGradesystems(){this.show_gradesystems=true;},
        hideGradesystems(){this.show_gradesystems=false;},
        showEditGradesystem(){this.edit_gradesystem=true;},
        hideEditGradesystem(){this.edit_gradesystem=false;},
        openEditGradeSystem(){this.hideGradesystems(); this.showEditGradesystem()},
        closeEditGradeSystem(){this.hideEditGradesystem(); this.showGradesystems()},
        async initAll(){
            
            this.initGradeSystem();
        },
        
        
        async initGradeSystem(){
            let response = await this.getRequests('/gradesystems');
            this.grade_systems = response.data;
        },
        async getGradeSystem(id){
            let response = await this.getRequests('/gradesystems/'+id);
            return response.data;
        },
        async addGradeSystem(){
            let url = "/gradesystems";
            let data = {
                "_token" : this.token,
                "grade"  : this.new_gradesystem.grade,
                "from"  : this.new_gradesystem.from,
                "to"  : this.new_gradesystem.to,
                "remark"  : this.new_gradesystem.remark,

            };
            let response = await this.postRequests(url,data);
            if(response.data.message!="success"){
                toastr.error('Something went wrong.');
                return;
            }
            // proceed if successful
            //notify and refresh
            toastr.success('Added Successfully.');
            this.initGradeSystem();
        },
        async editGradeSystem(grade_system_id){
            //assign parameter to app global variable
            this.selected_gradesystem = await this.getGradeSystem(grade_system_id);
            this.openEditGradeSystem();
        },
        async updateGradeSystem(){
            let url = `/gradesystems/${this.selected_gradesystem.id}`;
            let data = {
                "_token" : this.token,
                "grade"  : this.selected_gradesystem.grade,
                "from"  : this.selected_gradesystem.from,
                "to"  : this.selected_gradesystem.to,
                "remark"  : this.selected_gradesystem.remark,

            };
            let response = await this.putRequests(url,data);
            if(response.data.message!="success"){
                toastr.error('Something went wrong.');
                return;
            }
            // proceed if successful
            //notify and refresh
            toastr.success('Updated Successfully.');
            this.initGradeSystem();
        },
        async deleteGradeSystem(id){
            if(!confirm("Are you sure you want to delete this record?")){
                return;
            }
            let url = `/gradesystems/${id}`;
            let response = await this.deleteRequests(url);
            if(response.data.message!="success"){
                toastr.error('Something went wrong.');
                return;
            }
            // proceed if successful
            //notify and refresh
            toastr.success('Deleted Successfully.');
            this.initGradeSystem();

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

const grade_system_app= Vue.createApp(GradeSystemApp);


if(document.querySelector('#grade-system')){
    grade_system_app.mount('#grade-system');
}
