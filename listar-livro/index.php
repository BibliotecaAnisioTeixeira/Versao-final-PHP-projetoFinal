<?php
session_start();
include_once "conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Livro cadastrados no sistema</title>
    <link rel="stylesheet" href="./css/style_index.css">
    <link rel="shortcut icon" href="./background/logo.png" type="image/x-icon">
</head>

<body>
    <div class="topo">
        <img src="./background/logo.png" alt="" class="logo">
        <nav class="link-topo">
        <div class="caixa-busca">
                <input type="text" id="pesquisar" placeholder="Pesquisa" required>
                <img src="./background/pesquisa.png" alt="logo" class="pesquisa">
            </div>
            <a class="link" href="upload.php">Cadastrar</a>
            <a class="link" href="../principal.php">Pág. Principal</a>
        </nav>
    </div>
    

    <div class="painel-controle">
        <h1 class="titulo" style="color:white;">Todos os livros cadastrados no sistema</h1> 
        <?php
            
                    $query_registros = "SELECT COUNT(id) AS qtd_registro FROM livros";

                    $result_registros = $conn->prepare($query_registros);
                    $result_registros->execute();
                    $row_registros = $result_registros->fetch(PDO::FETCH_ASSOC);

                    echo "<h1 class='titulo' style='font-size:28px; color:white;'>Quantidade de livros registrados: " . $row_registros['qtd_registro'] ;

            ?>
        
        
        <?php
            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
        ?>

        </div>

    

    <div class="container">

            <?php

            $query_usuarios = "SELECT id, nome_livro, autor, paginas, isbn, pdf, foto_usuario, acesso, download, ano, created FROM livros ORDER BY id 
            DESC";
            $result_usuarios = $conn->prepare($query_usuarios);
            $result_usuarios->execute();

            while($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)){
                //var_dump($row_usuario);
                extract($row_usuario);
            
                echo '<div class="card">'; 
                    echo "<img class='capa' src='imagens/" . $row_usuario['id'] . "/" . $row_usuario['foto_usuario'] ."' >";
                    echo ' <h4 class="titulo">Título: '. $row_usuario['nome_livro'] . ' </h4>';
                    echo ' <h4 class="titulo">Autor: '. $row_usuario['autor'] . ' </h4>';
                    echo ' <h4 class="titulo">Páginas: '. $row_usuario['paginas'] . ' </h4>';
                    echo ' <h4 class="titulo">Isbn: '. $row_usuario['isbn'] . ' </h4>';
                    echo ' <h4 class="titulo">Ano: '. $row_usuario['ano'] . ' </h4>';
                    echo ' <h4 class="titulo">Acesso: '. $row_usuario['acesso'] . ' </h4>';
                    echo ' <h4 class="titulo">Download: '. $row_usuario['download'] . ' </h4>';
                    echo "<h4 class='titulo'>Cadastrado em: " . date('d/m/Y H:i:s', strtotime($created)) . " <h4>";
                    echo '<div class="icon">';
                        echo "<a class='acao' href='visualizar.php?id=$id'>";
                        echo "<img class='delete' src='background/visualizar.png'>";
                        echo '</a>';
                        echo "<a class='acao' href='editar.php?id=$id'>";
                        echo "<img class='delete' src='background/editar.png'>";
                        echo '</a>';
                        echo "<a class='acao' href='editar_foto.php?id=$id'>";
                        echo "<img class='delete' src='background/pdf.png'>";
                        echo '</a>';
                        echo "<a class='acao' href='apagar.php?id=$id'>";
                        echo "<img class='delete' src='background/lixeira.png'>";
                        echo '</a>';
                    echo '</div>';
                echo '</div>';
               
            }

            ?>
    </div>

    <script>
        document.querySelector('#pesquisar').addEventListener('input', filterList);

        function filterList(){
            const pesquisar = document.querySelector('#pesquisar');
            const filter = pesquisar.value.toLowerCase();
            const listItem = document.querySelectorAll('.card');

            listItem.forEach((item) =>{
                let text = item.textContent;
                if(text.toLowerCase().includes(filter.toLowerCase())){
                    item.style.display = '';
                }
                else{
                    item.style.display = 'none';
                }
            });
        }
    </script>

</body>
</html>