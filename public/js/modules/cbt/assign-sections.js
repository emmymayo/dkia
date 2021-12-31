

export default{
    props:['cbt','classes'],
    data(){
        return{
            selected_class:'',
            sections:[],
            show_sections:false,
            cbt_sections:[],
        }
    },
    methods:{
        async loadSections(){
            // Load sections
            //load cbt sections
            // set assign true for those that overlap
            // show sections
            let section_url = '/sections/classes/'+this.selected_class+'/user';
            try{
                toastr.info('Fetching sections...',{timeout:20000});
                let response = await axios.get(section_url);
                this.sections = response.data;
                 response = await axios.get('/cbt-sections?cbt_id='+this.cbt.id);
                this.cbt_sections = response.data;
                toastr.info('Processing...',{timeout:10000});
                for (let i = 0; i < this.sections.length; i++) {
                    this.sections[i].assigned = false;
                    this.cbt_sections.forEach(cbt_section => {
                        if(this.sections[i].id == cbt_section.section_id){
                            this.sections[i].assigned = true;
                        }
                    });
                    
                }
                this.show_sections = true;
                toastr.clear();
                toastr.success('Done');
                
                
            }catch(error){
                toastr.clear();
                toastr.error('Something went wrong.');
                
            }
            
        },
        async toggleCbtSection(section_id){
            
            let url = '/cbt-sections/toggle';
            let data = {
                'cbt_id': this.cbt.id,
                'section_id': section_id
            };
            try{
                toastr.info('Processing data...',{timeout:10000});
                let response = await axios.put(url, data);
            }catch(error){
                toastr.clear();
                toastr.error('Something went wrong.');
            }
            await this.loadSections();
        }
    },
    created(){
        this.sections = [];
        this.show_sections = false;
    },
    template: `
        <h4 class="lead text-center"> Assign Sections <small class="text-muted"> (Select sections that can attempt CBT.)</small> </h4>
        

        <table class="table small table-responsive-sm  my-2">
            <tr>
                <th>Name</th>
                <td>{{cbt.name}}</td>
            </tr>
            <tr>
                <th>Exam</th>
                <td>{{cbt.exam.name}}</td>
            </tr>
            <tr>
                <th>Subject</th>
                <td>{{cbt.subject.name}}</td>
            </tr>
        </table>

        <div class="mt-4">
            <div class="row"> 
                <div class="col-md-4 form-group">
                    
                    <select id="classes" v-model="selected_class" class="form-control">
                        <option value="">--Select Class-- </option>
                        <option :value="a_class.id" v-for="a_class in classes" :key="a_class.id">{{a_class.name}} </option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                   
                    <button class="btn btn-primary" @click="loadSections">
                        Load Sections
                    </button>
                </div>
            </div>

            
                <table v-if="sections.length>0" class="table small table-responsive-sm table-hover  my-2">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Assign</th>
                    </tr>
                    <tr v-for="(section, index) in sections" :key="section.id">
                        <td>{{index+1}}</td>
                        <td>{{section.classes.name}} {{section.name}}</td>
                        <td>
                            <input class="" type="checkbox" 
                            v-model="sections[index].assigned" 
                            @change="toggleCbtSection(sections[index].id)" /> 
                        </td>
                    </tr>
                </table>
            
        </div>
    `
}