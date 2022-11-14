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
    $query_usuario = "SELECT id, nome_livro, sinopse, autor, paginas, isbn, genero_id, ano FROM livros WHERE id=:id LIMIT 1";
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
    <title>Editar - Informações</title>
    <link rel="stylesheet" href="./css/style_editar.css">
    <link rel="shortcut icon" href="./background/logo.png" type="image/x-icon">
</head>

<body>
    <div class="topo">
        <img src="./background/logo.png" class="logo" alt="logo projeto">
        <nav class="menu"> 
            <a href="index.php" class="link">Listar</a>
            <?php
            echo "<a class='link' href='visualizar.php?id=$id'>Visualizar</a>";
            ?>
        </nav>
    </div>

    <?php
    if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <?php
    // Receber os dados do formulario
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    // Verificar se o usuario clicou no botao
    if (!empty($dados['EditarUsuario'])) {
        //var_dump($dados);
        // Criar a QUERY editar no banco de dados
        $query_edit_usuario = "UPDATE livros SET nome_livro=:nome_livro, sinopse=:sinopse, autor=:autor, paginas=:paginas, isbn=:isbn, genero_id=:genero_id, ano=:ano, modified = NOW() WHERE id=:id";
        $edit_usuario = $conn->prepare($query_edit_usuario);
        $edit_usuario->bindParam(':nome_livro', $dados['nome_livro'], PDO::PARAM_STR);
        $edit_usuario->bindParam(':sinopse', $dados['sinopse'], PDO::PARAM_STR);
        $edit_usuario->bindParam(':paginas', $dados['paginas'], PDO::PARAM_STR);
        $edit_usuario->bindParam(':isbn', $dados['isbn'], PDO::PARAM_STR);
        $edit_usuario->bindParam(':genero_id', $dados['genero_id'], PDO::PARAM_STR);
        $edit_usuario->bindParam(':autor', $dados['autor'], PDO::PARAM_STR);
		$edit_usuario->bindParam(':ano', $dados['ano'], PDO::PARAM_INT);
        $edit_usuario->bindParam(':id', $id, PDO::PARAM_INT);

        // Verificar se editou com sucesso
        if ($edit_usuario->execute()) {
            $_SESSION['msg'] = "<p style='color: green;'>Livro editado com sucesso!</p>";
            header("Location: editar.php?id=$id");
        } else {
            echo "<p style='color: #f00;'>Erro: Livro não editado com sucesso!</p>";
        }
    }
    ?>

    <div class="container">
        <div class="back">
            <div class="escrita">
                <h1 class="titulo">biblioteca <br>anísio teixeira</h1>
                <img src="./background/logo.png" alt="" class="logo1">
                <h1 class="titulo">edição de livros</h1>
            </div>
                <form name="edit_usuario" method="POST" action="" class="form">
                    <?php
                $nome_livro = "";
                if (isset($row_usuario['nome_livro'])) {
                    $nome_livro = $row_usuario['nome_livro'];
                }
                ?>
                <label class="text">Nome: </label>
                <input class="input" type="text" name="nome_livro" id="nome_livro" placeholder="Nome do livro" value="<?php echo $nome_livro; ?>" autofocus required><br><br>

                <?php
                $sinopse = "";
                if (isset($row_usuario['sinopse'])) {
                    $sinopse = $row_usuario['sinopse'];
                }
                ?>
                <label class="text">Sinopse: </label>
                <input class="input" type="text" name="sinopse" id="sinopse" placeholder="Sinopse do livro" value="<?php echo $sinopse; ?>" autofocus required><br><br>
                
                <?php
                $autor = "";
                if (isset($row_usuario['autor'])) {
                    $autor = $row_usuario['autor'];
                }
                ?>
                <label class="text">Autor: </label>
                <input class="input" type="text" name="autor" id="autor" placeholder="autor do livro" value="<?php echo $autor; ?>" required><br><br>
                    
                <div class="aux">
                    <?php
                $ano = "";
                if (isset($row_usuario['ano'])) {
                    $ano = $row_usuario['ano'];
                }
                ?>
                <label class="text">Ano: </label>
                <input class="input" type="text" name="ano" id="ano" placeholder="ano do livro" value="<?php echo $ano; ?>" required><br><br>

                <?php
                $paginas = "";
                if (isset($row_usuario['paginas'])) {
                    $paginas = $row_usuario['paginas'];
                }
                ?>
                <label class="text">Páginas: </label>
                <input class="input" type="text" name="paginas" id="paginas" placeholder="paginas" value="<?php echo $paginas; ?>" autofocus required><br><br>
                </div>
                        
                
                    

            <div class="aux">
                <?php
                $isbn = "";
                if (isset($row_usuario['isbn'])) {
                    $isbn = $row_usuario['isbn'];
                }
                ?>
                <label class="text">Isbn: </label>
                <input class="input" type="text" name="isbn" id="isbn" placeholder="isbn do livro" value="<?php echo $isbn; ?>" required><br><br>

                <?php
                $genero_id = "";
                if (isset($row_usuario['genero_id'])) {
                    $genero_id = $row_usuario['genero_id'];
                }
                ?>
                <label class="text">Gênero do livro: </label>
                <input class="input" type="text" name="genero_id" id="genero_id" placeholder="genero do livro" value="<?php echo $genero_id; ?>" required><br><br>
            </div>    
                

                <input class="label" type="submit" value="Salvar" name="EditarUsuario">

            </form>
        </div>
            
    
    </div>
    
</body>

</html>