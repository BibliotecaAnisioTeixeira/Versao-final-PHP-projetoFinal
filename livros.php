<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>Relatório de Usuários</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="./scripts/filtrar.js"></script>
<link rel="stylesheet" href="css/rating.css">

<style>
        * {
  margin: 0;
  padding: 0;
  font-family: "Monteserrat", sans-serif;
}

.topnav a {
  color: #000;
  text-transform: uppercase;
  text-decoration: none;
  transition: 0.3s;
}

nav a::after {
  content: "";
  width: 0;
  height: 3px;
  background-color: #f04e23;
  margin: auto;
  display: block;
}

.topnav a:hover {
  color: #f04e23;
}

a:hover::after {
  width: 100%;
  transition: width 0.3s linear;
}

.logo {
  font-size: 34px;
  letter-spacing: 3px;
}

nav {
  z-index: 4;
  position: fixed;
  display: flex;
  justify-content: center;
  align-items: center;
  background: #fffafa;
  height: 8vh;
  width: 100vw;
}

.nav-list {
  font-size: 20px;
  list-style: none;
  display: flex;
}

.navbar-login {
  font-size: 20px;
}

.nav-list li {
  margin-left: 20px;
}

li a, .dropbtn {
  display: inline-block;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}


li.dropdown {
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}


.dropdown:hover .dropdown-content {
  display: block;
}


 </style>
 </head>
<body>

<?php
session_start();
include_once 'conexaopdo.php';
?>
<div class="topnav">
<ul class="nav-list">
    
  <li><a href="principal.php">Inicio</a></li>
  <li></li><a href='cadastrar.php'>Cadastrar livro</a></li>
<?php 

//Menu só aparece para os administradores.
if($_SESSION['acesso']=="admin"){
    echo "<li class='dropdown'><a href='javascript:void(0)' class='dropbtn'>Administração</a>";
	echo "<div class='dropdown-content'><a href='usuarioscontrolar.php?pag=1'>Controlar Usuários</a><a href='livroscontrolar.php?pag=1'>Controlar Livros</a><a href='usuariosrelatorio.php?pag=1'>Relatório de Usuários</a></div></li>";
}  
?>
</ul>
</div>
    <h1>Lista de livros</h1>

    <?php
    
        $query_arquivos = "SELECT id, nome, isbn, paginas, nome_documento 
                        FROM livros 
                        ORDER BY id DESC";
        $result_arquivos = $conn->prepare($query_arquivos);
        $result_arquivos->execute();
        if(($result_arquivos) and ($result_arquivos->rowCount() != 0)){
            while($row_arquivo = $result_arquivos->fetch(PDO::FETCH_ASSOC)){
                //var_dump($row_arquivo);
                extract($row_arquivo);
                echo "ID: $id <br>";
                echo "Nome do livro: $nome <br>";
                echo "Isbn: $isbn <br>";
                echo "Paginas: $paginas <br>";
                echo "Documento: <a href='visualizar_arquivo.php?id=$id' target='_blank'>$nome_documento</a> <br>";
                echo "<hr>"; 

            }
    
        }else{
            echo "<p style='color: #f00;'>Erro: Nenhum arquivo encontrado!</p>";
        }
      
        ?>
</body>
</html>