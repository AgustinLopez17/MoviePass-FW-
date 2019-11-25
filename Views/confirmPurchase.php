<?php
    include("header.php");
    if (isset($msg) && is_a($msg,'PDOException')) {
        ?>
<script>
        if(confirm("There was a problem with the database, please try again later."));
</script>
<?php
        $this->goHome(); 
    }else if(isset($msg)){ 
?>
    <script>
        if(confirm("<?php echo $msg ?>"));
    </script>
<?php
    }
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
            <li><a id="profile" href="<?php echo FRONT_ROOT ?>User/seeUser">Profile</a></li>
            <li> <a id="exit" href="<?php echo FRONT_ROOT ?>HomePage/exit" id="EXIT"> Exit  </a></li>
        </ul>

    </nav>
</header>

<div id="containerForm">
            <h1> Movie: <?php echo $movie->getTitle(); ?> </h1>
            <h2> Cine:  <?php echo $mt->getName(); ?> </h2>
            <h3> Date:  <?php echo $show->getDate()->format("Y-m-d H:i"); ?> </h3>
            <h3> Room:  <?php echo $cinema->getNumberCinema(); ?> </h3> <br>
            <h2> Price:  $<?php echo $show->getTicket_price(); ?>/cu </h2> <br>
            <form action="<?php echo FRONT_ROOT ?>Purchase/addCreditCard" method="GET">
                <input type="hidden" name="id_show" value="<?php echo $show->getId_show();?>">
                <input type="number" name="nroEntradas" placeholder="Number of tickets " id="nroEntradas">
                <button type="submit" class="buttonBuy"> BUY </button>
            <form>
<div>