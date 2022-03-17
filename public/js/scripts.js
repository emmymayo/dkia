//Make tables responsive
//var responsiveInterval = setInterval(tableResponsive,3000);

//clear interval after 30secs
//setTimeout(()=>clearInterval(responsiveInterval),20000);
function tableResponsive(){
    var tables = document.getElementsByTagName('table');
    for(let i = 0; i<tables.length;i++){
        !tables[i].classList.contains('table-responsive')?tables[i].classList.add('table-responsive'):'';
        
    }
}


//time init
setInterval(showDate,1000);
setInterval(showTime,1000);


//Full Calendar initialization
if(document.getElementById('calendar')){
document.addEventListener('DOMContentLoaded', function(){
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        themeSystem: 'bootstrap',
        initialView: 'dayGridMonth'
    })
    calendar.render();
});
}

//Student Attendance Calendar
if(document.getElementById('student-attendance')){
document.addEventListener('DOMContentLoaded', function(){
    //get student attendance
    var student_id = document.getElementById('student_id').value ;
    var url = `/attendances/student/${student_id}/events`;
    //initialize attendance
            var calendarEl = document.getElementById('student-attendance');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                themeSystem: 'bootstrap',
                initialView: 'dayGridWeek',
                headerToolbar:{
                    left:'prev,next today',
                    center:'title',
                    right:'dayGridMonth,dayGridWeek'
                },
                eventSources:[
                    {url:`/attendances/student/${student_id}/events`}
                ]
                // events: myEvents
            });
            
            calendar.render();
    
});
}

// Admin Datatables initialization
if(document.getElementById('admin_table')){
$(document).ready(function(){
    $('#admin_table').DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
        "paging":true, "searching":true, "dom":"Bfrtip", "ordering":false,
        "pageLength":10, 
      "buttons": ["copy", "excel", "pdf", "print", "colvis"]
    });
});
}

// Teacher Datatables initialization
if(document.getElementById('teacher_table')){
    $(document).ready(function(){
        $('#teacher_table').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false,
            "paging":true, "searching":true, "dom":"Bfrtip", "ordering":false,
            "pageLength":10, 
          "buttons": ["copy", "excel", "pdf", "print","colvis"]
        });
    });
    }

    // Student Datatables initialization- not in use
if(document.getElementById('student_table')){
    $(document).ready(function(){
        $('#student_table').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false,
            "paging":true, "searching":true, "dom":"Bfrtip", "ordering":false,
            "pageLength":10, 
          "buttons": ["copy", "excel", "pdf", "print","colvis"]
        });
    });
    }

     // Classes Datatables initialization
if(document.getElementById('class_list_table')){
    $(document).ready(function(){
        $('#class_list_table').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false,
            "paging":true, "searching":true, "dom":"Bfrtip", "ordering":false,
            "pageLength":10, 
          "buttons": ["copy", "excel", "pdf", "print","colvis"]
        });
    });
    }

// Sections Datatables initialization
if(document.getElementById('section_list_table')){
    $(document).ready(function(){
        $('#section_list_table').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false,
            "paging":true, "searching":true, "dom":"Bfrtip", "ordering":true,
            "pageLength":10, 
          "buttons": ["copy", "excel", "pdf", "print","colvis"]
        });
    });
    }

    // Examinstions Datatables initialization
if(document.getElementById('exam_list_table')){
    $(document).ready(function(){
        $('#exam_list_table').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false,
            "paging":true, "searching":true, "dom":"Bfrtip", "ordering":true,
            "pageLength":10, 
          "buttons": ["copy", "excel", "pdf", "print","colvis"]
        });
    });
    }

    // Classes Datatables initialization
if(document.getElementById('subject_list_table')){
    $(document).ready(function(){
        $('#subject_list_table').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false,
            "paging":true, "searching":true, "dom":"Bfrtip", "ordering":true,
            "pageLength":10, 
          "buttons": ["copy", "excel", "pdf", "print","colvis"]
        });
    });
    }

    //Dashboard clock
    
function addZero(time){
	if(parseInt(time)<10){return "0"+time ;}
	return time;
}

    
function showDate(){
	var dt = new Date();
    if(document.getElementById("dashDate"))
	document.getElementById("dashDate").innerHTML=' '+ dt.toDateString();
}

function showTime(){
	var dt = new Date();
    if(document.getElementById("dashTime"))
	document.getElementById("dashTime").innerHTML=addZero(dt.getHours())+':'+addZero(dt.getMinutes())+':'+addZero(dt.getSeconds());
}

//Short Notices

if(document.getElementById('short_notice')){
    document.addEventListener('DOMContentLoaded', function(){
     
        
        
        var url = `/settings/keys/short.notice`;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState==4 && this.status == 200){
                let notice = document.getElementById('short_notice') ;
            response = JSON.parse(this.responseText);
                notice.innerHTML= response.value;
                
            }
            else{
                
            }
        };
        xhttp.open("GET",url,true);
        xhttp.send();
        
    });
    }
    