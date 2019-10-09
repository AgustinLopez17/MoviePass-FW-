<?php
    
    
    //include('Process/checkUserLogged.php');
    include("homeHeader.php");

    use DAO\MovieRepository as MovieRepository;

    $movieList = new MovieRepository();
    $movieList->retrieveDataApi();
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
            <img id="logo" src="<?php echo "\\".IMG_PATH."Logo.png" ?>" alt="">
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
                <button class="slider" id="slideRight" type="button"> <img src="<?php echo "\\".IMG_PATH."flecha.png" ?>" alt="MoviePass" class="logo"></button>
                <button class="slider" id="slideLeft" type="button"> <img src=<?php echo "\\".IMG_PATH."flecha.png" ?> alt="MoviePass" class="logo"></button>
            </table>
        </div>
    </section>
    
    <section id="body">

    </section>        
    </body>



