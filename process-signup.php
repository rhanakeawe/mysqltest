<?php

# Account creation handler

if (empty($_POST["name"])) {
    die("Name is required");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Invalid Email");
}

if (strlen($_POST["password"]) < 6) {
    die("Password must be at least 8 characters");
}

if (! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if (! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password-confirmation"]) {
    die("Passwords must match");
}

# Hashes password for security

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

# Connects to the database

$mysqli = require __DIR__ ."/database.php";

# Inserts data into the database

$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?, ?, ?)";
$stmt = $mysqli->stmt_init();
$stmt->prepare($sql);

# SQL Error Prints

if (! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

# Binds the string parameter to the SQL query
# https://www.w3schools.com/php/php_mysql_prepared_statements.asp
$stmt->bind_param("sss", $_POST["name"],$_POST["email"], $password_hash);

# Takes user to signup-success page

if ($stmt->execute()) {
    header("Location: signup-success.html");
    exit;
} else {
    if ($mysqli->errorno === 1062) {
        die("Email already taken");
    } else {
        die($mysqli->error  . " " . $mysqli->errorno);
    }
}