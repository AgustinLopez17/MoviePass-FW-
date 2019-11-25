<?php
    include("header.php");
    if (isset($msg) && is_a($msg,'PDOException')) {
        ?>
<script>
        if(confirm("There was a problem with the database, please try again later."));
</script>
<?php
        $this->goHome(); 
    }else{ ?>
<link rel="stylesheet" href="/MoviePass/Views/layout/styles/stylePurchase.css">
</head>
<body background="<?php echo $movie->getBackground(); ?>" >
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
            <form action="<?php echo FRONT_ROOT ?>Purchase/listDats" method="GET" id="FORM_ID">
                <select name="fecha" id="selectFecha">    
                <option selected disabled hidden> Dates </option>
                    <?php foreach($avShows as $value){ ?>
                            <option value="<?php echo $value->getId_show(); ?>"> Date: <?php echo $value->getDate()->format("Y-m-d H:i"); ?>  </option>
                            <?php } ?>
                </select>
                <button type="submit" id="submitButton"></button>
            <form>

<div>

<script>
    document.getElementById('FORM_ID').fecha.onchange = function() {
        document.getElementById('submitButton').click();
    };
</script>

    <?php } ?>