# Uploader Bundle

**Warning:**
> This bundle and the documentation are still under development!

## Description
File Upload with multiple file selection, drag&drop support, progress bars, validation and preview images, audio and video.
Supports cross-domain, chunked and resumable file uploads and client-side image resizing.

The bundle is based on [jQuery File Upload](https://github.com/blueimp/jQuery-File-Upload), for which a [demo](https://blueimp.github.io/jQuery-File-Upload) and a [full list of features](https://github.com/blueimp/jQuery-File-Upload#features) are available.

## Features
*

## Installation
1. install bundle using [Composer](https://getcomposer.org)
2. install and require bundle dependencies
3. enable bundle in `app/AppKernel.php`
4. configure bundle in `app/config/config.yml`
5. create `Media` entity class

### Step 1: Install Uploader Bundle using [Composer](https://getcomposer.org)
``` bash
composer require luciantugui/uploader-bundle:dev-master
```
Uploader Bundle will be installed in `vendor/luciantugui` directory

### Step2: Install Uploader Bundle dependencies from GitHub
Since the bundle is based on [jQuery File Upload](https://github.com/blueimp/jQuery-File-Upload)
which is not available as a composer package, all dependencies must be installed manually
configuring custom [composer package repositories](https://getcomposer.org/doc/05-repositories.md#package-2) in `composer.json`:
 ``` json
 "repositories": [
     {
         "type": "package",
         "package": {
             "name": "blueimp/javascript-templates",
             "version": "master",
             "source": {
                 "url": "https://github.com/blueimp/JavaScript-Templates.git",
                 "type": "git",
                 "reference": "master"
             }
         }
     },
     {
         "type": "package",
         "package": {
             "name": "blueimp/javascript-load-image",
             "version": "master",
             "source": {
                 "url": "https://github.com/blueimp/JavaScript-Load-Image.git",
                 "type": "git",
                 "reference": "master"
             }
         }
     },
     {
         "type": "package",
         "package": {
             "name": "blueimp/javascript-canvas-to-blob",
             "version": "master",
             "source": {
                 "url": "https://github.com/blueimp/JavaScript-Canvas-to-Blob.git",
                 "type": "git",
                 "reference": "master"
             }
         }
     },
     {
         "type": "package",
         "package": {
             "name": "blueimp/gallery",
             "version": "master",
             "source": {
                 "url": "https://github.com/blueimp/Gallery.git",
                 "type": "git",
                 "reference": "master"
             }
         }
     },
     {
         "type": "package",
         "package": {
             "name": "blueimp/jquery-file-upload",
             "version": "master",
             "source": {
                 "url": "https://github.com/blueimp/jQuery-File-Upload.git",
                 "type": "git",
                 "reference": "master"
             },
             "autoload": {
                 "classmap": ["server/php/"]
             }
         }
     }
 ]
 ```
 Add previous packages to the require section in `composer.json`:
 ``` json
 "require": {
     "blueimp/jquery-file-upload": "dev-master",
     "blueimp/javascript-templates": "dev-master",
     "blueimp/javascript-load-image": "dev-master",
     "blueimp/javascript-canvas-to-blob": "dev-master",
     "blueimp/gallery": "dev-master"
}
 ```

### Step 3: Enable UploaderBundle in `AppKernel.php`
``` php
<?php
// app/AppKernel.php
$bundles = array(
    // ...
    new Gus\UploaderBundle\GusUploaderBundle(),
);
```
### Step 4: configure UploadBundle in `config.yml`
``` yml
# app/config/config.yml
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

### Step 5: create your `Media` class extending `BaseMedia`
`Media` entity class facilitates uploads persistence to the database.
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
// src/AppBundle/Entity/Media.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gus\UploaderBundle\Entity\BaseMedia;

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
*

## TODO
* composer require, doctrine bundle 1.3, symfony framework, twig
* tests
* documentation for doctrine configuration using php annotations (and xml, not only yaml)
* documentation for php form themes, not only twig
* migrate composer bundle dependencies from
[composer package repositories](https://getcomposer.org/doc/05-repositories.md#package-2)
to [composer vcs repositories](https://getcomposer.org/doc/05-repositories.md#vcs),
for this all blueimp libraries needed must be forked, so that a composer.json can be added.
The reason for this is the following note from [composer package repositories](https://getcomposer.org/doc/05-repositories.md#package-2):
```
**Note**: This repository type has a few limitations and should be avoided whenever possible:
Composer will not update the package unless you change the version field.
Composer will not update the commit references,
so if you use master as reference you will have to delete the package to force an update,
and will have to deal with an unstable lock file.
```
* ...

## License
Released under the [MIT license](http://opensource.org/licenses/MIT).
