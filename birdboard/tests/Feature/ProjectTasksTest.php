<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guest_cannot_add_tasks_to_projects ()
    {
        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    /** @test */
    function only_the_owner_of_a_project_may_add_tasks ()
    {
        $this->signIn();

        $project = factory('App\Project')->create();
        
        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    /** @test */
    function only_the_owner_of_a_project_may_update_a_tasks ()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $task = $project->addTask('tes tes');
        
        $this->patch($project->path() . '/tasks/' . $task->id, ['body' => 'Changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Changed']);
    }

    /** @test */
    function a_project_can_have_tasks ()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );
        
        $this->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
            ->assertSee('Test task');
    }

    /** @test */
    function a_project_can_be_updated ()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );
        
        $task = $project->addTask('Test test');

        $this->patch($task->path(), [
            'body' => 'Changed',
            'completed' => true
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'Changed',
            'completed' => true
            ]);
    }

    /** @test */
    function a_task_require_a_body ()
    {
        // $this->withoutExceptionHandling();

        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );

        $attributes = factory('App\Task')->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
