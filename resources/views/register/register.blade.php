<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>商户后台</title>
    <link rel="stylesheet" type="text/css" href="/login/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/login/css/body.css"/>
</head>
<body>
<div class="container">
    <section id="content">
        <form>
            <h1>商户注册</h1>
            <div>
                <input type="text" placeholder="账号"  id="username" />
            </div>
            <div>
                <input type="password" placeholder="密码" id="password" />
            </div>
            <div>
                <input type="password" placeholder="确认密码" class="passwordtwo" id="password" />
            </div>
            <div class="">
                <span class="help-block u-errormessage" id="js-server-helpinfo">&nbsp;</span></div>
            <div>
                <!-- <input type="submit" value="Log in" /> -->
                <input type="submit" value="注册" class="btn btn-primary" id="login"/>
                <a href="/dologin">已有账号? 去登录</a>
            </div>
        </form><!-- form -->
        <div class="button">
            <span class="help-block u-errormessage" id="js-server-helpinfo">&nbsp;</span>
        </div> <!-- button -->
    </section><!-- content -->
</div>
</body>
</html>
<link rel="stylesheet" href="{{URL::asset('/layui/css/layui.css')}}">
<script src="{{URL::asset('/layui/layui.js')}}"></script>
<script src="{{URL::asset('/js/jquery-1.12.4.min.js')}}"></script>
<script>
    $(function(){
        layui.use(['form','layer'], function(){
            var form = layui.form;
            var layer=layui.layer;
            $('#login').click(function(){
                var username= $('#username').val();
                var password= $('#password').val();
                var passwordtwo= $('.passwordtwo').val();
                $.post({
                    url:"/registerdo",
                    data:{username:username,password:password,passwordtwo:passwordtwo},
                    dataType:'json',
                    success:function(msg){
//                        console.log(msg)
                        layer.msg(msg.font,{icon:msg.code});
                        if(msg.code==1){
                            location.href="/";
                        }
                    }
                })
                return false;
            })
        })
    })
</script>


