<?php

    if (file_exists("connect.php") == 1){
        $inhalt = file_get_contents("./connect.php",FILE_USE_INCLUDE_PATH,null,0);
        $inhalt = substr($inhalt,5);
        $inhalt = explode(";",$inhalt);
        foreach ($inhalt as $item){
            echo $item."<br>";
        }
    }
    if (isset($_GET["write"])) {
        $stringArray = [
            '$hostname = "'.$_GET['hostname'].'";',
            '$username = "'.$_GET['username'].'";',
            '$password = "'.$_GET['password'].'";',
            '$database = "'.$_GET['database'].'";'
        ];
        $string = '<?php '."$stringArray[0]$stringArray[1]$stringArray[2]$stringArray[3]";
        file_put_contents("connect.php",$string);
    }
    if (file_exists("connect.php") == 1)  {
        require_once "connect.php";
        try {
            $testDatabase = new mysqli("$hostname", "$username","$password","$database",3306);

        }catch (Exception $e){
            echo $e->getMessage();
        }
    }


?>

<html>
<head>
    <title>iniDatabase</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<form name="DatabaseForm" method="get" action="iniDatabase.php?write=1">
    <label>
        <input name="hostname" placeholder="Host" value="<?php if (isset($hostname)) { echo $hostname;} ?>">
        <input name="username" placeholder="Username" value="<?php if (isset($username)) { echo $username;} ?>">
        <input name="password" placeholder="Password" value="<?php if (isset($password)) { echo $password;} ?>">
        <input name="database" placeholder="Database" value="<?php if (isset($database)) { echo $database;} ?>">
        <button name="write" value="1" type="submit">Absenden</button>
    </label>
</form>
</body>
</html>
