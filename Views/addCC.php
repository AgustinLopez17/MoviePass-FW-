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

<div class="creditCardForm">
        <h1>Add CreditCard</h1>
        <form action="<?php echo FRONT_ROOT ?>Purchase/completePurchase" method="POST">
            <div class="inputs">
                <br>
                Card number
                <input type="number" name="cardNumber" required>
            </div>
            <div class="inputs">
                <br>
                CVV
                <input type="number" name="code" required>
            </div>
            <div class="inputs">
                <br>
                DNI
                <input type="number" name="dni" value="<?php echo $_SESSION["loggedUser"]->getDni(); ?>" readonly>
            </div>

            <br><label>Expiration Date</label> <br>
            <select required name="expireMonth">
                <option value="01">January</option>
                <option value="02">February </option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
            <select required name="expireYear">
                <option value="2020"> 2020</option>
                <option value="2021"> 2021</option>
                <option value="2022"> 2022</option>
                <option value="2023"> 2023</option>
                <option value="2024"> 2024</option>
                <option value="2025"> 2025</option>
            </select>
            <input type="hidden" name="id_show" value="<?php echo $id_show ?>">
            <input type="hidden" name="numberOfTickets" value="<?php echo $numberOfTickets ?>">
            <input type="hidden" name="finalPrice" value="<?php echo $finalPrice ?>">
            <?php if(isset($discount)){ ?>
                <p id="discount"> Discount: $<?php echo $discount ?>
            <?php 
                ?>  <input type="hidden" name="discount" value="<?php echo $discount ?>">
                <?php } ?>
            <br><br><p> Final price: $<?php echo $finalPrice ?> </p>
            <div class="form-group" id="pay-now">
                <br>
                <button class="buttonAddCC" type="submit">Confirm</button>
            </div>
        </form>
</div>
