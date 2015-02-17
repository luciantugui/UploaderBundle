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
2. enable bundle in `app/AppKernel.php`
3. configure bundle in `app/config/config.yml`
4. create `Media` entity class

### Step 1: Install Uploader Bundle using [Composer](https://getcomposer.org)
``` bash
composer require luciantugui/uploader-bundle:dev-master
```
Uploader Bundle will be installed in `vendor/luciantugui` directory

### Step 2: Enable UploaderBundle in `app/AppKernel.php`
``` php
<?php
// app/AppKernel.php
$bundles = array(
    // ...
    new Gus\UploaderBundle\GusUploaderBundle(),
);
```
### Step 3: configure UploadBundle in `app/config/config.yml`
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
Bundle configuration `media_class` specifies the doctrine entity class which will store the media files (described in the next step),
`uploads_dir` configures the directory where the files will be uploaded
and `settings` holds configuration options for the [UploadHandler](https://github.com/blueimp/jQuery-File-Upload/blob/master/server/php/UploadHandler.php)

### Step 4:
Having a bundle `/src/AppBundle` and using `yaml` for Doctrine configuration,
add `Media.orm.yml` entity configuration and `Media.php` class as follows:
``` yml
# /src/AppBundle/Resources/config/doctrine/Media.orm.yml
AppBundle\Entity\Media:
    type: entity
    table: media
    id:
        id:
            type: integer
            nullable: false
            unsigned: false
            comment: ''
            id: true
            generator:
                strategy: IDENTITY
```
``` php
<?php
//src/AppBundle/Entity/Media.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gus\UploaderBundle\Entity\BaseMedia;

/**
 * Class Media
 * @package AppBundle\Entity
 */
class Media extends BaseMedia
{
    public function __construct()
    {
        parent::__construct();
    }
}

```
> Note that `Media` class extends `BaseMedia`, the constructor should not be overridden without calling `parent::__construct()`

## Usage

## TODO
* composer dependencies, doctrine bundle 1.3, symfony framework, twig
* tests
* documentation using php annotations (and xml, not only yaml)

## License
Released under the [MIT license](http://opensource.org/licenses/MIT).