<?php
    include("header.php");

    if(isset($msg)){
?>
<script>
    if(confirm('<?php
                      if(is_a($msg,'PDOException')){
                            echo 'There was a problem with the database, please try again later.';
                      } else {
                            echo $msg;
                      } 
                ?>')
    );
</script>
    <?php } ?>
<script src="<?php echo JS_PATH3 ?>"></script>
<link rel="stylesheet" href="/MoviePass/Views/layout/styles/styleCinema.css">
</head>

<body>
    <header>

        <a href="<?php echo FRONT_ROOT ?>MovieTheater/chargeAllAndBack">
            <?php echo file_get_contents(__DIR__."\image.svg");  ?> </a>

        <nav>
            <ul id="options">
                <li id="cinemas"><button type="button" id="button1">Add Cinema</button> </li>
                <li id="cinemas"><button type="button" id="button2">Update Cinema</button></li>
                <li id="cinemas"><button type="button" id="button3">Down Cinema</button></li>
            </ul>
        </nav>


    </header>
    <div class="div1">
        <form id="formAlta" action="<?php echo FRONT_ROOT ?>Cinemas/addCinema" method="POST">
            <h1 id="titleAdd">Add Cinema to <?php echo $nameOfMT ?></h1>
            <input class="mdAlt" type="hidden" name="id_movieTheater" value="<?php echo $id_movieTheater;?>">
            <input type="hidden" name="nameOfMT" value="<?php echo $nameOfMT;?>">
            Number of cinema:
            <input class="mdAlt" type="number" name="number_cinema"
                value="<?php echo end($this->allCinemas)->getNumberCinema()+1; ?>" readonly>
            <input class="mdAlt" type="number" name="capacity" placeholder="Type capacity" required>
            <input class="mdAlt" type="number" name="ticket_value" placeholder="Ticket value" required>
            <select name="available">  
                <option selected disabled hidden> Available </option>
                <option value="1"> Yes </option>
                <option value="0"> No </option>
            </select>
            <button type="submit" class="submit">New cinema</button>
        </form>
    </div>

    <div class="div2">
        <h1 id="titleModify">Modify cinemas of <?php echo $nameOfMT ?></h1>
        <table>
            <tr>
                <?php if(isset($this->allCinemas)){ foreach($this->allCinemas as $value){?>
                <td>
                    <form id="modC" action="<?php echo FRONT_ROOT ?>Cinemas/modCinema" method="POST">
                        <input class="mdAlt" type="hidden" name="id_movieTheater"
                            value="<?php echo $value->getIdMovieTheater();?>">
                        <input type="hidden" name="id" value="<?php echo $value->getIdCinema(); ?>">
                        <input type="hidden" name="nameOfMT" value="<?php echo $nameOfMT;?>">
                        <p> Number of cinema: </p>
                        <input type="text" name="numberCinema" value=" <?php echo $value->getNumberCinema(); ?>"
                            disabled>
                        <p> Capacity: </p>
                        <input type="text" name="name" value="<?php echo $value->getCapacity(); ?>">
                        <p> Ticket value: </p>
                        <input type="text" name="ticket_value" value="<?php echo $value->getTicket_value(); ?>">
                        <input type="hidden" name="available" value="<?php echo $value->getAvailable(); ?>">
                        <button type="submit" class="submit">Refresh</button>
                    </form>
                </td>
                <?php }} ?>
            </tr>
        </table>
    </div>

    <div class="div3">
        <h1 id="titleBaja">Unset/set Cinema of <?php echo $nameOfMT ?></h1>
        <form action="<?php echo FRONT_ROOT ?>Cinemas/setAvaiableCinema">
            <ul id="bajaCinema">
                <input type="hidden" name="nameOfMT" value="<?php echo $nameOfMT;?>">
                <?php if(isset($this->allCinemas)){ 
                        foreach($this->allCinemas as $value){?>
                <li id="<?php if($value->getAvailable() == 0){ echo "liRed"; }else{ echo "liNormal" ;}  ?>">
                    <p> Number of cinema: <?php echo $value->getNumberCinema(); ?> </p>
                    <input type="hidden" name="idMT" value="<?php echo $value->getIdMovieTheater(); ?>">
                    <input type="checkbox" name="check_list[]" value="<?php echo $value->getIdCinema(); ?>">
                </li> <?php }} ?>
            </ul>
            <button type="submit"> SUBMIT </button>
        </form>
    </div>

                       