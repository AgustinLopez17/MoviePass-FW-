<?php
    
    require_once('Config\Autoload.php');
    include('Process/checkUserLogged.php');
    include('api/nowPlaying.php');
?>

<!doctype html>
<html lang="en">
<head>
     <!-- Required meta tags -->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <!-- Style -->
     <link rel="stylesheet" href="css/styleHome.css">
     <link href="https://fonts.googleapis.com/css?family=Quicksand|Work+Sans&display=swap" rel="stylesheet">
     <link href="https://api.themoviedb.org/3/movie/76341?api_key=bf47253392bc9b0762556be7b49ab033">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
     <script src="js/script.js"></script>
     <title>MoviePass - [TP FINAL]</title>
</head>
<body>
    <?php
        $allMovies = $movieList->GetAll();
    ?>
    <header>
        <nav>
            <ul>
                <li>Inicio</li>
                <li>Buscar</li>
                <li>Categorias</li>
            </ul>
            <svg 
                id="stroke"
                viewBox="0 0 479 479" 
                fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <circle cx="239.5" cy="239.5" r="229.5" stroke="#ea164773" stroke-width="10"/>
            </svg>
            <img id="logo" src="img/logo.png" alt="">
            <p class="title">MoviePass</p>
            <ul>
                <li>Carrito</li>
                <li>Favoritos</li>
                <li>Perfil</li>
            </ul>
        </nav>
    </header>

    <section id="banner">
        <div id="container">
            <table class="table1">
                <tr>
                <?php
                    foreach($allMovies as $values){
                ?>
                    <td> 
                        <img class="movies" src="<?php echo "https://image.tmdb.org/t/p/w300/".$values->getImage() ?>" alt="">
                    </td>
                <?php
                    }
                ?>
                </tr>
                <button class="slider" id="slideRight" type="button"> <img src="img/flecha.png" alt="MoviePass" class="logo"></button>
                <button class="slider" id="slideLeft" type="button"> <img src="img/flecha.png" alt="MoviePass" class="logo"></button>
            </table>
        </div>
    </section>
    
    <section id="body">

    </section>


    



