<?php
    include("header.php");

    if(isset($msg)){
?>
<script>
    if(confirm('<?php
                      if(is_a($msg,'PDOException')){
                            echo 'Error in the database, please try again later.';
                      } else {
                            echo $msg;
                      } 
                ?>')
    );
</script>
    <?php } ?>
<script src="<?php echo JS_PATH3 ?>"></script>
<link rel="stylesheet" href="/MoviePass/Views/layout/styles/styleUser.css">
</head>

<body>
    <header>

        <a href="<?php echo FRONT_ROOT ?>HomePage/showListView">
            <?php echo file_get_contents(__DIR__."\image.svg");  ?> </a>

        <nav>
            <ul id="options">
                <li><button type="button" id="button1">See profile</button> </li>
                <li><button type="button" id="button2">See purchases</button></li>
            </ul>
        </nav>

    </header>
    <div class="div1">
        <h1> Perfil </h1>
        <form id="formAlta" action="<?php echo FRONT_ROOT ?>User/modifyUser" method="POST">
            <input type="text" name="firstName" value="<?php echo $user->getFirstName(); ?>" >
            <input type="text" name="surname" value="<?php echo $user->getSurName(); ?>" >
            <input type="number" name="dni" value="<?php echo $user->getDni(); ?>" disabled >
            <input type="hidden" name="dni" value="<?php echo $user->getDni(); ?>"  >
            <input type="email" name="email" value="<?php echo $user->getEmail(); ?>" disabled >
            <button type="submit" id="submitChanges">Modify</button>
        </form>
    </div>

    <div class="div2">
        <ul>
            <?php if($allPurchases){
                foreach ($allPurchases as $value) {
                    ?>
                <li id="liDatsP"> 
                    <img src=<?php echo $value->getQr();?>  style=" widht: 20px "/>
                    <div id="datsP">
                    <p> Movie: <?php echo $this->readMovie($value->getId_show())->getTitle(); ?> </p>
                    <p> Tickets purchased: <?php echo $value->getPurchased_tickets(); ?> </p>
                    <p> Date of purchase: <?php echo $value->getDate_purchase(); ?> </p>
                    <p> Amount: <?php echo $value->getAmount(); ?> </p>
                    <p> Discount: <?php echo $value->getDiscount(); ?> </p>
                    </div>
                </li>
            <?php
                }}
            ?>
        </ul>
    </div>