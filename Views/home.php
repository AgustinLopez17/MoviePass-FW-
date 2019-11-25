<?php
    include("header.php");


    if (is_a($this->allMovies, 'PDOException')) { ?>    
        <script> 
            if(confirm('There was a problem with the database, please try again later.'));
        </script>
    <?php 
        $this->exit();
    } else {
        ?>
<script src="<?php echo JS_PATH ?>"></script>
<link rel="stylesheet" href="/MoviePass/Views/layout/styles/styleHome.css">
</head>
<body>
<header>
    <nav>

        <ul>
            <a href="<?php echo FRONT_ROOT ?>HomePage/showListView"> <li>Home</li> </a>
            <li>
                <button id="searchByDate">Filter</button>
            </li>
            <li>
                <?php echo $_SESSION["loggedUser"]->getFirstName(); ?>
            </li>
        </ul>
        
        <?php
            if ($_SESSION["loggedUser"]->getGroup() == 1) {
                ?> <a id="admin" href="<?php echo FRONT_ROOT ?>Admin/checkAdmin"> <?php echo file_get_contents(__DIR__."\image.svg"); ?> </a> <?php
            } else {
                echo file_get_contents(__DIR__."\image.svg");
            } ?>

        <ul>
            <li>
                <form action="<?php echo FRONT_ROOT ?>HomePage/showListView" method="POST" id="FORM_ID">
                    <select name="id_genre" id="selectGenre" >
                    <option selected disabled hidden> Genres </option>
                    <?php foreach ($this->allGenres as $value) { ?>
                        <option value="<?php echo $value->getId_genre(); ?>"><?php echo $value->getName_genre(); ?></option>
                    <?php } ?>
                    </select> 
                    <button type="submit" id="submitButton"></button>
                </form>
            </li>
            <li><a href="<?php echo FRONT_ROOT ?>User/seeUser">Profile</a></li>
            <li> <a href="<?php echo FRONT_ROOT ?>HomePage/exit" id="EXIT"> Exit  </a></li>
        </ul>
    </nav>
    <form action="<?php echo FRONT_ROOT ?>HomePage/showListView" method="POST" id="FORM_ID_DATE">
        <input type="date" name="date">
        <button type="submit" id="buttonDate">Submit</button>
    </form>
</header>
<script>
    document.getElementById('FORM_ID').id_genre.onchange = function() {
        document.getElementById('submitButton').click();
    };
</script>
<section id="banner">
    <div id="container">
        <form action="<?php echo FRONT_ROOT ?>#">
            <table class="table1">
                <tr>
                <?php
                    if (!empty($this->allMovies)) {
                        foreach ($this->allMovies as $values) {
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
                                <p><?php echo "Genres: ";
                            foreach ($this->showGenreMovie($values->getId()) as $genre) {?> <br> <?php echo "-".$genre->getName_genre();} ?></p>
                            </div>
                            <div id="buyTicket"> <a href="<?php echo FRONT_ROOT ?>Purchase/seeAvailableMT?id_movie=<?php echo $values->getId();?>" >Buy ticket</a> <div>
                        </div>

                    </td>
                <?php
                        }
                    } else {
                        ?> <p id="emptyFunctions"> No functions </p> <?php
                    } ?>
                </tr>
                
            </table>
        </form>
    </div>
</section>

<section id="body">

</section>        
</body>


<?php } ?>
