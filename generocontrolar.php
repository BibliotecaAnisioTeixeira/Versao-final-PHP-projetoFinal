<?php
session_start();

//Cria variáveis com a sessão.
$logado = $_SESSION['nome'];

//Verifica o acesso.
if($_SESSION['acesso']=="admin"){

//Faz a conexão com o BD.
require 'conexao.php';

//Lê a página que será exibida
$id = $_GET["pag"];

//Quantidade de registros a serem exibidos
$total = 5;

//Indica o registro limite para paginação
if($id!=1){
    $id = $id -1;
    $id = $id * $total + 1;
}

$id--;

//Cria o SQL com limites de página ordenado por id
$sql = "SELECT * FROM genero ORDER BY id LIMIT $id, $total";

//Conta a quantidade total de registros
$sql1 = "SELECT count(*) as contagem FROM genero";

//Executa o SQL
$result = $conn->query($sql);
$result1 = $conn->query($sql1);

//Recupera o resultado da contagem
$row1 = $result1->fetch_assoc();
$contagem = $row1["contagem"];

if($contagem%$total==0){
    $contagem=$contagem/$total;
}else{
    $contagem=$contagem/$total + 1;    
}

	//Se a consulta tiver resultados
	 if ($result->num_rows > 0) {
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>Controle dos Gêneros</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/css/tabela2.css">
    <link rel="icon" type="image/x-icon" href="imagens/logo.png" />
<style>
        * {
  margin: 0;
  padding: 0;
  font-family: "Monteserrat", sans-serif;
}

body{
    background:#1e1e1e;
}

.topnav{
    width:100%;
    display:flex;
    align-items:center;
    justify-content:center;
}

a {
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

a:hover {
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

.dropdown-content a:hover {background-color: #f1f1f1;}

.dropdown:hover .dropdown-content {
  display: block;
}

/* Style the content */
.content {
  padding: 10px;
  
}

/* Style the footer */
.footer {
  background-color: #f1f1f1;
  padding: 10px;
}

.pagination{
    width:100%;
    justify-content:center;
    align-items:center;
    margin:25px 0px;
    display:flex;
}

.btn-pagi{
    padding:6px 12px;
    border:0.5px solid orangered;
    border-radius:8px;
    color:white;
}

 </style>
</head>
<body>

<div class="topnav">
<ul class="nav-list">
    
  <li><a href="index.php">Inicio</a></li>
<?php 

//Menu só aparece para os administradores.
if($_SESSION['acesso']=="admin"){
    echo "<li class='dropdown'><a href='javascript:void(0)' class='dropbtn'>Administração</a>";
	echo "<div class='dropdown-content'><a href='usuarioscontrolar.php?pag=1'>Controlar Usuários</a><a href='livroscontrolar.php?pag=1'>Controlar Livros</a><a href='usuariosrelatorio.php?pag=1'>Relatório de Usuários</a></div></li>";
}  
?>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">Usuário: <?php echo $logado;?></a>
    <div class="dropdown-content">
      <a href="deslogar.php">Deslogar</a>
    </div>
  </li>
</ul>
</div>

<div class="content">


			<center><h1 style="color:white; margin:20px 0px;">Lista de Gêneros</h1></center>
			<table>
<tr><th>Id</th><th>Nome<th colspan="2">Ações</td></tr>
				
	<?php
	  while($row = $result->fetch_assoc()) {
		echo "<tr><td>" . $row["id"] . "</td><td>" . $row["nome"] . "</td>";
		echo "<td><a href='generoeditarform.php?id=" . $row["id"] . "'><img style='width:40px;' src='./imagens/editar.png' alt='Editar Usuário'></a></td><td><a href='generoexcluir.php?id=" . $row["id"] . "'><img style='width:40px;' src='./imagens/excluir.png' alt='Excluir Usuário'></a></td></tr>";
	  }
	?>
				
			</table>
			<div class="pagination">
    <?php for($i=1; $i <= $contagem; $i++) {
            echo "<a class='btn-pagi' href='generocontrolar.php?pag=$i'>$i</a>";
    } 
	?>   
</div> 
   
			<a href="generocadastrarform.php"><img style="width:40px;" src='./imagens/incluir.png' alt='Editar Usuário'></a>
</div>

</body>
</html>
<?php
	//Se a consulta não tiver resultados  			
	} else {
		echo "<h1>Nenhum resultado foi encontrado.</h1>";
	}
	
//Fecha a conexão.	
	$conn->close();
	
//Se o usuário não usou o formulário
} else {
    header('Location: login.html'); //Redireciona para o form
    exit; // Interrompe o Script
}
?> 