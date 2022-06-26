<?php
function pdo_connect_mysql(){
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASSWORD = '';
    $DATABASE_NAME = 'ticketdatabase';
    try {
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASSWORD);
    } catch (PDOException $exception) {
        exit('Failed to connect to database!');
    }
}




function template_header($title){
    echo <<<EOT
<!DOCTYPE html>
<html lang="Deutsch">
    <head>
        <meta charset="utf-8">
        <title>$title</title>
        <link href="stylesheet.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    </head>
    <body>
    <nav class="navtop">
        <div>
            <h1>Goe-Tick</h1>
            <a href="index.php" >Startseite</a>
            <a href="create.php">Erstelle Ticket</a>
            <a href="adminLogin.php">Admin</a>
        </div>
    </nav>
EOT;
}
function template_footer()
{
    echo <<<EOT
    </body>
</html>
EOT;
}