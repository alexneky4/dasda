<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Proiect/public/resources/css/base.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/header.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script defer src="/Proiect/public/resources/js/profile.js"></script>
    <script defer src="/Proiect/public/resources/js/timer.js"></script>
    <title>Profile</title>
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
                <a href="/Proiect/about">About</a>
                <?php
                    if(isset($_SESSION['id']))
                        echo '<a href="logout">Logout</a>';
                    else
                        echo '<a href="login"> Login </a>'
                ?>

                <a href="statistics">Statistics</a>
            </div>
        </nav>
    </header>
    <div class = "main-template">
        <aside>
                <div class = "profile-info">
                <div class = "profile-picture">
                    <img src="<?php echo $profile_picture_path?>" alt = "Profile picture"/>
                </div>
                <div class = "user-info">
                    <?php
                        if(isset($_SESSION['id']))
                        {
                            echo ('<p>Username: <span id = "username">' .$_SESSION['username']. '</span></p>');
                            echo ('<p>Email: ' .$_SESSION['email']. '</p>');
                            if($_SESSION['date_of_birth'] != '')
                                echo ('<p>DOB: ' .$_SESSION['date_of_birth']. '</p>');
                            else
                                echo '<p>DOB: N/A </p>';
                            if($_SESSION['phone_number'] != '')
                                echo ('<p>Phone number: ' .$_SESSION['phone_number']. '</p>');
                            else
                                echo '<p>Phone number: N/A</p>';
                            echo ('<p>Country/region: ' .$_SESSION['country']. '</p>');
                            echo ('<p>Gender: ' .$_SESSION['gender']. '</p>');
                        }
                        else
                        {
                            echo ('<p>Username: <span id = "username">Anonim</span></p>');
                            echo ('<p>Email: -</p>');
                            echo ('<p>Phone number: -</p>');
                            echo ('<p>Country/region: -</p>');
                            echo ('<p>Gender: -</p>');
                        }
                        echo ('<p> Number of forms created:' .count($forms_created). '</p>');
                        echo ('<p> Number of forms taken:' .count($forms_taken). '</p>');
                    ?>
                </div>
            </div>
            <?php
                if(isset($_SESSION['id']))
                {
                    echo '<div id = "edit-button-group">
                            <button id = "edit-button">Edit Profile</button>
                           </div>';
                }
            ?>
        </aside>
        <main class = "profile-details">
            <div id = "completed-forms-list">
                <?php
                if(!empty($forms_taken))
                {
                    foreach($forms_taken as $i => $form) {
                        echo '<section class = "complete-form-info">';
                        echo '<div class = "form-info">';
                        echo('<h1>' . $form->name. '</h1>');
                        echo '<div class = "time-form">';
                        echo ('<p>' .$form->ending_date. '</p>');
                        echo ('<p class = "timer">' .formatTimeRemaining($form->ending_date). '</p>');
                        echo '</div> </div>';
                        echo '<div class = "progress-bar-container">
                                <div class="progress-bar">
                            <div class="progress"></div>
                                </div>';
                        echo ('<span class="progress-percent">' .($form->division * 100). '%</span>');
                        echo '</div>
                            <div class ="percentage-progress">';
                        echo ('<span class="value-percent">' .($form->division * 100). '</span>');
                        echo '</div>
                            </section>';
                    }
                    if(count($forms_taken) === 3)
                        echo '<button id="load-taken" class = "load-button">More</button>';
                }
                else {
                    echo '<p>You have not taken any forms yet</p>';
                }
                ?>
            </div>
            <div id = "created-forms-list">
                <?php
                    if(!empty($forms_created))
                    {
                        foreach($forms_created as $i => $form) {
                            echo '<section  class = "created-form">';
                            echo "<a href='/Proiect/give-statistics/$form->id'>";
                            echo '<div class = "form-info">';
                            echo('<h1>' . $form->name. '</h1>');
                            echo '<div class = "time-form">';
                            echo ('<p>' .$form->ending_date. '</p>');
                            echo ('<p class = "timer">' .formatTimeRemaining($form->ending_date). '</p>');
                            echo '</div> </div> <div class = "text-wrapper">';
                            echo('<p>' . $form -> description . '</p>');
                            echo '</div></a></section>';
                        }
                        if(count($forms_created) === 3)
                            echo '<button id="load-created" class = "load-button">More</button>';
                    }
                    else {
                        echo '<p>You have not created any forms yet</p>';
                    }
                ?>
            </div>
        </main>
    </div>
</body>
</html>