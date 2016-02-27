<?php

namespace nikzp\uploadedFile;

// use Yii;
// use yii\db\ActiveRecord;
// use common\components\AppActiveQuery as ActiveQuery;

class UploadedFile extends \yii\web\UploadedFile
{

    /**
     * overload save function
     */
    public function saveAs($file, $deleteTempFile = true)
    {
        if (parse_url($file,PHP_URL_SCHEME) != '') {
            $post = [ 'file'=> new \CURLFile($this->tempName, mime_content_type($this->tempName), 'file') ];
            $ch = curl_init($file);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            $ret = json_decode($result,true);
            if ($ret !== null && isset($ret['success']) && $ret['success'] === true) {
                return true;
            }
            return false;
        }
        return parent::saveAs($file, $deleteTempFile);
    }
}