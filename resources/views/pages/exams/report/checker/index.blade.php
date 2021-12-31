
    <x-header title="Exam Report Checker " >
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
                        <h1 class="m-0 lead">Exam Report Checker</h1>
                        
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/exams/report/checker">Exam Report Checker</a></li>
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
                <div id="exam-report-checker" v-cloak class="elevation-2 p-3 card" >
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
                        <div class="form-group col-md-4">
                        <label for="section" class="">Exam:</label>
                            <select v-model="selected_exam" id="section" class="form-control" >
                                @foreach ( $exams as $exam )
                                <option value="{{$exam->id}}" >{{$exam->name}}</option>
                                @endforeach
                            </select>
                            
                        </div> 

                        

                        

                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" @click="loadStudents" > Load Students</button>
                    </div>
                <!-- Vue Table -->
                <div v-show="show_students">   
                
                <table id="" class="table table-hover small table-responsive-md" >
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
                            
                            
                            <td> <img :src="'/storage/'+student.avatar" class="rounded-circle" height="50" width="50" alt="">
                            @{{student.name}}</td>
                            
                            
                            <td>
                            <form action="/exams/report" method="post" target="_blank">
                                @csrf
                                <input type="hidden" name="student_id" :value="student.id">
                                <input type="hidden" name="exam_id" :value="selected_exam">
                                <button class="btn btn-success" type="submit" >
                                    <i class="fas fa-file-invoice"></i> Check Report
                                </button>
                            </form>
                            
                                
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
            <script src="/js/vue.app.js"></script>
            

            </x-footer>