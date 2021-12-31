
    <x-header title="Assign Teacher" >
 
 </x-header>
 
         
         <x-nav-header />
         <x-sidebar-nav  />
         <x-sidebar-control />
        

         
         <div class="content-wrapper" style="min-height: 264px;">
             <!-- Content Header (Page header) -->
             <div class="content-header">
             <div class="container-fluid">
                 <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1 class="m-0 lead">Assign Teacher</h1>
                 </div><!-- /.col -->
                 <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                     <li class="breadcrumb-item"><a href="/">Home</a></li>
                     <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                     <li class="breadcrumb-item active"><a href="/teachers/assign/index">Assign Teacher</a></li>
                     </ol>
                 </div><!-- /.col -->
                 </div><!-- /.row -->
                 
             </div><!-- /.container-fluid -->
             </div>
             <!-- /.content-header -->

             <!-- Main content -->
             <div class="content">
             <div class="container-fluid">
             <!-- Vue App -->
             <div id="assign-teacher" v-cloak class="elevation-2 p-3 card" >
             <div class="overlay w-100 h-100 text-center" v-show="app_loading" 
                 style="position:absolute;"><i class="fas fa-2x fa-spinner fa-spin "></i></div>
          
             <!-- Vue Teachers Table -->
             <div v-show="show_teachers">   
             
             <table id="" class="table table-hover small table-responsive-md" >
                     <thead>
                         <tr>
                             <th>#</th>
                             <th>Teacher(s)</th>
                             
            
                             <th>...</th>
                         </tr>
                     </thead>
                     <tbody> 
                         <tr v-for="(teacher, index) in teachers" :key="index" >
                         <td >@{{index+1}}</td>
                        
                         <td>
                            <img :src="'/storage/'+teacher.user.avatar" height="50" width="50" class="rounded-circle" alt="">
                            @{{teacher.user.name}} 
                          </td>
                         
                         
                         <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success" ><i class="fas fa-stream"></i> </button>
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu" >
                                    <button class="dropdown-item" @click="loadAssignSection(teacher)"><i class="fas fa-hand-point-right "></i>Assign Sections</button>
                                    <div class="dropdown-divider"></div>
                                    <button class="dropdown-item"  @click="loadAssignSubject(teacher)"><i class="fas fa-hand-point-right"></i>Assign Subjects</button>
                                </div>
                            </div>
                         </td>
                         
                        
                         
                         
                         </tr>   
                         

                     </tbody>
             </table>
             
             </div>
             <!-- VUe table end -->

             <!-- Assign Sections -->
             <div v-if="show_assign_sections">
                <button class="btn  float-right font-weight-bold" @click="openTeachers">&times;</button>
             </div>
             <div v-if="show_assign_sections" class="card">
                <div class="card-header">Assign Section To - @{{selected_teacher.user.name}}</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Select Class</label>
                        <select v-model="assign_section_class" class="form-control ">
                            <option value="">... </option>
                            <option :value="each_class.id" v-for="(each_class,index) in classes">@{{each_class.name}}</option>
                        </select>
                    </div>
                    
                    <table  class="table table-hover small table-responsive-md">
                        
                        <tr v-for="(section,index) in sections" :key="index">
                            <td><input type="checkbox"  
                            v-model="section.checked"  :checked="section.checked"
                             @change="toggleTeacherSection('{{csrf_token()}}',section.id)" ></td>
                            <td>@{{section.classes.name+' '+section.name}}</td>
                        </tr>
                    </table>
                   
                    
               </div>

             </div>
             <!-- End of Assign Sections -->

             <!-- Assign Subjects -->
             <div v-if="show_assign_subjects">
                <button class="btn float-right font-weight-bold" @click="openTeachers"> &times;</button>
             </div>
             <div v-if="show_assign_subjects" class="card">

                <div class="card-header">Assign Subject to - @{{selected_teacher.user.name}}</div>
                <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="">Select Class</label>
                        <select v-model="assign_subject_class" class="form-control ">
                            <option value="">... </option>
                            <option :value="each_class.id" v-for="(each_class,index) in classes">@{{each_class.name}}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Select Section</label>
                        <select v-model="assign_subject_section" class="form-control ">
                            <option value="">... </option>
                            <option :value="section.id" v-for="(section,index) in assign_subject_sections">
                            @{{section.classes.name+' '+section.name}}</option>
                        </select>
                    </div>

                </div>
                    <div class="mb-3">
                        <button class="btn btn-primary" @click="loadSubjects(selected_teacher.id)">Load Subjects</button>
                    </div>
                    
                    <table  class="table table-hover small table-responsive-md" v-show="show_subjects">
                        
                        <tr v-for="(subject,index) in subjects" :key="index">
                            <td><input type="checkbox"  
                            v-model="subjects[index].checked"  :checked="subjects[index].checked"
                             @change="toggleTeacherSectionSubject('{{csrf_token()}}',subject.id)" ></td>
                            <td>@{{subject.name}}</td>
                        </tr>
                    </table>
                   <div v-if="false" class="alert alert-info">
                     <button class="btn btn-success" @click="">Update</button> 
                   </div>
                   
                    
               </div>

             </div>
             <!-- End of Assign Subjects -->

            


             </div>
             <!-- Vue App End -->
             
             
             
            
             
                 
             </div><!-- /.container-fluid -->
             </div>
             <!-- /.content -->
         </div>
     
         <x-footer motto="" >
         <script src="/js/axios.min.js"></script>
       
         <script src="/js/vue.global.prod.js"></script>
         <script src="/js/teachers.js"></script>
         

         </x-footer>