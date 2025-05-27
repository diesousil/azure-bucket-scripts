# Azure Bucket Scripts
Simple scripts to run to upload and download files from/to a azure bucket container

## How to intall

Run composer install, and then create the .env file based on .env.example. The azure setup configuration, 
output and input dir should be providen on this .env.

## How to use it

Currently it's possible to download all files for a given container to the output folder, and also upload all files from the input directory to the configured container. I've created this scripts for a file transfer task, and this is the situation that would be ideally applied fow now.

In future versions I want to implement filters that makes easier to filter what to download and what to upload.

### Downloading 

Check permissions to guarantee that it's possible to write files on the configured output dir and then run:

> composer download

All bucket files should be saved on the output dir then.

### Uploading 

First check that the files you want to upload are within the input folders, if any other files are there, they will be uploaded too.
After this checking, just run:

> composer upload

Files will be uploaded to the container and urls will be available and printed as output. One can save this output by using > operator on linux console

# TODO

I intend to implement these features on a near future:
    1. Save upload and download log files so it's possible to check with detailes what happend on the process
    2. Add filters on both scripts by file extension, size, and name part
    3. Implement a search tool to query a list of files given some filters