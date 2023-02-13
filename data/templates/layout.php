<!-- templates/layout.php -->
<!DOCTYPE html>
<html>

<head>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans">
    <link rel="stylesheet" href="/styles.css" />
</head>

<body>
    <?php if ($msg) : ?>
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <p><?= $msg ?></p>
            </div>

        </div>
    <?php endif ?>
    </div>
    <?= $navbar ?>
    <?= $content ?>
    <script src="https://kit.fontawesome.com/5aa08eb32c.js" crossorigin="anonymous"></script>
    <script src="/script.js"></script>
</body>

</html>