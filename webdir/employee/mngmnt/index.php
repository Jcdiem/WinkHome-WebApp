<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/employee/force_login.php";

/** @var mysqli $mysqli */
//Assuming already authenticated, due to forcing login
$lastName = substr($_SESSION['user'],3);
$firstName = substr($_SESSION['user'], 0, 3);
if(!$stmnt = $mysqli->prepare("SELECT isMng FROM staff WHERE last=? AND INSTR(first,?)")) echo "Error binding for user priv";
if (!$stmnt->bind_param("ss", $lastName, $firstName)) echo "Binding parameters failed: (";// . $stmnt->errno . ") " . $stmnt->error;
if (!$stmnt->execute()) echo "Execute failed: ("; // . $stmnt->errno . ") " . $stmnt->error;
if (!$result = $stmnt->get_result()) echo "Gathering result failed: (";// . $stmnt->errno . ") " . $stmnt->error;
$row = $result->fetch_assoc();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wink Home Management</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-vtXRMe3mGCbOeY7l30aIg8H9p3GdeSe4IFlP6G8JMa7o7lXvnz3GFKzPxzJdPfGK" crossorigin="anonymous"></script>
</head>
<?php
//If missing privileges
if($row['isMng'] == 0){?>
    <body>
    <p>
        ERROR: You do not have sufficient privileges to view this page.
    </p>
    </body>
<?php }
//If proper privileges, then load page
else{?>
<body>
<p>
    Content here :)
</p>
</body>
<?php } ?>
</html>