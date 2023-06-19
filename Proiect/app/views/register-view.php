<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/Proiect/public/resources/css/base.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/header.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/register.css">
    <script defer src="/Proiect/public/resources/js/register.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <!-- <script defer src="../header/header.js"></script> --> 
</head>
<body>
    <header>
        <nav>
            <div class="logo-wrapper">
                <a href="/Proiect/">EmoF</a>
            </div>
            <div class="actions-wrapper">
                <a href="/Proiect/register">Register</a>
                <a href="/Proiect/login">Login</a>
                <a href="/Proiect/about">About</a>
            </div>
        </nav>
    </header>
    <main>
        <section>
            <h1>Create an account</h1>
            <?php if($errors['general'] != null) {
                echo "<p class='error-message'>" . $errors['general'] . "</p>";
            } ?>
            <form action="" method="POST" onsubmit="return validateForm()">
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
                <button type="submit">Register</button>
                <a href="login">Already have an account?</a>
            </form>
        </section>
    </main>
</body>