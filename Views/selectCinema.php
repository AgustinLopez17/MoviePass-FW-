<?php
    include("header.php");
?>
<link rel="stylesheet" href="/MoviePass/Views/layout/styles/styleSelectCinema.css">
</head>
<body>
<header >

    
    </header>
        <div id="container"> 
            <h1 id="titleCinemas">Cinemas of MovieTheater: <?php echo $MT->getName(); ?></h1>
            <form action="<?php echo FRONT_ROOT ?>Show/verifyHour">
                <select name="id_cinema" id="selectCinema">
                <?php foreach($allCinemas as $value){  ?>
                        <option value="<?php echo $value->getIdCinema();?>"> <?php echo $value->getNumberCinema();?> </option>
                    <?php } ?>
                </select>
                <input type="hidden" name="id_MT" value="<?php echo $id_MT; ?>">
                <input type="hidden" name="id_movie" value="<?php echo $id_movie; ?>">
                <input type="hidden" name="date" value="<?php echo $date; ?>">
                <input type="time" name="time">
                <button type="submit">SUBMIT</button>
            </form>
        </div>

<div class="barra"></div>
<div class="barraAbajo"></div>