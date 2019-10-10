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
            <?php echo file_get_contents(__DIR__."\image.svg") ?>

            <!-- <p class="title">MoviePass</p> -->
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
                        <div class="container">
                            <div class="inner">
                                <span class="&">i</span>
                                <h1><?php echo $values->getTitle(); ?></h1> <br><br>
                                <p><?php echo $values->getOverview(); ?></p><br><br><br><br>
                                <p><?php echo "Lenght: ".$values->getLenght()."m"; ?></p>
                                <p><?php echo "Language: ".$values->getLanguage(); ?></p>
                            </div>
                        </div>
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



