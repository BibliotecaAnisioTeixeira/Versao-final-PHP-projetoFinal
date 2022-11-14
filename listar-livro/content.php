<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Download</title>

  <style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap');

*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

body{
    background: #1e1e1e;
    padding-top: 7%;
    padding-left: 35%;
}


.infos{
  
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    width: 500px;
    gap: 25px;
    padding: 15px;
}

.download{
    width: 100%;
    padding: 25px 30px;
    border-radius: 8px;
    background: #f6550c;
    border: 3px solid #f6550c;
    color: white;
    transition: 0.5s ease-in-out;
    text-align: center;
    text-decoration: none;
    outline: none;
    font-family: 'Roboto', sans-serif;
    font-weight: 300;
}

.download:hover{
    background: transparent;
    color: white;
    border: 2px solid #f6550c;
    border-left: 13px solid #f6550c;
}

.titulo{
    font-family: 'Roboto', sans-serif;
    color: white;
    font-size: 30px;
}


.info{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin-top: 60px;
    gap: 30px;
}

.seta{
  width: 200px;
  height: 250px;
  position: relative;
  animation-name: seta;
  animation-duration: 1s;
  animation-timing-function: ease-in-out;
  animation-iteration-count: infinite;
  animation-direction: alternate;
}

@keyframes seta{
  0%{
    top: 0px
  }
  100%{
    top:20px;
  }
}

  </style>
</head>
<body>
  
</body>
</html>

<?php

$id = $_GET["id"];
$pdf = $_GET["pdf"];

// Connection to database
  $connection=mysqli_connect("localhost","root","","biblioteca1305");
// Check connection
  if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    

// Increasing the current value with 1
  mysqli_query($connection,"UPDATE livros SET download = (download + 1)
      WHERE id=$id");
      


  mysqli_close($connection);
  
 
  echo '<div class="infos">';    
  echo "<h1 class='titulo'> Clique abaixo para baixar o livro </h1>";
 ?>

<body>
  <img class="seta" src="seta.png" alt="">
</body>
 <?php

echo "<a class='download' href='pdf/$id/$pdf' download>Download PDF</a><br><br>";

  

  echo '</div>';
echo '</div>';

   ?>