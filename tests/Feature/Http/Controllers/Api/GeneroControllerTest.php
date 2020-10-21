<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Genero;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Route;

class GeneroControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex(){

        $genero = factory(Category::class)->create();

        $response = $this->get(route('generos.index'));

        $response->assertStatus(200);
        #->assertJson([$genero->toArray()]) ;
    }

    public function testShow(){
        $genero = factory(Genero::class)->create();
        $response = $this->get(route('generos.show',[$genero->id]));
        $response->assertStatus(200)->assertJson($genero->toArray());
    }

    public function testInvalidationData(){
        // dd($this->json('POST',route('generos.store'),[]));
          $response = $this->json('POST', route('generos.store'),[]);
          $response->assertStatus(422)->assertJsonValidationErrors(['name'])
                   ->assertJsonMissingValidationErrors(['is_active'])
                   //->assertJsonFragment([
                     //  \Lang::trans('validation.required',['attribute'=> 'name'])
                   //])
                   ;
          $response = $this->json('POST',route('generos.store'),
                                  ['name'=>str_repeat('a',256),
                                   'is_active'=>'a']);
          $response->assertStatus(422)
                   ->assertJsonValidationErrors(['name','is_active'])
                   ->assertJsonFragment([\Lang::get('validation.max.string',['attribute'=>'name','max'=>255])])
                   ->assertJsonFragment([\Lang::get('validation.boolean',['attribute'=>'is active'])])
                  ;
          
          $genero = factory(Genero::class)->create();
          $response = $this->json('PUT',route('generos.update',['genero'=>$genero->id]),[]);
          $response->assertStatus(422)->assertJsonValidationErrors(['name'])
          ->assertJsonMissingValidationErrors(['is_active'])
          ->assertJsonFragment([
              \Lang::get('validation.required',['attribute'=> 'name'])
          ])
          ;

          
          $response = $this->json('PUT',
                                   route('generos.update',['genero'=>$genero->id]),
                                   ['name'=>str_repeat('a',256),
                                    'is_active'=>'a']);
          $response->assertStatus(422)
                   ->assertJsonValidationErrors(['name','is_active'])
                   ->assertJsonFragment([\Lang::get('validation.max.string',['attribute'=>'name','max'=>255])])
                   ->assertJsonFragment([\Lang::get('validation.boolean',['attribute'=>'is active'])])
                  ;
  }

            public function testStore(){
                $response = $this->json('POST',route('generos.store'),['name'=>'add nome']);
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

                $genero = factory(Genero::class)->create();
                $response = $this->json('DELETE',
                                         route('generos.destroy',['genero'=>$genero->id])  );
                $response->assertStatus(204);
               
            }
}
