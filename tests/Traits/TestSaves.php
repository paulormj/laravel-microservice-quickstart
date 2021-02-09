<?php

namespace Tests\Traits;

use Illuminate\Foundation\Testing\TestResponse;

trait TestSaves
{
    protected abstract function model();
    protected abstract function routeStore();
    protected abstract function routeUpdate();

    protected function assertStore(array $sendData,array $testDataBase, array $testJsondata=null) : TestResponse
    {
        $response = $this->json('POST', $this->routeStore(),$sendData);
        if($response->status()!=201){
            throw new \Exception("Status deve ser 201, recebido {$response->status()} : \n {$response->content()}");
        }
        $this->assertInDataBase($response,$testDataBase);
        $this->assertJsonResponseContent($response,$testDataBase,$testJsondata);

        return $response;
    }

    protected function assertUpdate(array $sendData,array $testDataBase, array $testJsondata=null) : TestResponse{
        
        $response = $this->json('PUT', $this->routeUpdate(),$sendData);
        if($response->status()!=200){
            throw new \Exception("Status deve ser 200, recebido {$response->status()} : \n {$response->content()}");
        }
        $this->assertInDataBase($response,$testDataBase);
        $this->assertJsonResponseContent($response,$testDataBase,$testJsondata);

        return $response;
    }

    private function assertInDataBase( TestResponse $response, array $testDataBase){
        $model = $this->model();
        $table = (new $model)->getTable();
        $this->assertDataBaseHas($table,$testDataBase+ ['id' => $response->json('id')]);
    }

    private function assertJsonResponseContent(TestResponse $response,array $testDataBase, array $testJsondata=null){
        
        $testResponse = $testJsondata ?? $testDataBase;
        $response->assertJsonFragment($testResponse + ['id'=> $response->json('id')]);
    }


}