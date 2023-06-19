<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Statistics</title>
    <link rel="stylesheet" href="/Proiect/public/resources/css/base.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/header.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/give-statistics.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
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
            <a href="/Proiect/logout">Logout</a>
            <a href="/Proiect/statistics">Statistics</a>
        </div>
        <!-- <div class = "mobile-wrapper">
            <div id  = "mobile-links">
                <a href="#" id = "active">Home</a>
                <a href="#">Create</a>
                <a href="#">About</a>
                <a href="#">Login</a>
                <a href="#">Register</a>
                <a href="#">Profile</a>
            </div>
            <button id = "hamburger-menu"><i class = "fa fa-bars"></i></button>
        </div> -->
    </nav>
</header>
<main>
    <div id="containers-column">
        <div id="container-div">
            <div class="container-one">
                <div class="select-btn">
                    <span class="btn-text">Components</span>
                    <span class="arrow-dwn">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                </div>
                <ul class="list-items">
                    <li class="item">
                        <input type="checkbox" name="selectedComponents[]" value="-1" id="form">
                        <label class="item-text" for="form">Form</label>
                    </li>
                    <?php
                    $i = 1;
                    if($formular != null) {
                        foreach($formular->components as $key => $component) {
                            //                    echo ('<li class="item">
                            //                          <span class="checkbox">
                            //                            <i class="fa-solid fa-check check-icon"></i>
                            //                          </span>
                            //                          <span class="item-text">Component' . $i .'</span>
                            //                          </li>');
                            echo ('<li class="item"><input type="checkbox" name="selectedComponents[]" value="' . $component->id . '" id="' .$component->id.'">');
                            echo ('<label class="item-text" for="'. $component->id .'">Component ' .$i. '</label></li>');
                            $i += 1;
                        }
                    }
                    echo ('<li class="item"><input type="checkbox" name="selectedComponents[]" value="0" id="overall">');
                    echo ('<label class="item-text" for="overall">Overall</label></li>');
                    ?>
                </ul>
            </div>
            <div class="container-two">
                <div class="select-btn">
                    <span class="btn-text">Age of the users</span>
                    <span class="arrow-dwn">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                </div>
                <ul class="list-items">
                    <?php
                    echo ('<li class="item"><input type="checkbox" id="under18" name="selectedAges[]" value="Under 18 years" >');
                    echo ('<label class="item-text" for="under18">Under 18 years</label></li>');
                    echo ('<li class="item"><input type="checkbox" id="age1829" name="selectedAges[]" value="18-29 years" >');
                    echo ('<label class="item-text" for="age1829">18-29 years</label></li>');
                    echo ('<li class="item"><input type="checkbox" id="age3039" name="selectedAges[]" value="30-39 years" >');
                    echo ('<label class="item-text" for="age3039">30-39 years</label></li>');
                    echo ('<li class="item"><input type="checkbox" id="age4049" name="selectedAges[]" value="40-49 years" >');
                    echo ('<label class="item-text" for="age4049">40-49 years</label></li>');
                    echo ('<li class="item"><input type="checkbox" id="age5059" name="selectedAges[]" value="50-59 years" >');
                    echo ('<label class="item-text" for="age5059">50-59 years</label></li>');
                    echo ('<li class="item"><input type="checkbox" id="over60" name="selectedAges[]" value="60 years or older" >');
                    echo ('<label class="item-text" for="over60">Over 60 years</label></li>');
                    echo ('<li class="item"><input type="checkbox" id="anyAge" name="selectedAges[]" value="Any age" >');
                    echo ('<label class="item-text" for="anyAge">Any age</label></li>');
                    ?>
                </ul>
            </div>
            <div class="container-three">
                <div class="select-btn">
                    <span class="btn-text">Any time</span>
                    <span class="arrow-dwn">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                </div>
                <ul class="list-items">
                    <?php
                    echo ('<li class="item"><input type="radio" id="now" name="time" value="Any time" checked>');
                    echo ('<label class="item-text" for="now" onclick="changeTitle(this)">Any time</label></li>');
                    echo ('<li class="item"><input type="radio" id="1h" name="time" value="One hour ago">');
                    echo ('<label class="item-text" for="1h" onclick="changeTitle(this)">Last hour</label></li>');
                    echo ('<li class="item"><input type="radio" id="6h" name="time" value="6 hours ago">');
                    echo ('<label class="item-text" for="6h" onclick="changeTitle(this)">Last 6 hours</label></li>');
                    echo ('<li class="item"><input type="radio" id="12h" name="time" value="12 hours ago">');
                    echo ('<label class="item-text" for="12h" onclick="changeTitle(this)">Last 12 hours</label></li>');
                    echo ('<li class="item"><input type="radio" id="24h" name="time" value="24 hours ago">');
                    echo ('<label class="item-text" for="24h" onclick="changeTitle(this)">Last day</label></li>');
                    echo ('<li class="item"><input type="radio" id="1w" name="time" value="One week ago">');
                    echo ('<label class="item-text" for="1w" onclick="changeTitle(this)">Last week</label></li>');
                    echo ('<li class="item"><input type="radio" id="1m" name="time" value="One month ago">');
                    echo ('<label class="item-text" for="1m" onclick="changeTitle(this)">Last month</label></li>');
                    echo ('<li class="item"><input type="radio" id="1y" name="time" value="1 year ago">');
                    echo ('<label class="item-text" for="1y" onclick="changeTitle(this)">Last year</label></li>');
                    ?>
                </ul>
            </div>
            <button id="verify">Check</button>
        </div>
    </div>
    <div class="pie_chart"></div>
</main>
<script src="/Proiect/public/resources/js/give-statistics.js"></script>
</body>
</html>