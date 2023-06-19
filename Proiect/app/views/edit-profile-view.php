<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/Proiect/public/resources/css/base.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/header.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/edit-profile.css">
    <script defer src="/Proiect/public/resources/js/edit-profile.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit profile</title>
    <!-- <script defer src="../header/header.js"></script> -->
</head>
<body>
    <header>
        <nav>
            <div class="logo-wrapper">
                <a href="/Public">EmoF</a>
            </div>
            <div class="actions-wrapper">
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
            </div>
        </nav>
    </header>
    <main>
        <section>
            <h1>Edit account</h1>
            <?php if($errors['general'] != null) {
                echo "<p class='error-message'>" . $errors['general'] . "</p>";
            } ?>
            <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div class="images-group">
                    <h2>Profile Image:</h2>
                    <img src="<?php echo $profile_picture_path ?>" id='image-container' alt="Cat nods yes gif">

                    <label for="image">Change profile picture<span class="red">*</span></label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>
                <div class="username-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo $formValues['username']; ?>" placeholder="Username">
                    <?php if($errors['username'] != null) {
                        echo "<p class='error-message'>" . $errors['username'] . "</p>";
                    } ?>
                </div>

                <div class="email-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $formValues['email']; ?>" placeholder="Email">
                    <?php if($errors['email'] != null) {
                        echo "<p class='error-message'>" . $errors['email'] . "</p>";
                    } ?>
                </div>

                <div class="password-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password">
                    <?php if($errors['password'] != null) {
                        echo "<p class='error-message'>" . $errors['password'] . "</p>";
                    } ?>
                </div>

                <div class="date-of-birth-group">
                    <label for="date-of-birth">Date of birth</label>
                    <input type="date" id="date-of-birth" value="<?php echo $formValues['date-of-birth']; ?>" name="date-of-birth">
                    <?php if($errors['dateOfBirth'] != null) {
                        echo "<p class='error-message'>" . $errors['dateOfBirth'] . "</p>";
                    } ?>
                </div>

                <div class="gender-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option disabled <?php if($formValues['gender'] === '') { echo 'selected'; } ?>>Gender</option>
                        <option value="Male" <?php if($formValues['gender'] === 'Male') { echo 'selected'; } ?>>Male</option>
                        <option value="Female" <?php if($formValues['gender'] === 'Female') { echo 'selected'; } ?>>Female</option>
                        <option value="Other" <?php if($formValues['gender'] === 'Other') { echo 'selected'; } ?>>Other</option>
                    </select>
                    <?php if($errors['gender'] != null) {
                        echo "<p class='error-message'>" . $errors['gender'] . "</p>";
                    } ?>
                </div>
                <div class="phone-group">
                    <label for="phone-number">Phone Number</label>
                    <input type="tel" id = "phone-number" value = "<?php echo $formValues['phone']; ?>" placeholder="123-45-678" pattern="[+0-9]{1,3}-?[0-9]{2,3}-?[0-9]{2,4}-?[0-9]{3,4}">
                    <?php if($errors['phone'] != null) {
                        echo "<p class='error-message'>" . $errors['phone'] . "</p>";
                    } ?>
                </div>
                <div class="country-group">
                    <label for="country">Country</label>
                    <input type="text" id="country" name="country" value="<?php echo $formValues['country']; ?>" placeholder="Country">
                    <?php if($errors['country'] != null) {
                        echo "<p class='error-message'>" . $errors['country'] . "</p>";
                    } ?>
                    <div class="container-dropdown">
                        <div id="country-list" class="dropdown">
                            <ul id="country-list-items">
                                <!-- List items -->
                            </ul>
                        </div>
                    </div>
                </div>
                <button type="submit">Edit</button>
            </form>
        </section>
    </main>
</body>