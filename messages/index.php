<?php
include('../db.php');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        getAllMessagesByGroup($_GET['idGroup'], $_GET['limit']);
        break;
    case 'POST':
        createMessage();
        break;
    default:
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}

function getAllMessagesByGroup($idGroup, $limit)
{
    global $conn;
    $sql = "SELECT * FROM messages WHERE idGroup = '$idGroup' LIMIT $limit";
    $result = mysqli_query($conn, $sql);
    $res = array();
    $x   = 0;
    while ($row = mysqli_fetch_array($result)) {
        $res[$x]['id']          = $row['id'];
        $res[$x]['content']     = $row['content'];
        $res[$x]['date']        = $row['date'];
        $res[$x]['idUser']      = $row['idUser'];
        $res[$x]['idGroup']     = $row['idGroup'];

        $x++;
    }
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($res);
}

function createMessage()
{
    global $conn;
    $content    = $_POST['content'];
    $date       = date('Y-m-d h:i:s');
    $idUser     = $_POST['idUser'];
    $idGroup    = $_POST['idGroup'];

    $sql = "INSERT INTO messages(content, date, idUser, idGroup)
                VALUES('$content', '$date', '$idUser', '$idGroup')";
    if (!mysqli_query($conn, $sql)) echo 'Erro ao enviar mensagem!';
}

mysqli_close($conn);