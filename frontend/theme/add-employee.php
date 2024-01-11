<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once "header.php";
require_once "../../backend/User.php";

if(!isset($_COOKIE['user_id']) || !User::isAdmin($_COOKIE['user_id'])){
    echo '<meta http-equiv="refresh" content="0;url=login.php">';
    die();
}

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = md5($_POST['password']);
  $address = $_POST['address'];
  $NewUser = new User();
  $NewUser->createNewUser($name,$email,$password,$address,'staff');
  $result = $NewUser->getIsRegistered();
  if($result){
    echo "<script>alert('重複的email');</script>";
  }
  else{
    echo "<script>alert('新增成功');</script>";
  }
}
?>




<!-- Main Menu Section -->
<section class="add-employee section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="form-wrapper">
                    <h2 class="section-title">新增員工</h2>
                    <form class="text-left clearfix" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <!-- 在這裡添加您的表單字段 -->
                        <div class="form-group">
                            <label for="name">員工名稱：</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="email">email:</label>
                            <input type="text" id="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password">員工密碼：</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="address">員工地址：</label>
                            <textarea id="address" name="address" class="form-control" required></textarea>
                        </div>

                        <!-- 根據需要添加更多字段 -->

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">新增員工</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


  </body>
  </html>

  <?php include "footer.php";?>
