<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo (isset($title))?$title : "monitoring-station
" ?></title>
    <link rel="stylesheet" href="/static/css/global.css">
    <link rel="stylesheet" href="/static/css/dropdown.css">
    <link rel="stylesheet" href="/static/css/container.css">
</head>
<body>
    <?php include_once APP_PATH .'app/views/layouts/includes/navbar.php' ?>

<div class="content">
    <div class="content-header">
        <!-- put description in content header -->
        <?php
        $headerFile = APP_PATH ."app/views/$this->_controller/header.php";
        if (is_file($headerFile)) include_once $headerFile;
        ?>
    </div>
    <div class="content-body">
        <!-- display content in content body -->
        <?php
        $bodyFile = APP_PATH ."app/views/$this->_controller/body.php";
        if (is_file($bodyFile)) include_once $bodyFile;
        else exit(header('HTTP/1.1 404 Not Found'));
        ?>
    </div>
    <div class="content-footer">
        <!-- put js or others in content footer -->
        <?php
        $footerFile = APP_PATH ."app/views/$this->_controller/footer.php";
        if (is_file($footerFile)) include_once $footerFile;
        ?>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
          integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
          <script src="/static/js/test.js"></script>
    </div>
</div>
</body>
</html>
<?php
