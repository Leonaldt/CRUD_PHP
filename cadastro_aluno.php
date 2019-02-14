<!DOCTYPE html>

<html>
    <head>
        <title>CRUD ALUNO - FLEXPEAK</title>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js" integrity="sha384-7aThvCh9TypR7fIc2HV4O/nFMVCBwyIUKL8XCtKE+8xgCgl/PQGuFsvShjr74PBp" crossorigin="anonymous"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script type="text/javascript" >

            function limpa_formulário_cep() {
                document.getElementById('logradouro').value = ("");
                document.getElementById('bairro').value = ("");
                document.getElementById('cidade').value = ("");
                document.getElementById('uf').value = ("");
            }

            function meu_callback(conteudo) {
                if (!("erro" in conteudo)) {

                    document.getElementById('logradouro').value = (conteudo.logradouro);
                    document.getElementById('bairro').value = (conteudo.bairro);
                    document.getElementById('cidade').value = (conteudo.localidade);
                    document.getElementById('uf').value = (conteudo.uf);

                } else {
                    limpa_formulário_cep();
                    alert("CEP não encontrado.");
                }
            }

            function pesquisacep(valor) {

                var cep = valor.replace(/\D/g, '');

                if (cep != "") {

                    var validacep = /^[0-9]{8}$/;

                    if (validacep.test(cep)) {

                        document.getElementById('logradouro').value = "...";
                        document.getElementById('bairro').value = "...";
                        document.getElementById('cidade').value = "...";
                        document.getElementById('uf').value = "...";

                        var script = document.createElement('script');

                        script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                        document.body.appendChild(script);

                    } else {
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } else {
                    limpa_formulário_cep();
                }
            }
            ;
        </script>

    </head>
    <body>

        <?php
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

        $mysqli = new mysqli('localhost', 'root', '', 'flexpeak') or die(mysqli_error($mysqli));
        $result_cursos = $mysqli->query("SELECT * FROM CURSO") or die($mysqli->error);

        if (isset($_GET['editar'])) {

            $id = $_GET['editar'];
            $alterar = true;

            $result = $mysqli->query("SELECT A.ID_ALUNO, A.NOME, A.DATA_NASCIMENTO, A.LOGRADOURO,  
            A.NUMERO, A.BAIRRO, A.CIDADE, A.ESTADO, A.DATA_CRIACAO, A.CEP, 
            A.ID_CURSO, C.ID_CURSO AS ID_CURSO, C.NOME AS NOME_CURSO, C.DATA_CRIACAO, C.ID_PROFESSOR FROM ALUNO A
            INNER JOIN CURSO C ON A.ID_CURSO = C.ID_CURSO WHERE ID_ALUNO='$id'") or die($mysqli->error);

            $row = $result->fetch_array();
            $nome = $row['NOME'];
            $data_nascimento = $row['DATA_NASCIMENTO'];
            $logradouro = $row['LOGRADOURO'];
            $numero = $row['NUMERO'];
            $bairro = $row['BAIRRO'];
            $cidade = $row['CIDADE'];
            $estado = $row['ESTADO'];
            $cep = $row['CEP'];
            $nome_curso = $row['NOME_CURSO'];
            $id_curso = $row['ID_CURSO'];
        }

        if (isset($_GET['pesquisar'])) {
            $resultado_busca = busca_cep($_GET['cep']);
            $logradouro = $resultado_busca['logradouro'];
        }
        ?>

        <div class="container">
            <form action="process_aluno.php" method="POST">
                <div class="form-row align-items-center">
                    <div class="form-group col-md-6">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?php echo $nome; ?>" 
                               placeholder="Nome">
                    </div>

                    <div class="form-group">
                        <label>Data Nascimento</label>
                        <input type="text" name="data_nascimento" class="form-control" value="<?php echo $data_nascimento; ?>" 
                               placeholder="Data de nascimento">
                    </div>

                    <div class="form-group">
                        <label>CEP</label>
                        <input type="text" id="cep" name="cep" class="form-control" value="<?php echo $cep; ?>" 
                               placeholder="CEP">
                        <button type="button" onclick="pesquisacep(cep.value)" name="pesquisar" class="btn btn-outline-success">Pesquisar</button>
                    </div>

                    <div class="form-group">
                        <label>Logradouro</label>
                        <input type="text" id="logradouro" name="logradouro" class="form-control" value="<?php echo $logradouro; ?>" 
                               placeholder="Logradouro">
                    </div>

                    <div class="form-group">
                        <label>Numero</label>
                        <input type="text" id="numero" name="numero" class="form-control" value="<?php echo $numero; ?>" 
                               placeholder="Numero">
                    </div>

                    <div class="form-group">
                        <label>Bairro</label>
                        <input type="text" id="bairro" name="bairro" class="form-control" value="<?php echo $bairro; ?>" 
                               placeholder="Bairro">
                    </div>
                    <div class="form-group">
                        <label>Cidade</label>
                        <input type="text" id="cidade" name="cidade" class="form-control" value="<?php echo $cidade; ?>" 
                               placeholder="Cidade">
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <input type="text" id="uf" name="estado" class="form-control" value="<?php echo $estado; ?>" 
                               placeholder="Estado">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Curso</label>
                        <select class="form-control" name="curso">
                            <option>..::Selecione::..</option>
                            <?php while ($r = $result_cursos->fetch_assoc()): ?>
                                <option value="<?php echo $r['ID_CURSO']; ?>">
                                    <?php echo $r['NOME']; ?> 
                                </option>
                            <?php endwhile; ?>

                            <?php if ($alterar && $r['NOME_CURSO'] = $nome_curso): ?>
                                <option selected="selected" value="<?php echo $id_curso; ?>">
                                    <?php echo $r['NOME_CURSO']; ?> 
                                </option>
                            <?php endif; ?>
                        </select>
                    </div> 
                    <hr>
                </div>
                <div class="form-group">
                    <?php if ($alterar): ?>
                        <button type="submit" class="btn btn-outline-warning" name="editar">Editar</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-outline-primary" name="salvar">Salvar</button>
                    <?php endif; ?>
                    <a class="btn btn-outline-danger" href="crud_aluno.php">Cancelar</a>
                </div>
            </form>
        </div>
    </body>
</html>