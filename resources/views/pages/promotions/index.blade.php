
    <x-header title="Student Promotion " >
    <!-- Select2 -->
  
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
                        <h1 class="m-0 lead">Student Promotion</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/promotions">Student Promotions</a></li>
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
                <div id="student-promotions" v-cloak class="elevation-2 p-3 card" >
                <div class="overlay w-100 h-100 text-center" v-show="app_loading" 
                    style="position:absolute;"><i class="fas fa-2x fa-spinner fa-spin "></i></div>
                <div class="row" >
                
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
                    <div class="form-group" >
                        <button class="btn btn-primary" @click="loadStudents" > Load Students</button>
                    </div>
                <!-- Vue Table -->
                <div v-show="show_students"> 
                    <div class="row" >
                    
                    <div class=" form-group col-md-4">
                    <label for="next_class" class="">Next Class:</label>
                        <select  class="form-control" v-model="next_class"  >
                                
                                <option :value="each_class.id" v-for="(each_class, key) in classes" :key="each_class.key">@{{each_class.name}}</option>

                        </select>
                    </div>
                    <div class="form-group col-md-4">
                    <label for="section" class="">Next Section:</label>
                        <select v-model="next_section"  class="form-control" >
                        <option :value="section.id" v-for="(section, key) in all_sections" :key="key">@{{section.name}}</option>
                        
                        </select>
                        
                    </div> 

                    

                    

                    </div> 
                
                <table id="" class="table table-hover small table-responsive-md" >
                        <thead>
                            <tr>
                                <th>#</th>
                                
                                <th>Name</th>
                                <th>Status</th>
                                
                                <th>...</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        
                         
                            
                            <tr v-for="(student,index) in students" :key="index" >
                            <td >@{{index+1}}</td>
                            
                            
                            <td>
                                <img :src="'/storage/'+student.avatar" class="rounded-circle" 
                                height="50" width="50"
                                :alt="student.name+' photo'">

                                @{{student.name}}
                             </td>
                             <td>
                                <span v-if="students[index].done==true" class="text-success">
                                    Done
                                </span>
                             </td>
                            
                            
                            <td>
                            <button class="btn btn-success" 
                                @click="promoteStudent('{{csrf_token()}}',student.id,index)">
                                <i class="fas "></i> Promote
                            </button>
                                
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
            <script src="/js/promotion.js"></script>
           
            

            </x-footer>