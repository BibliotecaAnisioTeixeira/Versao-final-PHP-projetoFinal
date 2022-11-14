<html>
    <body>
        <?php
        if(isset($_POST['acao'])){
                   // Formulário foi enviado!
                   $arquivo = $_FILES['file'];
                   
                   $arquivoNovo = explode('.',$arquivo['name']);
                   
                    if($arquivoNovo[sizeof($arquivoNovo)-1]!='jpg'){
                die('Você não pode fazer upload deste formato de arquivo');
            }else{
                echo('Arquivo enviado');
                move_uploaded_file($arquivo['tmp_name'],'files/'.$arquivo['name']);
            }
        }
        
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="file" />
            <input type="submit" name="acao" value="Enviar" />
        </form>
    </body>
</html>