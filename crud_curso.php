<!DOCTYPE html>

<html>
    <head>
        <title>CRUD CURSO - FLEXPEAK</title>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js" integrity="sha384-7aThvCh9TypR7fIc2HV4O/nFMVCBwyIUKL8XCtKE+8xgCgl/PQGuFsvShjr74PBp" crossorigin="anonymous"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <?php require_once 'process_curso.php'; ?>

        <?php if (isset($_SESSION['message'])): ?>

            <div class="alert alert-<?= $_SESSION['msg_type'] ?>">

                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                ?>

            </div>        
        <?php endif ?>

        <div class="container">

            <?php
                $mysqli = new mysqli('localhost', 'root', '', 'flexpeak') or die(mysqli_error($mysqli));
                $result = $mysqli->query("SELECT * FROM CURSO") or die($mysqli->error);
            ?>
            
            <?php
                $mysqli = new mysqli('localhost', 'root', '', 'flexpeak') or die(mysqli_error($mysqli));
                $result_professores = $mysqli->query("SELECT * FROM PROFESSOR P "
                        . "INNER JOIN CURSO C ON C.ID_PROFESSOR = P.ID_PROFESSOR") or die($mysqli->error);
            ?>

            <div class="row justify-content-center">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Professor</th>
                            <th>Data Criação</th>
                            <th colspan="2">Ações</th>
                        </tr>
                    </thead>

                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td> <?php echo $row['NOME']; ?></td>
                            <td> </td>
                            <td> <?php echo $row['DATA_CRIACAO']; ?></td>
                            <td>
                                <a href="crud_curso.php?editar=<?php echo $row['ID_CURSO']; ?>"
                                   class="btn btn-info">Editar</a>
                                <a href="process_curso.php?delete=<?php echo $row['ID_CURSO']; ?>"
                                   class="btn btn-danger">Deletar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>            
            </div>

            <hr>

            <div class="row justify-content-center">
                <form action="process_curso.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?php echo $nome; ?>" 
                               placeholder="Entre com seu nome">
                    </div>
                    <div class="form-group">
                        <label>Data Nascimento</label>
                        <input type="text" name="data_nascimento" class="form-control" value="<?php ?>" 
                               placeholder="Entre com sua data de nascimento">
                    </div>


                    <div class="dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            ..::Selecione::..
                        </button>
                        <div class="dropdown-menu">

                            <?php while ($row = $result_professores->fetch_assoc()): ?>
                                <a class="dropdown-item"><?php echo $row['P.NOME']; ?></a>
                            <?php endwhile; ?>

                        </div>
                    </div>

                    <div class="form-group">

                        <?php if ($alterar): ?>
                            <button type="submit" class="btn btn-infor" name="editar">Editar</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-primary" name="salvar">Salvar</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
