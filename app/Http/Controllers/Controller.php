<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * 数据返回
     */
    public function dataJson($status , $msg , $data = []){
        return [
            'status'    =>  $status,
            'msg'       =>  $msg,
            'data'      =>  $data
        ];
    }

    /**
     * layui数据返回
     */
    public function dataJsonLayui($code , $msg , $data = [] , $count = 0){
        return [
            'code'      =>  $code,
            'msg'       =>  $msg,
            'data'      =>  $data,
            'count'     =>  $count
        ];
    }

}
