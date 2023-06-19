<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/Proiect/public/resources/css/base.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/header.css">
    <link rel="stylesheet" href="/Proiect/public/resources/css/admin.css">
    <script defer src="/Proiect/public/resources/js/admin.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <!-- <script defer src="../header/header.js"></script> -->
</head>
<body>
<header>
    <nav>
        <div class="logo-wrapper">
            <a href="/Public">EmoF</a>
        </div>
        <div class="actions-wrapper">
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) { ?>
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
    <section>
        <div class="users-group">
            <h2>Users</h2>
            <input type="text" id="search-users" name="search-users" placeholder="Search users">
            <div class="table-container">
                <table>
                    <tr class="column-names">
                        <th>Username</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Date of Birth</th>
                        <th>Country</th>
                        <th>Admin</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($users as $user) { ?>
                        <tr class="user-row">
                            <td class="username"><?php echo $user['username']; ?></td>
                            <td class="email"><?php echo $user['email']; ?></td>
                            <td class="gender"><?php echo $user['gender']; ?></td>
                            <td class="date-of-birth"><?php echo $user['date_of_birth']; ?></td>
                            <td class="country"><?php echo $user['country']; ?></td>
                            <td class="is-admin"><?php echo $user['is_admin']; ?></td>
                            <td>
                                <button class="delete-user">Delete</button>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>

        <div class="tags-group">
            <h2>Tags</h2>
            <div class="tags-group-buttons">
                <input type="text" id="search-tags" name="search-tags" placeholder="Search tags">
                <button id="add-tag">Add</button>
            </div>
            <ul class="tags-list">
                <?php foreach ($tags as $tag) { ?>
                    <li class="tag-element">
                        <span><?php echo $tag['name']; ?></span>
                        <button class="delete-tag">Delete</button>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </section>
</main>
</body>