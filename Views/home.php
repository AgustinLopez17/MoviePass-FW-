<?php
    include("header.php");
?>

<style>
    @import "/MoviePass/Views/layout/styles/styleHome.css";
</style>
<script src="<?php echo "\\".JS_PATH ?>"></script>

<header >
    
    <nav>
        <ul>
            <li>Inicio</li>
            <li>Buscar</li>
            <li>Categorias</li>
        </ul>
        
        <?php
            if($_SESSION["loggedUser"]->getGroup() == 1){
               ?> <a id="admin" href="adminCines"> <?php echo file_get_contents(__DIR__."\image.svg"); ?> </a> <?php
            }else{
                echo file_get_contents(__DIR__."\image.svg");
            }
        ?>

        <ul>
            <li>Carrito</li>
            <li>Perfil</li>
            <li> <a href="exit"> Salir  </a></li>
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



