<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/Proiect/public/resources/css/base.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/header.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/login.css">
    <script defer src="/Proiect/public/resources/js/login.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
</head>
<body>
    <header>
        <nav>
            <div class="logo-wrapper">
                <a href="/Proiect">EmoF</a>
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
            <h1>Login</h1>
            <?php if($errors['general'] != null) {
                echo "<p class='error-message'>" . $errors['general'] . "</p>";
            } ?>
            <?php if(strlen($message) > 0) {
                echo "<p class='success-message'>" . $message . "</p>";
            } ?>
            <form action="" method="POST" onsubmit="return validateForm()">
                <div class="username-group">
                    <label for="username">Username </label>
                    <input type="text" id="username" name="username" value="<?php echo $formValues['username']; ?>" placeholder="Username">
                    <?php if($errors['username'] != null) {
                        echo "<p class='error-message'>" . $errors['username'] . "</p>";
                    } ?>
                </div>
                <div class="password-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password">
                    <?php if($errors['password'] != null) {
                        echo "<p class='error-message'>" . $errors['password'] . "</p>";
                    } ?>
                </div>
                <button type="submit">Login</button>
                <a href="register" class="login-link">Need an account?</a>
            </form>
        </section>
    </main>
</body>