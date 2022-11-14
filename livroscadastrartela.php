<?php
session_start();
?>
<html>
<head>
<title>Usuário Cadastrar</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="/css/estilo.css">
</head>
<body>
    
<?php

//Só administrador pode acessar o programa.
if($_SESSION['acesso']=="admin"){
    
    //Faz a conexão com o BD.
require 'conexao.php';
    
$sql = "SELECT * FROM genero ORDER BY id";

$result = $conn->query($sql);

?>
	<form action="livrocadastrarcodigo.php" method="post">
	<h3>Cadastrar Livros</h3>
	<input type="text" name="nome" placeholder="Nome do livro" required>	
	<input type="text" name="isbn" placeholder="ISBN do livro" required>	
		
	<select name='genero_id'>

<?php

	 if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {			
			echo "<option value=" . $row["id"] . ">" . $row["nome"] . "</option>";
		}
	}
?>	
</select>
	<input type="text" name="paginas" placeholder="Número de páginas" required>
	<input type="file" name="conteudo" placeholder="" required>	
	<input type="submit" value="Enviar">
	</form>
	
<?php
}else{
    header('Location: livroscontrolar.php'); //Redireciona para o form
    exit; // Interrompe o Script
}
?>
</body>
</html>
