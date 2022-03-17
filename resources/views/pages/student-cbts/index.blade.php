

    <x-header title="Student CBT System " >
       
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
                           <h1 class="m-0">Student CBT System</h1>
                       </div><!-- /.col -->
                       <div class="col-sm-6">
                           <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="/">Home</a></li>
                           <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                           <li class="breadcrumb-item active"><a href="/student-cbts">Student CBT System</a></li>
                           </ol>
                       </div><!-- /.col -->
                       </div><!-- /.row -->
                       
                   </div><!-- /.container-fluid -->
                   </div>
                   <!-- /.content-header -->
   
                   <!-- Main content -->
                   <div class="content">
                   <div class="container-fluid">
                   
                       
                  
                   
                   <!--CBT Student App  -->
                   
                    <div id="student-cbt-app" v-cloak class="card my-1 p-2">

                            <!--Student CBT HOME -->
                        <div v-show="viewManager.get('home')" class="">
                           <div v-show="app_loading"><loader ></loader></div>
                         
                           <template v-if="cbts.data.length>0">
                                
                                <table class="table small table-responsive-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Duration (mins)</th>
                                                <th>Subject</th>
                                                <th>Type</th>
                                                <th>...</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="cbt,index in cbts.data" :key="index">

                                                <td>@{{index+1}}</td>
                                                <td>@{{cbt.name}}</td>
                                                <td>@{{cbt.duration}}</td>
                                                <td>@{{cbt.subject.name}}</td>
                                                <td>@{{getCbtType(parseInt(cbt.type))}} </td>
                                                <td class="">
                                                        <button @click="takeTest(cbt)" class="btn btn-success"><i class="fa fa-chalkboard-teacher"></i> Take Test</button>
                                                        
                                                
                                                </td>
                                            </tr>
                                        </tbody>
                                </table>
                                <paginator :resource="cbts" @get-page="fetchStudentCbts"></paginator>
                           </template>
                           <template v-else-if="app_loading==false && cbts.data.length==0">
                                
                                <div class="container justify-content-center ">
                                    No CBT Available... 
                                </div>
                           </template>
                           
                        </div>
                        <!-- /Student CBT HOME -->
                     
                     <!-- Take test -->
                        <div v-show="viewManager.get('take-test')" class="">
                            <!-- <button class="btn btn-default" @click="toggleView('home');test_component=''">Back</button> -->
                            <component :is="test_component" :cbt="test_cbt" @finished="finishTest" 
                                :cbt_questions="test_questions">
                            </component>
                        </div>

                     <!-- /Take test -->
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
           
     