<?php

$configs = include('config.php');

$DB_SERVER = $configs['DB_SERVER'];
$DB_NAME = $configs['DB_NAME'];
$DB_USERNAME = $configs['DB_USERNAME'];
$DB_PASSWORD = $configs['DB_PASSWORD'];

/* Attempt to connect to MySQL database */
$link =  new mysqli($DB_SERVER,$DB_USERNAME,$DB_PASSWORD,$DB_NAME);
return $link;
 ?>
