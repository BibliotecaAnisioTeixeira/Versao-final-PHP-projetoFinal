<?php
// Parâmetros para criar a conexão
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca1305";

try{
    //Conexão com a porta
    //$conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user, $pass);

    //Conexão sem a porta
    $conn = new PDO("mysql:host=$servername;dbname=" . $dbname, $username, $password);

    //echo "Conexão com banco de dados realizado com sucesso!";
}  catch(PDOException $err){
    echo "Erro: Conexão com banco de dados não foi realizada com sucesso. Erro gerado " . $err->getMessage();
}