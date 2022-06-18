<?php
include('db.php');
header("Content-Type: application/json; charset=UTF-8");
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        login($_GET['email'], $_GET['pass']);
        break;
    default:
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}

function login($email, $pass)
{
    global $conn;
    $sql = "SELECT * FROM users WHERE email = '$email' AND pass = '$pass'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($result);
    if ($row == 1) {
        $res = array(
            'status' => 1,
            'status_message' => 'Login efetuado com sucesso!'
        );
    } else {
        $res = array(
            'status' => 0,
            'status_message' => 'Erro ao efetuar login!'
        );
    }
    echo json_encode($res);
}

mysqli_close($conn);
