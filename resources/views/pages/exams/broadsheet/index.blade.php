

    <x-header title="Broadsheet " >
        <style>
            th.translate{
                /* transform: translateY(150px); */
            }
            th.rotate{
                
                height:250px;
                white-space: nowrap;
                padding: 0 !important;

            }
            th.rotate > div{
                
                transform: translateY(-20px) rotate(-90deg);
                width:30px;
                
                }
            th.rotate > div > span{
                
                padding: 0;
                
            }
        </style>
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
                        <h1 class="m-0 lead">Broadsheet</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><a href="/exams/students/broadsheet">Broadsheet</a></li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                <div class="container-fluid">
                    
                    <div id="broadsheet" v-cloak class="card p-3">
                        <x-vue-loader/>
                        <div class="my-2">
                            <div class="row">
                                <div class="form- col-md-4">
                                    <label for="">Select Exam</label>
                                    <select v-model="selected_exam" required class="form-control">
                                        <option value="">--select exam--</option>
                                        <option v-for="(exam,index) in exams" :key="index" :value="exam">
                                            @{{exam.name}}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Select Class</label>
                                    <select v-model="selected_class" required class="form-control">
                                        <option value="">--select class--</option>
                                        <option v-for="(each_class,index) in classes" :key="index" :value="each_class.id">
                                            @{{each_class.name}}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Select Section</label>
                                    <select v-model="selected_section" required class="form-control">
                                        <option value="">--select section--</option>
                                        <option v-for="(section,index) in sections" :key="index" :value="section">
                                            @{{section.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary" @click="loadBroadsheet">Load Broadsheet</button>
                            </div>
                        </div>
                        <div v-show="show_broadsheet "><button class="btn btn-default float-right" @click="printBroadsheet"><i class="fa fa-print"></i> print</button></div>
                        <div id="printable" v-show="show_broadsheet" class="my-2">
                            <div>
                                <h3 class="text-uppercase text-center my-2">
                                @{{broadsheet_section.classes.name}}
                                @{{broadsheet_section.name!='general'?broadsheet_section.name:''}} -
                                @{{termText(broadsheet_exam.term)+' term'}} @{{broadsheet_exam.session.start+'/'+broadsheet_exam.session.end+' session'}}
                                </h3>
                            </div>
                            <table class="table table-bordered  ">
                                <thead>
                                <tr class="" >
                                    <!-- List subjects in first row -->
                                    <th class="translate">S/N</th>
                                    <th class="translate">Name</th>
                                    <th class="rotate small" v-for="(subject,subject_index) in subjects" :key="subject_index">
                                       <div class=""><span> @{{subject.name}}</span></div>
                                    </th>
                                    <th class="translate">Total</th>
                                    <th class="translate">Average</th>
                                    <th class="translate">Grade</th>
                                    <th class="translate">Position</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="" v-for="(student_marks,marks_index) in section_marks" :key="marks_index">
                                    <td>@{{marks_index+1}}</td>
                                    <td > <span v-if="student_marks[0]!='undefined'"></span>@{{student_marks[0].student.user.name}}</td>
                                    <td v-for="(subject,subject_index) in subjects" :key="subject_index">
                                        <template v-for="(student_mark,mark_index) in student_marks">
                                            <span v-if="student_mark.subject_id==subject.id">@{{student_mark.subject_total}}</span>
                                        </template>
                                    </td>
                                    <td>@{{subjectsSum(student_marks)}}</td>
                                    <td>@{{subjectsAverage(student_marks)}}</td>
                                    <td>@{{getGrade(subjectsAverage(student_marks))}}</td>
                                    <!-- Students have been sorted according to score hence their index is same as position -->
                                    <td>@{{formattedPosition(marks_index+1)}}</td>
                                </tr>
                                </tbody>

                                
                            </table>
                            
                        
                        </div>

                    </div>
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
        
            <x-footer motto="" >
                <script src="/js/axios.min.js"></script>
       
                <script src="/js/vue.global.prod.js"></script>
                <script src="/js/broadsheet-grade.js"></script>
            </x-footer>
        </div>
  