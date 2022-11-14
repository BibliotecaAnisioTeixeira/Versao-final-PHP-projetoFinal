<?php
session_start();
//Verifica o acesso.
if($_SESSION['acesso']=="admin"){

//Faz a leitura do dado passado pelo link.
$campoid = $_GET["id"];

//Faz a conexão com o BD.
require 'conexao.php';

//Cria o SQL (consulte tudo da tabela usuarios)
$sql = "SELECT * FROM genero WHERE id = $campoid";

//Executa o SQL
$result = $conn->query($sql);

	//Se a consulta tiver resultados
	 if ($result->num_rows > 0) {

// Cria uma matriz com o resultado da consulta
 $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="./css/estilo.css">
        <title>Editar Gênero</title>
    </head>
    <body>
        <form action="generoeditar.php" method="post">
            <h3>Editar genero Id: <?php echo $row["id"]; ?></h3>
            <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
            <input type="text" name="nome" value="<?php echo $row["nome"]; ?>" placeholder="Altere o gênero" required>
            <input type="submit" value="Editar">
        </form>
    </body>
</html>
<?php
	//Se a consulta não tiver resultados  			
	} else {
		echo "<h1>Nenhum resultado foi encontrado.</h1>";
	}

	//Fecha a conexão.	
	$conn->close();
	
//Se o usuário não tem acesso.
} else {
    header('Location: login.html'); //Redireciona para o form
    exit; // Interrompe o Script
}

?> 