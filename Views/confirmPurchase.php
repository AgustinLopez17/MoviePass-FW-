<?php
    include("header.php");
?>
<link rel="stylesheet" href="/MoviePass/Views/layout/styles/stylePurchase.css">
</head>
<body  background="<?php echo $movie->getBackground();?>"  >
<header>
    <nav>
        <ul>
            <a href="<?php echo FRONT_ROOT ?>HomePage/showListView"> 
                <li>Home</li>
            </a>
            <li>
                <?php echo $_SESSION["loggedUser"]->getFirstName(); ?>
            </li>
        </ul>
        
        <?php
            if ($_SESSION["loggedUser"]->getGroup() == 1) {
                ?> <a id="admin" href="<?php echo FRONT_ROOT ?>Admin/checkAdmin"> <?php echo file_get_contents(__DIR__."\image.svg"); ?> </a> <?php
            } else {
                echo file_get_contents(__DIR__."\image.svg");
            } ?>

        <ul>
            <li>Profile</li>
            <li> <a id="exit" href="<?php echo FRONT_ROOT ?>HomePage/exit" id="EXIT"> Exit  </a></li>
        </ul>

    </nav>
</header>

<div id="containerForm">
            <h1> Movie: <?php echo $movie->getTitle(); ?> </h1>
            <h2> Cine:  <?php echo $mt->getName(); ?> </h2>
            <h3> Date:  <?php echo $show->getDate()->format("Y-m-d H:m"); ?> </h3>
            <h3> Room:  <?php echo $show->getId_cinema(); ?> </h3> <br>
            <h2> Price:  $<?php echo $show->getTicket_price(); ?>/cu </h2> <br>
            <form action="<?php echo FRONT_ROOT ?>Purchase/makeTicket" method="GET">
                <input type="hidden" name="id_show" value="<?php $show->getId_show() ?>">
                <input type="number" name="nroEntradas" placeholder="Number of tickets " id="nroEntradas">
                <button type="submit" id="buttonBuy"> BUY </button>
            <form>

<div>
