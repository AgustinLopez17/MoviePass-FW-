<?php
    include("header.php");
    if (isset($msg) && is_a($msg,'PDOException')) {
        ?>
<script>
        if(confirm("Error in the database, please try again later."));
</script>
<?php
        $this->goHome(); 
    }else { ?>
<link rel="stylesheet" href="/MoviePass/Views/layout/styles/stylePurchase.css">
</head>
<body background="<?php echo $movie->getBackground(); ?>">
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

<section id="banner">
    <div id="container">
        <table class>
            <tr>
                <?php foreach ($avMT as $value) { ?>
                    <td> 
                        <div class="container"> <p> <?php echo $value->getName();  ?> </p> </div>
                        <div class="continue"> <a href="<?php echo FRONT_ROOT ?>Purchase/continuePurchase?id_mt=<?php echo $value->getId(); ?>&id_movie=<?php echo $movie->getId(); ?>  " >Continue</a> <div>
                </td>
                <?php } ?>
            </tr>
            
        </table>
    </div>
</section>
                <?php } ?>