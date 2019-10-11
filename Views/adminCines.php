<?php
    include("header.php");
?>


<style>
    @import "/MoviePass/Views/layout/styles/styleAdmC.css";
</style>
<script src="<?php echo JS_PATH3 ?>"></script>


<header >

    <a href="<?php echo FRONT_ROOT ?>HomePage/login"> <?php echo file_get_contents(__DIR__."\image.svg");  ?> </a>

    <nav>
        <ul id="options">
            <li id="cinemas"><button type="button" id="Alta">Alta cine</button> </li>
            <li id="cinemas"><button type="button" id="Mod">Modificar cine</button></li>
            <li id="cinemas"><button type="button" id="Baja">Baja cine</button></li>
        </ul>
    </nav>

</header>

        <div class="alta">
            <form action="<?php echo FRONT_ROOT ?>Cinema/addCine" method="POST"> <!-- averiguar como pija redireccionar esto   -->
                <input class="mdAlt" type="text" name="name" placeholder="Type name of cinema" required>
                <input class="mdAlt" type="text" name="address" placeholder="Type address" required>
                <input class="mdAlt" type="number" name="capacity" placeholder="Type capacity" required>
                <input class="mdAlt" type="number" name="ticket_value" placeholder="Type ticket value" required>
                <input type="radio" name="available" value="1" required> Yes
                <input type="radio" name="available" value="0 " required> No
                <button type="submit" class="submit">New cinema</button>
            </form>
        </div>
        <div class="mod"> 
            <table>
                <tr>
                <?php foreach($cinemaList as $value){?>
                    <td>
                        <form id="modC" action="<?php echo FRONT_ROOT ?>Cinema/modCine" method="POST"> <!-- averiguar como pija redireccionar esto   -->
                            <input class="modInp" type="hidden" name="id" value="<?php echo $value->getId(); ?>">
                            <input class="modInp" type="text" name="name" value="<?php echo $value->getName(); ?>">
                            <input class="modInp" type="text" name="address" value="<?php echo $value->getAddress(); ?>">
                            <input class="modInp" type="number" name="capacity"  value="<?php echo $value->getCapacity(); ?>">
                            <input class="modInp" type="number" name="ticket_value"  value="<?php echo $value->getTicket_value(); ?>">
                            <input class="modInp" type="hidden" name="available"  value="<?php echo $value->getAvailable(); ?>">
                            <button type="submit" class="submit">Refresh</button>
                        </form>  
                    </td>
                    <?php } ?>
                </tr>
                </table>
            </ul>    
        </div>
        <div class="baja"> 
            <ul id="bajaCinema">
            <?php foreach($cinemaList as $value){?>
                <li id="cinemas"><?php echo $value->getName(); ?></li> <?php } ?>
            </ul>
        </div>

</body>