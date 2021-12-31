<?php

namespace Tests\Feature;

use App\Models\Timetable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\TimetableTimeslot;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TimetableTimeslotControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_timeslot_index()
    {
       
        //anyone should be able to view all timetable
        $role = \App\Models\Role::firstWhere('name','teacher');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        
        $response = $this->get('/timetable-timeslots');
        $response->assertStatus(200);
        $response->assertViewIs('pages.timetables.timeslots.index');
        
        
    }

    public function test_timeslot_index_json()
    {
        
        //anyone should be able to view all timetable
        $role = \App\Models\Role::firstWhere('name','teacher');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        
        $response = $this->getJson('/timetable-timeslots');
        
        $response->assertStatus(200);
        
    }

    public function test_timeslot_show_json()
    {
        
        //anyone should be able to view all timetable
        $role = \App\Models\Role::firstWhere('name','teacher');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $timeslot = TimetableTimeslot::factory()->create();
        $url = '/timetable-timeslots/'.$timeslot->id;
        $response = $this->getJson($url);
        
        $response->assertSuccessful();
        
    }

    public function test_timeslot_store()
    {
        //acting as Admin user
        
        $role = \App\Models\Role::firstWhere('name','admin');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        
        $from = $this->faker->time();
        $url = '/timetable-timeslots';
        $response = $this->post($url, [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(10),
            'from' => $from,
            'to' => \Carbon\Carbon::parse($from)->addMinutes(30)->format('H:i:s')
        ]);

        
        $response->assertCreated();
        $response->assertExactJson(['message'=>'success']);
        
    }

    public function test_timeslot_update()
    {
        //acting as Admin user
        
        $role = \App\Models\Role::firstWhere('name','admin');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $timeslot = TimetableTimeslot::factory()->create();
       
        $name = $this->faker->name;
        $url = '/timetable-timeslots/'.$timeslot->id;
        $response = $this->put($url, [
            'name' => $name,
            
        ]);
        
        $timeslot = TimetableTimeslot::find($timeslot->id);
        $this->assertEquals($name,$timeslot->name);
        
        $response->assertCreated();
       // $response->assertExactJson(['message'=>'success']);
        
    }

    public function test_timeslot_delete()
    {
        //acting as Admin user
        
        $role = \App\Models\Role::firstWhere('name','admin');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        
        $name = $this->faker->name;
        TimetableTimeslot::factory()->create([
            'name' => $name
        ]);
        $this->assertDatabaseHas('timetable_timeslots',['name' => $name]);
        $timeslot = TimetableTimeslot::firstWhere('name',$name);
        $url = '/timetable-timeslots/'.$timeslot->id;
        $response = $this->delete($url);
        
        $this->assertDatabaseMissing('timetable_timeslots',['name' => $name]);
        
        
        $response->assertSuccessful();
       $response->assertExactJson(['message'=>'success']);
        
    }

    public function test_timeslots_by_timetable(){
        $role = \App\Models\Role::firstWhere('name','admin');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $timetable = Timetable::factory()->create();
        $url = '/timetable-timeslots/timetables/'.$timetable->id;
        $response = $this->get($url);

        $response->assertSuccessful();


    }
}
