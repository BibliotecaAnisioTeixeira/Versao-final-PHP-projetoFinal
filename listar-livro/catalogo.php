<?php
        session_start();
        include_once "conexao.php";
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style_catalogo.css">
    <link rel="shortcut icon" href="./background/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Cátalogo</title>
</head>
<body>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
	<script type="text/javascript" src="personalizado.js"></script>
    
    <div class="topo">
        <a href="../principal.php"><img src="./background/logo.png" alt="logo" class="logo"></a>
        <nav class="menu">
            <div class="caixa-busca">
                <input type="text" id="pesquisar" placeholder="Pesquise algum livro..." required>
                <img src="./background/pesquisa.png" alt="logo" class="pesquisa">
            </div>
            <a href="../principal.php" class="menu-item">Pág Principal</a>
        </nav>
    </div>
    
    <div class="container"> 

       

        <?php

            $query_usuarios = "SELECT id, nome_livro, autor, paginas, pdf, foto_usuario FROM livros ORDER BY id 
            DESC";
            $result_usuarios = $conn->prepare($query_usuarios);
            $result_usuarios->execute();

            
            while($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)){
                //var_dump($row_usuario);
                extract($row_usuario);
                $ultimo_id = $conn->lastInsertId();

                echo "<a class='view' href='visualizar.php?id=$id'>";
                echo '<div class="card">'; 
                echo "<img class='img' src='imagens/" . $row_usuario['id'] . "/" . $row_usuario['foto_usuario'] ."' >";
                echo ' <h4 class="titulo"> '. $row_usuario['nome_livro'] . ' </h4>';
                echo '</div>';
                echo '</a>';

            }
            
        ?>

    </div>

    <div class="visitas">
        <div class="numero">
            <img src="./background/visitas.png" alt="">
            <h1><?php include("contador.php") ?></h1>
        </div>
        
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