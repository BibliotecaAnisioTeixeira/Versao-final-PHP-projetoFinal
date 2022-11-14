<?php
session_start();
ob_start();
include_once "conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Página de download</title>
    <link rel="stylesheet" href="./css/style_visualizar.css">
    <link rel="shortcut icon" href="./background/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
</head>

<body>

    <div class="topo">
        <a href="catalogo.php">
            <img src="./background/logo.png" alt="logo" class="logo">
        </a>
        <nav class="menu"> 
            <a href="catalogo.php" class="link">Voltar
            <span class="material-symbols-outlined">arrow_back</span>
            </a>
        </nav>
    </div>

    <div class="container">

    <?php

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    if (!empty($id)) {
        $query_usuario = "SELECT id, nome_livro, sinopse, autor, paginas, isbn, pdf, foto_usuario, acesso, download, ano, created, modified FROM livros WHERE id=:id LIMIT 1";
        
        $result_usuario = $conn->prepare($query_usuario);
        $result_usuario->bindParam(':id', $id);
        $result_usuario->execute(); 

        $query_usuario_2 = "UPDATE livros SET acesso=acesso+1 WHERE id=:id";
        $result_usuario_2 = $conn->prepare($query_usuario_2);
        $result_usuario_2->bindParam(':id', $id);
        $result_usuario_2->execute();
        
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
        //var_dump($row_usuario);
        extract($row_usuario);
        
        echo '<div class="livro">';
            echo '<div class="conteudo">';
                echo '<div class="capa_livro">';
                    if ((!empty($foto_usuario)) and (file_exists("imagens/$id/$foto_usuario"))) {
                        echo "<img src='imagens/$id/$foto_usuario' class='capa_pdf'><br>";
                    }

                echo '</div>';

                echo '<div class="infos">';    
                echo "<h1 class='titulo'> $nome_livro </h1>";
                
 
             echo "<a class='download' href='content.php?id=$id & pdf=$pdf' >Download PDF</a><br><br>";
             
                
              // href='content.php?id=$id & pdf=$pdf  href='pdf/$id/$pdf'

                } else {
                    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário selecionar o usuário!</p>";
                        header("Location: .php");
                }
                echo '</div>';
            echo '</div>';

            echo '<div class="info">';
                echo "<div class='sinopse'>";
                    echo "<h1 class='text_infos'>Sinopse<br><br> $sinopse </h1>";
                echo "</div>";
                echo '<h1 class="titulo_info">Informações do livro</h1>';
                echo "<h1 class='text_infos'>AUTOR: $autor </h1>";
                echo "<h1 class='text_infos'>PÁGINAS: $paginas </h1>";
                echo "<h1 class='text_infos'>ISBN: $isbn </h1>";
                echo "<h1 class='text_infos'>ANO: $ano </h1>";
		echo "<h1 class='text_infos'>N° ACESSOS: $acesso </h1>";
		echo "<h1 class='text_infos'>N° DOWNLOADS: $download </h1>";
                
            echo '</div>';

        echo '<div>';
       
        ?>

    </div>
    </div>
    <footer class="rodape">
        <h1 class="titulo-rodape">ANISIO TEIXEIRA</h1>
        <span class="material-symbols-outlined" id="book">
            menu_book
        </span>
    </footer>
</body>


</html>
            