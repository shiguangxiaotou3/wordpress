<?php

function dump($res){
    echo "<pre>";
    print_r($res);
    echo "</pre>";
}
session_start();
$url =$_SERVER["REQUEST_SCHEME"]."://" .$_SERVER["HTTP_HOST"]."/wp-admin/admin.php?page=ads";
if(isset($_GET['code']) and !empty($_GET['code'])){
    $_SESSION["code"] =$_GET['code'];
    Header("Location: $url");
}else{
    echo "没有获取到code";
}