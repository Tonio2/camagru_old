<?php ob_start() ?>
<div class="navbar">
    <div class="logo">
        <h1>CAMAGRU</h1>
    </div>
    <?php if ($_SESSION['loggedin'] == TRUE) : ?>
        <ul>
            <li><a href="/index.php/upload">Add Image</a></li>
            <li><a href="/index.php/profile">Profile</a></li>
            <li><a href="/index.php/logout">Logout</a></li>
        </ul>
    <?php else : ?>
        <ul>
            <li><a href="/index.php/login">Login</a></li>
        </ul>
    <?php endif ?>
</div>
<?php $navbar = ob_get_clean() ?>