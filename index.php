<?php

## The home page

session_start();

if (isset($_SESSION["user_id"])) {

    $mysqli = require __DIR__ ."/database.php";

    # Gets user from database
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
    
    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

?>

<!--  html for the home page  -->

<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./pico-main/css/pico.min.css">
    </head>

    <body>
        <h1>Home</h1>

        <?php if (isset($user)) : ?>
            
            <!-- Hello {user}-->
            <p>Hello <?= htmlspecialchars($user["name"]) ?></p>
            <p><a href="logout.php">Log out</a></p>

        <?php else: ?>
            
            <p><a href="login.php">Login in</a> or <a href="signup.html">Sign up</a></p>
        
        <?php endif; ?>

    </body>
</html>