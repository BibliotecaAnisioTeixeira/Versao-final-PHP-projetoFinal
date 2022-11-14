<?php
//include_once 'conexaopdo.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Upload</title>
    <style>
@import url('https://fonts.googleapis.com/css2?family=Patua+One&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

body{
    background: #ffcc91;
}

.container{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100vw;
}

.cabecalho{
    display: flex;
    width: 100vw;
    justify-content: end;
    padding: 10px;
}

.link{
    text-decoration: none;
    color: #ff6600;
    margin-left: 25px;
    font-family: 'Patua One', cursive;
    font-size: 20px;
    transition-duration: 0.5s;
}

.link:hover{
    color: #c25e00;
}

.conteudo{
    display: flex;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    border-radius: 25px 8px 25px 8px;
}

.banner{
    width: 350px;
    height: 500px;
    background: url(./Cadastro.jpg);
    background-position: center;
    background-size: cover;
}

.form{
    display: flex;
    flex-direction: column;
    width: 400px;
    height: 500px;
    justify-content: space-around;
    padding: 20px;
    background: rgb(63, 60, 60);
}

.label{
    color: white;
    font-family: 'Roboto', sans-serif;
}

.form input{
    height: 32px;
    border-radius: 25px;
    outline: none;
    border: none;
    padding: 8px 15px;
}

.btn{
    background: #ff6600;
    color: white;
    padding: 25px 10px;
}
    </style>
</head>

<body>

    <?php
        // Receber os dados do formulario
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        // Acessa IF quando o usuário clica no botao
        if(!empty($dados['CadArquivoPdf'])){
            //var_dump($dados);

            // Receber o arquivo PDF do formulario
            $arquivo_pdf = $_FILES['arquivo_pdf'];
            //var_dump($arquivo_pdf);

            // validar se he arquivo PDF
            if($arquivo_pdf['type'] == "application/pdf"){
                // Converter o arquivo para blob
                $arquivo_pdf_blob = file_get_contents($arquivo_pdf['tmp_name']);

                $query_arquivo = "INSERT INTO livros (nome, isbn, paginas, nome_documento, arquivo_pdf) VALUES (:nome, :isbn, :paginas, :nome_documento, :arquivo_pdf)";
                $cad_arquivo = $conn->prepare($query_arquivo);
                $cad_arquivo->bindParam(':nome', $dados['nome']);
                $cad_arquivo->bindParam(':isbn', $dados['isbn']);
                $cad_arquivo->bindParam(':paginas', $dados['paginas']);
                $cad_arquivo->bindParam(':nome_documento', $arquivo_pdf['name']);
                $cad_arquivo->bindParam(':arquivo_pdf', $arquivo_pdf_blob);
                $cad_arquivo->execute();

                if($cad_arquivo->rowCount()){
                    echo "<p style='color: green;'>Arquivo cadastrado com sucesso!</p>";
                }else{
                    echo "<p style='color: #f00;'>Erro: Arquivo não cadastrado com sucesso!</p>";
                }

            }else{
                echo "<p style='color: #f00;'>Erro: Extensão do arquivo inválido. Necessário enviar arquivo PDF!</p>";
            }

        }
    ?>

    <div class="container">
        <div class="cabecalho">
            <a href="livros.php" class="link">Listar</a><br>
            <a href="cadastrar.php" class="link">Cadastrar</a><br><br>
        </div>

        <div class="conteudo">
            <div class="banner">
            
            </div>
            <form method="POST" action="" enctype="multipart/form-data" class="form">
                <label class="label">Número do Contrato: </label>
                <input type="text" name="nome" placeholder="Número do contrato"><br><br>

                <label class="label">isbn: </label>
                <input type="text" name="isbn" placeholder="Isbn do livro"><br><br>

                <label class="label">Páginas: </label>
                <input type="text" name="paginas" placeholder="Número de páginas"><br><br>

                <label class="label">Arquivo PDF: </label>
                <input type="file" name="arquivo_pdf"><br><br>

                <label for="CadArquivoPdf" class="file"></label>
                <input type="submit" name="CadArquivoPdf" value="Enviar" class="btn"><br><br>
            </form>
        </div>
    </div>
</body>

</html>