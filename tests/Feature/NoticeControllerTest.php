<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Notice;
use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NoticeControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    public function test_notice_index()
    {
        $this->setActor('admin');
       
        $response = $this->get('/notices');

        $response->assertStatus(200);
        $response->assertViewIs('pages.notices.index');
    }

    public function test_notice_index_json()
    {
        $this->setActor();
        Notice::factory(2)->create();
        //create expired notices
        Notice::factory(2)
                    ->create(['expires_at'=>now()->subDay()]);
        $response = $this->getJson('/notices');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_notice_show_json()
    {
        $this->setActor();
        $notice = Notice::factory()->create();
        $response = $this->getJson('/notices/'.$notice->id);

        $response->assertStatus(200);
        $response->assertJson(['id'=> $notice->id]);
    }

    public function test_notice_store_json()
    {
        $this->setActor('admin');
        $data = [
            'title' => $this->faker->sentence(),
            'message' => $this->faker->paragraph(),
            'role_id' => Role::firstWhere('id','>',0)->id,
            'expires_at' => now()->addDay()->format('Y-m-d')
        ];
        $response = $this->postJson('/notices',$data);

        $response->assertCreated();
        $response->assertJson(['message'=> 'success']);
        $this->assertDatabaseHas('notices',$data);
    }

    public function test_notice_update_json()
    {
        $this->setActor('admin');
        $notice = Notice::factory()->create();
        $data = [
            'title' => $this->faker->sentence()
        ];
        $url = '/notices/'.$notice->id ;
        $response = $this->putJson($url,$data);
        $response->assertCreated();
        $response->assertJson(['message'=> 'success']);
        $this->assertDatabaseHas('notices',$data);
    }
    public function test_notice_delete_json()
    {
        $this->setActor('admin');
        $notice = Notice::factory()->create();
        $this->assertDatabaseHas('notices',['id' =>$notice->id]);
        $response = $this->deleteJson('/notices/'.$notice->id);

        $response->assertCreated();
        $response->assertJson(['message'=> 'success']);
        $this->assertDatabaseMissing('notices',['id' =>$notice->id]);
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
