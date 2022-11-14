<?php

session_start()
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <title>Cadastro de arquivos</title>
    <link rel="stylesheet" href="./styleenviar.css">


</head>

<body>



    <div class="container">
        <?php 

//Menu só aparece para os administradores.
if($_SESSION['acesso']=="admin"){
    
       echo '<div class="envio">';
           echo '<h1> Cadastro de Arquivos </h1>';
       echo '<br/>';
            echo '<form enctype="multipart/form-data" method="post" class="form">';
                 echo '<input type="text" name="titulo" id="titulo" placeholder="Insira o titulo do arquivo">';
                

                 echo '<div class="cad">';
                 echo '<label for="arquivo">Arquivo</label>';
                    echo '<button type="submit" class="btn">Enviar arquivo</button>';
                     echo '<input type="file" name="arquivo" id="arquivo">';
                 echo '</div>';
            echo '</form>';
        echo '</div>';
}  
?>
      
        
        

        <?php
        if ($_POST) {        
            include("conexao.php");
            $arquivo = $_FILES["arquivo"]["tmp_name"]; 
            $tamanho = $_FILES["arquivo"]["size"];
            $tipo    = $_FILES["arquivo"]["type"];
            $nome  = $_FILES["arquivo"]["name"];
            $titulo  = $_POST["titulo"];

            if ( $arquivo != "none" )
            {
                $fp = fopen($arquivo, "rb");
                $conteudo = fread($fp, $tamanho);
                $conteudo = addslashes($conteudo);
                fclose($fp);                 
                
                  try { 
                     $conecta = new PDO("mysql:host=$servername;dbname=$dbname", $username , $password); //istancia a classe PDO
			         $comandoSQL = "INSERT INTO arquivos VALUES (0,'$nome','$titulo','$conteudo','$tipo')";
			         $grava = $conecta->prepare($comandoSQL); //testa o comando SQL
			         $grava->execute(array()); 	                                        
                     echo '<br/><div class="alert alert-success" role="alert">
                                Arquivo enviado com sucesso para o servidor!
                            </div>';
		          } catch(PDOException $e) { // caso retorne erro
                     
                     echo '<br/><div class="alert alert-success" role="alert">
                                Erro ' . $e->getMessage() . 
                          '</div>';
		          }
            }}
    ?>
        
    <div style="height:50px"></div>

    <h2>Lista dos documentos da biblioteca</h2>
        
    <?php include("lista-de-arquivos.php")?>
        
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

    <script>
        (function() {
            'use strict'

            if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
                var msViewportStyle = document.createElement('style')
                msViewportStyle.appendChild(
                    document.createTextNode(
                        '@-ms-viewport{width:auto!important}'
                    )
                )
                document.head.appendChild(msViewportStyle)
            }

        }())

    </script>
</body>

</html>