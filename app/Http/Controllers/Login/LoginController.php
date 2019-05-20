<?php

namespace App\Http\Controllers\Login;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\BusinessModel;

class LoginController extends Controller
{
    //登录
   public function login(){
       return view('login.login');
   }
    //验证登录时的值
    public function doLogin(Request $request){
        $username=$request->input('username');
        $pwd=$request->input('password');
        if(empty($username)){
            $data=[
                'code'=>2,
                'font'=>'账号不能为空'
            ];
            return $data;
        }
        if(empty($pwd)){
            $data=[
                'code'=>2,
                'font'=>'密码不能为空'
            ];
            return $data;
        }
        $pwd=md5($pwd);
        $where=[
            'username'=>$username,
            'pwd'=>$pwd
        ];
        $businessInfo=BusinessModel::where($where)->first()->toArray();
        if(empty($businessInfo)){
            $data=[
                'code'=>2,
                'font'=>'商户不存在'
            ];
            return $data;
        }
        $business_id=$businessInfo['id'];
        $business_name=$businessInfo['username'];
//        var_dump($business_id);die;
        if(empty($businessInfo)){
            $data=[
                'code'=>2,
                'font'=>'账号或密码错误'
            ];
        }else{
            $data=[
                'code'=>1,
                'font'=>'登录成功'
            ];
            //存储cookie 与 session
            setcookie("business_id",$business_id,time()+86400,"/",'',false,true);
            setcookie("business_name",$business_name,time()+86400,"/",'',false,true);
            $request->session()->put('businessInfo',$businessInfo);
        }
        echo json_encode($data);
    }
    //注册
    public function register(){
        return view('register.register');
    }
    //注册入库
    public function doRegister(Request $request){
        $username=$request->input('username');
        $pwd=$request->input('password');
        $pwd2=$request->input('passwordtwo');
        if(empty($username)){
            $data=[
                'code'=>2,
                'font'=>'账号不能为空'
            ];
            return $data;
        }
        if(empty($pwd)){
            $data=[
                'code'=>2,
                'font'=>'密码不能为空'
            ];
            return $data;
        }
        if(empty($pwd2)){
            $data=[
                'code'=>2,
                'font'=>'确认密码不能为空'
            ];
            return $data;
        }
        if($pwd!=$pwd2){
            $data=[
                'code'=>2,
                'font'=>'确认密码必须与密码保持一致'
            ];
            return $data;
        }
        $pwd=md5($pwd);
        $businessInfo=[
            'username'=>$username,
            'pwd'=>$pwd,
            'add_time'=>time()
        ];
        //验证唯一
        $where=[
            'username'=>$username
        ];
        $res=BusinessModel::where($where)->first();
        if($res){
            $data=[
                'code'=>2,
                'font'=>'用户已存在'
            ];
            return $data;
        }
        $id=BusinessModel::insertGetId($businessInfo);
        if(!empty($id)){
            $data=[
                'code'=>1,
                'font'=>'注册成功'
            ];
            setcookie("business_id",$id,time()+86400,"/",'',false,true);
            setcookie("business_name",$username,time()+86400,"/",'',false,true);
            $request->session()->put('businessInfo',$businessInfo);
        }else{
            $data=[
                'code'=>1,
                'font'=>'注册失败'
            ];
        }
        echo json_encode($data);
    }
    //退出
    public function quit(){
        session_start();
        session()->forget("businessInfo");
//        cookie()->forget("admin_id","/",'');
        setcookie('business_id','',time()-3600,"/",'',false,true);
        cookie()->forget("business_name");
        setcookie('business_name','',time()-3600,"/",'',false,true);
//        var_dump($_COOKIE);
        session_destroy();
        setcookie('PHPSESSID','',time()-3600,"/",'',false,true);
        //echo "退出成功";
        header("refresh:1,url=/dologin");
    }
}
