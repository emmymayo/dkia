
    <x-header title="Attendance - Roll Call" >
 
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
                        <h1 class="m-0 lead">Attendance - Roll Call</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/attendances/roll/call">Roll Call</a></li>
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
                <div id="roll-call" v-cloak class="elevation-2 p-3 card " >
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
                        <label for="exam" class="">Attendance For:</label>
                            <select v-model="my_exam" id="section" class="form-control" >
                            <option :value="exam.id" v-for="(exam, key) in exams" :key="key">@{{exam.name}}</option>
                            </select>
                            
                        </div> 
                        
                        <div class="form-group col-md-4">
                        <label for="date" class="">Date:</label>
                            <input class="form-control" type="date" v-model="roll_date" />
                        </div>

                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary bg-gradient-primary" @click="loadRolls('{{csrf_token()}}')" > 
                         Load Students</button>
                    </div>
                    <div v-show="show_init_info" class="">
                        Fetching: @{{init_roll_count+' of '+init_roll_max}}
                        
                    </div>
                    
                <!-- Vue Table -->
                <div v-show="show_rolls" class="animate__animated animate__slideIn animate__slow">   
                
                <table id="" class="table table-striped table-responsive-md" >
                        <thead>
                            <tr>
                                <th>#</th>
                                
                                
                                <th>Name</th>
                                <th>Morning</th>
                                <th>Afternoon</th>
                                <th>Remark</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        
                        
                         
                            
                            <tr v-for="(student, index) in students" :key="index" >
                            <td >@{{index+1}}</td>
                            
                            
                            
                            <td> 
                                <img :src="'/storage/'+students[index].avatar" height="50" width="50" class="rounded-circle"alt=""> 
                                @{{students[index].name}}
                            </td>
                            
                            <td><input type="checkbox" true-value="1" false-value="0" v-model="students[index].roll.morning"></td>
                            <td><input type="checkbox" true-value="1" false-value="0" v-model="students[index].roll.afternoon"></td>
                            <td><input type="text" class="form-control" v-model="students[index].roll.remark"></td>
                            
                            
                            </tr>   
                            
                            
                            
                              
                           
                        
                        </tbody>
                </table>
                <div>
                    <button class="btn btn-success float-right" @click="submitRoll('{{csrf_token()}}')">
                        <i class="fa fa-paper-plane"></i> Submit
                    </button>
                    <div v-show="show_finished_info" class="">
                        Completed: @{{init_finished_count+' of '+init_finished_max}}  
                    </div>
                </div>
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
            <script src="/js/attendance.js"></script>
            

            </x-footer>