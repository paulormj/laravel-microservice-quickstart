<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Carbon\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        Factory(Category::class,1)->create();
        $categories = Category::all();
        $this->assertCount(1,$categories);
        $categoriesKeys = array_keys($categories->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            ['id',
             'name',
             'description',
             'is_active',
             'created_at',
             'deleted_at',
             'updated_at' 
            ]
            , $categoriesKeys
            
        );

    }

    public function testCreate(){
        $category = Category::create([
            'name' => 'test1'
        ]);
        
        $category->refresh();

        $this->assertEquals(36,strlen($category->id));

        $this->assertEquals('test1',$category->name);
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);
        
        $category = Category::create([
            'name' => 'test1',
            'description' => null
        ]);
        $this->assertNull($category->description);

         
        $category = Category::create([
            'name' => 'test1',
            'description' => 'test_description'
        ]);
        $this->assertEquals('test_description',$category->description);

        $category = Category::create([
            'name' => 'test1',
            'is_active' => false
        ]);
        $this->assertFalse($category->is_active);

        $category = Category::create([
            'name' => 'test1',
            'is_active' => true
        ]);
        $this->assertTrue($category->is_active);

    }

    public function testUpdate(){
        $category = factory(Category::class)->create([
            'description'=>'test_description',
            'is_active' => false
        ]);
        
        $data = [
            'name' => 'test_name_update',
            'description'=>'test_description_update',
            'is_active' => false
        ];
        $category->update($data);

       foreach($data as $key => $value){
           $this->assertEquals($value, $category->{$key});

       }

    }

    public function testDelete(){
        $category = factory(Category::class)->create();
       
        $category->delete();
        
       $this->assertSoftDeleted($category);
    }   
}
