<?php
	$host = 'localhost';
	$usuario = 'root';
	$senha = '';
	$banco = 'biblioteca1305';

	//$host = 'localhost';
	//$usuario = 'id18839396_livraria';
	//$senha = 'CtQHcvEV>5eaQN|T';
	//$banco = 'id18839396_bdlivrariaiserj';

	$con = new mysqli($host, $usuario, $senha, $banco);

	if(mysqli_connect_errno()){
		exit('Erro ao conectar-se '.mysqli_connect_error());
	}
?>