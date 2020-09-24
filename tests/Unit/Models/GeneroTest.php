<?php

namespace Tests\Unit\Models;

use App\Models\Genero;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GeneroTest extends TestCase
{
   
    protected function setUp():void{
        parent::setUp();
        $this->genero = new Genero();
    }

    public function testCast(){

        $casts = ['is_active'=>'boolean'];
        $this->assertEquals($casts,$this->genero->getCasts());
    }

    public function testFillabe(){
        $fillable = ['name','is_active'];
        $this->assertEquals($fillable,$this->genero->getFillable());
    }

    public function testUseTraits(){
        $traits = [SoftDeletes::class,Uuid::class];
        $generoTraits = array_keys(class_uses(Genero::class));
        $this->assertEquals($traits,$generoTraits);

    }

    public function testIncremetings(){
        $this->assertFalse($this->genero->getIncrementing());
    }

    public function testDates(){
        $dates = ['updated_at','deleted_at','created_at'];
        $this->assertEqualsCanonicalizing($dates,$this->genero->getDates());
    }
}


