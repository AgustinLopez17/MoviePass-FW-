<?php
    include("header.php");
?>

<style>
    @import "/MoviePass/Views/layout/styles/styleHome.css";
</style>
<script src="<?php echo JS_PATH ?>"></script>

<header >
    
    <nav>
        <ul>
            <li>Cart</li>
            <li>Search</li>
            <li><?php echo $_SESSION["loggedUser"]->getFirstName(); ?></li>
        </ul>
        
        <?php
            if($_SESSION["loggedUser"]->getGroup() == 1){
               ?> <a id="admin" href="<?php echo FRONT_ROOT ?>Cinema/adminCines"> <?php echo file_get_contents(__DIR__."\image.svg"); ?> </a> <?php
            }else{
                echo file_get_contents(__DIR__."\image.svg");
            }
        ?>

        <ul>
            <li>Categories</li>
            <li>Profile</li>
            <li> <a href="<?php echo FRONT_ROOT ?>HomePage/exit"> Exit  </a></li>
        </ul>
    </nav>
</header>

<section id="banner">
    <div id="container">
        <form action="<?php echo FRONT_ROOT ?>#">
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
                            <button type="buttom" id="buyTicket">Buy ticket</button>
                        </div>

                    </td>
                <?php
                    }
                ?>
                </tr>
                
            </table>
        </form>
    </div>
</section>

<section id="body">

</section>        
</body>



