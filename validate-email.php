<?php

## Checks if email is a valid server-side

# Connects to database
$mysqli = require __DIR__ ."/database.php";

# Queries the database
$sql = sprintf("SELECT * FROM user
                WHERE email = '%s'",
                $mysqli->real_escape_string($_GET["email"]));

$result = $mysqli->query($sql);

# If there are no rows that have this email, it is available
$is_available = $result->num_rows === 0;

header("Content-Type: application/json");

echo json_encode(["available" => $is_available]);