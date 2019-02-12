<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '', 'flexpeak') or die(mysqli_error($mysqli));

$id = 0;
$nome = '';
$data_nascimento = '';
$logradouro = '';
$numero = '';
$bairro = '';
$cidade = '';
$estado = '';
$id_curso = 0;
$cep = '';
$alterar = false;

if (isset($_POST['salvar'])) {
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];

    $mysqli->query("INSERT INTO ALUNO (NOME, DATA_NASCIMENTO, 
        LOGRADOURO, NUMERO, BAIRRO, CIDADE, ESTADO, DATA_CRIACAO, CEP, ID_CURSO) 
        VALUES ('$nome', '$data_nascimento')") or
            die($mysqli->error);

    $_SESSION['message'] = "Aluno salvo!";
    $_SESSION['msg_type'] = "success";

    header("location: index.php");
}

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM ALUNO WHERE ID_ALUNO=$id") or die($mysqli->error);

    $_SESSION['message'] = "Aluno deletado!";
    $_SESSION['msg_type'] = "danger";

    header("location: index.php");
}

if (isset($_GET['editar'])) {

    $id = $_GET['editar'];
    $alterar = true;
    $result = $mysqli->query("SELECT * FROM ALUNO WHERE ID_ALUNO=$id") or die($mysqli->error);

    if (!is_array($result)) {
        $row = $result->fetch_array();
        $nome = $row['NOME'];
        $data_nascimento = $row['DATA_NASCIMENTO'];
    }
}

if (isset($_POST['editar'])) {

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];

    $mysqli->query("UPDATE ALUNO SET NOME='$nome', DATA_NASCIMENTO='$data_nascimento' WHERE ID_ALUNO=$id") or
            die($mysqli->error);

    $_SESSION['message'] = "Aluno alterado!";
    $_SESSION['msg_type'] = "warning";

    header("location: index.php");
}