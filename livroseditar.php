<?php
session_start();
//Verifica o acesso.
if($_SESSION['acesso']=="admin"){

//Dados do formulário
$campoid = $_POST["id"];
$camponome = $_POST["nome"];
$campoisbn = $_POST["isbn"];
$campogenero_id = intval($_POST["genero_id"]);
$campopaginas = $_POST["paginas"];

//Faz a conexão com o BD.
require 'conexao.php';

//Sql que altera um registro da tabela usuários
$sql = "UPDATE livros SET nome='" . $camponome . "', genero_id='" . $campogenero_id . "' , paginas='" . $campopaginas . "' WHERE id=" . $campoid;


//Executa o sql e faz tratamento de erro.
if ($conn->query($sql) === TRUE) {
  echo "Registro atualizado.";
} else {
  echo "Erro: " . $conn->error;
}
    header('Location:livroscontrolar.php'); //Redireciona para o form	

//Fecha a conexão.
	$conn->close();
	
//Se o usuário não tem acesso.
} else {
    header('Location: login.html'); //Redireciona para o form
    exit; // Interrompe o Script
}

?> 