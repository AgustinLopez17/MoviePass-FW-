<?php
    include("header.php");
?>
<link rel="stylesheet" href="/MoviePass/Views/layout/styles/styleAdministration.css">
</head>
<body>
<header >

    <div id="container">
    <a id ="svg" href="<?php echo FRONT_ROOT ?>HomePage/showListView"> <?php echo file_get_contents(__DIR__."\image.svg");  ?> </a>

        <ul id="options">
            <li class="button"><a href="<?php echo FRONT_ROOT ?>Admin/showAdminMovieTheater" > Manage MovieTheater </li>
            <li class="button"><a href="<?php echo FRONT_ROOT ?>Admin/showAdminShows">Manage Shows</button></li>
            <li class="button"><a href="<?php echo FRONT_ROOT ?>Admin/showStatistics">Statistics</button></li>
        </ul>
    </div>
    
</header>

<div class="barra"></div>
<div class="barraAbajo"></div>