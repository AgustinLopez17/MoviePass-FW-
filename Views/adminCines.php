<?php
    include("header.php");
?>
<script src="<?php echo JS_PATH3 ?>"></script>
<link rel="stylesheet" href="/MoviePass/Views/layout/styles/styleAdmC.css">
</head>
<body>
<header >

    <a href="<?php echo FRONT_ROOT ?>HomePage/showListView"> <?php echo file_get_contents(__DIR__."\image.svg");  ?> </a>

    <nav>
        <ul id="options">
            <li id="cinemas"><button type="button" id="Alta">New cinema</button> </li>
            <li id="cinemas"><button type="button" id="Mod">Modify cinema</button></li>
            <li id="cinemas"><button type="button" id="Baja">Unset/set cinema</button></li>
            <li id="cinemas"><button type="button" id="AddShow">Add Show</button></li>
            <li id="cinemas"><button type="button" id="Shows">Shows</button></li>
        </ul>
    </nav>
    
    
</header>
<div class="barra"></div>
<div class="barraAbajo"></div>
        

        <p class="msg"> <?php if(isset($msg)){ echo $msg;} ?> </p>
        <div class="alta">
            <form id="formAlta" action="<?php echo FRONT_ROOT ?>Cinema/addCine" method="POST"> 
                <h1 id="titleAdd">Add cinema</h1>
                <input class="mdAlt" type="text" name="name" placeholder="Type name of cinema" required>
                <input class="mdAlt" type="text" name="address" placeholder="Type address" required>
                <input class="mdAlt" type="number" name="capacity" placeholder="Type capacity" required>
                <input class="mdAlt" type="number" name="ticket_value" placeholder="Type ticket value" required>
                <p> Available </p>
                <input type="radio" name="available" value="1" required> Yes 
                <input type="radio" name="available" value="0 " required> No
                <button type="submit" class="submit">New cinema</button>
            </form>
        </div>


        <div class="mod"> 
                <h1 id="titleModify">Modify cinema</h1>
            <table>
                <tr>
                    <?php foreach($this->cinemaDao->readAll() as $value){?>
                    <td>
                        <form id="modC" action="<?php echo FRONT_ROOT ?>Cinema/modCine" method="POST"> 
                            <input type="hidden" name="id" value="<?php echo $value->getId(); ?>">
                            <input type="text" name="name" value="<?php echo $value->getName(); ?>">
                            <input type="text" name="address" value="<?php echo $value->getAddress(); ?>">
                            <input type="number" name="capacity"  value="<?php echo $value->getCapacity(); ?>">
                            <input type="number" name="ticket_value"  value="<?php echo $value->getTicket_value(); ?>">
                            <input type="hidden" name="available"  value="<?php echo $value->getAvailable(); ?>">
                            <button type="submit" class="submit">Refresh</button>
                        </form>  
                    </td>
                    <?php } ?>
                </tr>
                </table>
            </ul>    
        </div>
        <div class="baja"> 
            <h1 id="titleBaja">Unset/set cinema</h1>
            <form action="<?php echo FRONT_ROOT ?>Cinema/bajaCine">
                <ul id="bajaCinema">
                <?php
                $id = array();
                foreach($this->cinemaDao->readAll() as $value){?>
                    <li id="<?php if($value->getAvailable() == 0){ echo "cinemas2"; }else{ echo "cinemas" ;}  ?>" >
                        <?php echo $value->getName(); ?>
                        <input type="checkbox" name="check_list[]" value="<?php echo $value->getId(); ?>">
                    </li> <?php } ?>
                </ul>
                <button type="submit"> SUBMIT </button>
            </form>
        </div>
        <p class="msg"> <?php if(isset($outcome)){ echo $outcome;} ?> </p>
        <div class="addShow">
            <h1 id="titleAddShow">Add Show</h1>
            <form action="<?php echo FRONT_ROOT ?>Show/addShow" method="GET">
                        <select name="id_cinema" id="selectCinema">
                            <?php foreach($this->cinemaDao->readAll() as $value){  ?>
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
            <?php foreach($this->showDao->readAll() as $value){ ?>
            <ul id="bajaCinema">
                <li id="individualShow" >
                    <img class="movies" src="<?php echo "https://image.tmdb.org/t/p/w200/". ($this->movieDao->read($value->getId_movie()))->getImage() ; ?>" alt="">
                    <div class="desc">
                        <p>Movie: <?php echo $this->movieDao->read($value->getId_movie())->getTitle(); ?></p>
                        <p>Cinema: <?php echo $this->cinemaDao->read($value->getId_cinema())->getName(); ?></p>
                        <p>Date: <?php echo $value->getDate()->format("Y-m-d H:m"); ?></p>
                    </div>
                        <!-- <div class="buttonsShows">
                            <button> DELETE </button>
                            <button> MODIFY </button>
                        </div> -->
                </li>
            </ul>
            <?php } ?>
        </div>
        

</body>