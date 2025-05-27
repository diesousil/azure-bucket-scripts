# Azure Bucket Scripts

Simple scripts to upload and download files to/from an Azure Bucket container

## How to intall

Run the composer installation and then create the .env file based on .env.example. The Azure access settings and the outgoing and incoming directories must be provided in this .env.

## How to use it

Currently, it's possible to download all the files from a given container to the output folder and also upload all the files from the input directory to the configured container. I created these scripts for a file transfer task, and that's the situation these scripts ideally apply to for now..

In future versions, I want to implement filters to make it easier to filter what should be downloaded and what should be uploaded.

### Downloading 

Check the permissions to make sure you can write files to the configured output directory and then run:

> composer download

All bucket files will be saved in the output directory.

### Uploading 

First, check that the files you want to upload are inside the input folders; if there are other files there, they will also be uploaded.
After this check, simply run:

> composer upload

The files will be loaded into the container and the URLs will be available and printed as output. You can save this output using the > operator in the Linux console

# TODO

I plan to implement these features in the near future:

1. Saving upload and download log files so that you can check in detail what happened in the process
2. Add filters to both scripts by file extension, size and part of the name
3. Implement a search tool to consult a list of files based on certain filters.