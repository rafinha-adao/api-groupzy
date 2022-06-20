<?php
include('db.php');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (!empty($_GET['id'])) {
            getGroupById($_GET['id']);
        } else {
            getAllGroups();
        }
        break;
    case 'POST':
        if (!empty($_GET['id'])) {
            updateGroupById($_GET['id']);
        } else {
            createGroup();
        }
        break;
    case 'DELETE':
        deleteGroupById($_GET['id']);
        break;
    default:
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}

function getAllGroups()
{
    global $conn;
    $sql = "SELECT * FROM groups";
    $result = mysqli_query($conn, $sql);
    $res = array();
    $x   = 0;
    while ($row = mysqli_fetch_array($result)) {
        $res[$x]['id']          = $row['id'];
        $res[$x]['name']        = $row['name'];
        $res[$x]['description'] = $row['description'];
        $res[$x]['image']       = $row['image'];
        $res[$x]['idUser']      = $row['idUser'];

        $x++;
    }
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($res);
}

function createGroup()
{
    global $conn;
    $name           = $_POST['name'];
    $description    = $_POST['description'];
    // FEAT: POST IMAGE
    $idUser         = $_POST['idUser'];
    $sql = "INSERT INTO groups(name, description, idUser)
                VALUES('$name', '$description', '$idUser')";
    if (!mysqli_query($conn, $sql)) echo 'Erro ao adicionar grupo!';
}

function getGroupById($id)
{
    global $conn;
    $sql = "SELECT * FROM groups WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $res = array();
    $x   = 0;
    while ($row = mysqli_fetch_array($result)) {
        $res[$x]['id']          = $row['id'];
        $res[$x]['name']        = $row['name'];
        $res[$x]['description'] = $row['description'];
        $res[$x]['image']       = $row['image'];
        $res[$x]['idUser']      = $row['idUser'];

        $x++;
    }
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($res);
}

function deleteGroupById($id)
{
    global $conn;
    $sql = "DELETE FROM groups WHERE id = '$id'";
    if (!mysqli_query($conn, $sql)) echo 'Erro ao deletar grupo!';
    header("Content-Type: application/json; charset=UTF-8");
}

function updateGroupById($id)
{
    global $conn;
    $name           = $_POST['name'];
    $description    = $_POST['description'];
    // FEAT: POST IMAGE
    $idUser         = $_POST['idUser'];

    $sql = "INSERT INTO groups(name, description, idUser)
                VALUES('$name', '$description', '$idUser')
                    WHERE id = '$id'";
    if (!mysqli_query($conn, $sql)) echo 'Erro ao atualizar grupo!';
}

mysqli_close($conn);