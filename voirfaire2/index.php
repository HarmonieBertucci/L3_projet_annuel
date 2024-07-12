<?php


set_include_path("./src");

// Inclusion des classes utilisées dans ce fichier
require_once("Router.php");
require_once("./mysql_config.php");

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$dsn = "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DB . ";charset=utf8mb4";
$pdo = new PDO($dsn, MYSQL_USER, MYSQL_PASSWORD, $options);

//création du routeur
$router = new Router();

$router->main($pdo);


?>
