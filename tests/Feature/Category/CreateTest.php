<?php

namespace Tests\Feature\Category;

use App\Http\Livewire\Category\Create;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire;
use Livewire\Testing\TestableLivewire;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public User $user;
    public Category $category;
    public TestableLivewire $test;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->category = Category::factory()->make();
    }

    public function testOnlyLoggedInCanSeeForm()
    {
        $this->withoutExceptionHandling();
        $this->expectException(HttpException::class);

        Livewire::test(Create::class);
    }

    public function testNormalUsersCanNotAddCategories()
    {
        $this->withoutExceptionHandling();
        $user = $this->signIn();
        $this->assertFalse($user->is_admin);

        $this->expectException(HttpException::class);
        Livewire::test(Create::class);
    }

    public function testAdminCanAddCategoriesWithValidData()
    {
        $this->setTest();

        $this->test->call('submit')->assertHasErrors('title');

        $this->test
            ->set('title', $this->category->title)
            ->call('submit')
            ->assertSet('title', '')
            ->assertEmitted(
                'add-category',
                $this->category->slug
            );

        $this->assertTrue(
            Category::whereTitle($this->category->title)->exists()
        );
    }

    // public function testAdminCanEditCategory()
    // {
    //     $this->testAdminCanAddCategoriesWithValidData();
        
    //     $this->test->set('editMode', true)
    //         ->set('title', 'nameof')
    //         ->call('submit')
    //         ->assertEmitted('category-updated', $this->category->slug);
    // }
    

    private function setTest()
    {
        $this->signIn($this->user);
        $this->test = Livewire::test(Create::class);
    }
}
