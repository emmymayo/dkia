<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <link rel="stylesheet" href="/css/styles.css">
    <style> body {
                font-family: 'Nunito', sans-serif;

            }
            .rot{	-ms-transform:rotate(-90deg); -webkit-transform:rotate(-90deg); 
			        transform:rotate(-90deg);  	
                }
    </style>
    <title>Document</title>
</head>
<body>

    <div id="result_body" class="my-2 mx-5">

        <div id="result-head ">
            <div class="text-center" id="logo">
                <img src="/storage/{{$settings->where('key','school.logo')->first()['value']}}"
                    height="100" width="50" alt="">
            </div>
            <div id="school-info my-3">
                <h4 class="text-center text-uppercase" id="school-name">{{$settings->where('key','school.name')->first()['value']}}</h4>
                <h5 class="text-center text-uppercase" id="school-address">{{$settings->where('key','school.address')->first()['value']}}</h5>
                <h6 class="text-center text-muted text-uppercase" id="school-motto">Motto:{{$settings->where('key','school.motto')->first()['value']}}</h6>
            </div>
            <div id="exam-info my-3">
                <h5 class="lead font-weight-bold text-center text-uppercase my-4">
                    {{$exam->termText()}} Term {{$exam->session->start.'/'.$exam->session->end}} Session Report 
                </h5>
            </div>
            <div id="student-info my-3 ">
                <div class="row mx-auto px-5">
                
                    <div class="col-sm-5 row ">
                        <div class="col-sm-12 mb-3 text-uppercase" id="student-name">Name: {{$record->student->user->name}}</div>
                        <div class="col-sm-12 mb-3 text-uppercase" id="student-class">Class: {{$record->section->classes->name.' '}} 
                                                                                            {{$record->section->name=='general' ? ''
                                                                                              : $record->section->name}}
                        </div>
                        <div class="col-sm-12 mb-3 text-uppercase" id="student-gender">Gender: {{$record->student->gender}}</div>
                        <div class="col-sm-12 mb-3 text-uppercase" id="student-average">Average: {{round($student_average,1)}} </div>
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-5 row ">
                        <div class="col-sm-12 mb-3 text-uppercase" id="student-attendance">No. of times present: {{$attendance}}</div>
                        <div class="col-sm-12 mb-3 text-uppercase" id="times-opened">No. of times School Opened: {{$settings->where('key','times.school.opened')->first()['value']}}</div>
                        <div class="col-sm-12 mb-3 text-uppercase" id="no-in-class">No. in class: {{$no_in_class}} </div>
                        <div class="col-sm-12 mb-3 text-uppercase" id="student-grade">Grade: {{App\Support\Helpers\Exam::getLetterScoreRemark($student_average)}} </div>
                        
                    </div>
                   

                    
                </div>
            </div>
        </div>

        <div id="result-scores ">

        <div class="card card-outline card-secondary mt-5"></div>
        <div class="text-uppercase text-center text-muted my-2">Cognitive Ability</div>
            <table class="table text-uppercase ">
                <tr class="text-uppercase  p-5  text-center">
                    <th class="text-left">Subjects</th>
                    @foreach (config('settings.cass') as $cass )
                        <th class="">{{$cass}}</th>
                    @endforeach
                    <th>Total</th>
                    <th class="rot  py-3">Class <br> Lowest</th>
                    <th class="rot py-3 ">Class <br> Highest</th>
                    <th class="rot py-3">Class <br> Average</th>
                    <th>Position</th>
                    <th>Grade</th>
                    <th>Remark</th>
                </tr>

                @foreach($marks as $mark)
                <tr class="text-center">
                    <td class="text-left">{{$mark->subject->name}}</td>
                    @foreach (config('settings.cass') as $cass )
                    <td>{{$mark->{$cass} }}</td>
                    @endforeach
                    <td>{{$mark->totalScore()}}</td>
                    <td>{{$mark->subjectStat()->mini}}</td>
                    <td>{{$mark->subjectStat()->maxi}}</td>
                    <td>{{round($mark->subjectStat()->average,1)}}</td>
                    <td>{{$mark->subjectPosition()}}</td>
                    <td>{{App\Support\Helpers\Exam::getLetterScoreRemark($mark->totalScore())}}</td>
                    <td>{{App\Support\Helpers\Exam::getWordScoreRemark($mark->totalScore())}}</td>
                    
                </tr>
                @endforeach
    
        </table>
        <div class="card card-outline card-secondary"></div>
        </div>

        <div class="" id="student-skills">
            <div class="card card-outline card-secondary mt-5"></div>
            <div class="text-uppercase text-center text-muted my-2">Behavioural Assessment</div>
            <div class="card card-outline card-secondary "></div>
            
            <div class="row">
                @foreach ($record->skills as $skill )
                <div class="col-md-4 my-2 row">
                    <div class="col-md-6">{{$skill['name']}} </div> 
                    <div class="col-md-6">
                        @for($i=0;$i<$skill['value'];$i++)
                            &#x2605;
                        @endfor 
                    </div> 
                    
                </div>
                @endforeach

                
            </div>
        
        
        
        </div>
        
        <div class="my-5">
            @if($record->comment1 != null OR $record->comment1 != '' )
            <div class="text-uppercase h6">Remark: {{$record->comment1}}</div>
            @endif
            @if($record->comment2 != null OR $record->comment2 != '' )
            <div class="text-uppercase h6">Additional Remark: {{$record->comment2}}</div>
            @endif
        </div>
            <div class="other-info text-right text-uppercase">
                Next Term Resumes: {{$settings->where('key','next.term.begins')->first()['value']}}
            </div>
        <div class="card card-outline card-secondary mt-5"></div>
    </div>
    

    
   
</body>
</html>