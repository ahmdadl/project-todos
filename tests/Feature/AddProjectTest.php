<?php

namespace Tests\Feature;

use App\Http\Livewire\AddProject;
use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire;
use Livewire\Testing\TestableLivewire;
use Str;
use Tests\TestCase;

class AddProjectTest extends TestCase
{
    use RefreshDatabase;

    public User $user;
    public Project $project;
    public Category $category;
    public TestableLivewire $test;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->category = Category::factory()->create();
        $this->project = Project::factory()->makeOne([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
        ]);

        $this->test = Livewire::test(AddProject::class, [
            'user' => $this->user,
        ]);

        $this->actingAs($this->user);
    }

    public function testUserCanAddProject()
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('some.png');

        $this->test
            ->assertSet('name', '')
            ->assertSet('showModal', false)
            ->call('openModal')
            ->assertSet('showModal', true)
            ->set('categorySlug', $this->category->slug)
            ->set('image', $image)
            ->set('name', $this->project->name)
            ->set('cost', $this->project->cost)
            ->set('completed', $this->project->completed)
            ->call('save')
            ->tap(fn() => Storage::exists('public/' . $image->hashName()))
            ->assertEmitted('project:added', $this->project->slug)
            ->assertDispatchedBrowserEvent('reset-img');

        $this->assertTrue(Project::whereSlug($this->project->slug)->exists());
    }

    public function testUserCanEditProjectWithoutChangingImage()
    {
        $this->project->save();

        $this->test
            ->emit('project:edit', $this->project->slug)
            ->assertSet('showModal', true)
            ->assertSet('editMode', true)
            ->assertSet('name', $this->project->name)
            ->assertSet('cost', $this->project->cost)
            ->assertSet('completed', $this->project->completed)
            ->set('cost', 556.21)
            ->assertSet('cost', 556.21)
            ->call('save')
            ->assertHasNoErrors()
            ->assertEmitted('project:updated', $this->project->slug);
        $this->assertDatabaseHas('projects', [
            'slug' => $this->project->slug,
            'cost' => 556.21,
        ]);
    }

    public function testUserCanEditProjectWithImageAndDeleteOldImage()
    {
        // Storage::fake('public');

        $imgOld = UploadedFile::fake()->image('a.jpg');
        $imgNew = UploadedFile::fake()->image('some.png');

        $imgOld = Str::replaceFirst(
            'public/',
            '',
            $imgOld->store('projects', 'public')
        );

        $this->project->image = $imgOld;
        $this->project->save();

        sleep(1);

        $this->test
            ->emit('project:edit', $this->project->slug)
            ->set('image', $imgNew)
            ->call('save')
            ->assertHasNoErrors()
            ->assertEmitted('project:updated', $this->project->slug);

        Storage::disk('public')->assertMissing($imgOld);

        // livewire changes hashname during uploading
        // then get the uploaded image from the project instance
        $imgNew = Project::whereSlug($this->project->slug)->first()->image;

        Storage::disk('public')->assertExists($imgNew);

        $this->assertTrue(
            Project::whereSlug($this->project->slug)
                ->whereImage($imgNew)
                ->exists()
        );
    }
}
