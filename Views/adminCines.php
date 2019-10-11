<?php
    include("header.php");
    // foreach($cinemaList as $key=>$value){
    //     echo $value->getName()."   -   ";
    // }

?>


<style>
    @import "/MoviePass/Views/layout/styles/styleAdmC.css";
</style>
<script src="<?php echo "\\".JS_PATH3 ?>"></script>


<header >

    <a href="back"> <?php echo file_get_contents(__DIR__."\image.svg");  ?> </a>

    <nav>
        <ul>
            <li><button type="button" id="Alta">Alta cine</button> </li>
            <li><button type="button" id="Mod">Modificar cine</button></li>
            <li><button type="button" id="Baja">Baja cine</button></li>
        </ul>
    </nav>

</header>

        <div class="alta">
            <form action="addCine" method="POST"> <!-- averiguar como pija redireccionar esto   -->
                <input type="text" name="name" placeholder="Type name of cinema" required>
                <input type="text" name="address" placeholder="Type address" required>
                <input type="number" name="capacity" placeholder="Type capacity" required>
                <input type="number" name="ticket_value" placeholder="Type ticket value" required>
                <button type="submit" class="submit">New cinema</button>
            </form>
        </div>
        <div class="mod"> MOD</div>
        <div class="baja"> BAJA</div>

</body>