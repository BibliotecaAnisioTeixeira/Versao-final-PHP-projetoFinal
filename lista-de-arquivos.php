<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <title>Cadastro de arquivos</title>
</head>

<body>
    <div class="container">

    <?php
    include("conexao.php");
	try
	{
		$conecta = new PDO("mysql:host=$servername;dbname=$dbname", $username , $password);
		$consultaSQL = "SELECT arquivo_id, arquivo_nome, arquivo_titulo, arquivo_tipo FROM arquivos";
		$exComando = $conecta->prepare($consultaSQL); //testar o comando
		$exComando->execute(array());
		
        echo("
        <table class='tabela'>
        <thead class='thead-dark'>
        <tr>
            <th>Titulo</th>
            <th>Tipo de documento</th>
            <th>Abrir</th>
        </tr>
        </thead>
        ");
		foreach($exComando as $resultado) 
		{
            echo "
            <tr>
                <td>$resultado[arquivo_titulo]</td>
                <td>$resultado[arquivo_tipo]</td>
                <td><a href='abrirarquivo.php?id=$resultado[arquivo_id]'>abrir</a></td>
            </tr>
            ";
		}	
        echo("</table>");
        
	}catch(PDOException $erro)
	{
		echo("Errrooooo! foi esse: " . $erro->getMessage());
	}
    ?>

    </div>
</body>
</html>