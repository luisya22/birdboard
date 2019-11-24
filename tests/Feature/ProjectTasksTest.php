<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_add_tasks_to_projects(){

        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks(){


        $this->signIn();

        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks',['body' => 'Test task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_update_a_task(){

//        $this->withoutExceptionHandling();

        $this->signIn();

        $project = app(ProjectFactory::class)->withTasks(1)->create();



        $this->patch($project->tasks[0]->path(),['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    /** @test */
    public function a_project_can_have_tasks(){

        $this->withoutExceptionHandling();

        $project = app(ProjectFactory::class)->create();


        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks',['body' => 'Test task']);

        $this->get($project->path())
                ->assertSee('Test task');
    }

    /** @test */
    function a_task_can_be_updated(){

//        $this->withoutExceptionHandling();

        $project = app(ProjectFactory::class)
//            ->ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

//        $this->signIn();
//
//        $project = auth()->user()->projects()->create(
//            factory(Project::class)->raw()
//        );
//
//        $task = $project->addTask('test task');

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
            'body' => 'changed',
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
        ]);
    }

    /** @test */
    function a_task_can_be_completed(){

        $project = app(ProjectFactory::class)
            ->withTasks(1)
            ->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed',
                'completed' => true
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    /** @test */
    function a_task_can_be_incompleted(){

        $project = app(ProjectFactory::class)
            ->withTasks(1)
            ->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed',
                'completed' => true
            ]);

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed',
                'completed' => false
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => false
        ]);
    }


    /** @test */
    public function a_task_requires_a_body(){

        $project = app(ProjectFactory::class)->create();


        $attributes = factory('App\Task')->raw(['body' => '']);

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
