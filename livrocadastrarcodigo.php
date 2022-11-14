<?php
session_start();
//Só administrador pode acessar o programa.
if($_SESSION['acesso']=="admin"){

// Dados do Formulário
$camponome = $_POST["nome"];
$campoisbn = $_POST["isbn"];
$campopaginas = $_POST["paginas"];
$campogenero_id = intval($_POST["genero_id"]);  
$campoconteudo = $_POST["conteudo"];  
	

//Faz a conexão com o BD.
require 'conexao.php';

//Insere na tabela os valores dos campos
$sql = "INSERT INTO livros(nome, isbn, genero_id, paginas, conteudo) VALUES ('$camponome', '$campoisbn', $campogenero_id, '$campopaginas', '$campoconteudo')";


//Executa o SQL e faz tratamento de erros
if ($conn->query($sql) === TRUE) {
  header( "refresh:5;url=livroscontrolar.php" );	
  echo "Gravado com sucesso.";
  
  //Abre o arquivo log.txt, a opção "a" é para adicionar 
  $livro = fopen("livro.txt", "a") or die("Não abriu");
  
  //Como será a String gravada no log
  $txt = $_SESSION['nome'] . " - $sql - " . 
  date("d/m/Y") . " - " . date("H:i:s") . "\n";

  //Escreve a String no objeto que representa o arquivo
  fwrite($livro, $txt);
  
  //Fecha o objeto
  fclose($livro);

} else {
  header( "refresh:5;url=principal.php" );	
  echo "Error: " . $sql . "<br>" . $conn->error;
}

//Fecha a conexão.
$conn->close();
 
}else{
    header('Location: login.html'); //Redireciona para o form
    exit; // Interrompe o Script
}

?>