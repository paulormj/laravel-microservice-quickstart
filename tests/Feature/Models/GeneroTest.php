<?php

namespace Tests\Feature\Models;

use App\Models\Genero;
use Faker\Factory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GeneroTest extends TestCase
{
    use DatabaseMigrations;
    use SoftDeletes;
  
    public function testList()
    {
        Factory(Genero::class,1)->create();
        $generos = Genero::all();
        $this->assertCount(1,$generos);
        $generoKeys = array_keys($generos->first()->getAttributes());
        $keys = ['id','name','is_active','created_at','deleted_at','updated_at'];
        $this->assertEqualsCanonicalizing($keys,$generoKeys);
        
    }
    public function testCreate(){
        $genero = Genero::create([
            'name' => 'test1'
        ]);
        
        $genero->refresh();
        
        $this->assertEquals(36,strlen($genero->id));
        $this->assertEquals('test1',$genero->name);
        $this->assertTrue($genero->is_active);
        
        $genero = Genero::create([
            'name' => 'test1',
            'is_active' => false
        ]);
        $this->assertFalse($genero->is_active);

       $genero = Genero::create([
            'name' => 'test1',
            'is_active' => true
        ]);
        $this->assertTrue($genero->is_active);

    }

    public function testUpdate(){
        $genero = factory(Genero::class)->create([
            'is_active' => false
        ]);
        
        $data = [
            'name' => 'test_name_update',
           'is_active' => false
        ];
        $genero->update($data);

       foreach($data as $key => $value){
           $this->assertEquals($value, $genero->{$key});

       }

    }

  public function testDelete(){
        $genero = factory(Genero::class)->create();
       
        $genero->delete();
        
       $this->assertSoftDeleted($genero);
    }   
    
}
