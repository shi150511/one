<?php
   header("content-type:text/html;charset=utf-8");
   $GetUser=$_GET['username'];
   $GetPassWord=$_GET['password'];
   $MyUser='zhangsan';
   $MyPassWord='123456';
   
    if($GetUser==$MyUser&&$GetPassWord==$MyPassWord){
     	echo '登录成功';
    }else if($GetUser=='' && $GetPassWord=='' ){
    	echo "账号密码不能为空";
    }else if($GetUser!=$MyUser&&$GetPassWord!=$MyPassWord){
        echo '账号或密码输入错误,请重新输入';
    }
?>