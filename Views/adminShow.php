<?php
    include("header.php");

    if(isset($msg) && is_a($msg,'PDOException') ){
        ?> 
        <script>
            if(confirm('There was a problem with the database, please try again later.'));
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
<link rel="stylesheet" href="/MoviePass/Views/layout/styles/styleShow.css">
</head>
<body>
<header >

    <a href="<?php echo FRONT_ROOT ?>Admin/checkAdmin"> <?php echo file_get_contents(__DIR__."\image.svg");  ?> </a>

    <nav>
        <ul id="options">
            <li ><button type="button" id="Button1">New show</button> </li>
            <li ><button type="button" id="Button2">Shows</button></li>
        </ul>
    </nav>

</header>
        <div class="div1">
            <h1>Add Show</h1>
            <form action="<?php echo FRONT_ROOT ?>Show/verifyMovieTheater" method="GET">
                <select name="id_movieTheater" class="selects">
                <?php foreach($this->allMT as $value){  ?>
                        <option value="<?php echo $value->getId();?>"> <?php echo $value->getName();?> </option>
                    <?php } ?>
                </select>

                <select name="id_movie" class="selects">
                    <?php foreach($this->movieDao->readAll() as $value){  ?>
                        <option value="<?php echo $value->getId();?>"> <?php echo $value->getTitle();?> </option>
                    <?php } ?>
                </select>
                <input id="date" type="date" name="date">
                <button type="submit"> SUBMIT </button>
            </form>
        </div>

        <div class="div2">
            <h1 id="titleShows">Shows</h1>
            <ul>
            <?php foreach($this->allShows as $value){ ?>
                <li id="shows">
                    <img class="movies" src="<?php echo "https://image.tmdb.org/t/p/w200/". ($this->movieDao->read($value->getId_movie()))->getImage() ; ?>" alt="">
                    <div id="descShow">
                        <p>Movie: <?php echo $this->movieDao->read($value->getId_movie())->getTitle(); ?></p>
                        <p>Movie Theater: <?php echo $this->movieTheaterDao->read($value->getId_movieTheater())->getName(); ?></p>
                        <p>Date: <?php echo $value->getDate()->format("Y-m-d H:i"); ?></p>
                    </div>
                </li>
                <?php } ?>
            </ul>
        </div>
