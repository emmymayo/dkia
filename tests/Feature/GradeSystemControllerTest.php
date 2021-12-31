<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\GradeSystem;

class GradeSystemControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions;
    /**
     * 
     *
     * @return void
     */
    public function test_gradesystem_index()
    {
       $this->setActor('admin');
        
        $response = $this->get("/gradesystems");

        $response->assertStatus(200);
        $response->assertViewIs('pages.exams.grade-system.index');
    }

    public function test_gradesystem_index_json()
    {
        $this->setActor();
        
        $grade_systems = GradeSystem::factory(2)->create();
        $response = $this->getJson("/gradesystems");

        $response->assertStatus(200);
        $response->assertJsonCount(2);
       
    }

    public function test_gradesystem_show_json()
    {
        $this->setActor();
        
        $grade_system = GradeSystem::factory()->count(1)->create();
        $id = $grade_system->first()->id;
        $response = $this->getJson("/gradesystems/".$id);
        
        $response->assertStatus(200);
        
        $response->assertJson(['id' => $id]);
    }

    public function test_gradesystem_store_json()
    {
        $this->setActor('admin');
        $data = [
            'grade' => 'A',
            'remark' => "Excellent",
            'from' => 70.0,
            'to' => 100.0
        ];
        $response = $this->postJson("/gradesystems",$data);
        
        $response->assertCreated();
        
        $response->assertJson(["message" => 'success']);
        $this->assertDatabaseHas('grade_systems',$data);
    }

    public function test_gradesystem_update_json()
    {
        $this->setActor('admin');
        $grade_system = GradeSystem::factory()->create(['grade'=>'A'])->first();
        $this->assertDatabaseHas('grade_systems',['id'=> $grade_system->id]);
        $data = [
                'grade' => 'B'
        ];
        $response = $this->putJson("/gradesystems/".$grade_system->id, $data);
        
        $response->assertCreated();
        
        $response->assertJson(["message" => 'success']);
        $this->assertDatabaseHas('grade_systems',[
                            'id' => $grade_system->id,
                            'grade' => 'B'
        ]);
    }

    public function test_gradesystem_delete_json()
    {
        $this->setActor('admin');
        $grade_system = GradeSystem::factory()->create()->first();
        $this->assertDatabaseHas('grade_systems',['id'=> $grade_system->id]);
        
        $response = $this->deleteJson("/gradesystems/".$grade_system->id);
        
        $response->assertSuccessful();
        
        $response->assertJson(["message" => 'success']);
        $this->assertDatabaseMissing('grade_systems',['id' => $grade_system->id]);
    }

    private function setActor($role=null){
        //when role is provided get user that belongs to that role
        //else get the first user you can find
        $user = $role != null ? \App\Models\Role::firstWhere('name',$role)
                                ->users()
                                ->first()
                              : \App\Models\User::firstWhere("id",'>',0);
        $this->actingAs($user);
    }
}
