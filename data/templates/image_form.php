<!-- templates/list.php -->
<?php $title = 'Camagru - Upload Image' ?>

<?php require "templates/navbar.php" ?>

<?php ob_start() ?>
<div id="upload">
    <h1>UPLOAD IMAGE</h1>
    <p><?= $msg ?></p>    
    <form action="#" method="POST" enctype="multipart/form-data">
        <label for "file">
            <i class="fa-solid fa-user"></i>
        </label>
        <input type="file" name="file" placeholder="Username"  />
        <input value="UPLOAD" type="submit" />
    </form>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>