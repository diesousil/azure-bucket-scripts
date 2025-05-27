<?php

use MicrosoftAzure\Storage\Blob\BlobSharedAccessSignatureHelper;
use Carbon\Carbon;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

function generateConnectionString() {
    return 'DefaultEndpointsProtocol=https;AccountName=' . $_ENV["AZURE_ACCOUNT_NAME"] . ';AccountKey=' . $_ENV["AZURE_ACCOUNT_KEY"] . ';EndpointSuffix=core.windows.net';
}

function getBlobUrl($blobName) {
    $blobSasHelper     = new BlobSharedAccessSignatureHelper($_ENV["AZURE_ACCOUNT_NAME"], $_ENV["AZURE_ACCOUNT_KEY"]);
    $signedResource    = 'b'; 
    $resourceName      = $_ENV["AZURE_CONTAINER"] . '/' . $blobName;
    $signedPermissions = 'r'; 
    $now               = Carbon::now();
    $signedExpiry      = $now->addMinutes(10);

    $sasToken = $blobSasHelper->generateBlobServiceSharedAccessSignatureToken(
        $signedResource,
        $resourceName,
        $signedPermissions,
        $signedExpiry,
    );
    
    return "https://".$_ENV["AZURE_ACCOUNT_NAME"].".blob.core.windows.net/".$_ENV["AZURE_CONTAINER"]."/{$blobName}?{$sasToken}";
}

function checkDir(string $path, int $permisions = 0755): bool {
    
    if (is_dir($path)) {
        return true;
    }

    if (!mkdir($path, $permisions, true)) {        
        return false;
    }

    return true;
}

checkDir(getcwd()."/".$_ENV["OUTPUT_DIR"]);
checkDir(getcwd()."/".$_ENV["INPUT_DIR"]);