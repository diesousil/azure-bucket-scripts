<?php

require __DIR__ . '/../vendor/autoload.php';
require "common.php";

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\BlobSharedAccessSignatureHelper;

function processUpload() {
    
    $connectionString = generateConnectionString();
    $blobClient       = BlobRestProxy::createBlobService($connectionString);

    $files = scandir($_ENV["INPUT_DIR"]);
    array_splice($files, 0 , 2);
    
    $found = count($files);
    $uploaded = 0;

    foreach($files as $file) {
        
        $path = $_ENV["INPUT_DIR"] . "/" . $file;
        $content = fopen($path, 'r');
        try {
            $blobClient->createBlockBlob($_ENV["AZURE_CONTAINER"], $file, $content);
            $newUrl = getBlobUrl($file);
            $uploaded++;
            echo "$file => $newUrl \n";
        } catch(ServiceException $ex) {
            echo "File {$file} failed! \n ";
        }
    }

    echo "{$uploaded} upload files from {$found}.\n";
}

processUpload();