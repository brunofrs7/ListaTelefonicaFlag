<?php

class functions
{
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

    public static function removeImage($id){
        $target_dir = "../inc/img/contacts/";
        $target_file = $target_dir . $id . ".png";
        if (file_exists($target_file)) {
            unlink($target_file);
            return true;
        }
        return false;
    }

    public static function uploadImage($new_contact_id, $photo)
    {
        // https://www.w3schools.com/php/php_file_upload.asp

        $target_dir = "../inc/img/contacts/";
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
