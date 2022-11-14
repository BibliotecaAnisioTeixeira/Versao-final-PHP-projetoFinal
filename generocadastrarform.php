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
    
?>
	<form action="generocadastrar.php" method="post">
	<h3>Cadastrar Gênero</h3>
	<input type="text" name="nome" placeholder="Seu nome..." required>		
	<input type="submit" value="Enviar">
	</form>
	
<?php
//}else{
  //  header('Location: login.html'); //Redireciona para o form
    //exit; // Interrompe o Script
}
?>
</body>
</html>
