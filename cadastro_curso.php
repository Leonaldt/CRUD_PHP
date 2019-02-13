<!DOCTYPE html>

<html>
    <head>
        <title>CADASTRO CURSO - FLEXPEAK</title>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js" integrity="sha384-7aThvCh9TypR7fIc2HV4O/nFMVCBwyIUKL8XCtKE+8xgCgl/PQGuFsvShjr74PBp" crossorigin="anonymous"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <?php
        
        $id = 0;
        $nome = '';
        $alterar = false;

        $mysqli = new mysqli('localhost', 'root', '', 'flexpeak') or die(mysqli_error($mysqli));
        $result_prof = $mysqli->query("SELECT * FROM PROFESSOR") or die($mysqli->error);

        if (isset($_GET['editar'])) {

            $id = $_GET['editar'];
            $alterar = true;

            $result = $mysqli->query("SELECT ID_CURSO, C.NOME AS NOME_CURSO, C.DATA_CRIACAO AS DCC, 
                    C.ID_PROFESSOR AS ID_PROF_CURSO, P.NOME AS NOME_PROF, DATA_NASCIMENTO, P.DATA_CRIACAO AS DCP FROM CURSO AS C "
                    . "INNER JOIN PROFESSOR AS P ON C.ID_PROFESSOR = P.ID_PROFESSOR where ID_CURSO = $id")
                    or die($mysqli->error);

            $row = $result->fetch_array();
            $nome = $row['NOME_CURSO'];
            $id_prof = $row['ID_PROF_CURSO'];
            $nome_prof = $row['NOME_PROF'];
        }
        ?>

        <div class="container">
            <div class="row justify-content-center">
                <form action="process_curso.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <label>Nome do Curso</label>
                        <input type="text" name="nome" class="form-control" value="<?php echo $nome; ?>" 
                               placeholder="Nome">
                    </div>
                    <label>Professor</label>
                    <select class="form-control" name="professor">
                        <option>..::Selecione::..</option>
                        <?php while ($r = $result_prof->fetch_assoc()): ?>
                            <option value="<?php echo $r['ID_PROFESSOR']; ?>">
                                <?php echo $r['NOME']; ?> 
                            </option>
                        <?php endwhile; ?>

                        <?php if ($alterar && $r['NOME'] = $nome_prof): ?>
                            <option selected="selected" value="<?php echo $id_prof; ?>">
                                <?php echo $r['NOME']; ?> 
                            </option>
                        <?php endif; ?>

                    </select>

                    <hr>

                    <div class="form-group">

                        <?php if ($alterar): ?>
                            <button type="submit" class="btn btn-outline-warning" name="editar">Editar</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-outline-primary" name="salvar">Salvar</button>
                        <?php endif; ?>

                        <a class="btn btn-outline-danger" href="crud_curso.php">Cancelar</a>
                    </div>

                </form>
            </div>
        </div>
    </body>
</html>

