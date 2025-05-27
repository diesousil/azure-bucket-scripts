<?php

require __DIR__ . '/../vendor/autoload.php';
require "common.php";

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;

function processDownload() {
    $connectionString = generateConnectionString();

    $marker = null;
    $allBlobs = [];
    $options = new ListBlobsOptions();
    $options->setMaxResults(2);

    $blobClient = BlobRestProxy::createBlobService($connectionString);

    do {
        if ($marker !== null) {
            $options->setMarker($marker); 
        }
        
        $blobsList = $blobClient->listBlobs($_ENV["AZURE_CONTAINER"], $options);
        $allBlobs = array_merge($allBlobs, $blobsList->getBlobs());
        
        $marker = $blobsList->getNextMarker(); 
        $marker = null;
    } while ($marker !== null);

    $found = count($allBlobs);
    $saved = 0;

    foreach ($allBlobs as $blob) {
        $destinationPath = $_ENV["OUTPUT_DIR"] . "/" . $blob->getName();
        $blobUrl = getBlobUrl($blob->getName());
        $result = file_put_contents($destinationPath, file_get_contents($blobUrl));

        if($result !== false)
            $saved++;
    }

    echo "$saved files saved from $found found\n";
}

processDownload();