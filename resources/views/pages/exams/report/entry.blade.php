
    <x-header title="Exam Score Entry " >
    
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
                        <h1 class="m-0 lead">Exam Score Entry</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/exams-entry">Exam Score Entry</a></li>
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
                <div id="exam-entry" v-cloak class="elevation-2 p-3 card" >
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
                        <label for="subject" class="">Subject:</label>
                            <select v-model="my_subject" id="section" class="form-control" >
                            <option :value="subject.id" v-for="(subject, key) in subjects" :key="key">@{{subject.name}}</option>
                               
                            </select>
                            
                        </div> 

                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" @click="loadStudentEntries" > Load Student Entries</button>
                    </div>
                <!-- Vue Table -->
                <div v-show="show_entries">   
                <button class="btn btn-success float-right" @click="bulkUpdate()"> <i class="fa fa-paper-plane"></i> Update</button>
                <table id="" class="table table-hover small table-responsive-md" >
                        <thead>
                            <tr>
                                <th>#</th>
                                
                                <th>Name</th>
                                <th v-if="assessments.indexOf('cass1')!=-1">CASS 1</th>
                                <th v-if="assessments.indexOf('cass2')!=-1">CASS 2</th>
                                <th v-if="assessments.indexOf('cass3')!=-1">CASS 3</th>
                                <th v-if="assessments.indexOf('cass4')!=-1">CASS 4</th>
                                <th v-if="assessments.indexOf('tass')!=-1">TASS</th>
                                <th>...</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        
                         
                            
                            <tr v-for="(entry,index) in entries" :key="index" >
                            <td >@{{index+1}}</td>
                            
                            
                            <td>@{{entries[index].student.user.name}}</td>
                            <input type="hidden" v-model="entries[index].id" >
                            <td v-if="assessments.indexOf('cass1')!=-1"><input type="text" class="form-control"   v-model="entries[index].cass1" ></td>
                            <td v-if="assessments.indexOf('cass2')!=-1"><input type="text" class="form-control"  v-model="entries[index].cass2" ></td>
                            <td v-if="assessments.indexOf('cass3')!=-1"><input type="text" class="form-control"  v-model="entries[index].cass3" ></td>
                            <td v-if="assessments.indexOf('cass4')!=-1"><input type="text" class="form-control"  v-model="entries[index].cass4" ></td>
                            <td v-if="assessments.indexOf('tass')!=-1"><input type="text" class="form-control" v-model="entries[index].tass"></td>
                            
                            <td>
                            
                                
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