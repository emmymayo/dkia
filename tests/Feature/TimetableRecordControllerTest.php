<?php

namespace Tests\Feature;

use App\Models\TimetableRecord;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TimetableRecordControllerTest extends TestCase
{ 
    use DatabaseTransactions, WithFaker;

    public function test_timetable_record_index_json()
    {
        $role = \App\Models\Role::firstWhere('name','admin');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        
        $response = $this->getJson('/timetable-records');
        
        $response->assertSuccessful(); 
        
    }

    public function test_timetable_record_index_by_timetable()
    {
        $role = \App\Models\Role::firstWhere('name','admin');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $timetable = \App\Models\Timetable::factory()->create();
        $url = '/timetable-records?timetable_id='.$timetable->id;
        $response = $this->getJson($url);
        
        $response->assertSuccessful(); 
  
        

    }

    public function test_timetable_record_show()
    {
        $role = \App\Models\Role::firstWhere('name','admin');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $timetable_record = \App\Models\TimetableRecord::factory()->create();
        $url = '/timetable-records/'.$timetable_record->id;
        $response = $this->getJson($url);
        
        $response->assertSuccessful(); 
        
        
    }

    public function test_timetable_record_store()
    {
        $role = \App\Models\Role::firstWhere('name','admin');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        
        $url = '/timetable-records';
        $day = $this->faker->dayOfWeek();
        $entry = $this->faker->word();
        $response = $this->post($url,[
            'timetable_id' => \App\Models\Timetable::factory()->create()->id,
            'timeslot_id' => \App\Models\TimetableTimeslot::factory()->create()->id,
            'day' => $day,
            'entry' => $entry
        ]);
           
        $response->assertCreated();
        $response->assertExactJson(['message'=>'success']);
        $this->assertDatabaseHas('timetable_records',['day'=>$day,'entry'=>$entry]);
        
    }

    public function test_timetable_record_update()
    {
        $role = \App\Models\Role::firstWhere('name','admin');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $timetable_record = TimetableRecord::factory()->create();
        
        $url = '/timetable-records/'.$timetable_record->id;
        $day = $this->faker->dayOfWeek();
        $entry = $this->faker->word();
        $response = $this->put($url,[
            'day' => $day,
            'entry' => $entry
        ]);
           
        $response->assertSuccessful();
        $response->assertExactJson(['message'=>'success']);
        $this->assertDatabaseHas('timetable_records',['day'=>$day,'entry'=>$entry]);
        
    }
    public function test_timetable_record_delete()
    {
        $role = \App\Models\Role::firstWhere('name','admin');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $timetable_record = TimetableRecord::factory()->create();
        $this->assertDatabaseHas('timetable_records',['id'=>$timetable_record->id]);
        $url = '/timetable-records/'.$timetable_record->id;
        
        $response = $this->delete($url);
           
        $response->assertSuccessful();
        $response->assertExactJson(['message'=>'success']);
        $this->assertDatabaseMissing('timetable_records',['id'=>$timetable_record->id]);
        
    }
}
