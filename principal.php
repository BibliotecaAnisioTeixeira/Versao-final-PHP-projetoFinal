<?php
session_start();
//Verifica se o usuário logou.
if(!isset ($_SESSION['nome']) || !isset ($_SESSION['acesso']))
{
  unset($_SESSION['nome']);
  unset($_SESSION['acesso']);
  header('location:login.html');
  exit;
}

//Cria variáveis com a sessão.
$logado = $_SESSION['nome'];
$acesso = $_SESSION['acesso'];
?>

<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Biblioteca Iserj</title>
    <link rel="icon" type="image/x-icon" href="imagens/logo.png" />
    <link rel="stylesheet" href="css/base.css" />
    <link rel="stylesheet" href="css/about.css" />
    <link rel="stylesheet" href="css/livros.css" />
    <link rel="stylesheet" href="css/contact.css" />
    <link rel="stylesheet" href="css/navbar.css" />
    <script
      src="https://kit.fontawesome.com/5bf58c3794.js"
      crossorigin="anonymous"
    ></script>
    <style>
        .inicio{
    display: flex;
    justify-content: space-around;
    align-items: center;
    width: 100%;
}

.apresentacao{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 40px;
}
.logo{
    width: 450px;
    height: 450px;
}

.apresentacao h1{
    color: white;
    font-size: 70px;
    text-transform: uppercase;
}

.btns{
    display: flex;
    align-items: center;
    width: 100%;
    justify-content: center;
    gap: 40px;
}

.btn{
    background: orangered;
    border-radius: 8px;
    padding: 20px 0px;
    width: 180px;
    display: flex;
    justify-content: center;
    text-decoration: none;
    color: white;
    text-transform: uppercase;
    box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
}

.btn:hover{
    color:black;
}
    </style>
  </head>
  <body>
    <nav>
      <div class="topnav">
<?php
	//Coloca o menu que está no arquivo
	include 'menu.php';
