<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Proiect/public/resources/css/base.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/header.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/statistics.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script defer src = "/Proiect/public/resources/js/statistics.js"></script>
    <script defer src = "/Proiect/public/resources/js/timer.js"></script>
    <title>Statistics</title>
</head>
<body>
    <header>
        <nav>
            <div class="logo-wrapper">
                <a href="/Proiect">EmoF</a>
            </div>
            <div class="actions-wrapper">
                <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) { ?>
                    <a href="/Proiect/admin">Admin</a>
                <?php } ?>
                <a href="/Proiect/home">Home</a>
                <a href="/Proiect/create-form">Create</a>
                <a href="/Proiect/profile">Profile</a>
                <?php
                if(isset($_SESSION['id']))
                    echo '<a href="logout">Logout</a>';
                else
                    echo '<a href="/Proiect/login"> Login </a>'
                ?>
                <a href="statistics">Statistics</a>
            </div>
            <div class = "mobile-wrapper">
                <div id  = "mobile-links">
                    <a href="#" id = "active">Home</a>
                    <a href="#">Create</a>
                    <a href="#">About</a>
                    <a href="#">Login</a>
                    <a href="#">Register</a>
                    <a href="#">Profile</a>
                </div>
                <button id = "hamburger-menu"><i class = "fa fa-bars"></i></button>
            </div>
        </nav>
    </header>
        <main>
            <?php
            if($forms === null) {
                echo '<p> There are no available statistics at the moment</p>';
            }
            else
            {
                echo '<div class="search-div">
                        <input type="text" placeholder="Search..." name="search" id = "search-bar">
                        <!--                    <button type="submit"><i class="fa fa-search"></i></button>-->
                     </div>';
                foreach($forms as $i => $form)
                {
                    echo ('<article class = "form-info">');
                    echo('<div class = "clicked-image"><img src="public/resources/images/forms/' .$form->main_image);
                    echo('"alt="Form picture" class = "form-picture"></div>');
                    echo('<a href = "give-statistics/' .$form->id. '"class="form-link">');
                    echo('<div class = "name_and_time">');
                    echo('<h1 class = "title">' . $form->name . '</h1>');
                    echo('<p class = "timer">' . formatTimeRemaining($form->ending_date) . '</p>');
                    echo('</div>');
                    echo('<div class = "text-wrapper">');
                    echo('<p class = "description">' . $form -> description . '</p>');
                    echo('</div>');
                    echo('</a>');
                    echo('</article>');
                }
            }
            ?>
        </main>
</body>
</html>
