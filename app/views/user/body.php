<?php

$bodyFile = "app/views/$this->_controller/$page/body.php";
if (is_file($bodyFile)) include_once $bodyFile;
else exit(header('HTTP/1.1 404 Not Found'));
