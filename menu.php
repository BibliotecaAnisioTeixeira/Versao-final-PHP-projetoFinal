
<ul class="nav-list">
    
  <li><a href="#inicio">Inicio</a></li>
  <li><a href="#sobre">Sobre</a></li>
  <li><a href="#livros">Livros</a></li>
  <li><a href="#arquivos">Arquivos</a></li>
    <li><a href="#contato">Contato</a></li>
    <li><a href="forum/index.php">Forum</a></li>
<?php 

//Menu só aparece para os administradores.
if($_SESSION['acesso']=="admin"){
    echo "<li class='dropdown'><a href='javascript:void(0)' class='dropbtn'>Administração</a>";
	echo "<div class='dropdown-content'><a href='usuariosrelatorio.php?pag=1'>Relatório de Usuários</a><a href='listar-livro/index.php'>Controlar Livros</a></div></li>";
}  
?>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">Usuário: <?php echo $logado;?></a>
    <div class="dropdown-content">
      <a href="deslogar.php">Deslogar</a>
    </div>
  </li>
</ul>