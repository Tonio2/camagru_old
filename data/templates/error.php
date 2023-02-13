<!-- templates/list.php -->
<?php $title = 'Camagru - ' . $code ?>

<?php require "navbar.php"; ?>

<?php ob_start() ?>
<p><?= $msg ?></p>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>