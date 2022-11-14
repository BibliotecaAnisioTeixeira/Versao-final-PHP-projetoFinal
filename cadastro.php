<?php
session_start();

// Dados do Formulário
$camponome = $_POST["nome"];
$campoemail = $_POST["email"];
//$camposenha = password_hash($_POST["senha"], PASSWORD_BCRYPT);
$camposenha = $_POST["senha"];

//Faz a conexão com o BD.
require 'conexao.php';

//Verifica email duplicado e retorna erro.
$sql = "select * from usuariossite where email='$campoemail'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
	header("Location: login.html");
	exit;	
}

//Cria um número inteiro aleatório dentro do intervalo
$validador = rand(10000000,99999999);

//Insere na tabela os valores dos campos
$sql = "INSERT INTO usuariossite(nome, email, senha, acesso, status, validador) VALUES('$camponome', '$campoemail', '$camposenha', 'comum', 'ativo', $validador)";

//Executa o SQL e faz tratamento de erros
if ($conn->query($sql) === TRUE) {
  //header( "refresh:0.1;url=index.php" );	
  echo "Gravado com sucesso.";
  
//Envie email para validar a conta.
//require 'enviaremail.php';  
  
  //Abre o arquivo log.txt, a opção "a" é para adicionar 
  $log = fopen("log.txt", "a") or die("Não abriu");
  
  //Como será a String gravada no log
  $txt = $_SESSION['nome'] . " - $sql - " . 
  date("d/m/Y") . " - " . date("H:i:s") . "\n";

  //Escreve a String no objeto que representa o arquivo
  fwrite($log, $txt);
  
  //Fecha o objeto
  fclose($log);

} else {
  header( "refresh:2;url=index.php" );	
  echo "Error: " . $sql . "<br>" . $conn->error;
}

//Fecha a conexão.
$conn->close();

?>