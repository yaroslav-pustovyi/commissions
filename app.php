<?php

use App\AppBootstrap;
use App\Service\FileReader;

require __DIR__ . '/vendor/autoload.php';

$file = new SplFileObject($argv[1]);
if (!$file->isFile()) {
    throw new RuntimeException(sprintf("Unable to find '%s'", $argv[1]));
}

if (!$file->isReadable()) {
    throw new RuntimeException(sprintf("Unable to open '%s'", $argv[1]));
}

$app = (new AppBootstrap())->bootstrap();
$fileReader = new FileReader();
foreach ($fileReader->readByLine($file) as $line) {
    $data = json_decode($line, true, 512, JSON_THROW_ON_ERROR);
    $result = $app->run($data);

    echo $result. PHP_EOL;
}
