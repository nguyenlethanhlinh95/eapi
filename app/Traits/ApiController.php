<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 1/21/2020
 * Time: 8:30 PM
 */

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiController
{
    private function successReponse($data, $code)
    {
        return response()->json($data,$code);
    }

    protected function errorResponse($message='Error', $code=500)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        return $this->successReponse(['data'=> $collection], $code);
    }

    protected function showOne(Model $model, $code = 200)
    {
        return $this->successReponse(['data'=> $model], $code);
    }
}