<!-- templates/list.php -->
<?php $title = 'Camagru - Home' ?>

<?php require "navbar.php"; ?>

<?php ob_start() ?>
<h1>Welcome <?=$_SESSION['uname']?></h1>
<ul>
<?php foreach ($imgs as $img): ?>
    <li><img src="<?php echo $img["image"] ?>" alt="No image"/></li>
<?php endforeach ?>
</ul>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>