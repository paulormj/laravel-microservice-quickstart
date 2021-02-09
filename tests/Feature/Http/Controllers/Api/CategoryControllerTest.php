<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidations;

class CategoryControllerTest extends TestCase
{
      
    use DatabaseMigrations,TestValidations, TestSaves;

    private $category;
    protected function setUp():void
    {
        parent::setUp();
        $this->category = factory(Category::class)->create();


    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        
        
        $response = $this->get(route('categories.index'));
        $response->assertStatus(200)
                 ->assertJson([$this->category->toArray()])   ;
    }
    public function testShow()
    {
        
        
        $response = $this->get(route('categories.show',[$this->category->id]));

        $response->assertStatus(200)
                 ->assertJson($this->category->toArray());
    }
    public function testInvalidationData(){

        $data = ['name'=>''];
        $this->assertInvalidationInStoreAction($data,'required');
        $this->assertInvalidationInUpdateAction($data,'required');

       $data =  ['name'=>str_repeat('a',256)];
        $this->assertInvalidationInStoreAction($data,'max.string',['max'=>'255']);
        $this->assertInvalidationInUpdateAction($data,'max.string',['max'=>'255']);

       
        $data =  ['is_active'=>'a'];
        $this->assertInvalidationInStoreAction($data,'boolean');
        $this->assertInvalidationInUpdateAction($data,'boolean');
        
        $response = $this->json('POST', route('categories.store'),[]);   
        
        
        
    }

    public function testStore(){

        $data = ['name'=> 'teste'];

        $this->assertStore($data,$data + ['description'=>null,'is_active' => true,'deleted_at'=>null]);

        $data = ['name'=>'test',
                                    'is_active'=>false,
                                    'description'=>'description'];
    
        $response = $this->assertStore($data,$data + ['description'=>'description','is_active' => false,'deleted_at'=>null]);

        $response->assertJsonStructure(['created_at','updated_at']);


    }

    public function testUpdate(){
        
        $this->category = factory(Category::class)->create([
            'description'=>'description',
            'is_active'=>false
        ]);
        $data = ['name'=>'test','description'=>'test','is_active'=>true];

        $response = $this->assertUpdate($data,$data + ['deleted_at'=>null]);
        $response->assertJsonStructure([
            'created_at','updated_at'
        ]);
        
        $data = ['name'=>'test','description'=>''];

        $response = $this->assertUpdate($data,array_merge($data,['description'=>null]));

        $data = ['name'=>'test','description'=>'teste'];

        $response = $this->assertUpdate($data,array_merge($data,['description'=>'teste']));

        $data = ['name'=>'test','description'=>null];

        $response = $this->assertUpdate($data,array_merge($data,['description'=>null]));

        
    }
    public function testDelete(){

        
        $response = $this->json('DELETE',
                                 route('categories.destroy',['category'=>$this->category->id])  );
        $response->assertStatus(204);
        $this->assertNull(Category::find($this->category->id));
        $this->assertNotNull(Category::withTrashed()->find($this->category->id));
       
    }

    protected function routeStore(){
        return route('categories.store');
    }

    
    protected function routeUpdate(){
        return route('categories.update',['category'=>$this->category->id]);
    }

    protected function model(){
        return Category::class;
    }
}
