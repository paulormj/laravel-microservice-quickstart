<?php

namespace Tests\Stubs\Controllers;

use App\Http\Controllers\Api\BasicCrudController;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tests\Stubs\Models\CategoryStub;

class CategoryControllerStub extends BasicCrudController
{

    protected function model(){
        return CategoryStub::class;
    }
    
    function rolesStore()
    {
        return [
            "name"=>"required | max:255"
        ];
    }
}
