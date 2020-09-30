<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryControllerTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $category = factory(Category::class)->create();
        
        $response = $this->get(route('categories.index'));

        $response->assertStatus(200)
                 ->assertJson([$category->toArray()])   ;
    }
    public function testShow()
    {
        $category = factory(Category::class)->create();
        
        $response = $this->get(route('categories.show',[$category->id]));

        $response->assertStatus(200)
                 ->assertJson($category->toArray());
    }
}
