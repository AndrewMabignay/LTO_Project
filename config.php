<?php

$db_connection = 'mysql';
$db_host = 'localhost';
$db_port = 3307;
$db_name = 'LTO';
$db_user = 'root';
$db_pass = '';

$conn = \mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

if (!$conn) die('Connection Failed : ' . \mysqli_connect_error());

echo 'Connected Successfully!' . '<br>';