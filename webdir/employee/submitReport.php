<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/employee/force_login.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/employee/db.php";


if(isset($_REQUEST['formType'])){
    /** @var $mysqli */
    $userName = explode('.', $_SESSION['user']);
    $success = false;

    switch($_REQUEST['formType']){
        case "dailyNeeds":
            echo "Daily needs submit not implemented.";
            break;
        case "dailyReport":
            if(!is_numeric($_REQUEST['clientRadio'])) {
                echo "Error in data format, client and staff ID should be numeric!";
                exit(-1);
            }
            else{
                if (!($stmnt = $mysqli->prepare('INSERT INTO DailyLogs(description, dateTime, signingEmployee, regardingClient) VALUES(?, ?, (SELECT staffID from staff where last LIKE ? AND INSTR(first,?)),(SELECT clientID from client where clientID=?));'))) echo "Prepare failed";//: (" . $mysqli->errno . ") " . $mysqli->error;
                if (!$stmnt->bind_param("ssssi", $_REQUEST['dreportEvent'], $_REQUEST['dreportDate'],$userName[1],$userName[0],$_REQUEST['clientRadio'])) echo "Binding parameters failed";//: (" . $stmnt->errno . ") " . $stmnt->error;
                if (!$stmnt->execute()) echo "Execute failed";// : (" . $stmnt->errno . ") " . $stmnt->error;
                else $success = true;
            }
            break;
        case "activity":
            if(!is_numeric($_REQUEST['clientRadio'])) {
                echo "Error in data format, client and staff ID should be numeric!";
                exit(-1);
            }
            else{
                if (!($stmnt = $mysqli->prepare('INSERT INTO activityReports(employee, client, activityType, date, location) VALUES((SELECT staffID from staff WHERE last LIKE ? AND INSTR(first, ?)), ?,?,?,?);'))) echo "Prepare failed";//: (" . $mysqli->errno . ") " . $mysqli->error;
                if (!$stmnt->bind_param("ssiiss", $userName[1],$userName[0],$_REQUEST['clientRadio'],$_REQUEST['activityCodeRadio'],$_REQUEST['activityDate'],$_REQUEST['activityLocation'])) echo "Binding parameters failed";//: (" . $stmnt->errno . ") " . $stmnt->error;
                if (!$stmnt->execute()) echo "Execute failed";// : (" . $stmnt->errno . ") " . $stmnt->error;
                else $success = true;
            }

            break;
        case "behaviourReport":
            if(!(isset($_REQUEST['damagesInput'])) || !(isset($_REQUEST['reflectInput'])) || !(isset($_REQUEST['damagesInput'])) || !(isset($_REQUEST['notesInput']))  || !(isset($_REQUEST['incidentInput'])) || !(isset($_REQUEST['precipInput'])) || !(isset($_REQUEST['clientRadio'])) || !(isset($_REQUEST['date']))){
                echo "All required fields not filled!";
            }
            else{
                if(!is_numeric($_REQUEST['clientRadio'])) {
                    echo "Error in data format, client and staff ID should be numeric!";
                    exit(-1);
                }
                else{
                    if(isset($_REQUEST['witnessInput'])){
                        if (!($stmnt = $mysqli->prepare('INSERT INTO behaviourIncidentReports (regardingClient, dateTime, signingEmployee, precipitatingFactors, incidentDescription, followupNotes, selfReflection, damages, witnesses) VALUES (?,?,(SELECT staffID from staff WHERE last LIKE ? AND INSTR(first, ?)),?,?,?,?,?,?)'))) echo "Prepare failed";//: (" . $mysqli->errno . ") " . $mysqli->error;
                        if (!$stmnt->bind_param("isssssssss", $_REQUEST['clientRadio'],$_REQUEST['date'],$userName[1],$userName[0],$_REQUEST['precipInput'],$_REQUEST['incidentInput'],$_REQUEST['notesInput'],$_REQUEST['reflectInput'],$_REQUEST['damagesInput'],$_REQUEST['witnessInput'])) echo "Binding parameters failed";//: (" . $stmnt->errno . ") " . $stmnt->error;
                        if (!$stmnt->execute()) echo "Execute failed";// : (" . $stmnt->errno . ") " . $stmnt->error;
                        else $success = true;
                    }
                    else{
                        if (!($stmnt = $mysqli->prepare('INSERT INTO behaviourIncidentReports (regardingClient, dateTime, signingEmployee, precipitatingFactors, incidentDescription, followupNotes, selfReflection, damages) VALUES (?,?,(SELECT staffID from staff WHERE last LIKE ? AND INSTR(first, ?)),?,?,?,?,?)'))) echo "Prepare failed";//: (" . $mysqli->errno . ") " . $mysqli->error;
                        if (!$stmnt->bind_param("isssssssss", $_REQUEST['clientRadio'],$_REQUEST['date'],$userName[1],$userName[0],$_REQUEST['precipInput'],$_REQUEST['incidentInput'],$_REQUEST['notesInput'],$_REQUEST['reflectInput'],$_REQUEST['damagesInput'])) echo "Binding parameters failed";//: (" . $stmnt->errno . ") " . $stmnt->error;
                        if (!$stmnt->execute()) echo "Execute failed";// : (" . $stmnt->errno . ") " . $stmnt->error;
                        else $success = true;
                    }
                }
            }


            break;
        default:
            echo "Error: unknown form type submitted!";
            exit(-1);
    }

    if($success){ ?>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Wink Home :: Report Submission</title>
        </head>
        <body class="flex-column">
        <h1>Success! Redirecting...</h1>
        <p>If redirection takes too long you may press the button below.</p>
        <a href="/employee" class="d-block">
            <button>
                Employee Page
            </button>
        </a>
        </body>
    <?php }
    else { ?>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Wink Home :: Report Submission</title>
        </head>
        <body class="flex-column">
        <h1>Submission failed!</h1>
        <p>Please inform your administrator before heading back to the employee page.</p>
        <a href="/employee" class="d-block">
            <button>
                Employee Page
            </button>
        </a>
        </body>
    <?php }
}
else{ ?>
<html lang="en">
<head>
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