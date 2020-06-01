<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{   
    use WithFaker, RefreshDatabase;

    /** @test */
    function guest_cannot_manage_projects ()
    {
        $project = factory('App\Project')->create();
        
        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }

    /** @test */
    function a_user_can_create_a_project ()
    {
        // $this->withoutExceptionHandling();
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
       ];

        $this->post('/projects', $attributes)
            ->assertRedirect(Project::where($attributes)->first()->path());

        $this->assertDatabaseHas('projects', $attributes); 

        $this->get('/projects')->assertSee($attributes['title'])
            ->assertSee(\Illuminate\Support\Str::limit($attributes['description'], 100));
    }

    /** @test */
    function a_user_can_view_their_project ()
    {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);
       
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    function an_authenticated_user_cannot_view_the_projects_of_others ()
    {
        $this->signIn();

        $project = factory('App\Project')->create();
        
        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    function a_project_require_a_title ()
    {
        $this->signIn();

        $attributes = factory('App\Project')->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    function a_project_require_a_description ()
    {
        $this->signIn();

        $attributes = factory('App\Project')->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }


}
