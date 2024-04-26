<?php

## The login page

    $is_invalid = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        # Connects to database
        $mysqli = require __DIR__ ."/database.php";
        # Queries database for email
        $sql = sprintf("SELECT * FROM user
                        WHERE email = '%s'",
                        $mysqli->real_escape_string($_POST["email"]));
        $result = $mysqli->query($sql);
        $user = $result->fetch_assoc();

        # Checks if password entered matches user password_hash
        if ($user) {
            if (password_verify($_POST["password"], $user["password_hash"])) {
                
                # Starts session as user
                session_start();
                session_regenerate_id();

                # Sets user_id for session
                $_SESSION["user_id"] = $user["id"];

                header("Location: index.php");
                exit;
            }
        }

        $is_invalid = true;
    }
?>

<!-- The html for login page -->
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./pico-main/css/pico.min.css">
    </head>

    <body>
        <h1>Login</h1>

        <?php if ($is_invalid) : ?>
            <em>Invalid login</em>
        <?php endif; ?>

        <form method="post">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" 
                    value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">

            <label for="password">Password</label>
            <input type="password" name="password" id="password">

            <button>Log in</button>
        </form>
    </body>
</html>