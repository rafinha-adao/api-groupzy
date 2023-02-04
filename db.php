<?php
$host = 'localhost';
$user = 'id20253877_groupzy_user';
$pass = '6J2f$[Wk3^R5)P#h';
$db   = 'id20253877_groupzy';
$conn = new mysqli($host, $user, $pass, $db);
if (!$conn) die('Falha na conexão: ' . mysqli_connect_error());
