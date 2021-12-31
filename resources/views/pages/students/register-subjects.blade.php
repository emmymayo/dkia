
    <x-header title="Register Exam Subjects " >
    <!-- Select2 -->
 
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
                        <li class="breadcrumb-item active"><a href="#">Exam Registration</a></li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                <div class="container-fluid">
                <input type="hidden" id="student_id" name="student_id" value="{{$student->id}}">
                <input type="hidden" id="section_id" name="ssection_id" value="{{$student_section}}">
                <!-- Vue App -->
                <div id="reg-subjects" v-cloak class="elevation-2 p-3 card" >
                <div class="overlay w-100 h-100 text-center" v-show="app_loading" 
                    style="position:absolute;"><i class="fas fa-2x fa-spinner fa-spin "></i></div>
                
                <!-- Vue Table -->
                <div v-show="show_subjects">   
                <div>
                    Total Subjects Registered: @{{registered_subjects.length}}
                </div>
                <table id="" class="table table-hover small table-responsive-md" >
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
                                <input type="checkbox"  v-model="subjects[index].registered" 
                                @change="registerSubject('{{csrf_token()}}',subject.id)" >
                                
                            </td>
                            
                            </tr>   
                            
                            
                            
                              
                           
                        
                        </tbody>
                </table>

                
                </div>
                <!-- VUe table end -->

                </div>
                <!-- Vue App End -->
                
                
                
               
                
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
        
            <x-footer motto="" >
            <script src="/js/axios.min.js"></script>
          
            <script src="/js/vue.global.prod.js"></script>
            <script src="/js/student-panel.js"></script>
            

            </x-footer>