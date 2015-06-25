<!DOCTYPE HTML>
<html>
<head>
    <title>BlueStats 3 Install</title>
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/paper/bootstrap.min.css">
    <style>
        .input-group {
            margin-bottom: 10px;
        }

        .label {
            font-size: 14px;
            margin: 5px 5px 5px 0;
            float: left;
            display: block;
        }

        .requirements {
            overflow: hidden;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>BlueStats 3 Install</h1>

    <div class="requirements">
        <?php
        if (version_compare(PHP_VERSION, '5.2.0', '>=')) {
            echo '<span class="label label-success">Current PHP version: ' . PHP_VERSION, '</span>';
        } else {
            echo '<span class="label label-danger">Minimum php version required: 5.2 You have: ' . PHP_VERSION, '</span>';
        }
        if (is_writable('.')) {
            echo '<span class="label label-success">PHP has permission to write config.php</span>';
        } else {
            echo '<span class="label label-danger">Config.php must be created manually</span>';
        }
        if (extension_loaded('mysqlnd')) {
            echo '<span class="label label-success">mysqlnd is installed</span>';
        } else {
            echo '<span class="label label-success">mysqlnd is required</span>';
        }
        ?>
        <br>
        <br>
    </div>
    <form action="install.php" method="POST">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    BlueStats database Settings (Not lolmewn stats database settings)
                </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Host</span>
                            <input type="text" class="form-control" placeholder="Host" name="bs-host" value="127.0.0.1">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Username</span>
                            <input type="text" class="form-control" placeholder="Username" name="bs-username"
                                   value="minecraft">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Password</span>
                            <input type="password" class="form-control" placeholder="Password" name="bs-password">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Database</span>
                            <input type="text" class="form-control" placeholder="DataBase" name="bs-db"
                                   value="BlueStats">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success btn-lg pull-right">Install</button>
    </form>
</div>
</body>
</html>