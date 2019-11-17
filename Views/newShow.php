
<link rel="stylesheet" href="/MoviePass/Views/layout/styles/styleNewShow.css">
</head>

<body>

<header >

    <a href="<?php echo FRONT_ROOT ?>HomePage/showListView"> <?php echo file_get_contents(__DIR__."\image.svg");  ?> </a>
    
</header>
<div class="barra"></div>
        <div class="addShowHour">
            <h1 id="titleAddShow">Insert hour</h1>
            <form action="<?php echo FRONT_ROOT ?>Show/addHour" method = "GET">
                    <input type="hidden" name="id_cinema" value="<?php echo $id_cinema; ?>">
                    <input type="hidden" name="id_movie" value="<?php echo $id_movie; ?>">
                    <input type="hidden" name="date" value="<?php echo $date; ?>">
                    <input type="time" name="time">
                <button type="submit">Add Show</button>
            </form>
        </div>
<div class="barraAbajo"></div>

        
</body>