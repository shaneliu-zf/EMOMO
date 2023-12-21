<?php
ini_set('display_errors','1');
error_reporting(E_ALL);


require_once "backend/db.php";


class UUser{
    public $user_id;
    public $name;
    public $email;

    function __construct($user_id){

        $db = connectDB();
        $data = array();

        $sql = "SELECT * FROM `user` WHERE `user_id`= ".$user_id;
        // 用mysqli_query方法執行(sql語法)將結果存在變數中
        $result = mysqli_query($db,$sql);

        if($result){
            // mysqli_num_rows方法可以回傳我們結果總共有幾筆資料
            if (mysqli_num_rows($result)>0) {
                // 取得大於0代表有資料
                // while迴圈會根據資料數量，決定跑的次數
                // mysqli_fetch_assoc方法可取得一筆值
                while ($row = mysqli_fetch_assoc($result)){
                    // 每跑一次迴圈就抓一筆值，最後放進data陣列中
                    $data[] = $row;
                }
            }
            // 釋放資料庫查到的記憶體
            mysqli_free_result($result);
        }
        else{
            echo "{$sql} 語法執行失敗，錯誤訊息: " . mysqli_error($db);
        }

        // 處理完後印出資料
        if(!empty($result)){
            // 如果結果不為空，就利用print_r方法印出資料
            print_r($data);
        }
        else {
            // 為空表示沒資料
            echo "查無資料";
        }

        $this->user_id = $data[0]["user_id"];
        $this->name = $data[0]["name"];
        $this->email = $data[0]["email"];
    }
}
?>
