<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17/2/8
 * Time: 17:48
 */

//=======================
//本例以登陆laravel作为例子
//具体为SkyDrive项目
//=======================


function login()
{
    //获取本地存储的cookie
    $cookie = $_COOKIE;
    //按照http请求中"Cookie: "部分的内容，设置cookie格式
    $str_coo = "";
    foreach($cookie as $k=>$v){
        $str_coo .= $k.'='.$v.'; ';
    }
    if(count($cookie)) $str_coo = substr($str_coo,0,strlen($str_coo)-2);

    //设置表单提交，laravel这里需要提前获取_token的值，访问登陆界面的表单_token即可
    $data = array(
        '_token'    =>  'umBVpLALyS59KAaIQpjFGLSq2ZZkxfETuC9ChUcw',
        'email'     =>  '690828339@qq.com',
        'password'  =>  '690828339',
        'open'      =>  'on'
    );

    //初始化curl会话
    $ch = curl_init("http://192.168.1.60:8017/login");
    curl_setopt($ch, CURLOPT_HEADER, 0);                        //禁止显示header信息包含在输出中
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);                //如果成功只将结果返回，不自动输出
    curl_setopt($ch, CURLOPT_POST, 1);                          //将此次请求设置为post
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                //添加表单
    curl_setopt($ch, CURLOPT_COOKIE, $str_coo);                 //添加cookie数据
//    curl_setopt($ch, CURLOPT_COOKIEFILE, "vickaycookie");     //从文件添加cookie数据
    curl_setopt($ch, CURLOPT_COOKIEJAR, "vickaycookie");        //将请求返回的cookie存入最后一个参数所指文件中
    $output = curl_exec($ch);                                   //发起会话
    curl_close($ch);                                            //关闭会话

    file_put_contents("login_result.txt", $output);

    echo $output;
}

function getData(){

    $data = array(
        '_token'=>'umBVpLALyS59KAaIQpjFGLSq2ZZkxfETuC9ChUcw',
        'father_catalog_name'=>'',
        'skip'=>0,
        'size'=>10
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://192.168.1.60:8017/sky_drive/refresh");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "vickaycookie");       //携带cookie数据进行访问
    curl_setopt($ch, CURLOPT_COOKIEJAR, "vickaycookie");
    $str = curl_exec($ch);
    file_put_contents("data.txt", $str);
    curl_close($ch);
    var_dump(json_decode($str,true));
}

//登陆laravel
login();
//访问指定页面
getData();