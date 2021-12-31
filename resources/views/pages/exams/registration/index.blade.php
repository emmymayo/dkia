
    <x-header title="Exam Registration " >
  
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
                        <h1 class="m-0 lead">Exam Registration</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/exams-registration">Exam Registration</a></li>
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
                <div id="exam-reg" v-cloak class="elevation-2 p-3 card" >
                <div class="overlay w-100 h-100 text-center" v-show="app_loading" 
                    style="position:absolute;"><i class="fas fa-2x fa-spinner fa-spin "></i></div>
                <div class="row">
                
                        <div class=" form-group col-md-4">
                          <label for="my_class" class="">Class:</label>
                            <select  class="form-control" v-model="my_class" id="my_class" >
                                    
                                    <option :value="each_class.id" v-for="(each_class, key) in classes" :key="each_class.key">@{{each_class.name}}</option>

                            </select>
                        </div>
                        <div class="form-group col-md-4">
                        <label for="section" class="">Section:</label>
                            <select v-model="my_section" id="section" class="form-control" >
                            <option :value="section.id" v-for="(section, key) in sections" :key="key">@{{section.name}}</option>
                               
                            </select>
                            
                        </div> 
                      
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" @click="loadStudents" > Load Students</button>
                    </div>
                <!-- Vue Table -->
                <div v-show="showStudents">   
                <table id="" class="table table-hover table-responsive-md small" >
                        <thead>
                            <tr>
                                <th>#</th>
                               
                                <th>Name</th>
                                
                                <th>...</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        
                         
                            
                            <tr v-for="(student,index) in students" :key="index" >
                            <td >@{{index+1}}</td>
                            <td>
                              <img :src="'/storage/'+student.avatar" alt="Avatar" height="50" width="50" class="img-circle">
                              @{{student.name}}
                            </td>
                            
                            <td>
                            <button class="btn btn-success" 
                                    @click="initRegistrationModal('{{csrf_token()}}',student.id)">
                                       <i class="fa fa-edit"></i> Register Subjects
                                    </button>
                                
                            </td>
                            
                            </tr>   
                            
                            
                            
                              
                           
                        
                        </tbody>
                </table>
                </div>
                <!-- VUe table end -->

                <!-- Vue Registration Modal -->

          <div class="modal fade modal-primary " id="exam-registration-modal"  v-if="selected_student">
        <div class="modal-dialog modal-lg">
        <div class="overlay w-100 h-100 text-center" v-show="app_loading" >
        <i class="fas fa-2x fa-spinner fa-spin "></i></div>
        
          <div class="modal-content">
            <div class="modal-header bg-primary">
            
              <h4 class="modal-title">Subject Registration For @{{active_exam.name}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>

              
            </div>
            <div class="modal-body p-3">
            <div class="row">
              <h5 class="text-center ">@{{selected_student.user.name}}</h5>
            </div>
            
            
            

           <hr>
           <span class="text-success">@{{subject_registration_message}}</span>
           <hr>
            <br>
            <table class="table table-hover table-responsive-md small">
                <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Short Name</th>
                                
                                <th>...</th>
                            </tr>
                </thead>
                <tbody>
                        
                        
                         
                            
                        <tr v-for="(subject,index) in subjects" :key="index" class="uppercase">
                            <td >@{{index+1}}</td>
                            <td>@{{subject.name}}</td>
                            
                            <td>@{{subject.short_name}}</td>
                            
                            <td>
                            <input class="form-check-input" type="checkbox" 
                            :value="subject.id" v-model="registered_subjects_id"
                            @change="registerSubject(subject.id)">
                                
                            
                            </td>
                            
                          </tr>   
                            
                            
                            
                              
                           
                        
                </tbody>
            </table>
            
              <form>
                
              
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal" >Done</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
   
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

        <!-- End Vue registration modal -->



                </div>
                <!-- Vue App End -->
                
                
                
               
                
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
        
            <x-footer motto="" >
            <script src="/js/axios.min.js"></script>
          
            <script src="/js/vue.global.prod.js"></script>
            <script src="/js/vue.app.js"></script>
            

            </x-footer>