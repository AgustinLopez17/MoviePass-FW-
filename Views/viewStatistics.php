<?php
    include("header.php");

    if(isset($msg)){
?>
<script>
    if(confirm('<?php
                      if(is_a($msg,'PDOException')){
                            echo 'Error en la base de datos, por favor intente nuevamente mas tarde.';
                      } else {
                            echo $msg;
                      } 
                ?>')
    );
</script>
    <?php } ?>
<script src="<?php echo JS_PATH3 ?>"></script>
<link rel="stylesheet" href="/MoviePass/Views/layout/styles/styleStatistics.css">
</head>

<body>
    <header>

        <a href="<?php echo FRONT_ROOT ?>HomePage/showListView">
            <?php echo file_get_contents(__DIR__."\image.svg");  ?> </a>


    </header>


    <div class="div1">
        <h1> Quantity of tickets sold </h1>
        <ul id="options">
            <li><button type="button" id="button1-1">Tickets sold from movie theater</button> </li>
            <li><button type="button" id="button1-2">Tickets sold from movie</button></li>

            <form id="formDates" action="<?php echo FRONT_ROOT ?>Statistics/salesBetweenDates" method="GET">
                <p> Input between dates </p>
                <input class="dates" type="date" name="minDate" required>
                <input class="dates" type="date" name="maxDate" required>
                <button id="submitDates" type="submit">Submit</button>
            </form>
        </ul>
    </div>
    
    <div class="div1-1">
        <h1> MovieTheater's </h1>
        <ul>
            <?php  foreach($this->allMT as $value){ ?>
                <li> <a href="<?php echo FRONT_ROOT ?>Statistics/salesOfMT?id_mt=<?php echo $value->getId();?>"> <?php echo $value->getName(); ?> </a></li>
            <?php } ?>
        </ul>    
    </div>

    <div class="div1-2">
        <h1> Movies </h1>
        <ul>
            <?php  foreach($this->allMovies as $value){ ?>
                <li> <a href="<?php echo FRONT_ROOT ?>Statistics/salesOfMovie?id_movie=<?php echo $value->getId();?>"> <?php echo $value->getTitle();  ?> </a> </li>
            <?php } ?>
        </ul>    
    </div>

    <div class="div1-3">
        <h1> Shows </h1>
        <ul>
            <?php  foreach($this->allShows as $value){ ?>
                <li> <a href="<?php echo FRONT_ROOT ?>Statistics/ShowSales?id_mt=<?php echo $value->getId();?>"> <?php echo $value->getName(); ?> </a> </li>
            <?php } ?>
        </ul>    
    </div>


            </body>