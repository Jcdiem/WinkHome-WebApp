<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/employee/force_login.php" ?>

<html lang="en">
<head>
    <!--  Template for the dashboard courtesy of https://www.blog.duomly.com/bootstrap-tutorial/  -->
    <!--  Tab code and implementation https://inspirationalpixels.com/creating-tabs-with-html-css-and-jquery/  -->
    <meta charset="UTF-8">
    <title>Wink Home :: Employee Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha384-vtXRMe3mGCbOeY7l30aIg8H9p3GdeSe4IFlP6G8JMa7o7lXvnz3GFKzPxzJdPfGK"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
            integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/main.css">
    <style>
        main {
            padding-top: 90px;
        }
        button{
            background: none;
            color: inherit;
            border: none;
            padding: 0;
            font: inherit;
            cursor: pointer;
            outline: inherit;
        }
        .sidebar {
            position: fixed;
            left: 0;
            bottom: 0;
            top: 0;
            z-index: 100;
            padding: 70px 0 0 10px;
            border-right: 1px solid #d3d3d3;
        }

        .left-sidebar {
            position: sticky;
            top:0;
            height: calc(100vh - 70px)
        }

        .sidebar-nav li .nav-link {
            color: #333;
            font-weight: 500;
        }

        .tab {
            display:none;
        }

        .tab.active {
            display:block;
        }

        .submissionField {
            width: 75%;
            height: 300px;
            border: 1px solid #555555;
            padding: 5px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark fixed-top bg-primary flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Employee Dashboard</a>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="/employee/logout.php">Logout</a>
        </li>
    </ul>
</nav>
<div class="container-fluid">
    <div class="row">
        <div id="sidebar" class="col-md-2 bg-light d-none d-md-block sidebar">
            <div class="left-sidebar">
                <ul class="nav nav-pills flex-column sidebar-nav">
                    <li class="nav-item active">
                        <a class="nav-link tablinks active" href="#dailyNeedsTab">
                            <svg class="bi bi-chevron-right" width="16" height="16" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6.646 3.646a.5.5 0 01.708 0l6 6a.5.5 0 010 .708l-6 6a.5.5 0 01-.708-.708L12.293 10 6.646 4.354a.5.5 0 010-.708z" clip-rule="evenodd"/></svg>
                            Daily Needs Reporting
                        </a>
                    </li>
<!--                    -->
                    <li class="nav-item">
                        <a class="nav-link tablinks" href="#dailyReportTab">
                            <svg class="bi bi-chevron-right" width="16" height="16" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6.646 3.646a.5.5 0 01.708 0l6 6a.5.5 0 010 .708l-6 6a.5.5 0 01-.708-.708L12.293 10 6.646 4.354a.5.5 0 010-.708z" clip-rule="evenodd"/></svg>
                            Daily Client Report
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tablinks" href="#activityReportTab">
                            <svg class="bi bi-chevron-right" width="16" height="16" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6.646 3.646a.5.5 0 01.708 0l6 6a.5.5 0 010 .708l-6 6a.5.5 0 01-.708-.708L12.293 10 6.646 4.354a.5.5 0 010-.708z" clip-rule="evenodd"/></svg>
                            Activity Report
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tablinks" href="#behaviourReportTab">
                            <svg class="bi bi-chevron-right" width="16" height="16" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6.646 3.646a.5.5 0 01.708 0l6 6a.5.5 0 010 .708l-6 6a.5.5 0 01-.708-.708L12.293 10 6.646 4.354a.5.5 0 010-.708z" clip-rule="evenodd"/></svg>
                            Behaviour Report
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <main role="main" class="tab-content col-md-9 ml-sm-auto col-lg-10 px-4">
            <div id="dailyNeedsTab" class="tab active">
<!--            Client Completion of Daily Schedule Report-->
                <form>
                    <div class="form-group">
                        <label for="dateInput">Date:  </label>
                        <input type="date" id="dateInput">
                    </div>
                    <div class="form-group">
                        <label for="wakeupInput">Wake up time: </label>
                        <input type="time" id="wakeupInput">
                    </div>
                    <div class="form-group">
                        <label for="sleepInput">Bed time: </label>
                        <input type="time" id="sleepInput">
                    </div>
                    <input type="submit">
                </form>
<!--            TODO: Load in from a schedule -->
            </div>
            <div id="dailyReportTab" class="tab">
            test2
            </div>
            <div id="activityReportTab" class="tab">
            test3
            </div>
            <div id="behaviourReportTab" class="tab">
                <!-- Behavioral Incident Report Form -->
                <p>This report is to be a factual account of behavioral incidents that occur. <br> 
                Be factual and objective in your writing when filing this form. <br></p>                
                <form>
                    <div class="form-group">
                        <label for="clientInput">Client: </label>
                        <br>
                        <input type="radio" id="clientInput">
                    </div>
                    <div class="form-group">
                        <label for="precipInput">Precipitating Factors: </label>
                        <br>
                        <textarea id="precipInput" class="submissionField"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="incidentInput">Details of Behavioral Incident: </label>
                        <br>
                        <p style="font-size: 0.75rem">Please include details of what intervention was used, and how the client responded.</p>
                        <textarea id="precipInput" class="submissionField"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="notesInput">Details From Follow-Up Meeting</label>
                        <br>
                        <textarea id="notesInput" class="submissionField"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="reflectInput">How will this change assisting the client? (Self Reflection)</label>
                        <br>
                        <textarea id="reflectInput" class="submissionField"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="damagesInput">Physical Injuries and Damages: </label>
                        <br>
                        <textarea id="damagesInput" class="submissionField"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="witnessInput">Witnesses</label>
                        <br>
                        <input type="text" id="witnessInput" placeholder="John Doe, Jane Doe, etc...">
                    </div>
                    <p class="text-danger">By submitting this form, you are entering your above text as an official statement tied to your name.</p>
                    <input type="submit">
                </form>
            </div>
        </main>
    </div>
</div>
</body>
<script>
    $(document).ready(function() {
        $('.tablinks').on('click', function(e) {
            console.debug('Hit nav link');
            let currentAttrValue = $(this).attr('href');
            $('.active').removeClass('active');
            $(this).addClass('active');
            $(currentAttrValue).addClass("active");

            e.preventDefault();
        });
    });
</script>
</html>


