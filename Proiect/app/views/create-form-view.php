<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/Proiect/public/resources/css/base.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/header.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/create-form.css">
    <script defer src="/Proiect/public/resources/js/create-form.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Feedback Request Form - EmoF</title>
    <!-- <script defer src="../header/header.js"></script> --> 
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
        <?php if($success == 'true') {
            echo "<div class='success-message-group'>";
            echo "<h2 class='success-message'>The form with the name <span class='bold-gray'>$formName</span> created successfully!</h2>";
            echo "<a href='/Proiect/give-feedback/$formId'>Click here to view the form made!</a>";
            echo "</div>";
        } else { ?>
        <section class="main-section">
            <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                <section class="main-details-section">
                    <h1>Feedback Request Form</h1>
                    <?php if($error) {
                        echo "<p class='error-message'>" . $error . "</p>";
                    } ?>
                    <h2>Complete the following details in order to create a new form:</h2>
                    <div class="form-name-group">
                        <label for="form-name">Form name <span class="red">*</span></label>
                        <input type="text" id="form-name" name="form-name" placeholder="Form name" required>
                        <?php if($errorFormName) {
                            echo "<p class='error-message'>" . $errorFormName . "</p>";
                        } ?>
                    </div>
                
                    <div class="description-group">
                        <label for="form-description">Description <span class="red">*</span></label>
                        <textarea id="form-description" name="form-description" rows="8" required></textarea>
                    </div>

                    <div class="main-image-group">
                        <label for="image">Main Image for the form <span class="red">*</span></label>
                        <input type="file" id="image" name="main-image" accept="image/*" required>
                    </div>

                    <div class="images-group">
                        <label for="images">Other Images</label>
                        <input type="file" id="images" name="images[]" accept="image/*" multiple>
                    </div>

                    <div class="tags-group">
                        <h2>Tags:</h2>

                        <?php if($tags) {
                        foreach($tags as $tag) { ?>
                            <div class="tag-group">
                                <input type="checkbox" id="<?php echo $tag['name'] ?>" name="tags[]" value="<?php echo $tag['name'] ?>">
                                <label for="<?php echo $tag['name'] ?>"><?php echo $tag['name'] ?></label>
                            </div>
                        <?php }} else echo "<p> No tags exist yet!</p>" ?>
                    </div>
                </section>


                <section class="components-section">
                    <h1>Components you wish to get feedback on:</h1>
                    <div class="all-components-group">
                        <div class="group-component">
                            <div class="component-name-group">
                                <label for="component-1">Component Name <span class="red">*</span></label>
                                <div class="component-name-input-group">
                                    <input type="text" class="input-component-name" name="component-1" placeholder="Component name" required>
                                    <button type="button" class="remove-component-button" onclick="removeComponent(event)">X</button>
                                </div>
                            </div>

                            <div class="component-description-group">
                                <label for="component-1-description">Component Description</label>
                                <textarea id="component-1-description" name="component-1-description" rows="5"></textarea>
                            </div>

                            <div class="component-image-group">
                                <label for="component-1-images">Any images you wish to add for this component</label>
                                <input type="file" id="component-1-images" name="component-1-images[]" accept="image/*" multiple>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-component-button" onclick="createInputComponent()">Add another component</button>
                </section>

                <section class="settings-section">
                    <div class="expiration-date-group">
                        <label for="expiration-date">Expiration date <span class="red">*</span></label>
                        <input type="datetime-local" id="expiration-date" name="expiration-date" placeholder="Expiration date" required>
                    </div>

                    <div class="statistics-public-or-private-group">
                        <legend>Should the statistics for this form be public? <span class="red">*</span> </legend>
                        <label><input type="radio" name="statistics-public-or-private" value="1" required>Yes</label>
                        <label><input type="radio" name="statistics-public-or-private" value="0" required>No</label>
                    </div>

                    <div class="hide-after-expiration-group">
                        <legend>Should the form still be available to be seen for the public after the expiration date? <span class="red">*</span> </legend>
                        <label><input type="radio" name="hide-after-expiration" value="1" required>Yes</label>
                        <label><input type="radio" name="hide-after-expiration" value="0" required>No</label>
                    </div>
                </section>

                <button type="submit">Create new form</button>
            </form>
        </section> <?php } ?>
    </main>
</body>