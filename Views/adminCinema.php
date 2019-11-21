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
<script src="<?php echo JS_PATH4 ?>"></script>
<link rel="stylesheet" href="/MoviePass/Views/layout/styles/styleAdmC.css">
</head>

<body>
    <header>

        <a href="<?php echo FRONT_ROOT ?>MovieTheater/chargeAllAndBack">
            <?php echo file_get_contents(__DIR__."\image.svg");  ?> </a>

        <nav>
            <ul id="options">
                <li id="cinemas"><button type="button" id="Alta">Add Cinema</button> </li>
                <li id="cinemas"><button type="button" id="Mod">Update Cinema</button></li>
                <li id="cinemas"><button type="button" id="Baja">Down Cinema</button></li>
            </ul>
        </nav>




    </header>
    <div class="alta">
        <form id="formAlta" action="<?php echo FRONT_ROOT ?>Cinemas/addCinema" method="POST">
            <h1 id="titleAdd">Add Cinema to <?php echo $nameOfMT ?></h1>
            <input class="mdAlt" type="hidden" name="id_movieTheater" value="<?php echo $id_movieTheater;?>">
            <input type="hidden" name="nameOfMT" value="<?php echo $nameOfMT;?>">
            Number of cinema:
            <input class="mdAlt" type="number" name="number_cinema"
                value="<?php echo end($this->allCinemas)->getNumberCinema()+1; ?>">
            <input class="mdAlt" type="number" name="capacity" placeholder="Type capacity" required>
            <input class="mdAlt" type="number" name="ticket_value" placeholder="Ticket value" required>
            <p> Available </p>
            <input type="radio" name="available" value="1" required> Yes
            <input type="radio" name="available" value="0 " required> No
            <button type="submit" class="submit">New cinema</button>
        </form>
    </div>

    <div class="mod">
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
                        Number of cinema:
                        <input type="text" name="numberCinema" value=" <?php echo $value->getNumberCinema(); ?>"
                            disabled>
                        <input type="text" name="name" value="<?php echo $value->getCapacity(); ?>">
                        <input type="text" name="address" value="<?php echo $value->getTicket_value(); ?>">
                        <input type="hidden" name="available" value="<?php echo $value->getAvailable(); ?>">
                        <button type="submit" class="submit">Refresh</button>
                    </form>
                </td>
                <?php }} ?>
            </tr>
        </table>
    </div>

    <div class="baja">
        <h1 id="titleBaja">Unset/set Cinema of <?php echo $nameOfMT ?></h1>
        <form action="<?php echo FRONT_ROOT ?>Cinemas/setAvaiableCinema">
            <ul id="bajaCinema">
                <input type="hidden" name="nameOfMT" value="<?php echo $nameOfMT;?>">
                <?php if(isset($this->allCinemas)){ 
                        foreach($this->allCinemas as $value){?>
                <li id="<?php if($value->getAvailable() == 0){ echo "cinemas2"; }else{ echo "cinemas" ;}  ?>">
                    <?php echo $value->getNumberCinema(); ?>
                    <input type="hidden" name="idMT" value="<?php echo $value->getIdMovieTheater(); ?>">
                    <input type="checkbox" name="check_list[]" value="<?php echo $value->getIdCinema(); ?>">
                </li> <?php }} ?>
            </ul>
            <button type="submit"> SUBMIT </button>
        </form>
    </div>

                       