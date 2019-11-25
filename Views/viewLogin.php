<?php
    include("header.php");
?>

<script src="<?php echo JS_PATH2 ?>"></script>
<link rel="stylesheet" href="/MoviePass/Views/layout/styles/style.css">

</head>

<body id="body">
<?php if (isset($datosIncorrectos) && $datosIncorrectos) { ?>
    <script>
        if(confirm('Incorrect data, try again!'));
        // window.location = '../index.php';
    </script>
<?php } ?>

<?php if (isset($huboProblema) && $huboProblema) { ?>    
    <script> 
        if(confirm('There was a problem processing the data, try again!'));
    </script>
<?php  } ?>

<?php if (isset($msg) && is_a($msg,'PDOException')) { ?>    
    <script> 
        if(confirm('There was a problem with the database, please try again later. '));
    </script>
<?php  } else if( isset($msg) ) { ?>
    <script> 
        if(confirm('<?php echo $msg ?>'));
    </script>
<?php $this->goBack(); } ?>




<header></header>
    <img src="<?php echo IMG_PATH."logo.png" ?>" alt="MoviePass" class="logo">
    <p class="title">MoviePass</p>
    <div id="scroller">
        <div class="container">
            <h1>Welcome</h1>
            <form action="<?php echo FRONT_ROOT ?>HomePage/login" method="POST">
                <input type="text" name="email" placeholder="Type your email" required>
                <input type="password" name="password" placeholder="Type your password" required>
                <button type="submit" class="submit">Log In</button> <p class="or">or</p>
                <button type="button" id="register">Sign Up</button>
            </form>
        </div>

        <div id="sign-up">
            <form action="<?php echo FRONT_ROOT ?>Register\register" method="POST">
                <input type="text" name="firstName" placeholder="Type your first name" required>
                <input type="text" name="surName" placeholder="Type your surname" required>
                <input type="number" name="dni" placeholder="Type your dni" required>
                <input type="email" name="email" placeholder="Type your email" required>
                <input type="password" name="pass" placeholder="Type your password" required>
                <button type="submit" class="submit">Sign Up</button> <p class="or">or</p>
                <button type="button" id="back">Back</button>
            </form>
        </div>
    </div>
<footer></footer>
</body>