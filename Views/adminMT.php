<?php
    include("header.php");

    if(isset($this->allMT) && is_a($this->allMT,'PDOException')){
        ?> <script> if(confirm('Error en la base de datos')); </script> <?php
    }else if(isset($msg)){
        ?> <script> if(confirm('<?php echo $msg ?>')); </script> <?php
    }else if(isset($msg) && is_a($msg,'PDOException')){
        ?> <script> if(confirm('Error en la base de datos')); </script> <?php
    }

?>
<script src="<?php echo JS_PATH3 ?>"></script>
<link rel="stylesheet" href="/MoviePass/Views/layout/styles/styleAdmC.css">
</head>

<body>
    <header>

        <a href="<?php echo FRONT_ROOT ?>Admin/checkAdmin"> <?php echo file_get_contents(__DIR__."\image.svg");  ?> </a>

        <nav>
            <ul id="options">
                <li id="cinemas"><button type="button" id="Alta">New MovieTheater</button> </li>
                <li id="cinemas"><button type="button" id="Mod">Modify MovieTheater</button></li>
                <li id="cinemas"><button type="button" id="Baja">Unset/set MovieTheater</button></li>
                <li id="cinemas"><button type="button" id="Cinemas">Config cinemas</button></li>
            </ul>
        </nav>


    </header>
    <div class="barra"></div>
    <div class="barraAbajo"></div>



    <div class="alta">
        <form id="formAlta" action="<?php echo FRONT_ROOT ?>MovieTheater/addMT" method="POST">
            <h1 id="titleAdd">Add MovieTheater</h1>
            <input class="mdAlt" type="text" name="name" placeholder="Type name of cinema" required>
            <input class="mdAlt" type="text" name="address" placeholder="Type address" required>
            <input class="mdAlt" type="number" name="numberOfCinemas" placeholder="Number of cinemas" required>
            <input class="mdAlt" type="number" name="priceDefault" placeholder="Price default" required>
            <p> Available </p>
            <input type="radio" name="available" value="1" required> Yes
            <input type="radio" name="available" value="0 " required> No
            <button type="submit" class="submit">New Movie Theater</button>
        </form>
    </div>


    <div class="mod">
        <h1 id="titleModify">Modify MovieTheater</h1>
        <table>
            <tr>
                <?php if(isset($this->allMT)){ foreach($this->allMT as $value){?>
                <td>
                    <form id="modC" action="<?php echo FRONT_ROOT ?>MovieTheater/modMT" method="POST">
                        <input type="hidden" name="id" value="<?php echo $value->getId(); ?>">
                        <input type="text" name="name" value="<?php echo $value->getName(); ?>">
                        <input type="text" name="address" value="<?php echo $value->getAddress(); ?>">
                        <input type="hidden" name="available" value="<?php echo $value->getAvailable(); ?>">
                        <button type="submit" class="submit">Refresh</button>
                    </form>
                </td>
                <?php }} ?>
            </tr>
        </table>
        </ul>
    </div>
    <div class="baja">
        <h1 id="titleBaja">Unset/set MovieTheater</h1>
        <form action="<?php echo FRONT_ROOT ?>MovieTheater/downMT">
            <ul id="bajaCinema">
                <?php if(isset($this->allMT)){ 
                    foreach($this->allMT as $value){?>
                <li id="<?php if($value->getAvailable() == 0){ echo "cinemas2"; }else{ echo "cinemas" ;}  ?>">
                    <?php echo $value->getName(); ?>
                    <input type="checkbox" name="check_list[]" value="<?php echo $value->getId(); ?>">
                </li> <?php }} ?>
            </ul>
            <button type="submit"> SUBMIT </button>
        </form>
    </div>
    <div class="cinemas">
        <h1 id="titleCinemas">Cinemas of MovieTheater's</h1>
        <ul id="movieTheaters">
            <?php if(isset($this->allMT)){ 
                    foreach($this->allMT as $value){?>
            <a
                href="<?php echo FRONT_ROOT ?>Cinemas/seeCinemas?id_movieTheater=<?php echo $value->getId();?>&nameOfMT=<?php echo $value->getName();?>">
                <li id="cinemas">
                    <?php echo $value->getName(); ?>
                </li>
            </a>
            <?php }} ?>
        </ul>
        </form>
    </div>

</body>

               