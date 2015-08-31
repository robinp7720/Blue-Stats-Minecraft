<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>

    <style>
        body {
            background: #eee;
        }

        .install {
            font-family: 'Open Sans', sans-serif;
            width: 100%;
            line-height: 30px;
            height: auto;
            border-radius: 3px;
            background: white;
            padding: 5px 0;
            margin-top: 20px;
            -webkit-box-shadow: 0 0 20px 0 #3B3B3B;
            box-shadow: 0 0 20px 0 #3B3B3B;
        }
        .input-group{
            margin: 2px 0;
        }
        .light {
            font-weight: 300;
        }

        .bold {
            font-weight: bold;
        }

        .install-steps {
            height: 50px;
            width: 100%;
            margin-top: 20px;
            padding: 0;

        }

        .install-steps .step {
            width: 25%;
            display: block;
            float: left;
            background: #fff;
            height: 100%;
            line-height: 50px;
            text-align: center;
            border-bottom: #ddd 2px solid;
        }

        .install-steps .step.active {
            width: 25%;
            display: block;
            float: left;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            border: #ddd 2px solid;
            border-bottom: none;
        }

        .install-steps .step:first-of-type.active {
            border-top-left-radius: 0;
            border-top-right-radius: 5px;
            border-left: none;
            border-bottom: none;
        }
        .install-steps .step:last-of-type.active {
            border-top-left-radius: 5px;
            border-top-right-radius: 0;
            border-right: none;
            border-bottom: none;
        }

        .install-container {
            margin-top: 5px;
            padding: 10px;
            font-size: 1.2em;
        }

        .text-warning {
            color: #E74C3C;
        }

        .col-md-6 {
            padding: 5px 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="install">
        <h1 class="light text-center"><span class="bold">BlueStats</span> Installer</h1>

        <div class="install-steps">
            <div class="step <?php if ($_GET["step"] == 1 || !isset($_GET["step"])) echo "active"; ?>">Requirements
            </div>
            <div class="step <?php if ($_GET["step"] == 2) echo "active"; ?>">Configuration</div>
            <div class="step <?php if ($_GET["step"] == 3) echo "active"; ?>">Config Check</div>
            <div class="step <?php if ($_GET["step"] == 4) echo "active"; ?>">Install</div>
        </div>
        <div class="install-container" style="overflow: hidden">
            <?php
            if ($_GET["step"] == 1 || !isset($_GET["step"]))
                include 'views/step1.php';
            if ($_GET["step"] == 2)
                include 'views/step2.php';
            if ($_GET["step"] == 3)
                include 'views/step3.php';
            if ($_GET["step"] == 4)
                include 'views/step4.php';
            ?>
        </div>
    </div>
</div>
</body>
</html>