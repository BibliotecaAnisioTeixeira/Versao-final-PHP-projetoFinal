<?php
session_start();
//Verifica o acesso.
if($_SESSION['acesso']=="admin"){

//Faz a leitura do dado passado pelo link.
$campoid = $_GET["id"];

//Faz a conexão com o BD.
require 'conexao.php';

//Cria o SQL (consulte tudo da tabela usuarios)
$sql = "SELECT * FROM usuariossite WHERE id = $campoid";

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
        <title>Editar Usuário</title>

        <style>

            @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap');

            *{
                padding:0;
                margin: 0;
                box-sizing: border-box;
            }

            body{
                background: #1e1e1e;
            }

            .container{
                width: 100%;
                height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            .form{
                display: flex;
                flex-direction: column;
                justify-content: center;
                gap: 35px;
            }

            .titulo{
                color: #f0f0f0;
                font-family: 'Roboto', sans-serif;
                text-transform: uppercase;
                font-weight: 500;
                font-size: 24px;
            }

            .input{
                color: #333;
                font-family: 'Roboto', sans-serif;
                padding: 15px;
                border: none;
                outline: none;
                height: 45px;
                border-radius: 50px;
                width: 300px;
                font-weight: 400;
                font-size: 15px;
            }

            .select{
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .btn{
                border: none;
                outline: none;
                width: 200px;
                height: 50px;
                border-radius: 50px;
                color: #333;
                background: #c7c7c7;
            }

            .label{
                color: #f0f0f0;
                font-family: 'Roboto', sans-serif;
                font-size: 16px;
            }

        </style>

    </head>
    <body>
        <div class="container">
            <form action="usuarioeditar.php" method="post" class="form">
            <h3 class="titulo">Editar Usuário Id: <?php echo $row["id"]; ?></h3>
            <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
            <input class="input" type="text" name="nome" value="<?php echo $row["nome"]; ?>" placeholder="Seu nome..." required>		
            <input class="input" type="email" name="email" value="<?php echo $row["email"]; ?>" placeholder="Seu e-mail..." required>	     
            <?php if ($row["acesso"]=="admin"){ ?>

                <div class="select">
                    <input type="radio" name="acesso" value="Comum" required><label class="label">Comum</label>
                    <input type="radio" name="acesso" value="Admin" checked="true"><label class="label">Admin</label>
                </div>
                        
            <?php }else{ ?>

                <div class="select">
                    <input type="radio" name="acesso" value="Comum" required checked="true"><label class="label">Comum</label>
                    <input type="radio" name="acesso" value="Admin"><label class="label">Admin</label>      
                </div>
                  
            <?php } ?>      
                <input class="btn" type="submit" value="Editar">
        </form>
        </div>
        
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