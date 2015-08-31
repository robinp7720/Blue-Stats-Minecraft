<?php
session_start();
?>

<form action="?step=3" method="post" style="overflow: hidden">
<div class="row">
    <div class="col-md-6">
        <h2>BlueStats Database
            <br><small>(Not lolmewnStats mysql details)</small>
        </h2>
        <label for="bs-host">Host:</label>
        <input type="text" class="form-control" id="bs-host" placeholder="Host" name="bs-host" value="<?php if (isset($_SESSION["bs-host"])) echo $_SESSION["bs-host"]?>">

        <label for="bs-username">Username:</label>
        <input type="text" class="form-control" id="bs-username" placeholder="Username" name="bs-username" value="<?php if (isset($_SESSION["bs-username"])) echo $_SESSION["bs-username"]?>">

        <label for="bs-password">Password:</label>
        <input type="password" class="form-control" id="bs-password" placeholder="Password" name="bs-password" value="">

        <label for="bs-db">Data Base:</label>
        <input type="text" class="form-control" id="bs-db" placeholder="Database name" name="bs-db" value="<?php if (isset($_SESSION["bs-db"])) echo $_SESSION["bs-db"]?>">
    </div>
    <div class="col-md-6">
        <h2>BlueStats looks <br>
        <small>Edit/Create themes in /themes/</small>
        </h2>
        <label for="theme">Theme: </label>
        <select id="theme" name="theme" class="form-control">
            <option value="material">Material</option>
            <option value="bigBlue">Deep Blue</option>
        </select>
        <label for="ip">Query IP:</label>
        <input type="text" class="form-control" id="ip" placeholder="Server Ip" name="ip" value="<?php if (isset($_SESSION["ip"])) echo $_SESSION["ip"]?>">

        <label for="port">Query Port:</label>
        <input type="text" class="form-control" id="port" placeholder="Server Port" name="port" value="<?php if (isset($_SESSION["port"])) echo $_SESSION["port"]?>">

    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <h2>LolmewnStats DataBase</h2>
        <label for="lolstats-enable">Enable: </label>
        <input type="checkbox" id="lolstats-enable" name="lolstats-enable" <?php if (isset($_SESSION["lolstats-enable"])&&$_SESSION["lolstats-enable"]==="on") echo "checked"?>>
        <br>
        <label for="lolstats-host">Host:</label>
        <input type="text" class="form-control" id="lolstats-host" placeholder="Host" name="lolstats-host" value="<?php if (isset($_SESSION["lolstats-host"])) echo $_SESSION["lolstats-host"]?>">

        <label for="lolstats-username">Username:</label>
        <input type="text" class="form-control" id="lolstats-username" placeholder="Username" name="lolstats-username" value="<?php if (isset($_SESSION["lolstats-username"])) echo $_SESSION["lolstats-username"]?>">

        <label for="lolstats-password">Password:</label>
        <input type="password" class="form-control" id="lolstats-password" placeholder="Password" name="lolstats-password" value="">

        <label for="lolstats-db">Data Base:</label>
        <input type="text" class="form-control" id="lolstats-db" placeholder="Database name" name="lolstats-db" value="<?php if (isset($_SESSION["lolstats-db"])) echo $_SESSION["lolstats-db"]?>">

        <label for="lolstats-prefix">Table Prefixes:</label>
        <input type="text" class="form-control" id="lolstats-prefix" placeholder="Table prefixes" name="lolstats-prefix" value="<?php if (isset($_SESSION["lolstats-prefix"])) echo $_SESSION["lolstats-prefix"]?>">

    </div>
    <div class="col-md-6">
        <h2>mcmmo DataBase</h2>
        <label for="mcmmo-enable">Enable: </label>
        <input type="checkbox" id="mcmmo-enable" name="mcmmo-enable" <?php if (isset($_SESSION["mcmmo-enable"])&&$_SESSION["mcmmo-enable"]==="on") echo "checked"?>>
        <br>
        <label for="mcmmo-host">Host:</label>
        <input type="text" class="form-control" id="mcmmo-host" placeholder="Host" name="mcmmo-host" value="<?php if (isset($_SESSION["mcmmo-host"])) echo $_SESSION["mcmmo-host"]?>">

        <label for="mcmmo-username">Username:</label>
        <input type="text" class="form-control" id="mcmmo-username" placeholder="Username" name="mcmmo-username" value="<?php if (isset($_SESSION["mcmmo-username"])) echo $_SESSION["mcmmo-username"]?>">

        <label for="mcmmo-password">Password:</label>
        <input type="password" class="form-control" id="mcmmo-password" placeholder="Password" name="mcmmo-password" value="">

        <label for="mcmmo-db">Data Base:</label>
        <input type="text" class="form-control" id="mcmmo-db" placeholder="Database name" name="mcmmo-db" value="<?php if (isset($_SESSION["mcmmo-db"])) echo $_SESSION["mcmmo-db"]?>">

        <label for="mcmmo-prefix">Table Prefixes:</label>
        <input type="text" class="form-control" id="mcmmo-prefix" placeholder="Table prefixes" name="mcmmo-prefix" value="<?php if (isset($_SESSION["mcmmo-prefix"])) echo $_SESSION["mcmmo-prefix"]?>">

    </div>
</div>
    <button type="submit" class="btn btn-success pull-right">Submit</button>
</form>
