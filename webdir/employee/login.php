<?php
session_start();
//Create CSRF
try {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(128));
} catch (Exception $e) {
    echo "Error in verification of user security!";
}

require_once "db.php";

$user = strtolower($_REQUEST['user']);
if(!empty($user)){
    $lastName = substr($user,3);
    $firstName = substr($user, 0, 3);

    $pass = $_REQUEST['pass']; 

    /** @var mysqli $mysqli */
    if (!($stmnt = $mysqli->prepare("SELECT * FROM staff WHERE last=? AND INSTR(first,?) AND password=SHA2(?,512)"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmnt->bind_param("sss", $lastName, $firstName, $pass)) {
        echo "Binding parameters failed: (" . $stmnt->errno . ") " . $stmnt->error;
    }
    if (!$stmnt->execute()) {
        echo "Execute failed: (" . $stmnt->errno . ") " . $stmnt->error;
    }
    if (!$result = $stmnt->get_result()) {
        echo "Gathering result failed: (" . $stmnt->errno . ") " . $stmnt->error;
    }
    $row = $result->fetch_assoc();

// This is what happens when a user successfully authenticates
    if(!empty($row) && $_SESSION['csrf_token'] == $_REQUEST['csrf_token']) {
        unset($_SESSION['csrf_token']);
        session_destroy();
        session_start();


        $_SESSION['user'] = $firstName.$lastName;



// This is what happens when the username and/or password doesn't match
    } else {
        echo "<p>Incorrect username OR password</p>";
    }
}

if($_SESSION['user']) {
    echo "<p>Welcome ";
    echo htmlspecialchars($_SESSION['user']);
    echo "</p>";

    if(!empty($_REQUEST['redirect'])){
        header("Location: {$_REQUEST['redirect']}");
    }
    exit();

} else {
?>

<html lang="en">
<body>

<form method="post">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
	<input type="hidden" name="redirect" value="<?= $_REQUEST['redirect'] ?>" />

	<label for="usrInput">Username:</label>
	<input type="text" id="usrInput" name="user" />

	<label for="passInput" >Password:</label>
	<input type="password" id="passInput" name="pass" />

	<input type="submit" value="Log In" />
</form>

<?php
}
?>

</body>
</html>
