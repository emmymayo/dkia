<?php 

namespace App\Support\Helpers;

use App\Models\Section;
use App\Models\Setting;

class Exam {

   public static function defaultSkills(){
       $skills = config('settings.skills');
       return $skills;
   }

   public static function isRegistrationOpen(){
       return (bool) SchoolSetting::getSchoolSetting('exam.registration.open');
   }

   public static function isExamLocked(){
       return (bool) SchoolSetting::getSchoolSetting('exam.locked');
   }

   public static function isUsingAttendanceSystem(){
       return (bool) SchoolSetting::getSchoolSetting('use.attendance.system');
   }

    public static function getFormattedPosition($rank){
        //returns formatted position from 1 - 200
        $rank = intval($rank);
        $st = array(1,21,31,41,51,61,71,81,91,101,121,131,141,151,161,171,181,191,201,221);
        $nd = array(2,22,32,42,52,62,72,82,92,102,122,132,142,152,162,172,182,192,202,222);
        $rd = array(3,23,33,43,53,63,73,83,93,103,123,133,143,153,163,173,183,193,203,223);
        if(in_array($rank,$st)){return $rank.'st';}
        elseif(in_array($rank,$nd)){return $rank.'nd';}
        elseif(in_array($rank,$rd)){return $rank.'rd';}
        else{return $rank.'th';}
    }

    public static function  getWordScoreRemark($value){
		$grades = \App\Models\GradeSystem::all();
        $remark = '';
        foreach ($grades as $key => $grade) {
            if( ($value >= $grade['from']) AND ($value <= $grade['to']) ){
                $remark = $grade['remark'];
                break;
            }
        }
        return $remark;
    
	}
	public static function getLetterScoreRemark($value){
		$grades = \App\Models\GradeSystem::all();
        $remark = '';
        foreach ($grades as $key => $grade) {
            if( ($value >= $grade['from']) AND ($value <= $grade['to']) ){
                $remark = $grade['grade'];
                break;
            }
        }
        return $remark;
	}

    public static function getStudentSection($student_id, $session_id){
        $section = Section::whereIn('id',function($query) use($student_id,$session_id){
                $query->select('section_id')
                      ->from('students_sections_sessions')
                      ->where('student_id',$student_id)
                      ->where('session_id',$session_id)
                      ->get();
        })->first();

        return $section;
    }

    public static function getStudentCurrentSection($student_id){
        $current_session_id = SchoolSetting::getSchoolSetting('current.session');
        return self::getStudentSection($student_id,$current_session_id);
    }
    
    
}


?>