<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->delete();
       $settings =  [
                        [1, 'school.name', 'SMS Technical Academy, Abuja.', 'School Name'],
                        [2, 'current.session', '', 'Current Session', ],
                        [3, 'school.address', '5 SMS Street, Silicon Crescent, Abuja.', 'School Address', ],
                        [4, 'school.motto', 'Nurturing leaders, building the future.', 'School Motto', ],
                        [5, 'current.term', 'First', 'Current Term', ],
                        [6, 'active.exam', '', 'Active Examination', ],
                        [7, 'exam.registration.open', '1', 'Exam Registration Open', ],
                        [8, 'exam.locked', '1', 'Lock Examination', ],
                        [9, 'next.term.begins', '30th January 2022', 'Next Term Begins', ],
                        [10, 'times.school.opened', '0', 'No. Times School Opened',],
                        [11, 'use.attendance.system', '1', 'Use Attendance System',],
                        [12, 'school.logo', 'images/school-logo.png', 'School Logo',],
                        [13, 'short.notice', '', 'Short Notice', ]
                    ];
        foreach($settings as $setting){
            Setting::create([
                'key' => $setting[1],
                'value' => $setting[2],
                'display_name' => $setting[3],
            ]);
        }

    }
}
