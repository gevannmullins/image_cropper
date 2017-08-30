<?php


class imgUploadCropper
{

    // upload the image
    function imgUploader($image, $target_file)
    {
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            return "The file ". basename( $image["name"]). " has been uploaded.";
        } else {
            return "Sorry, there was an error uploading your file.";
        }
    }

    // check if the image is a real image
    function checkIfImg($image)
    {
        $check = getimagesize($image["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        return $uploadOk;
    }

    // check if the file already exist
    function checkIfExists($target_file)
    {
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        } else {
            $uploadOk = 1;
        }
        return $uploadOk;
    }

    // check the filesize
    function checkFileSize($file_size)
    {
        // Check file size
        if ($file_size > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        } else {
            $uploadOk = 1;
        }
        return $uploadOk;
    }

    // ensure we have the right format
    function checkFormat($imageFileType)
    {
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        } else {
            $uploadOk = 1;
        }
    }

    function cropImg($sourceImg, $targetImg, $xImg, $yImg, $imgWidth, $imgHeight)
    {
        $im = imagecreatefrompng($sourceImg);
        $size = min(imagesx($im), imagesy($im));
        $im2 = imagecrop($im, ['x' => $xImg, 'y' => $yImg, 'width' => $size, 'height' => $size]);
        if ($im2 !== FALSE) {
            imagepng($im2, $targetImg);
        }

        return $im2;
    }

    function cropImage($imagePath, $startX, $startY, $width, $height) {
        $imagick = new \Imagick(realpath($imagePath));
        $imagick->cropImage($width, $height, $startX, $startY);
        header("Content-Type: image/jpg");
        return $imagick->getImageBlob();
    }

    function cropImage2($x1, $x2, $y1, $y2, $src)
    {
        $x1 = $_POST['x1']; //this one gives me the point where start to crop
        $x2 = $_POST['x2']; //the end of X axis
        $y1 = $_POST['y1']; //same for Y1 and Y2
        $y2 = $_POST['y2'];
        $w  = ( $x2 - $x1 ); //getting the width for the new image
        $h  = ( $y2 - $y1 ); //getting the height for the new image

        $src  = "path_to_file";
        $info = getimagesize( $src );

        switch( $info[2] ) {
            case IMAGETYPE_JPEG:
                $copy = imagecreatefromjpeg( $src );
                $new  = imagecreatetruecolor( $w, $h );
                imagecopyresampled( $new, $copy, 0, 0, $x1, $y1, $info[0], $info[1], $w, $h );
                header( 'Content-type: image/jpeg' );
                imagejpeg( $new );
                break;
            default:
                break;
        }
        return $info;
    }

    //resize and crop image by center
    function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 80){
        $imgsize = getimagesize($source_file);
        $width = $imgsize[0];
        $height = $imgsize[1];
        $mime = $imgsize['mime'];

        switch($mime){
            case 'image/gif':
                $image_create = "imagecreatefromgif";
                $image = "imagegif";
                break;

            case 'image/png':
                $image_create = "imagecreatefrompng";
                $image = "imagepng";
                $quality = 7;
                break;

            case 'image/jpeg':
                $image_create = "imagecreatefromjpeg";
                $image = "imagejpeg";
                $quality = 80;
                break;

            default:
                return false;
                break;
        }

        $dst_img = imagecreatetruecolor($max_width, $max_height);
        $src_img = $image_create($source_file);

        $width_new = $height * $max_width / $max_height;
        $height_new = $width * $max_height / $max_width;
        //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
        if($width_new > $width){
            //cut point by height
            $h_point = (($height - $height_new) / 2);
            //copy image
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
        }else{
            //cut point by width
            $w_point = (($width - $width_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
    }

        $image($dst_img, $dst_dir, $quality);

        if($dst_img)imagedestroy($dst_img);
        if($src_img)imagedestroy($src_img);

        return $image;
    }

}