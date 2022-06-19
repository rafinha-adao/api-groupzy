<?php
include('../db.php');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (!empty($_GET['id'])) {
            getUserById($_GET['id']);
        } else {
            getAllUsers();
        }
        break;
    case 'POST':
        if (!empty($_GET['id'])) {
            updateUserById($_GET['id']);
        } else {
            createUser();
        }
        break;
    case 'DELETE':
        deleteUserById($_GET['id']);
        break;
    default:
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}

function getAllUsers()
{
    global $conn;
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    $res = array();
    $x   = 0;
    while ($row = mysqli_fetch_array($result)) {
        $res[$x]['id']          = $row['id'];
        $res[$x]['name']        = $row['name'];
        $res[$x]['tagName']     = $row['tagName'];
        $res[$x]['birthday']    = $row['birthday'];
        $res[$x]['bio']         = $row['bio'];
        $res[$x]['email']       = $row['email'];
        $res[$x]['idGroup']     = $row['idGroup'];

        $x++;
    }
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($res);
}

function createUser()
{
    global $conn;
    $name       = $_POST['name'];
    $tagName    = $_POST['tagName'];
    $birthday   = $_POST['birthday'];
    $bio        = $_POST['bio'];
    $email      = $_POST['email'];
    $pass       = $_POST['pass'];
    $sql = "INSERT INTO users(name, tagName, birthday, bio, email, pass)
                VALUES('$name', '$tagName', '$birthday', '$bio', '$email', '$pass')";
    if (mysqli_query($conn, $sql)) {
        $res = array(
            'status'            => 1,
            'status_message'    => 'Usuário criado com sucesso.',
            'user' => array(
                'name'          => $_POST['name'],
                'tagName'       => $_POST['tagName'],
                'bio'           => $_POST['bio'],
                'email'         => $_POST['email']
            )
        );
    } else {
        $res = array(
            'status' => 0,
            'status_message' => 'Erro ao adicionar usuário!',
            'error' => mysqli_error($conn)
        );
    }
    echo json_encode($res);
}

function getUserById($id)
{
    global $conn;
    $sql = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $res = array();
    $x   = 0;
    while ($row = mysqli_fetch_array($result)) {
        $res[$x]['id']          = $row['id'];
        $res[$x]['name']        = $row['name'];
        $res[$x]['tagName']     = $row['tagName'];
        $res[$x]['birthday']    = $row['birthday'];
        $res[$x]['bio']         = $row['bio'];
        $res[$x]['email']       = $row['email'];
        $res[$x]['idGroup']     = $row['idGroup'];

        $x++;
    }
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($res);
}

function deleteUserById($id)
{
    global $conn;
    $sql = "DELETE FROM users WHERE id = '$id'";
    if (!mysqli_query($conn, $sql)) echo 'Erro ao deletar usuário!';
    header("Content-Type: application/json; charset=UTF-8");
}

function updateUserById($id)
{
    global $conn;
    $name       = $_POST['name'];
    $tagName    = $_POST['tagName'];
    $birthday   = $_POST['birthday'];
    $bio        = $_POST['bio'];
    $email      = $_POST['email'];
    $pass       = $_POST['pass'];
    $idGroup    = $_POST['idGroup'];

    $sql = "INSERT INTO users(name, tagName, birthday, bio, email, pass, idGroup)
                VALUES('$name', '$tagName', '$birthday', '$bio', '$email', '$pass', $idGroup)
                    WHERE id = '$id'";
    if (!mysqli_query($conn, $sql)) echo 'Erro ao atualizar usuário!';
}

mysqli_close($conn);
