<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Admin;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    

    public function test_admin_index_authorized(){
          //acting as Admin user
        $role = Role::firstWhere('name','admin');
        $user = $role->users()->first();
        $this->actingAs($user);
        $response = $this->get('/admins');
        
        $response->assertStatus(200);
        $response->assertViewHas(['admins']);
    }

    public function test_admin_index_unauthorized(){
          //acting as other user
          $role = Role::firstWhere('name','student');
          $user = $role->users()->first();
        $this->actingAs($user);
        $response = $this->get('/admins');
        
        //$response->assertStatus(200);
        $response->assertForbidden();
    }

    public function test_admin_create_authorized(){
          //acting as other user
          $role = Role::firstWhere('name','admin');
          $user = $role->users()->first();
        $this->actingAs($user);
        $response = $this->get('/admins/create');
        
        $response->assertStatus(200);
        
        //$response->assertForbidden();
    }

    public function test_admin_create_unauthorized(){
          //acting as other user
          $role = Role::firstWhere('name','student');
          $user = $role->users()->first();
        $this->actingAs($user);
        $response = $this->get('/admins/create');
        $response->assertForbidden();
        
    }

    public function test_admin_store_with_photo(){
          //acting as admin user
          $role = Role::firstWhere('name','admin');
          $user = $role->users()->first();
        $this->actingAs($user);
        $photo = UploadedFile::fake()->image('avatar.jpg')->size(1000);
        $name = $this->faker->name();
        $email = $this->faker->safeEmail();
        $data = [
            'email'=> $email,
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'name' => $name,
            'photo' => $photo
        ];
        $response = $this->post('/admins',$data);
        
        //$response->dumpSession();
        $response->assertSessionHas(['admin-added-success']);
        $this->assertDatabaseHas('users',['email'=>$email]);
        
    }

    public function test_admin_store_without_photo(){
          //acting as admin user
          $role = Role::firstWhere('name','admin');
          $user = $role->users()->first();
        $this->actingAs($user);
        //$photo = UploadedFile::fake()->image('avatar.jpg')->size(1000);
        $name = $this->faker->name();
        $email = $this->faker->safeEmail();
        $data = [
            'email'=> $email,
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'name' => $name,
            
        ];
        $response = $this->post('/admins',$data);
       
        //$response->dumpSession();
        $response->assertSessionHas(['photo-upload-fail']);
        $this->assertDatabaseHas('users',['email'=>$email]);
        
    }

    public function test_admin_show_authorized(){
        //acting as Admin user
      $role = Role::firstWhere('name','admin');
      $user = $role->users()->first();
      $admin = Admin::firstWhere('user_id',$user->id);
      $this->actingAs($user);
      $url = 'admins/'.$admin->id;
      $response = $this->get($url);
      
      $response->assertStatus(200);

      $response->assertSeeText($admin->user->name);
      $response->assertViewHas(['profile']);
  }

    public function test_admin_show_unauthorized(){
        //acting as Admin user
      $role = Role::firstWhere('name','teacher');
      $user = $role->users()->first();
      //find any admin
      $admin = Admin::where('id','>',0)->first();
      $this->actingAs($user);
       $url = '/admins/'.$admin->id;
      
       $response = $this->get($url);
      
       $response->assertForbidden();
   
  }

    public function test_admin_update(){
      //acting as admin user
      $role = Role::firstWhere('name','admin');
      $user = $role->users()->first();
      $admin = Admin::firstWhere('user_id',$user->id);
      $this->actingAs($user);
    
      $name = $this->faker->name();
      $email = $this->faker->safeEmail();
      $data = [
          'email'=> $email,
          'name' => $name,
      ];
      $url = '/admins/'.$admin->id;
      $response = $this->put($url,$data);
    
      //$response->dumpSession();
      $response->assertSessionHas(['profile-update-success']);
      $this->assertDatabaseHas('users',['email'=>$email]);
      
  }

  public function test_admin_update_unauthorized(){
      //acting as admin user
      $role = Role::firstWhere('name','teacher');
      $user = $role->users()->first();
      //get the first admin you find
      $admin = Admin::firstWhere('user_id','>',0);
      $this->actingAs($user);
    
      $name = $this->faker->name();
      $email = $this->faker->safeEmail();
      $data = [
          'email'=> $email,
          'name' => $name,
      ];
      $url = '/admins/'.$admin->id;
      $response = $this->put($url,$data);
      
      $response->assertForbidden();
      
  }

  public function test_destroy_admin(){
     //acting as admin user
     $role = Role::firstWhere('name','admin');
     $user = $role->users()->first();
     $this->actingAs($user);
     $admin = Admin::factory()->create();
     
     $url = '/admins/'.$admin->id;
     //assert admin created
     $this->assertDatabaseHas('users',['id'=>$admin->user_id]);
     $this->assertDatabaseHas('admins',['id'=>$admin->id]);
     $response = $this->delete($url);
     //assert admin deleted
     $this->assertSoftDeleted('users',['id'=>$admin->user_id]);
     $this->assertSoftDeleted('admins',['id'=>$admin->id]);
    
     $response->assertSessionHas(['user-delete-success']);
     

  }
    
  public function test_destroy_admin_unauthorized(){
     //acting as teacher user
     $role = Role::firstWhere('name','teacher');
     $user = $role->users()->first();
     $this->actingAs($user);
     $admin = Admin::factory()->create();
     
     $url = '/admins/'.$admin->id;
     //assert admin created
     $this->assertDatabaseHas('users',['id'=>$admin->user_id]);
     $this->assertDatabaseHas('admins',['id'=>$admin->id]);
     $response = $this->delete($url);
     //assert unauthorized
     $response->assertForbidden();

     

  }
    
}
