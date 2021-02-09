<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Genero;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Route;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidations;

class GeneroControllerTest extends TestCase
{
    use DatabaseMigrations, TestValidations, TestSaves;

    private $genero;
    protected function setUp():void
    {
        parent::setUp();
        $this->genero = factory(Genero::class)->create();


    }
    public function testIndex(){

        $response = $this->get(route('generos.index'));

        $response->assertStatus(200);
        #->assertJson([$genero->toArray()]) ;
    }

    public function testShow(){
        $response = $this->get(route('generos.show',[$this->genero->id]));
        $response->assertStatus(200)->assertJson($this->genero->toArray());
    }

    public function testInvalidationData(){

        $data = ['name'=>''];
        $this->assertInvalidationInStoreAction($data,'required');

       $data =  ['name'=>str_repeat('a',256)];
        $this->assertInvalidationInStoreAction($data,'max.string',['max'=>'255']);
       
        $data =  ['is_active'=>'a'];
        $this->assertInvalidationInStoreAction($data,'boolean');


          
          $response = $this->json('PUT',route('generos.update',['genero'=>$this->genero->id]),[]);
          $response->assertStatus(422)->assertJsonValidationErrors(['name'])
          ->assertJsonMissingValidationErrors(['is_active'])
          ->assertJsonFragment([
              \Lang::get('validation.required',['attribute'=> 'name'])
          ])
          ;

          
          $response = $this->json('PUT',
                                   route('generos.update',['genero'=>$this->genero->id]),
                                   ['name'=>str_repeat('a',256),
                                    'is_active'=>'a']);
          $response->assertStatus(422)
                   ->assertJsonValidationErrors(['name','is_active'])
                   ->assertJsonFragment([\Lang::get('validation.max.string',['attribute'=>'name','max'=>255])])
                   ->assertJsonFragment([\Lang::get('validation.boolean',['attribute'=>'is active'])])
                  ;
  }

            public function testStore(){
                $data = ['name'=>'add nome'];
                $response = $this->assertStore($data,$data );
                //$response = $this->json('POST',route('generos.store'),['name'=>'add nome']);
                $id = $response->json('id');
                $genero = Genero::find($id);
                $response->assertStatus(201);
                $this->assertTrue($response->json('is_active'));
            }

            public function testUpdate(){

                $genero = factory(Genero::class)->create(['is_active'=>false]);
                $response = $this->json('PUT',
                                         route('generos.update',['genero'=>$genero->id]),
                                         ['name'=>'Update Genero','is_active'=>true]);
                $id = $response->json('id');
                $genero = Genero::find($id);

                $response->assertStatus(200)->assertJson($genero->toArray());
                $this->assertTrue($response->json('is_active'));
                                         
            }
            
            public function testDelete(){

                $response = $this->json('DELETE',
                                         route('generos.destroy',['genero'=>$this->genero->id])  );
                $response->assertStatus(204);
                $this->assertNull(Genero::find($this->genero->id));
                $this->assertNotNull(Genero::withTrashed()->find($this->genero->id));
               
            }

            protected function routeStore(){
                return route('generos.store');
            }

            protected function routeUpdate(){
                return route('generos.update',['genero'=>$this->genero->id]);
            }

            protected function model (){
                return Genero::class;
            }
}
