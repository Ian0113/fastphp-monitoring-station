<?php
$bodyFile = APP_PATH ."app/views/$this->_controller/$page/body.php";
if (is_file($bodyFile)) {
    header('HTTP/1.1 206 Partial Content');
    header('Content-Type: application/json; charset=utf-8');
    include_once $bodyFile;
}
else exit(header('HTTP/1.1 404 Not Found'));
