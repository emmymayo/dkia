<?php

namespace Tests\Feature;

use App\Models\Cbt;
use App\Models\CbtQuestion;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CbtQuestionControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    public function test_cbt_question_index()
    {
        $this->setActor();
        $response = $this->get('/cbt-questions');

        $response->assertStatus(200);
        $response->assertViewIs('pages.cbts.questions.index');
    }

    public function test_cbt_question_index_json()
    {
        $this->setActor(); 
        CbtQuestion::factory()->count(2)->create();
        ;
        $response = $this->getJson('/cbt-questions');

        $response->assertStatus(200);
        
    }

    public function test_cbt_question_show_json()
    {
        $this->setActor();
        $cbt_question = CbtQuestion::factory()->create();
        
        $response = $this->getJson('/cbt-questions/'.$cbt_question->id);

        $response->assertStatus(200);
        $response->assertJson(['id' => $cbt_question->id]);
        
    }

    public function test_cbt_question_store_json()
    {
        $this->setActor('admin');
        $data = [
            'question' => $this->faker->sentence(),
            'type' => CbtQuestion::TYPE_MULTICHOICE,
            'cbt_id' => Cbt::factory()->create()->id,
            'marks' => 1
        ];
        $response = $this->postJson('/cbt-questions',$data);

        $response->assertCreated();
        $this->assertDatabaseHas('cbt_questions',$data);

    }

    public function test_cbt_question_update_json()
    {
        $this->setActor('admin');
        $cbt_question = CbtQuestion::factory()->create();
        
        $data = [
            'question' => $this->faker->sentence(), 
            'type' => CbtQuestion::TYPE_FREEFORM,
        ];
        $url = '/cbt-questions/'.$cbt_question->id;
        $response = $this->putJson($url,$data);

        $response->assertSuccessful();
        $this->assertDatabaseHas('cbt_questions',$data);

    }

    public function test_cbt_question_upload_image(){

        $this->setActor('admin');
        $cbt_question = CbtQuestion::factory()->create();
        Storage::fake('public');
        $file = UploadedFile::fake()->image('photo.jpg')->size(200);
        $url = '/cbt-questions/'.$cbt_question->id.'/image';
        $response = $this->patch($url,[
            'image' => $file
        ]);

        $response->assertSuccessful();
        Storage::disk('public')->assertExists('images/cbt/'.$cbt_question->id.'.jpg');
       
    }

    public function test_cbt_question_destroy_json()
    {
        $this->setActor('admin');
        $cbt_question = CbtQuestion::factory()->create();
        $this->assertModelExists($cbt_question);
        $url = '/cbt-questions/'.$cbt_question->id;
        $response = $this->deleteJson($url);

        $response->assertSuccessful();
        $this->assertModelMissing($cbt_question);

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
