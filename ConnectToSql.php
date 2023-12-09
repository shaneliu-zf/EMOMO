<?php
    function ConnectToDataBase($databasename){
        $host = 'localhost';
        $dbuser ='root';
        $dbpassword = '';
        $link = mysqli_connect($host,$dbuser,$dbpassword,$databasename);
        if($link){
            mysqli_query($link,'SET NAMES uff8');
            // echo "正確連接資料庫";
        }
        else {
            echo "不正確連接資料庫</br>" . mysqli_connect_error();
        }
        $link_add = &$link;
        return $link_add;
    }
?>