# Yii2 remote uploaded file
Загрузка файлов на удаленный сервер.
## Установка
Установка через [composer](http://getcomposer.org/download/).

Запустить

```
$ php composer.phar require nik-zp/yii2-remote-uploaded-file "dev-master"
```

или добавить

```
"nik-zp/yii2-remote-uploaded-file": "dev-master"
```

в секцию `require` в файле `composer.json`.

##Использование
На сервере приложения
```
use nikzp\uploadedFile\UploadedFile;
...
$file = UploadedFile::getInstanceByName('file');
$file->saveAs('http://img.example.com/catalog/user/56/image.jpg');
```
На сервер `http://img.example.com/` будет отправлен POST запрос с изображением.
Для сохранения на локальный север пользуемся как обычно `/path/to/dir/image.jpg`

На сервере изображений
Файл .htaccess
```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_METHOD} POST
RewriteRule ^(.*) upload.php?image=$1 [L]
```
Файл upload.php
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
Изображение будет сохранено по передаваемому пути.
