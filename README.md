# Uploader Bundle

## Under development
This bundle and the documentation are still under development

## Description
File Upload with multiple file selection, drag&drop support, progress bars, validation and preview images, audio and video.
Supports cross-domain, chunked and resumable file uploads and client-side image resizing.

The bundle is based on [jQuery File Upload](https://github.com/blueimp/jQuery-File-Upload), for which a [demo](https://blueimp.github.io/jQuery-File-Upload) and a [full list of features](https://github.com/blueimp/jQuery-File-Upload#features) are available.

## Features
*

## Installation
1. install bundle using [Composer](https://getcomposer.org)
2. enable bundle in AppKernel.php
3. configure bundle in app/config/config.yml

### Step1: Install Uploader Bundle using [Composer](https://getcomposer.org)
``` bash
composer require luciantugui/uploader-bundle:dev-master
```
Uploader Bundle will be installed in `vendor/luciantugui` directory

### Step2: Enable UploaderBundle in AppKernel.php
``` php
$bundles = array(
    // ...
    new Gus\UploaderBundle\GusUploaderBundle(),
);
```
### Step3: configure UploadBundle in app/config/config.yml
``` yml
gus_uploader:
    media_class: Bike\ProductBundle\Entity\Media
    uploads_dir: 'uploaded/'
    settings:
        upload_dir: 'files/'
        upload_url: '/files/'
        user_dirs: false
        download_via_php: false
        accept_file_types: '/.+$/i'
        inline_file_types: '/\.(gif|jpe?g|png)$/i'
        print_response: true
        mkdir_mode: 0755
        readfile_chunk_size: 10485760
        max_file_size: null
        min_file_size: 1
        max_number_of_files: null
        correct_image_extensions: false
        max_width: null
        max_height: null
        min_width: 1
        min_height: 1
        discard_aborted_uploads: true
        image_library: 1
        image_versions:
            original:
                auto_orient: true
#            medium:
#                max_width: 800
#                max_height: 600
            thumbnail:
#                crop: false
                max_width: 80
                max_height: 80
```
## Usage

## TODO
* composer dependencies, doctrine bundle 1.3, symfony framework, twig
* tests

## License
Released under the [MIT license](http://opensource.org/licenses/MIT).