<html>
<?php
    require_once("backend/text.php");
    require_once("backend/User.php");
    require_once("backend/Admin.php");
    require_once("backend/Customer.php");
    $user = new User('2','HCW','toby911202360@gmail.com','abc','Tainan','customer');
?>

<body>


    <div id="d">
        <h1>Welcome!</h1>

        user name is: <?php echo $user->name;?><br />
        user email is: <?php echo $user->email;?>

    </div>

</body>

</html>
