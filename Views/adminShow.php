<?php
    include("header.php");

    if(isset($msg) && is_a($msg,'PDOException') ){
        ?> 
        <script>
            if(confirm('Error en base de datos'));
        </script>
        <?php
    }else if(isset($msg)){
        ?> 
        <script>
            if(confirm('<?php echo $msg ?>'));
        </script>
        <?php
    }


?>



<script src="<?php echo JS_PATH5 ?>"></script>
<link rel="stylesheet" href="/MoviePass/Views/layout/styles/styleAdmC.css">
</head>
<body>
<header >

    <a href="<?php echo FRONT_ROOT ?>Admin/checkAdmin"> <?php echo file_get_contents(__DIR__."\image.svg");  ?> </a>

    <nav>
        <ul id="options">
            <li id="cinemas"><button type="button" id="Alta">New show</button> </li>
            <li id="cinemas"><button type="button" id="SeeShows">Shows</button></li>
        </ul>
    </nav>

</header>
        <div class="addShow">
            <h1 id="titleAddShow">Add Show</h1>
            <form action="<?php echo FRONT_ROOT ?>Show/verifyMovieTheater" method="GET">
                        <select name="id_movieTheater" id="selectCinema">
                        <?php foreach($this->allMT as $value){  ?>
                                <option value="<?php echo $value->getId();?>"> <?php echo $value->getName();?> </option>
                            <?php } ?>
                        </select>

                        <select name="id_movie" id="selectMovie">
                            <?php foreach($this->movieDao->readAll() as $value){  ?>
                                <option value="<?php echo $value->getId();?>"> <?php echo $value->getTitle();?> </option>
                            <?php } ?>
                        </select>
                        <input id="date" type="date" name="date">
                <button type="submit"> SUBMIT </button>
            </form>
        </div>

        <div class="shows">
            <h1 id="titleShows">Shows</h1>
            <?php foreach($this->allShows as $value){ ?>
            <ul id="bajaCinema">
                <li id="individualShow" >
                    <img class="movies" src="<?php echo "https://image.tmdb.org/t/p/w200/". ($this->movieDao->read($value->getId_movie()))->getImage() ; ?>" alt="">
                    <div class="desc">
                        <p>Movie: <?php echo $this->movieDao->read($value->getId_movie())->getTitle(); ?></p>
                        <p>Cinema: <?php echo $this->movieTheaterDao->read($value->getId_movieTheater())->getName(); ?></p>
                        <p>Date: <?php echo $value->getDate()->format("Y-m-d H:m"); ?></p>
                    </div>
                         <div class="buttonsShows">
                            <button> DELETE </button>
                            <button> MODIFY </button>
                        </div> 
                </li>
            </ul>
            <?php } ?>
        </div>
