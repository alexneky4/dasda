<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/Proiect/public/resources/css/base.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/header.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/give-feedback.css">
    <script defer src="/Proiect/public/resources/js/give-feedback.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Give Feedback - EmoF</title>
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
        </nav>
    </header>
    <main>
        <?php if(isset($form['error'])) {
            echo "<div class='no-form-message-group'>";
            echo "<h2 class=''>There's no form with the given id!</h2>";
            echo "<a href='/Proiect/home'>Click here to return to home page!</a>";
            echo "</div>";
        } else if($success) {
            echo "<div class='success-message-group'>";
            $message = "Successfully gave feedback for the form with the name <span class='bold-gray'>$formName</span>!";
            if($edit) {
                $message = "Successfully edited the feedback for the form with the name <span class='bold-gray'>$formName</span>!";
            }
            echo "<h2 class='success-message'>$message</h2>";
            echo "<a href='/Proiect/home'>Click here to return to home!</a>";
            echo "</div>";
        } else { ?>
        <section class="main-section">
            <form action="/Proiect/give-feedback/<?php echo $form_id?>" method="POST" onsubmit="return validateForm()">
                <section class="info-section">
                    <div class="description-group">                
                        <h1><?php echo $formName; ?></h1>
                        <?php if(isset($_GET['error'])) { ?>
                            <h2 class="error-message"><?php echo $_GET['error']; ?></h2>
                        <?php } ?>
                        <h2>Description: <?php echo $formDescription; ?></h2>
                    </div>

                    <div class="images-group">
                        <h2>Images:</h2>
                        <?php if($images) {
                            if(count($images) == 1) {?>
                                <img src="/Proiect/public/resources/images/forms/<?php echo $images[0]; ?>" alt="Image">
                            <?php } else { ?>
                            <div id="carousel" class="carousel" data-index="0">
                                <?php foreach($images as $index => $image) { ?>
                                    <div class="carousel-item <?php if ($index == 0) echo 'active'; ?>">
                                        <img src="/Proiect/public/resources/images/forms/<?php echo $image; ?>" alt="Image">
                                    </div>
                                <?php } ?>
                                <a class="carousel-control-prev" role="button">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" role="button">
                                    <span class="sr-only">Next</span>
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </a>
                            </div>
                        <?php } } else {
                            echo "<h3>There are no images for this form!</h3>";
                        } ?>
                    </div>

                    <p class="required-message"><span id="red-text">*</span> Means that it is required to be filled!</p>
                </section>

                
                <section class="give-feedback-main-section">
                    <h2>How does this make you feel overall?</h2>
                    <div class="emotion-group">
                        <label for="choose-emotion-main">Choose an emotion <span id="red-text">*</span></label>
                        <input type="text" id="choose-emotion-main" class="input-emotion" name="choose-emotion-main" placeholder="Write the emotion here" value="<?php echo isset($_GET['emotion-main']) ? $_GET['emotion-main'] : ''?>"required>
                        <div class="container-dropdown">
                            <div class="emotion-list dropdown">
                                <ul class="emotion-list-items">
                                    <!-- List items -->
                                </ul>
                            </div>
                        </div>
                        <?php if(isset($_GET['emotion-main-error'])) { ?>
                            <h2 class="error-message"><?php echo $_GET['emotion-main-error']; ?></h2>
                        <?php } ?>
                    </div>

                    <div class="explain-emotion-group">
                        <label for="explain-emotion">What made you feel that way?</label>
                        <textarea id="description" name="explain-emotion" rows="5" value="<?php echo isset($_GET['description-main']) ? $_GET['description-main'] : '' ?>"></textarea>
                    </div>
                </section>

                <?php if($components) {
                    for($i = 0; $i < count($components); $i++) { ?>
                <section class="give-feedback-component-<?php echo $i ?>-section">
                    <?php if($i == 0) { ?>
                            <h1>Components</h1>
                    <?php } ?>
                    <h2>Title: <?php echo $components[$i]['name']; ?> </h2>
                    <h2>Description: <?php echo $components[$i]['description'] ? $components[$i]['description'] : 'No description' ; ?> </h2>
                    <?php if($components[$i]['images'] != []) { ?>
                        <h2>Images:</h2>
                        <?php if(count($components[$i]['images']) == 1) { ?>
                            <img src="/Proiect/public/resources/images/forms/<?php echo $components[$i]['images'][0]; ?>" alt="Image">
                        <?php } else { ?>
                        <div class="carousel" data-index="0">
                            <?php foreach($components[$i]['images'] as $index => $image) { ?>
                                <div class="carousel-item <?php if ($index == 0) echo 'active'; ?>">
                                    <img src="/Proiect/public/resources/images/forms/<?php echo $image; ?>" alt="Image">
                                </div>
                            <?php } ?>
                            <a class="carousel-control-prev" role="button">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" role="button">
                                <span class="sr-only">Next</span>
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </a>
                        </div><?php } }
                    else {?> <h2>Images: No images</h2> <?php } ?>
                    <h2>How does this component make you feel?</h2>
                    <div class="emotion-group">
                        <label for="choose-emotion-component-<?php echo $i?>">Choose an emotion <span id="red-text">*</span></label>
                        <input type="text" id="choose-emotion-component-<?php echo $i?>" class="input-emotion" name="choose-emotion-component-<?php echo $components[$i]['id']?>" value="<?php $id_component = $components[$i]['id']; echo isset($_GET["choose-emotion-component-$id_component"]) ? $_GET["choose-emotion-component-$id_component"] : '' ?>" placeholder="Write the emotion here" required>
                        <div class="container-dropdown">
                            <div class="emotion-list dropdown">
                                <ul class="emotion-list-items">
                                    <!-- List items -->
                                </ul>
                            </div>
                        </div>
                        <?php $component_id = $components[$i]['id']; if(isset($_GET["emotion-component-$component_id-error"])) { ?>
                            <h2 class="error-message"><?php echo $_GET["emotion-component-$component_id-error"]; ?></h2>
                        <?php } ?>
                    </div>

                    <div class="explain-emotion-group">
                        <label for="explain-emotion-<?php echo $i ?>">What made you feel that way?</label>
                        <textarea id="description-<?php echo $i ?>" name="explain-emotion-component-<?php echo $components[$i]['id'] ?>" value="<?php $id_component = $components[$i]['id']; echo isset($_GET["explain-emotion-component-$id_component"]) ? $_GET["explain-emotion-component-$id_component"] : '' ?>" rows="5"></textarea>
                    </div>
                </section>
                <?php } } ?>
                
                <button type="submit">Submit response</button>
            </form>
        </section> <?php } ?>
    </main>
</body>