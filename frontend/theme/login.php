<?php
ob_start();
include_once "header.php";
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once "../../backend/User.php";

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  $email = $_POST['email'];
  $password = md5($_POST['password']);
  $Newuser = New User();
  $result = $Newuser->loginCheck($email,$password);
  if($result[0]){
    setcookie("user_id", $result[1], 0, "/");
    echo "<script>alert('登入成功');</script>";
    echo "<script>window.location.href = '/index.php';</script>";
    ob_end_flush();
  }
  else{
    echo "<script>alert('登入失敗，請重試');</script>";
  }
}
?>

<body id="body">

<section class="signin-page account">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">
          <a class="logo" href="index.php">
            <h1>EMOMO</h1>
          </a>
          <h2 class="text-center">登入帳號</h2>
          <form class="text-left clearfix" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
              <h3>Email</h3>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
              <h3>Password</h3>
              <input type="password" class="form-control" id="password" name="password" require>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-main text-center" >登　入</button>
            </div>
          </form>
          <p class="mt-20">沒有 EMOMO 購物帳號？ <a href="Register.php">立即註冊</a></p>
        </div>
      </div>
    </div>
  </div>
</section>

  </body>
  </html>

  <?php include "footer.php"?>