?>
</div>
    </nav>
    <header>
      <div class="inicio">
        <div class="apresentacao">
            <h1>Biblioteca<br>Anísio Teixeira</h1>
            <div class="btns">
                <a href="#sobre" class="btn">Saiba mais</a>
                <a href="#contato" class="btn">Fale Conosco</a>
            </div>
            
        </div>
        <div class="img-logo">
            <img src="imagens/logo.png" alt="logo" class="logo">
        </div>
    </div>
    </header>
    <section>
           <div id="sobre" class="all-about">
      <h1>A grande Biblioteca agora informatizada!</h1>

      <div class="about">
        <div class="about-us">
          <div class="about_img">
            <img src="imagens/rapidez.png" alt="" />
          </div>
          <h3>Rapidez</h3>
          <p>
            Totalmente formado com a total agilidade para a sua leitura, alterne
            entre livros com rapidez e leia-os facilmente e busque por novos
            gêneros com a máxima agilidade providenciada por nossa biblioteca.
          </p>
        </div>
        <div class="about-us">
          <div class="about_img">
            <img src="imagens/praticidade.png" alt="" />
          </div>
          <h3>Praticidade</h3>
          <p>
            A completa simplicidade para ajudar o usuário a chegar onde quiser
            com o mínimo esforço, saindo do lugar em poucos segundos e
            conseguindo ter um fácil uso para a obtenção do que deseja.
          </p>
        </div>
        <div class="about-us">
          <div class="about_img">
            <img src="imagens/comunicacao.png" alt="" />
          </div>
          <h3>Comunicação</h3>
          <p>
            A plataforma da biblioteca ISERJ permite que os usuários se
            interconectem para a discussão e análises de livros com interações
            totalmente ricas, além da fácil comunicação direta com a equipe de
            nossa biblioteca
          </p>
        </div>
      </div>
    </div>
    </section>
    <section>
      <div id="livros" class="section">
        <div class="container">
          <div class="content-section">
            <div class="title">
              <h1>Leia seus livros</h1>
            </div>
            <div class="content-book">
              <h3>Seu principal ponto de leitura em seu dispositivo</h3>
              <p>
                Centenas de livros para ler! Entre e tenha acesso a seu
                principal ponto para diversos livros ou interaja com outras
                pessoas e tenha a liberdade para comentar sobre o livro que leu.
              </p>
              <div class="button">
                <a href="listar-livro/catalogo.php">Leia agora</a>
              </div>
            </div>
          </div>
          <div class="image-section">
            <img src="imagens/smartphone-livro.png" />
          </div>
        </div>
      </div>
    </section>
    <section>
      <div id="arquivos" class="section">
        <div class="container">
            <div class="image-section-a">
            <img class="file-img" src="imagens/arquivos.png" />
          </div>
          <div class="content-section">
            <div class="title">
              <h1>Veja os arquivos</h1>
            </div>
            <div class="content-book">
              <h3>Todos os arquivos registrados</h3>
              <p>
                De uma olhada nos arquivos armazenados na biblioteca, você com certeza irá adorar o que encontrará!
              </p>
              <div class="button">
                <a href="enviararquivos.php">Veja agora</a>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </section>
    <section>
         <div id="contato" class="contact">
      <div class="container">
        <div class="contactInfo">
          <div class="content-contact">
            <h2>
              Entre em contato com nosso time e <b>fale conosco</b> ou
              <b> relatar problemas </b>
            </h2>
          </div>
          <div class="box">
            <div class="icon">
              <i class="fa fa-map-marker" aria-hidden="true" id="icon"></i>
            </div>
            <div class="text">
              <h3>Endereço</h3>
              <p>
                Rua Mariz e Barros 273,<br />Maracanã, Rio de Janeiro - RJ,<br />20270-003
              </p>
            </div>
          </div>
          <div class="box">
            <div class="icon">
              <i class="fa fa-phone" aria-hidden="true" id="icon"></i>
            </div>
            <div class="text">
              <h3>telefone</h3>
              <p>(21)2334 2501</p>
            </div>
          </div>
          <div class="box">
            <div class="icon">
              <i class="fa fa-envelope-o" aria-hidden="true" id="icon"></i>
            </div>
            <div class="text">
              <h3>Email</h3>
              <p>biblioteca1305@gmail.com</p>
            </div>
          </div>
        </div>
        <div class="contactForm">
          <form
            action="https://formsubmit.co/de26824db4255b6aea69f043c1307a1b"
            method="POST"
          >
            <h2>Mande Sua Mensagem</h2>
            <div class="inputBox">
              <input type="text" name="Nome" required />
              <span>Nome Completo</span>
            </div>
            <div class="inputBox">
              <input type="text" name="Email" required />
              <span>Email</span>
            </div>
            <div class="inputBox">
              <textarea name="Mensagem" required="required"></textarea>
              <span>Digite sua Mensagem</span>
            </div>
            <div class="inputBox">
              <input type="submit" name="" value="send" />
            </div>
          </form>
        </div>
      </div>
    </div>
    </section>
      <footer>
        <div class="col-1">
          <h3>LINKS ÚTEIS</h3>
          <a href="#inicio">Inicio</a>
          <a href="#sobre">Sobre</a>
          <a href="#livros">Livros</a>
          <a href="#">Contato</a>
        </div>
        <div class="col-2">
          <h3>NOTICIAS</h3>
          <form>
            <input type="text" placeholder="Seu e-mail" required />
            <br />
            <button type="submit">Se inscreva agora</button>
          </form>
        </div>
        <div class="col-3">
          <h3>CONTATO</h3>
          <p>273, Rua Mariz e Barros<br />São Cristovão, Rio de Janeiro, BR</p>
          <div class="social-icons">
            <i class="fa-brands fa-facebook"></i>
            <i class="fa-brands fa-twitter"></i>
            <i class="fa-brands fa-Instagram"></i>
          </div>
        </div>
      </footer>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
      $(document).ready(function () {
        $("a").on("click", function (event) {
          if (this.hash !== "") {
            event.preventDefault();

            var hash = this.hash;
            $("html, body").animate(
              {
                scrollTop: $(hash).offset().top,
              },
              800,
              function () {
                window.location.hash = hash;
              }
            );
          }
        });
      });
    </script>
  </body>
</html>
