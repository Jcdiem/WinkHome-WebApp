<?php
session_start();
//Create CSRF
try {
    if(!isset($_SESSION['csrf_token'])) $_SESSION["csrf_token"] = bin2hex(random_bytes(128));
} catch (Exception $e) {
    echo "FATAL ERROR: Please refresh the page and try again";
}
?>
<!-- <pre>
<?php
//print_r($_SESSION);
?>
</pre> -->

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wink Home :: Login</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-vtXRMe3mGCbOeY7l30aIg8H9p3GdeSe4IFlP6G8JMa7o7lXvnz3GFKzPxzJdPfGK" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/main.css">
    <style>
        #loginForm {
            width: fit-content;
            margin: auto;
        }
        .btn-primary {
            text-align: center;
            margin: auto;
        }
    </style>
</head>
<?php

if(isset($_REQUEST['user']) && isset($_REQUEST['pass'])){

    $userName = $_REQUEST['user'];
    $password = $_REQUEST['pass'];

    require_once $_SERVER['DOCUMENT_ROOT']."/employee/db.php";

    /** @var $mysqli */
    if (!($stmnt = $mysqli->prepare('SELECT * FROM staff WHERE last=? AND INSTR(first,?) AND password=SHA2(?,512)'))) {
        echo "Prepare failed: (";// . $mysqli->errno . ") " . $mysqli->error;
    }

    $lastName = substr($userName, 3);
    $firstName = substr($userName, 0, 3);
    
    if (!$stmnt->bind_param("sss", $lastName, $firstName, $password)) echo "Binding parameters failed: (";// . $stmnt->errno . ") " . $stmnt->error;
    if (!$stmnt->execute()) echo "Execute failed: ("; // . $stmnt->errno . ") " . $stmnt->error;
    if (!$result = $stmnt->get_result()) echo "Gathering result failed: (";// . $stmnt->errno . ") " . $stmnt->error;

    $row = mysqli_fetch_assoc($result);

    if(!empty($row) && $_SESSION['csrf_token'] == $_REQUEST['csrf_token']) {
        unset($_SESSION['csrf_token']);
        session_destroy();
        session_start();
    
        $_SESSION['user'] = $firstName . $lastName;
    
        
    // This is what happens when the username and/or password doesn't match
    } else {
        unset($_SESSION['csrf_token']);
        echo "<p>Incorrect username OR password</p>";
    }
}


if(isset($_SESSION['user'])) { ?>
    <div id="goodAuthContainer" class="centered-box">
        <h1 class="font-roboto text-center">You have been logged in!</h1>
        <p class="text-center">Logged in as: <?= htmlspecialchars($_SESSION['user']); ?></p>
        <p class="text-center">Please click the button below if you are not automatically redirected to the employee page.</p>
        <a href="/employee" class="d-block text-center">
            <button class="btn-success btn-lg">
                Employee Page
            </button>
        </a>
    </div>
<?php

} else {

?>

<body>
<div id="loginForm-Container" class="centered-box">
    <h1 class="font-roboto text-center">Please Login Below</h1>
    <h2 id='incorrectInfoHeader' class='invalidServerVal' style='display: none'>Incorrect username OR password</h2>
    <form id="loginForm" method="post" class="border border-info">
        <div id="hiddenGroup" class="form-group">
            <input class="form-control" type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        </div>
        <div id="usernameGroup" class="form-group">
            <label for="usrInput">Username:</label>
            <input type="text" id="usrInput" name="user"/>
        </div>
        <div id="passwordGroup" class="form-group">
            <label for="passInput">Password:</label>
            <input type="password" id="passInput" name="pass"/>
        </div>

        <input type="submit" class="btn btn-primary" value="Log In"/>
    </form>
</div>
</body>
</html>
<?php } ?>