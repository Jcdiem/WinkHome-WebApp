<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/employee/force_login.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/employee/db.php";


if(isset($_REQUEST['formType'])){
    switch($_REQUEST['formType']){

    }
}
else{ ?>
<html lang="en">
<head>
    <!--  Template for the dashboard courtesy of https://www.blog.duomly.com/bootstrap-tutorial/  -->
    <meta charset="UTF-8">
    <title>Wink Home :: Report Submission</title>
</head>
<body class="flex-column">
<h1>Redirecting...</h1>
<p>If redirection takes too long you may press the button below.</p>
<a href="/employee" class="d-block">
    <button>
        Employee Page
    </button>
</a>
</body>
<?php }