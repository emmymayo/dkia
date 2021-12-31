

    <x-header title="CBT System " >
       
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
                           <h1 class="m-0">CBT System</h1>
                       </div><!-- /.col -->
                       <div class="col-sm-6">
                           <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="/">Home</a></li>
                           <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                           <li class="breadcrumb-item active"><a href="/cbts">CBT System</a></li>
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
                   
                    <div id="cbt-app" v-cloak class="card my-5 p-2">

                        <!-- CBT HOME -->
                        <div v-show="viewManager.get('home')" class="">
                           <div v-show="app_loading"><loader ></loader></div>
                           <div class="my-2 d-flex justify-content-end"><button @click="toggleView('create-cbt')" class="btn btn-primary ">CREATE CBT</button></div>
                           <div class="filter-panel row my-2">
                                    <div class="col-md-4 form-group">
                                        <label for="search">Search</label>
                                        <input id="search" type="search" class="form-control" placeholder="Search" v-model="cbt_search">
                                     </div>
                                    <div class="col-md-4">
                                    <label for="">Filter by subject</label>
                                        <select v-model="filter_subject_id" class="form-control">
                                            <option value=""> </option>
                                            <option :value="subject.id" v-for="subject in subjects" :key="subject.id">
                                                @{{subject.name}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                    <label for="">Filter by exam</label>
                                        <select v-model="filter_exam_id" class="form-control">
                                            <option value=""> </option>
                                            <option :value="exam.id" v-for="exam in exams" :key="exam.id">
                                                @{{exam.name}}
                                            </option>
                                        </select>
                                    </div>

                            </div>
                           <template v-if="cbts.data.length>0">
                                
                                <table class="table small table-responsive-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Duration (mins)</th>
                                                <th>Subject</th>
                                                <th>Type</th>
                                                <th>Published</th>
                                                <th>...</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="cbt,index in cbts.data" :key="index">

                                                <td>@{{index+1}}</td>
                                                <td>@{{cbt.name}}</td>
                                                <td>@{{cbt.duration}}</td>
                                                <td>@{{cbt.subject.name}}</td>
                                                <td>@{{getCbtType(cbt.type)}}</td>
                                                <td class="" :class="{ 'text-success': cbt.published}">@{{cbt.published?'Published':'Pending'}}</td>
                                                <td class="dropdown small">
                                                    <a class="btn" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <button @click="togglePublished(cbt.id,cbt.published)" class="dropdown-item"><i class="fa fa-toggle-on"></i> Toggle Publish</button>
                                                        <button @click="viewCbt(cbt.id)" class="dropdown-item"><i class="fa fa-eye"></i> View</button>
                                                        <button @click="assignSections(cbt.id)" class="dropdown-item"><i class="fas fa-school"></i> Assign Sections</button>
                                                        <button @click="editCbt(cbt.id)" class="dropdown-item"><i class="fa fa-edit"></i> Edit</button>
                                                        <button @click="resetCbt(cbt.id)" class="dropdown-item"><i class="fa fa-sync"></i> Reset</button>
                                                       
                                                        <button @click="deleteCbt(cbt.id)" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                                                       
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                </table>
                                <paginator :resource="cbts" @get-page="fetchCbtPage"></paginator>
                           </template>
                           <template v-else-if="app_loading==false && cbts.data.length==0">
                                
                                <div class="container justify-content-center ">
                                    No CBT found... <button @click="resetFilters" class="btn text-primary "> <i class="fa fa-sync"></i> Refresh </button>
                                </div>
                           </template>
                           
                        </div>
                        <!-- /CBT HOME -->
                        <!-- Create CBT -->
                        <div v-show="viewManager.get('create-cbt')">
                            <button class="btn btn-default" @click="toggleView('home')"><i class="fa fa-caret-left"></i> Back</button>
                            <create-cbt @saved="fetchCbtPage" :subjects="subjects" :exams="exams"> </create-cbt>
                        </div>
                        <!-- Edit CBT -->
                        <div v-show="viewManager.get('edit-cbt')">
                            <button class="btn btn-default" @click="toggleView('home');edit_cbt_component=null"><i class="fa fa-caret-left"></i> Back</button>
                            <component :is="edit_cbt_component" @updated="fetchCbtPage(cbt_page)" :cbt="selected_cbt" :subjects="subjects" 
                                :exams="exams" > 
                            </component>
                        </div>
                        <!-- Manage CBT -->
                        <div v-show="viewManager.get('view-cbt')">
                            <button class="btn btn-default" @click="toggleView('home');view_cbt_component=null"><i class="fa fa-caret-left"></i> Back</button>
                            <component :is="view_cbt_component" @updated="fetchCbtPage(cbt_page)" :cbt="selected_cbt" > </component>
                        </div>
                        <!-- Assign Sections -->
                        <div v-show="viewManager.get('assign-sections')">
                            <button class="btn btn-default" @click="toggleView('home');assign_sections_component=null"><i class="fa fa-caret-left"></i> Back</button>
                            <component :is="assign_sections_component" @updated="fetchCbtPage(cbt_page)" :classes="classes" :cbt="selected_cbt" > </component>
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
           
     