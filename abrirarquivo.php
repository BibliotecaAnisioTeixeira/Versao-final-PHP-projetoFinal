<?php
 include("conexao.php");
 try
	{
		$conecta = new PDO("mysql:host=$servername;dbname=$dbname", $username , $password);
		$consultaSQL = "SELECT arquivo_tipo, arquivo_conteudo FROM arquivos WHERE arquivo_id=$_GET[id]";
		$exComando = $conecta->prepare($consultaSQL); //testar o comando
		$exComando->execute(array());
        foreach($exComando as $resultado) 
		{
            $tipo = $resultado['arquivo_tipo'];
            $conteudo = $resultado['arquivo_conteudo'];
            header("Content-Type: $tipo");
            echo $conteudo;
		}	
    }catch(PDOException $erro)
	{
		echo("Errrooooo! foi esse: " . $erro->getMessage());
	}
?>