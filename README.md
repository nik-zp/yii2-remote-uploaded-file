# Yii2 remote uploaded file
Upload file to remote server
## Install
The preferred way to install this extension is through [composer](http://getcomposer.org/download/). 

To install, run
```
$ php composer.phar require nik-zp/yii2-remote-uploaded-file "dev-master"
```
or add
```
"nik-zp/yii2-remote-uploaded-file": "@dev"
```
to the `require` section of your `composer.json` file.

##Usage (for example)
```
use nikzp\uploadedFile\UploadedFile;
...
$file = UploadedFile::getInstanceByName('file');
$file->saveAs('http://img.example.com/catalog/user/56/image.jpg');
```
POST: to img.example.com server with image

###Image Server
.htaccess
```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_METHOD} POST
RewriteRule ^(.*) upload.php?image=$1 [L]
```
upload.php
```
<?php
if (!empty($_FILES['file']['tmp_name']) && !empty($_GET['image'])) {
    $to = './'.$_GET['image'];
    $dir = pathinfo($to,PATHINFO_DIRNAME);
    if(!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    if (move_uploaded_file($_FILES['file']['tmp_name'], $to)) {
        echo json_encode(['success'=>true]);
    } else {
        echo json_encode(['success'=>false]);
    }
}
return;
```

