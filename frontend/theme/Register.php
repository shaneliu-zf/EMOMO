<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once "header.php";
require_once "../../backend/User.php";

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  $name = $_POST['name'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $usertype = "Customer";
  $password = md5($_POST['password']);
  $Newuser = new User();
  $Newuser->createNewUser($name,$email,$password,$address,$usertype);
  $result = $Newuser->getIsRegistered();
  if($result){
    echo "<script>alert('已註冊過或有相同email');</script>";
  }
  else{
    echo "<script>alert('註冊成功');</script>";
    echo "<script>window.location.href = '/login.php';</script>";
  }
}
?>

<section class="signin-page account">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">
          <a class="logo" href="index.php">
            <h1>EMOMO</h1>
          </a>
          <h2 class="text-center">建立帳號</h2>

          <form class="text-left clearfix" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
              <label for="name">名字:</label>
              <input type="text" class="form-control"  id="name" name="name" required>
            </div>
            <div class="form-group">
              <label for="email">Email帳號:</label>
              <input type="email" class="form-control"  id="email" name="email" required>
            </div>
            <div class="form-group">
              <label for="password">密碼:</label>
              <input type="password" class="form-control"  id="password" name="password" required>
            </div>
            <div class="form-group">
            <label for="address">地址:</label>
              <input type="text" class="form-control"  id="address" name="address" required>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-main text-center">創建</button>
            </div>
          </form>
          <p class="mt-20">已經有帳號了嗎 ?<a href="login.php"> 登入</a></p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include "footer.php";?>
