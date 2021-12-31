<?php

namespace Tests\Feature;

use App\Models\Cbt;
use App\Models\CbtSection;
use App\Models\Section;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CbtSectionControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    public function test_cbt_section_index_json()
    {
        $this->setActor('admin'); 
        CbtSection::factory()->count(2)->create();
        
        $response = $this->getJson('/cbt-sections');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        
    }

    public function test_cbt_section_toggle_on_json()
    {
        $this->setActor('admin'); 
        $cbt = Cbt::factory()->create();
        $section= Section::factory()->create();
        
        $response = $this->putJson('/cbt-sections/toggle',[
            'cbt_id' => $cbt->id,
            'section_id' => $section->id,
        ]);

        $response->assertSuccessful();
        $this->assertDatabaseHas('cbt_sections',[
            'cbt_id' => $cbt->id,
            'section_id' => $section->id,
        ]);
        
    }
    public function test_cbt_section_toggle_off_json()
    {
        $this->setActor('admin'); 
        $cbt_section = CbtSection::factory()->create();
        $response = $this->putJson('/cbt-sections/toggle',[
            'cbt_id' => $cbt_section->cbt_id,
            'section_id' => $cbt_section->section_id,
        ]);

        $response->assertSuccessful();
        $this->assertDatabaseMissing('cbt_sections',[
            'cbt_id' => $cbt_section->cbt_id,
            'section_id' => $cbt_section->section_id,
        ]);
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
