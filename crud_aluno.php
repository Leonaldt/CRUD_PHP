<!DOCTYPE html>

<html>
    <head>
        <title>CRUD FLEX PEAK</title>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js" integrity="sha384-7aThvCh9TypR7fIc2HV4O/nFMVCBwyIUKL8XCtKE+8xgCgl/PQGuFsvShjr74PBp" crossorigin="anonymous"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <?php require_once 'process_aluno.php'; ?>

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
            $result = $mysqli->query("SELECT * FROM ALUNO") or die($mysqli->error);
            ?>

            <div class="row justify-content-center">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Data de Nascimento</th>
                            <th>Logradouro</th>
                            <th>Número</th>
                            <th>Bairro</th>
                            <th>Cidade</th>
                            <th>Estado</th>
                            <th>CEP</th>
                            <th>Data Criação</th>
                            <th>Curso</th>
                            <th colspan="2">Ações</th>
                        </tr>
                    </thead>

                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td> <?php echo $row['NOME']; ?></td>
                            <td> <?php echo $row['DATA_NASCIMENTO']; ?></td>
                            <td> <?php echo $row['LOGRADOURO']; ?></td>
                            <td> <?php echo $row['NUMERO']; ?></td>
                            <td> <?php echo $row['BAIRRO']; ?></td>
                            <td> <?php echo $row['CIDADE']; ?></td>
                            <td> <?php echo $row['ESTADO']; ?></td>
                            <td> <?php echo $row['CEP']; ?></td>
                            <td> <?php echo $row['DATA_CRIACAO']; ?></td>
                            <td> <?php echo $row['ID_CURSO']; ?></td>
                            <td>
                                <a href="crud_aluno.php?editar=<?php echo $row['ID_ALUNO']; ?>"
                                   class="btn btn-info">Editar</a>
                                <a href="process_aluno.php?delete=<?php echo $row['ID_ALUNO']; ?>"
                                   class="btn btn-danger">Deletar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>           
            </div>

            <?php

            function prep_r($array) {
                echo '<pre>';
                print_r($array);
                echo '</pre>';
            }
            ?>

            <hr>
            
            <div class="row justify-content-center">
                <form action="process_aluno.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?php echo $nome; ?>" 
                               placeholder="Entre com seu nome">
                    </div>
                    <div class="form-group">
                        <label>Data Nascimento</label>
                        <input type="text" name="data_nascimento" class="form-control" value="<?php echo $data_nascimento; ?>" 
                               placeholder="Entre com sua data de nascimento">
                    </div>
                    
                    <div class="form-group">
                        <label>CEP</label>
                        <input type="text" name="cep" class="form-control" value="<?php echo $cep; ?>" 
                               placeholder="Entre com o cep">
                    </div>
                    
                    <div class="form-group">
                        <label>Logradouro</label>
                        <input type="text" name="logradouro" class="form-control" value="<?php echo $logradouro; ?>" 
                               placeholder="Entre com o logradouro">
                    </div>
                    
                    <div class="form-group">
                        <label>Numero</label>
                        <input type="text" name="numero" class="form-control" value="<?php echo $numero; ?>" 
                               placeholder="Entre com o numero">
                    </div>
                    
                    <div class="form-group">
                        <label>Bairro</label>
                        <input type="text" name="bairro" class="form-control" value="<?php echo $bairro; ?>" 
                               placeholder="Entre com o bairro">
                    </div>
                    
                    <div class="form-group">
                        <label>Cidade</label>
                        <input type="text" name="cidade" class="form-control" value="<?php echo $cidade; ?>" 
                               placeholder="Entre com o cidade">
                    </div>
                    
                    <div class="form-group">
                        <label>Estado</label>
                        <input type="text" name="estado" class="form-control" value="<?php echo $estado; ?>" 
                               placeholder="Entre com o estado">
                    </div>
                                                            
                    <div class="form-group">
                        <label>Curso</label>
                        <input type="text" name="curso" class="form-control" value="<?php echo $id_curso; ?>" 
                               placeholder="Entre com o curso">
                    </div>
                    
                    <div class="form-group">
                        
                        <?php if($alterar): ?>
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
