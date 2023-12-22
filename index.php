<html>
<?php
    require_once("backend/text.php");
    require_once("backend/User.php");
    require_once("backend/Admin.php");
    require_once("backend/Customer.php");
?>

<body>


    <div id="d">
        <h1>Welcome!</h1>

        <!-- register -->
        <!-- <form method="post" action="backend/register.php">
            <label for="id">Account:</label>
            <input type="text" id="id" name="id" required><br>

            <label for="name">name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="address">address:</label>
            <input type="address" id="address" name="address" required><br>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <label for="usertype">Usertype:</label>
            <input type="text" id="usertype" name="usertype" required><br>

            <input type="submit" value="Login">
        </form> -->

        <!-- login -->
        <form method="post" action="backend/login.php">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <input type="submit" value="Login">
        </form>
    </div>

</body>

</html>
