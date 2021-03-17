<?php
session_start();
//Create CSRF
try {
    if(empty($_SESSION['csrf_token'])) $_SESSION["csrf_token"] = bin2hex(random_bytes(128));
} catch (Exception $e) {
    echo "FATAL ERROR: Please refresh the page and try again";
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wink Home :: Login</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-vtXRMe3mGCbOeY7l30aIg8H9p3GdeSe4IFlP6G8JMa7o7lXvnz3GFKzPxzJdPfGK" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/main.css">
    <style>
        #loginForm{
            width: fit-content;
            margin: auto;
        .btn-primary {
            text-align: center;
            margin: auto;
        }
        }
    </style>
</head>
<?php

require_once "db.php";

$user = strtolower($_REQUEST['user']);

if ($_SESSION['user']) {?>
    <body>
    <div class="centered-box">
        <h1 class="text-center font-weight-bold">Already Logged In</h1>
        <p class="text-center">Logged in as: <?php echo htmlspecialchars($_SESSION['user']); ?></p>
        <a href="/employee" class="d-block text-center">
            <button class="btn-success btn-lg">
                Employee Page
            </button>
        </a>
    </div>
    <?php

    if (!empty($_REQUEST['redirect'])) {
        header("Location: {$_REQUEST['redirect']}");
    }
    exit();

} else {
if (!empty($user)) {
    $lastName = substr($user, 3);
    $firstName = substr($user, 0, 3);

    $pass = $_REQUEST['pass'];

    /** @var mysqli $mysqli */
    if (!($stmnt = $mysqli->prepare("SELECT * FROM staff WHERE last=? AND INSTR(first,?) AND password=SHA2(?,512)"))) {
        echo "Prepare failed: (";// . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmnt->bind_param("sss", $lastName, $firstName, $pass)) echo "Binding parameters failed: (";// . $stmnt->errno . ") " . $stmnt->error;
    if (!$stmnt->execute()) echo "Execute failed: ("; // . $stmnt->errno . ") " . $stmnt->error;
    if (!$result = $stmnt->get_result()) echo "Gathering result failed: (";// . $stmnt->errno . ") " . $stmnt->error;

    $row = $result -> fetch_assoc();

// This is what happens when a user successfully authenticates
    if(!($_SESSION['csrf_token'] == $_REQUEST['csrf_token'])) echo 'FATAL ERROR: Please refresh the page and try again';
    if(!empty($row)) {
        unset($_SESSION['csrf_token']);
        session_destroy();
        session_start();

        $_SESSION['user'] = $firstName . $lastName;


// Create an else to allow notifying user of wrong info
    } else {?>
<body>
<div id="loginForm-Container" class="centered-box">
    <h1 class="font-roboto text-center">Please Login Below</h1>
    <?php echo "<h2 class='invalidServerVal'>Incorrect username OR password</h2>";}} ?>
    <form id="loginForm" method="post" class="border border-info">
        <div id="hiddenGroup" class="form-group">
            <input class="form-control" type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input class="form-control" type="hidden" name="redirect" value="<?= $_REQUEST['redirect'] ?>"/>
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

<?php
}
?>

</body>
</html>
