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
//Conta a quantidade total de registros por acesso
$sql1 = "SELECT count(*) as ADM FROM usuariossite WHERE acesso='admin'";
$sql2 = "SELECT count(*) as Comum FROM usuariossite WHERE acesso='comum'";
$sql3 = "SELECT count(*) as contagem FROM usuariossite";

//Executa o SQL
$result = $conn->query($sql);
$result1 = $conn->query($sql1);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);

//Prepara as contagens
$row1 = $result1->fetch_assoc();
$row2 = $result2->fetch_assoc();

//Recupera o resultado da contagem
$row3 = $result3->fetch_assoc();
$contagem = $row3["contagem"];

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
<title>Relatório de Usuários</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="./css/tabela1.css">
<link rel="stylesheet" href="./css/grafico.css">
<link rel="icon" type="image/x-icon" href="imagens/logo.png" />
<script src="./scripts/filtrar.js"></script>

<!-- PDF I - Bibliotecas para gerar PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.4/jspdf.plugin.autotable.min.js"></script>

<!-- PDF II - Arquivo com o código para gerar PDF -->
<script src="pdf.js"></script>

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
    justify-content:space-between;
    align-items:center;
    display:flex;
    padding:12px 0px;
    background:#1e1e1e;
}

.filtro{
    width:100%;
    display:flex;
    align-items:center;
    justify-content:space-around;
    margin:25px 0px;
}

.filtragem{
    display:flex;
    justify-content:center;
    gap:20px;
    align-items:center;
}

.btn-pdf{
    outline:none;
    border:none;
    width:150px;
    padding:20px 0;
    border-radius:8px;
    background:orangered;
    color:#fff;
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
  align-items: center;
  background: #fffafa;
  justify-content:center;
}

.nav-list {
  font-size: 20px;
  list-style: none;
  display: flex;
  justify-content:center;
  margin-right:25px;
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

.filtrarelemento{
    outline:none;
    background:transparent;
    border:none;
    border-bottom:2px solid orangered;
    color:#fff;
    border-radius:6px;
    padding:6px 8px;
}

.filtrarelemento::placeholder{
    color:#fff;
}

.pagination{
    width:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
}

.btn-pagi{
    padding:6px 12px;
    border:0.4px solid orangered;
    border-radius:8px;
    margin:25px 0px;
}

 </style>
</head>
<body>

<div class="topnav">
    <img src="imagens/logo.png" style="width:60px; margin-left:30px;">
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

        <div class="filtro">
            
            <h1 style="color:white;">Relatório de Usuários</h1>
			<form><input type="button" value="Gerar PDF" class="btn-pdf" onclick="getPDF()"></form>
			
			<div class="filtragem">
			    <input type="text" id="filtrarnomes" class="filtrarelemento" onkeyup="filtrar('filtrarnomes', 1)" placeholder="Busca de nomes...">
			    <input type="text" id="filtraremails" class="filtrarelemento" onkeyup="filtrar('filtraremails', 2)" placeholder="Busca de emails...">
			</div>
			
		</div>	
			<table id="myTable">
<tr><th>Id</th><th onclick="sortTable(1)">Nome</th><th>Email</th><th>Acesso</th></tr>
				
	<?php
	  while($row = $result->fetch_assoc()) {
		echo "<tr><td>" . $row["id"] . "</td><td>" . $row["nome"] . "</td><td>" . $row["email"] . "</td><td>" . $row["acesso"] . "</td></tr>";
		
	  }
	?>
				
			</table>
</div>

<div class="pagination">
    <?php for($i=1; $i <= $contagem; $i++) {
            echo "<a class='btn-pagi' href='usuariosrelatorio.php?pag=$i'>$i</a>";
    } 
	?>   
</div>  

<div class="wrapper">
    <canvas id="myChart" width="800" height="400"></canvas>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

    <script type="text/javascript">
        var ctx = document.getElementById("myChart");
        var valores = [<?php echo $row1["ADM"] ?>, <?php echo $row2["Comum"] ?>];
        var tipos = ["Administrador", "Comum"];

        var myChart = new Chart(ctx, {
          type: "pie",
          data: {
            labels: tipos,
            datasets: [
              {
                label: "Usuarios",
                data: valores,
                backgroundColor: [
                  "rgba(255, 99, 132, 0.9)",
                  "rgba(54, 162, 235, 0.9)",
                  "rgba(255, 206, 86, 0.2)",
                  "rgba(75, 192, 192, 0.2)",
                  "rgba(153, 102, 255, 0.2)",
                ]
              }
            ]
          }
        }); 
    </script>           

  
           
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
    header('Location: index.html'); //Redireciona para o form
    exit; // Interrompe o Script
}
?> 
