<?php

class Upload
{
    function uploadFile($image, $targetDir, $maxSize)
    {
        $uploadDirAndFileName = $targetDir . Session::get('userid').'_'.basename($image["uploadFile"]["name"]);
        $isUploaded = true;
        $imageFileType = strtolower(pathinfo($uploadDirAndFileName,PATHINFO_EXTENSION));

        $checkImage = getimagesize($image["uploadFile"]["tmp_name"]);
        if ($checkImage !== false)
            $isUploaded = true;
        else
            $isUploaded = false;
            
        if (file_exists($uploadDirAndFileName))
            $isUploaded = false;

        if ($image["uploadFile"]["size"] > $maxSize)
            $isUploaded = false;

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
            $isUploaded = false;

        if ($isUploaded)
            move_uploaded_file($image["uploadFile"]["tmp_name"], $uploadDirAndFileName);
            
        return $isUploaded;
    }
    
    function removeFile($uploadDir, $file)
    {
        unlink($uploadDir . $file);
    }
}

?>