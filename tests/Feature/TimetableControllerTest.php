<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Timetable;


class TimetableControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_timetable_index()
    {
       
        //anyone should be able to view all timetable
        $role = \App\Models\Role::firstWhere('name','teacher');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        
        $response = $this->get('/timetables');
        $response->assertStatus(200);
        $response->assertViewIs('pages.timetables.index');
        
    }

    public function test_timetable_index_json()
    {
        
        //anyone should be able to view all timetable
        $role = \App\Models\Role::firstWhere('name','teacher');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        
        $response = $this->getJson('/timetables');
        
        $response->assertStatus(200);
        
    }

    public function test_timetable_show_json()
    {
        
        //anyone should be able to view all timetable
        $role = \App\Models\Role::firstWhere('name','teacher');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $timetable = Timetable::factory()->create();
        
        $url = '/timetables/'.$timetable->id;
        $response = $this->getJson($url);
        
        $response->assertSuccessful();
        
    }

    public function test_timetable_store()
    {
        //acting as Admin user
        
        $role = \App\Models\Role::firstWhere('name','admin');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();

        $url = '/timetables';
        $response = $this->post($url, [
            'name' => $this->faker->name,
            'type' => 'sections',
            'id' => \App\Models\Section::firstWhere('id','>',0)->id
        ]);

        
        $response->assertCreated();
       // $response->assertExactJson(['message'=>'success']);
        
    }

    public function test_timetable_update()
    {
        //acting as Admin user
        
        $role = \App\Models\Role::firstWhere('name','admin');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $timetable = Timetable::factory()->create();

        $name = $this->faker->name;
        $url = '/timetables/'.$timetable->id;
        $response = $this->put($url, [
            'name' => $name,
            //'type' => 'sections',
            //'id' => \App\Models\Section::firstWhere('id','>',0)->id
        ]);
        
        $timetable = Timetable::find($timetable->id);
        $this->assertEquals($name,$timetable->name);
        
        $response->assertCreated();
       // $response->assertExactJson(['message'=>'success']);
        
    }

    public function test_timetable_delete()
    {
        //acting as Admin user
        
        $role = \App\Models\Role::firstWhere('name','admin');
        $user = $role->users()->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        
        $name = $this->faker->name;
        Timetable::factory()->create([
            'name' => $name
        ]);
        $this->assertDatabaseHas('timetables',['name' => $name]);
        $timetable = Timetable::firstWhere('name',$name);
        $url = '/timetables/'.$timetable->id;
        $response = $this->delete($url);
        
        $this->assertDatabaseMissing('timetables',['name' => $name]);
        
        
        $response->assertSuccessful();
       $response->assertExactJson(['message'=>'success']);
        
    }
}
