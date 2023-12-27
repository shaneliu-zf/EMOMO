<?php
function connectDB(){
    $host = 'localhost';
    $dbuser ='u118150049_admin';
    $dbpassword = 'Emomo1momo';
    $dbname = 'u118150049_emomo';

    $link = mysqli_connect($host,$dbuser,$dbpassword,$dbname);
    if($link){
        mysqli_query($link,'SET NAMES utf8');
        //echo "正確連接資料庫";
    }
    else {
        echo "不正確連接資料庫</br>" . mysqli_connect_error();
    }
    return $link;
}
?>
