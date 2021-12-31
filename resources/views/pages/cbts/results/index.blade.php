

    <x-header title="CBT Results " >
       
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
                           <h1 class="m-0">CBT Results</h1>
                       </div><!-- /.col -->
                       <div class="col-sm-6">
                           <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="/">Home</a></li>
                           <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                           <li class="breadcrumb-item active"><a href="/cbt-results">CBT Results</a></li>
                           </ol>
                       </div><!-- /.col -->
                       </div><!-- /.row -->
                       
                   </div><!-- /.container-fluid -->
                   </div>
                   <!-- /.content-header -->
   
                   <!-- Main content -->
                   <div class="content">
                   <div class="container-fluid">
                   
                       
                  
                   
                   <!--CBT system App  -->
                   
                    <div id="cbt-result-app" v-cloak class="card my-1 p-2">

                        <!-- CBT HOME -->
                        <div v-show="viewManager.get('home')" class="">
                           <div v-show="app_loading"><loader ></loader></div>
                          
                           <div class=" row my-2">
                                    <div class="col-md-4">
                                    <label for="">Class</label>
                                        <select v-model="selected_class" class="form-control">
                                            <option value="">--Select Class-- </option>
                                            <option :value="each_class.id" v-for="each_class in classes" :key="each_class.id">
                                                @{{each_class.name}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                    <label for="">Section</label>
                                        <select v-model="selected_section" class="form-control">
                                            <option value=""> </option>
                                            <option :value="section.id" v-for="section in sections" :key="section.id">
                                                @{{section.name}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                    <label for="">CBT</label>
                                        <select v-model="selected_cbt" class="form-control">
                                            <option value=""> </option>
                                            <option :value="cbt.id" v-for="cbt in cbts" :key="cbt.id">
                                                @{{cbt.name}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 py-2">
                                        <button class="btn btn-primary" @click="getCbtSectionStudents">Load Students</button>
                                    </div>
                            </div>
                            
                           <template v-if="students.data.length>0">
                                
                                <table class="table small table-responsive-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                
                                                <th>...</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="student,index in students.data" :key="index">

                                                <td>@{{index+1}}</td>
                                                <td>@{{student.user.name}}
                                                    <img :src="'/storage/'+student.user.avatar"   height="50" width="50" class="rounded-circle">
                                                </td>
                                                
                                                <td class="">
                                                    <button @click="viewResult(student.id)" class="btn btn-success"><i class="fa fa-eye"></i> View Results</button>
                                                    
                                                </td>
                                            </tr>
                                        </tbody>
                                </table>
                                <paginator :resource="students" @get-page="getCbtSectionstudents"></paginator>
                           </template>
                           <template v-else-if="app_loading==false && students.data.length==0 && selected_cbt!=null">
                                
                                <div class="container justify-content-center my-2">
                                    No Student match this query 
                                </div>
                           </template>
                           
                        </div>
                        <!-- /CBT HOME -->
                        <!-- Create CBT -->
                        <div v-show="viewManager.get('view-result')">
                            <button class="btn btn-default" @click="toggleView('home');result_component=''"><i class="fa fa-caret-left"></i> Back</button>
                            <component :is="result_component" :results="student_cbt_results"> </component>
                        </div>
                        
                     
                    </div>
                           
                      
                       
                   </div><!-- /.container-fluid -->
                   </div>
                   <!-- /.content -->
               </div>
           
               <x-footer motto="" >
                   <script src="/js/axios.min.js"></script>
          
                   <script src="/js/vue.global.prod.js"></script>
                   <script src="/js/main.js"></script>
               </x-footer>
           
     