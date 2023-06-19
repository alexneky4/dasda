<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Proiect/public/resources/css/base.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/header.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script defer src = "/Proiect/public/resources/js/home.js"></script>
    <script defer src = "/Proiect/public/resources/js/timer.js"></script>
    <title>Home</title>
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
    <div class = "main-display">
        <aside>
            <div class="user-info  aside-div">
                <img src="<?php echo $profile_picture_path ?>" alt = "Profile picture" class = "profile-picture"/>
                <?php
                    echo ('<p>' . $name . '</p>');
                ?>
            </div>
            <div class="tags aside-div">
                <ul>
<!--                    <li><input type="checkbox"><label> Persons</label></li>-->
<!--                    <li><input type="checkbox"><label> Product</label></li>-->
<!--                    <li><input type="checkbox"><label> Service</label></li>-->
<!--                    <li><input type="checkbox"><label> Hospitals</label></li>-->
<!--                    <li><input type="checkbox"><label> Games</label></li>-->
<!--                    <li><input type="checkbox"><label> Events</label></li>-->
<!--                    <li><input type="checkbox"><label> Hotels</label></li>-->
                    <?php
                        if($tags !== null) {
                            foreach ($tags as $i => $tag) {
                                echo ('<li><input type="checkbox" name="selectedTags[]" value="' . $tag->id . '"><label for="' . $tag->id . '">' . $tag->name . '</label></li>');
                            }
                        }
                        else
                            echo ('<li><label>' . $error_tags . '</label></li>');
                    ?>
                </ul>
                <?php
                    if($tags !== null)
                    {
                        echo '<button id = "submit-tags"> Submit </button>';
                    }
                ?>
            </div>
        </aside>
        <main>

            <?php
                if($forms === null) {
                    echo('<p>' . $error_forms . '</p>');
                }
                else
                {
                    echo '<div class="search-div">
                            <input type="text" placeholder="Search..." name="search" id = "search-bar">
                                <!--<button type="submit"><i class="fa fa-search"></i></button>-->
                           </div>';
                    foreach($forms as $i => $form)
                    {
                        echo ('<article class = "form-info">');
                        echo('<div class = "clicked-image"><img src="/Proiect/public/resources/images/forms/' .$form->main_image);
                        echo('"alt="Form picture" class = "form-picture"></div>');
                        echo('<a href = "give-feedback/' .$form->id. '"class="form-link">');
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
<!--            <article class = "form-info">-->
<!--                    <div class = "clicked-image"><img src="public/resources/images/mountains.jpg" alt="Form picture" class = "form-picture"></div>-->
<!--                    <a href = "give-feedback" class="form-link">-->
<!--                            <div class = "name_and_time">-->
<!--                                <h1>Carpathian Mountains</h1>-->
<!--                                <p>1:08:45</p>-->
<!--                            </div>-->
<!--                            <div class = "text-wrapper">-->
<!--                                <p>The Carpathian Mountains represent a mountain range, belonging to the great central mountain system of Europe. The Carpathians included between the Vienna Basin (which separates it from the Alpine chain) and the Timocului Corridor (which separates it from Stara Planina, in the Balkan Peninsula) form an arc with a length of about 1,700 km and a maximum width of 130 km, unfolding along 6° in latitude and about 10° in longitude. The Carpathian Mountains span the territory of seven countries: the Czech Republic (3%), Slovakia (17%), Poland (10%), Hungary (4%), Ukraine (11%), Romania (51%) and Serbia (4%).</p>-->
<!--                            </div>-->
<!---->
<!--                    </a>-->
<!--            </article>-->
<!--            <article class = "form-info">-->
<!--                <div class = "clicked-image"><img src="public/resources/images/Everest.jpg" alt="Form picture" class = "form-picture"></div>-->
<!--                <a href = "give-feedback" class="form-link">-->
<!--                        <div class = "name_and_time">-->
<!--                            <h1>Everest Mountains</h1>-->
<!--                            <p>2:23:08</p>-->
<!--                        </div>-->
<!--                        <div class="text-wrapper">-->
<!--                            <p>Mount Everest is the highest point on Earth, with an altitude of 8848 m above sea level. It is located in the Himalayas at coordinates 27°59'20.62" N and 86°55'28.27" E (coordinates checked on Google Earth 26/11/06), on the border between Nepal and Tibet (China). In Nepali the name of the mountain is सगरमाथा, Sagarmāthā (Mother of the ocean), and in Tibet it is known as Chomolungma (mother of the universe). The English name, Everest, was given in honor of the British surveyor Sir George Everest.</p>-->
<!--                        </div>-->
<!---->
<!--                </a>-->
<!--            </article>-->
<!--            <article class = "form-info">-->
<!--                <div class = "clicked-image"><img src="public/resources/images/game.png" alt="Form picture" class = "form-picture"></div>-->
<!--                <a href = "give-feedback" class="form-link">-->
<!--                        <div class = "name_and_time">-->
<!--                            <h1>Starcraft II</h1>-->
<!--                            <p>0:16:33</p>-->
<!--                        </div>-->
<!--                        <div class="text-wrapper">-->
<!--                            <p>StarCraft II is a military science fiction video game created by Blizzard Entertainment as a sequel to the hit video game StarCraft released in 1998. Set in a fictional future, the game focuses on a galactic struggle for dominance between various fictional StarCraft races. StarCraft II's single-player campaign is divided into three chapters, each of which focuses on one of three races: StarCraft II: Wings of Liberty (released in 2010), Heart of the Swarm (2013), and Legacy of the Void (2015). A final campaign pack called StarCraft II: Nova Covert Ops was released in 2016.</p>-->
<!--                        </div>-->
<!--                </a>-->
<!--            </article>-->
<!--            <article class = "form-info">-->
<!--                <div class = "clicked-image"><img src="public/resources/images/hotel.jpg" alt="Form picture" class = "form-picture"></div>-->
<!--                <a href = "give-feedback" class="form-link">-->
<!--                        <div class = "name_and_time">-->
<!--                            <h1>Burj Al Arab</h1>-->
<!--                            <p>1:02:11</p>-->
<!--                        </div>-->
<!--                        <div class="text-wrapper">-->
<!--                            <p>Burj al-Arab (Arabic برج العرب, in translation: "Tower of the Arabs") is a luxury hotel in Dubai, known as the only seven-star hotel in the world, officially classified as five-star deluxe, designed by the architect British Tom Wright. At 321 meters high it is the tallest building in the world used exclusively as a hotel. It is located on a man-made island 280m from Jumeirah Beach, connected to the shore by a private curved bridge.</p>-->
<!--                        </div>-->
<!--                </a>-->
<!--            </article>-->
        </main>
    </div>
</body>
</html>
