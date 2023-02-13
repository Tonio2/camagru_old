<!-- templates/list.php -->
<?php $title = 'Camagru - Login' ?>

<?php ob_start() ?>
<div id="login">
    <h1>MEMBER LOGIN</h1>
    
    <form action="#" method="POST">
        <label for "uname">
            <i class="fa-solid fa-user"></i>
        </label>
        <input type="text" name="uname" placeholder="Username"  />
        <label for="pwd">
            <i class="fa-solid fa-lock"></i>
        </label>
        <input type="password" name="pwd" placeholder="Password" required />
        <p><?= $err ?></p>
        <input value="LOGIN" type="submit" />
    </form>
    <p class="subtext">Forgot password ? <a href="#">Click here</a></p>
    <div class="divider"></div>
    <a href="/index.php/register"><button>REGISTER</button></a>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>