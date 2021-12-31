
    <x-header title="Exam Score View " >
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
                        <h1 class="m-0 lead">Exam Score View</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/exams-entry/view">Exam Score View</a></li>
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
                <div id="exam-entry-view" v-cloak class="elevation-2 p-3 card" >
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
                <div v-show="showEntries">   
               
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
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        
                         
                            
                            <tr v-for="(entry,index) in entries" :key="index" >
                            <td >@{{index+1}}</td>
                            
                            
                            <td>@{{entries[index].student.user.name}}</td>
                            
                            <td v-if="assessments.indexOf('cass1')!=-1">@{{entry.cass1}}</td>
                            <td v-if="assessments.indexOf('cass2')!=-1">@{{entry.cass2}}</td>
                            <td v-if="assessments.indexOf('cass3')!=-1">@{{entry.cass3}}</td>
                            <td v-if="assessments.indexOf('cass4')!=-1">@{{entry.cass4}}</td>
                            <td v-if="assessments.indexOf('tass')!=-1">@{{entry.tass}}</td>
                            <td>@{{(!isNaN(parseInt(entry.tass,10))? parseInt(entry.tass,10):0)+
                                   (!isNaN(parseInt(entry.cass1,10))? parseInt(entry.cass1,10):0) +
                                   (!isNaN(parseInt(entry.cass2,10))? parseInt(entry.cass2,10):0) +
                                   (!isNaN(parseInt(entry.cass3,10))? parseInt(entry.cass3,10):0) +
                                   (!isNaN(parseInt(entry.cass4,10))? parseInt(entry.cass4,10):0) 
                                   }}</td>
                            
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