<?php

use App\App;

require_once __DIR__ . "/vendor/autoload.php";

try {
    $app = new App();
    echo $app->run();
} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
}