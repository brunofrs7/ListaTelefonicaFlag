<?php

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class functions
{
    public static function logger($message, $mode, $params = [])
    {
        // create a log channel
        $log = new Logger('LOG');
        $log->pushHandler(new StreamHandler('mylog.log'));

        // add records to the log

        switch ($mode) {
            case 'debug':
                $log->debug($message, $params);
                break;
            case 'info':
                $log->info($message, $params);
                break;
            case 'notice':
                $log->notice($message, $params);
                break;
            case 'warning':
                $log->warning($message, $params);
                break;
            case 'error':
                $log->error($message, $params);
                break;
            case 'critical':
                $log->critical($message, $params);
                break;
            case 'alert':
                $log->alert($message, $params);
                break;
            case 'emergency':
                $log->emergency($message, $params);
                break;
            default:
                $log->info($message, $params);
                break;
        }
    }

    public static function generateLink($size = 100)
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $size; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    public static function removeImage($id, $folder = "contacts")
    {
        $target_dir = "../inc/img/$folder/";
        $target_file = $target_dir . $id . ".png";
        if (file_exists($target_file)) {
            unlink($target_file);
            return true;
        }
        return false;
    }

    public static function uploadImage($new_contact_id, $photo, $folder = "contacts")
    {
        // https://www.w3schools.com/php/php_file_upload.asp

        $target_dir = "../inc/img/$folder/";
        $target_file = $target_dir . $new_contact_id . ".png";

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($photo["tmp_name"]);
            if ($check !== false) {
                //echo "File is an image - " . $check["mime"] . ".";
            } else {
                return [
                    'status' => 'error',
                    'message' => "File is not an image."
                ];
            }
        }

        // Check if file already exists, if true remove the older
        if (file_exists($target_file)) {
            unlink($target_file);
        }

        // Check file size
        if ($photo["size"] > 5000000000) {
            return [
                'status' => 'error',
                'message' => "Sorry, your file is too large."
            ];
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            return [
                'status' => 'error',
                'message' => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."
            ];
        }

        if (move_uploaded_file($photo["tmp_name"], $target_file)) {
            return [
                'status' => 'success',
                'message' => "The file " . htmlspecialchars(basename($photo["name"])) . " has been uploaded."
            ];
        } else {
            return [
                'status' => 'error',
                'message' => "Sorry, there was an error uploading your file."
            ];
        }
    }
}
