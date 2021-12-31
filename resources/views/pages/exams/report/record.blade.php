
    <x-header title="Student Behavioural Analysis " >
    <!-- Select2 -->
  <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
         <!-- DataTables -->
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <meta name="csrf-token" content="">
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
                        <h1 class="m-0 lead">Student Behavioural Analysis</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/exams-record">Student Behavioural Analysis</a></li>
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
                <div id="exam-report-data" v-cloak class="elevation-2 p-3 card" >
                <div class="overlay w-100 h-100 text-center" v-show="app_loading" 
                    style="position:absolute;"><i class="fas fa-2x fa-spinner fa-spin "></i></div>
                <div class="row" v-show="!show_record">
                
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
                    <div class="form-group" v-show="!show_record">
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
                            
                            
                            <td>
                                <img :src="'/storage/'+student.avatar" class="rounded-circle" height="50" width="50" alt="">
                                @{{student.name}}
                            </td>
                            
                            
                            <td>
                            <button class="btn btn-success" @click="showDataEntry('{{csrf_token()}}',student.id)">
                             <i class="fas fa-file-invoice"></i> Update Data</button>
                                
                            </td>
                            
                            </tr>   
                            
                            
                            
                              
                           
                        
                        </tbody>
                </table>
                </div>
                <!-- VUe table end -->

                <!-- Student Record -->
                <div v-show="show_record">
                <button class="btn btn-danger" @click="closeRecord"> Back</button>
                </div>
                <div class="card" v-show="show_record">
                    <div class="card-header">
                        <div class="card-title"></div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="">Attendance</label>
                                <input class="form-control" type="number" v-model="selected_student.attendance">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="">Comment</label>
                                <input class="form-control" type="text" v-model="selected_student.comment1">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="">Remark</label>
                                <input class="form-control" type="text" v-model="selected_student.comment2">
                            </div>
                            <div class="col-md-3  form-group" v-for="(skill,index) in selected_student.skills">
                                <label for="">@{{skill.name}}: @{{selected_student.skills[index].value}}</label>
                                <input class="form-control " type="range" 
                                step="1" :min="skill.min" :max="skill.max" 
                                 v-model="selected_student.skills[index].value">
                                 
                            </div>
                        </div>
                    
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success" @click="updateData('{{csrf_token()}}')">Update</button>
                    </div>
                
                
                </div>

                <!-- Student Record end -->

               


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