<?php

namespace Tests\Feature;

use App\Models\Cbt;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CbtControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions;
    
    public function test_cbt_index()
    {
        $this->setActor('admin');
        $response = $this->get('/cbts');

        $response->assertStatus(200);
        $response->assertViewIs('pages.cbts.index');
    }

    public function test_cbt_index_json()
    {
        $this->setActor();
        Cbt::factory()->count(2)->create();
        
        $response = $this->getJson('/cbts');

        $response->assertStatus(200);
        
        
    }

    public function test_cbt_show_json()
    {
        $this->setActor();
        $cbt = Cbt::factory()->create();
        
        $response = $this->getJson('/cbts/'.$cbt->id);

        $response->assertStatus(200);
        $response->assertJson(['id' => $cbt->id]);
        
    }

    public function test_cbt_store_json()
    {
        $this->setActor('admin');
        $data = [
            'name' => $this->faker->sentence(),
            'exam_id' => Exam::factory()->create()->id,
            'subject_id' => Subject::factory()->create()->id,
            'duration' => 60,
            'type' => Cbt::TYPE_MOCK
        ];
        $response = $this->postJson('/cbts',$data);

        $response->assertCreated();
        $this->assertDatabaseHas('cbts',$data);

    }

    public function test_cbt_update_json()
    {
        $this->setActor('admin');
        $cbt = Cbt::factory()->create();
        $data = [
            'name' => $this->faker->sentence(),
            'duration' => 60,
            'type' => Cbt::TYPE_MOCK
        ];
        $url = '/cbts/'.$cbt->id;
        $response = $this->putJson($url,$data);

        $response->assertSuccessful();
        $this->assertDatabaseHas('cbts',$data);

    }

    public function test_cbt_destroy_json()
    {
        $this->setActor('admin');
        $cbt = Cbt::factory()->create();
        $this->assertModelExists($cbt);
        $url = '/cbts/'.$cbt->id;
        $response = $this->deleteJson($url);

        $response->assertSuccessful();
        $this->assertModelMissing($cbt);

    }

    /**
     * Set authenticated user
     */
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
