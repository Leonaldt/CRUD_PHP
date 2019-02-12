<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '', 'flexpeak') or die(mysqli_error($mysqli));

$id = 0;
$nome = '';
$alterar = false;

if (isset($_POST['salvar'])) {

    $id_prof = $_POST['professor'];
    $nome = $_POST['nome'];

    printf( $id_prof );

    $mysqli->query("INSERT INTO CURSO (NOME, ID_PROFESSOR) VALUES ('$nome', '$id_prof')") or
            die($mysqli->error);

    $_SESSION['message'] = "Curso salvo!";
    $_SESSION['msg_type'] = "success";

    header("location: crud_curso.php");
}

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM CURSO WHERE ID_CURSO=$id") or die($mysqli->error);

    $_SESSION['message'] = "Curso deletado!";
    $_SESSION['msg_type'] = "danger";

    header("location: crud_curso.php");
}

if (isset($_GET['editar'])) {

    $id = $_GET['editar'];
    $alterar = true;
    $result = $mysqli->query("SELECT * FROM CURSO WHERE ID_CURSO=$id") or die($mysqli->error);

    if (!is_array($result)) {
        $row = $result->fetch_array();
        $nome = $row['NOME'];
        $id_prof = $row['ID_PROFESSOR'];
    }
}

if (isset($_POST['editar'])) {

    $id = $_POST['id'];
    $id_prof = $_POST['professor'];
    $nome = $_POST['nome'];

    $mysqli->query("UPDATE CURSO SET NOME='$nome', ID_PROFESSOR='$id_prof' WHERE ID_CURSO=$id") or
            die($mysqli->error);

    $_SESSION['message'] = "Curso alterado!";
    $_SESSION['msg_type'] = "warning";

    header("location: crud_curso.php");
}