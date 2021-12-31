<?php

namespace Tests\Feature;

use App\Models\Cbt;
use App\Models\CbtAnswer;
use App\Models\CbtQuestion;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CbtAnswerControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    public function test_cbt_answer_index_json()
    {
        $this->setActor(); 
        CbtAnswer::factory()->count(2)->create();
        ;
        $response = $this->getJson('/cbt-answers');

        $response->assertStatus(200);
        
    }

    public function test_cbt_answer_show_json()
    {
        $this->setActor();
        $cbt_answer = CbtAnswer::factory()->create();
        
        $response = $this->getJson('/cbt-answers/'.$cbt_answer->id);

        $response->assertStatus(200);
        $response->assertJson(['id' => $cbt_answer->id]);
        
    }

    public function test_cbt_answer_store_json()
    {
        $this->setActor('admin');
        $data = [
            'value' => $this->faker->word(),
            'cbt_question_id' => CbtQuestion::factory()->create()->id,
            'correct' => true
        ];
        $response = $this->postJson('/cbt-answers',$data);

        $response->assertCreated();
        $this->assertDatabaseHas('cbt_answers',$data);

    }

    public function test_cbt_answer_update_json()
    {
        $this->setActor('admin');
        $cbt_answer = CbtAnswer::factory()->create();
        
        $data = [
            'value' => $this->faker->word(),
        ];
        $url = '/cbt-answers/'.$cbt_answer->id;
        $response = $this->putJson($url,$data);

        $response->assertSuccessful();
        $this->assertDatabaseHas('cbt_answers',$data);

    }

    public function test_cbt_answer_destroy_json()
    {
        $this->setActor('admin');
        $cbt_answer = CbtAnswer::factory()->create();
        $this->assertModelExists($cbt_answer);
        $url = '/cbt-answers/'.$cbt_answer->id;
        $response = $this->deleteJson($url);

        $response->assertSuccessful();
        $this->assertModelMissing($cbt_answer);

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
