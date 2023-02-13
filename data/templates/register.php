<!-- templates/list.php -->
<?php $title = 'Camagru - Register' ?>

<?php ob_start() ?>
<div id="login">
    <h1>MEMBER REGISTRATION</h1>
    <form action="#" method="POST">
        <label for "uname">
            <i class="fa-solid fa-user"></i>
        </label>
        <input type="text" name="uname" placeholder="Username" required />
        <label for="mail">
            <i class="fa-solid fa-lock"></i>
        </label>
        <input type="text" name="mail" placeholder="Email" required />
        <label for="pwd">
            <i class="fa-solid fa-lock"></i>
        </label>
        <input type="password" name="pwd" placeholder="Password" required />
        <p><?= $err ?></p>
        <input value="REGISTER" type="submit" />
    </form>
    <div class="divider"></div>
    <a href="#"><button>LOGIN</button></a>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>