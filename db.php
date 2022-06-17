<?php
$host = '143.106.241.3';
$user = 'cl200270';
$pass = 'cl*06012004';
$db   = 'cl200270';
$conn = new mysqli($host, $user, $pass, $db);
if (!$conn) die('Falha na conexão: ' . mysqli_connect_error());
