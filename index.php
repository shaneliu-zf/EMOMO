<?php
    require_once("backend/text.php");
    require_once("backend/User.php");
    require_once("backend/Admin.php");
    require_once("backend/Customer.php");
?>

<body>
    <div id="d">
        <h1>Welcome<?php echo $_GET["user_id"]; ?>!</h1>
        <br>
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
