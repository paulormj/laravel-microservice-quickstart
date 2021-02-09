<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Stubs\Controllers\CategoryControllerStub;
use Tests\Stubs\Models\CategoryStub;
use Tests\TestCase;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidations;

class BasicCrudControllerTest extends TestCase
{
      protected function setUp(): void
      {
          parent::setUp();
          CategoryStub::dropTable();
          CategoryStub::createTable();
      }

      protected function tearDown(): void
      {
          CategoryStub::dropTable();
          parent::tearDown();
      }

      //**@Var CategoryStub  $category*/
      public function testIndex(){
        $category = CategoryStub::create(['name'=>'test_name','description'=>'test_description']);
        $controller = new CategoryControllerStub();
        $result = $controller->index()->toArray();
        $this->assertEquals([$category->toArray()],$result);          
      }
  
}
