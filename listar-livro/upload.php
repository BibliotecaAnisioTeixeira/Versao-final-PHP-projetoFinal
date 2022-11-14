<?php
session_start();
ob_start();
include_once "conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de livros</title>
    <link rel="stylesheet" href="./css/style_upload.css">
    <link rel="shortcut icon" href="./background/logo.png" type="image/x-icon">
</head>

<body>
    <div class="topo">
        <img src="./background/logo.png" alt="" class="logo">
        <a class="link" href="index.php">Listar</a>
    </div>
        
    <?php
    // Receber os dados do formulario
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    // Verificar se o usuario clicou no botao
    if (!empty($dados['SalvarFoto'])) {
        $arquivo = $_FILES['foto_usuario'];
        $pdf = $_FILES['pdf'];
        //var_dump($dados);
        //var_dump($arquivo);

        // Criar a QUERY cadastrar no banco de dados
        $query_usuario = "INSERT INTO livros (nome_livro, sinopse, autor, paginas, isbn, pdf, foto_usuario, ano, created) VALUES (:nome_livro, :sinopse, :autor, :paginas, :isbn, :pdf, :foto_usuario, :ano, NOW())";
        $cad_usuario = $conn->prepare($query_usuario);
        $cad_usuario->bindParam(':nome_livro', $dados['nome_livro'], PDO::PARAM_STR);
        $cad_usuario->bindParam(':sinopse', $dados['sinopse'], PDO::PARAM_STR);
        $cad_usuario->bindParam(':autor', $dados['autor']);
        $cad_usuario->bindParam(':paginas', $dados['paginas']);
        $cad_usuario->bindParam(':isbn', $dados['isbn']);
        $cad_usuario->bindParam(':ano', $dados['ano']);
        $cad_usuario->bindParam(':foto_usuario', $arquivo['name'], PDO::PARAM_STR);
        $cad_usuario->bindParam(':pdf', $pdf['name'], PDO::PARAM_STR);
        $cad_usuario->execute();

        // Verificar se cadastrou com sucesso
        if ($cad_usuario->rowCount()) {
            // Verificar se o usuario esta enviando a foto
            if ((isset($arquivo['name'])) and (!empty($arquivo['name']))) {
                // Recuperar ultimo ID inserido no banco de dados
                $ultimo_id = $conn->lastInsertId();

                // Diretorio onde o arquivo sera salvo
                $diretorio = "imagens/$ultimo_id/";
                $diretori = "pdf/$ultimo_id/";

                // Criar o diretorio
                mkdir($diretorio, 0755);
                mkdir($diretori, 0755);

                // Upload do arquivo
                $nome_arquivo = $arquivo['name'];
                move_uploaded_file($arquivo['tmp_name'], $diretorio . $nome_arquivo);

                $nome_pdf = $pdf['name'];
                move_uploaded_file($pdf['tmp_name'], $diretori . $nome_pdf);

                $acesso_pdf = $acesso[''];
                move_uploaded_file($acesso[''], $diretor . $acesso_pdf);

                $_SESSION['msg'] = "<p> </p>";
                header("Location: index.php");
                header("Location: catalogo.php");
            } else {
                $_SESSION['msg'] = "<p style='color: green;'>Livro pdf e Capa cadastrado com sucesso!</p>";
                header("Location: index.php");
            }
        } else {
            echo "<p style='color: #f00;'>Erro: Livro não cadastrado com sucesso!</p>";
        }
    }
    ?>

    <div class="container">
        <div class="back">
        <div class="escrita">
                <h1 class="titulo">biblioteca <br>anísio teixeira</h1>
                <img src="./background/logo.png" alt="" class="logo1">
           
            </div>
            <form class="form" name="cad_usuario" method="POST" action="" enctype="multipart/form-data">
                
                <label class="text">Nome do livro: </label>
                <input class="input" type="text" name="nome_livro" id="nome_livro" placeholder="Nome do livro" autofocus required>

                <label class="text">Sinopse do livro: </label>
                <input class="input" type="text" name="sinopse" id="sinopse" placeholder="Sinopse do livro" autofocus required>

                <div class="aux">
                    <label class="text">Autor: </label>
                    <input class="input" type="text" name="autor" id="autor" placeholder="autor" required>
                    <label class="text">Páginas: </label>
                    <input class="input" type="text" name="paginas" id="paginas" placeholder="paginas" required>
                </div>

                <div class="aux">
                    <label class="text">Isbn: </label>
                    <input class="input" type="text" name="isbn" id="isbn" placeholder="isbn" required>
                    <label class="text">Ano: </label>
                    <input class="input" type="text" name="ano" id="ano" placeholder="ano" required>
                </div>

                <div class="anexos">
                    <div class="foto-livro">
                        <label class="label" for="foto_usuario"><img src="./background/camera.png" class="icone"></label>
                        <input type="file" name="foto_usuario" id="foto_usuario">
                    </div>
                    <div class="anexo-pdf">
                        <label class="label" for="pdf"><img src="./background/pdf.png" class="icone"></label>
                        <input type="file" name="pdf" id="pdf">
                    </div>
                </div>
                
                <input class="label" type="submit" value="Cadastrar" onclick="alert('Cadastro Efetuado com sucesso')" name="SalvarFoto">
            </form>
        </div>
    </div>
</body>

</html>