<?php

session_start();
ob_start();

// Incluir a conexao com BD
include_once "conexao.php";

// Receber o ID do registro
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// Acessa o IF quando nao existe o ID
if (empty($id)) {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
    header("Location: index.php");
} else {
    // QUERY para recuperar os dados do registro
    $query_usuario = "SELECT id, foto_usuario, pdf FROM livros WHERE id=:id LIMIT 1";
    $result_usuario = $conn->prepare($query_usuario);
    $result_usuario->bindParam(':id', $id, PDO::PARAM_INT);
    $result_usuario->execute();

    // Verificar se encontrou o registro no banco de dados
    if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
        //var_dump($row_usuario);
    } else {
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
        header("Location: index.php");
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar livro</title>
    <link rel="stylesheet" href="./css/style_editar_foto.css">
    <link rel="shortcut icon" href="./background/logo.png" type="image/x-icon">
</head>

<body>
    <div class="topo">
        <img src="./background/logo.png" alt="" class="logo">
        <nav class="menu">
            <a class="link" href="index.php">Listar</a>
        </nav>
    </div>

    <?php
    // Receber os dados do formulario
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);    

        $query_usuario = "SELECT id, foto_usuario, pdf FROM livros WHERE id=:id LIMIT 1";
        
        $result_usuario = $conn->prepare($query_usuario);
        $result_usuario->bindParam(':id', $id);
        $result_usuario->execute();

        extract($row_usuario);

    // Verificar se clicou no botao
    if(!empty($dados['EditarFoto'])){
        // Receber a foto e o pdf
        $arquivo = $_FILES['foto_usuario'];
        $pdf = $_FILES['pdf'];
        //var_dump($arquivo);
        // Verificar se o usuario esta enviando a foto
        if((isset($arquivo['name'])) and (!empty($arquivo['name'])) or (isset($pdf['name'])) and (!empty($pdf['name']))){
            // Criar a QUERY editar no banco de dados
            $query_edit_usuario = "UPDATE livros SET foto_usuario=:foto_usuario, pdf=:pdf, modified = NOW() WHERE id=:id";
            $edit_usuario = $conn->prepare($query_edit_usuario);
            $edit_usuario->bindParam(':foto_usuario', $arquivo['name'], PDO::PARAM_STR);
            $edit_usuario->bindParam(':pdf', $pdf['name'], PDO::PARAM_STR);
            $edit_usuario->bindParam(':id', $id, PDO::PARAM_INT);

            // Verificar se editou com sucesso
            if($edit_usuario->execute()){
                // Diretorio onde o arquivo sera salvo
                $diretorio = "imagens/$id/";
                $diretori = "pdf/$id/";

                // Verificar se o diretorio existe
                if((!file_exists($diretorio)) and (!is_dir($diretorio))){
                    // Criar o diretorio
                    mkdir($diretorio, 0755);
                }

                if((!file_exists($diretori)) and (!is_dir($diretori))){
                    // Criar o diretorio
                    mkdir($diretori, 0755);
                }

                // Upload do arquivo
                $nome_arquivo = $arquivo['name'];
                if(move_uploaded_file($arquivo['tmp_name'], $diretorio . $nome_arquivo)){
                    // Verificar se existe o nome da imagem salva no banco de dados e o nome da imagem salva no banco de dados he diferente do nome da imagem que o usuario esta enviando
                    if(((!empty($row_usuario['foto_usuario'])) or ($row_usuario['foto_usuario'] != null)) and ($row_usuario['foto_usuario'] != $arquivo['name'])){
                        $endereco_imagem = "imagens/$id/". $row_usuario['foto_usuario'];
                        if(file_exists($endereco_imagem)){
                            unlink($endereco_imagem);
                        }
                    }
                }
                
                $nome_pdf = $pdf['name'];
                if(move_uploaded_file($pdf['tmp_name'], $diretori . $nome_pdf)){
                    // Verificar se existe o nome do pdf salvo no banco de dados e o nome da imagem salva no banco de dados he diferente do nome da imagem que o usuario esta enviando
                    if(((!empty($row_usuario['pdf'])) or ($row_usuario['pdf'] != null)) and ($row_usuario['pdf'] != $pdf['name'])){
                        $endereco_pdf = "pdf/$id/". $row_usuario['pdf'];
                        if(file_exists($endereco_pdf)){
                            unlink($endereco_pdf);
                        }
                    }
                }

                else{
                    echo "<p style='color: #f00;'>Erro: Livro não editado com sucesso!</p>";
                }
            }else{
                echo "<p style='color: #f00;'>Erro: Livro não editado com sucesso!</p>";
            }
        }else{
            echo "<p style='color: #f00;'>Erro: Necessário selecionar uma imagem!</p>";
        }
    }
    ?>

<div class="container">

    <div class="back">
        <form name="edit_foto" method="POST" action="" enctype="multipart/form-data" class="form">
            <div class="icones">
                <label for="foto_usuario" class="input"><img src="./background/camera.png" class="icone"></label>
                <input type="file" name="foto_usuario" id="foto_usuario">
                <label for="pdf" class="input"><img src="./background/pdf.png" class="icone"></label>
                <input type="file" name="pdf" id="pdf">
            </div>
            <input class="input" type="submit" value="Salvar" onClick="alert('Edição bem sucedida')" name="EditarFoto">
        </form>
    </div>
    
</div>
</body>
</html>