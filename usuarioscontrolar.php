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
$sql = "SELECT * FROM usuariossite ORDER BY id LIMIT $id, $total";

//Conta a quantidade total de registros
$sql1 = "SELECT count(*) as contagem FROM usuariossite";

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
<title>Controle dos Usuários</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/x-icon" href="imagens/logo.png" />
<link rel="stylesheet" href="css/tabela.css">
<style>
        * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Monteserrat", sans-serif;
}

body{
    background:#1e1e1e;
}

table {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td {
  border-right: 0.5px solid orangered;
  border-bottom: 0.5px solid orangered;
  padding: 8px;
  color:white;
  text-align:center;
}

td:nth-child(9){
    border-right:none;
}

tr:nth-child(even){background-color: #f2f2f2;}

tr:hover {background-color: #494949;}

th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: center;
  background-color: orangered;
  color: white;
  border:0.5px solid orangered;
}

.topnav{
    width:100%;
    justify-content:space-between;
    align-items:center;
    display:flex;
    padding:12px 0px;
}

a {
  color: #fff;
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
  padding:12px 0px;
  width: 100%;
}

.nav-list {
  font-size: 20px;
  list-style: none;
  display: flex;
  justify-content:center;
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
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.container{
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.pagination{
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
  margin: 15px;
}

.pag1{
  color: orangered;
  border: 0.5px solid orangered;
  padding: 6px;
  border-radius: 50px;
  transition: all 0.4s;
}

.pag1:hover{
  color: #fff;
}

.edit{
  transition: all 0.4s;
}

.edit:hover{
  transform: rotate(180deg);
}

 </style>
</head>
<body>

<div class="container">
  <div class="topnav">
    <img src="imagens/logo.png" style="width:60px;">
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


			<center><h1 style="color:white;">Lista de Usuários</h1></center>
			<table style="width: 100%;">
<tr><th>Id</th><th>Nome</th><th>Status</th><th>Email</th><th>Senha</th><th>Acesso</th><th colspan="3">Ações</td></tr>
				
	<?php
	
	while($row = $result->fetch_assoc()) {
	      if($row["status"]=="inativo"){
	          echo "<tr style='background-color:pink'>";
	      }else{
	          echo "<tr>";
	      }
		echo "<tr><td>" . $row["id"] . "</td><td>" . $row["nome"] . "</td><td>" . $row["status"] . "</td><td>" . $row["email"] . "</td><td>" . $row["senha"] . "</td><td>" . $row["acesso"] . "</td>";
		echo "<td><a href='usuarioeditarform.php?id=" . $row["id"] . "'><img src='./imagens/editar.png' style='width:40px;' alt='Editar Usuário'></a></td><td><a href='usuariobloquear.php?id=" . $row["id"] . "&status=" . $row["status"] . "'><img src='./imagens/cadeado.png' style='width:40px;' alt='Bloquear Usuário'></a></td><td><a href='usuarioexcluir.php?id=" . $row["id"] . "'><img src='./imagens/deletar.png' style='width:40px;' alt='Excluir Usuário'></a></td></tr>";
	  }
	?>
				
			</table>
			<div class="pagination">
    <?php for($i=1; $i <= $contagem; $i++) {
            echo "<a class='pag1' href='usuarioscontrolar.php?pag=$i'>$i</a>";
    } 
	?>   
</div> 
   
			<a class="edit" href="usuariocadastrartela.php"><img src='./imagens/incluir.png' style="width:40px;" alt='Editar Usuário'></a>
</div>
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