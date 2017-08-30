<?php

//include the image class
include "imgUploadCropper.php";
$uploadCropper = new imgUploadCropper();

// get all the form values
$image = $_FILES['image'];
$file_name = $image['name'];
$file_size = $image['size'];
$file_tmp = $image['tmp_name'];
$file_type = $image['type'];
$file_ext = strtolower(end(explode('.',$file_name)));

// organise variables
$target_dir = "uploaded_images/";
$target_file = $target_dir . basename($file_name);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// upload the file for further manipulation
$uploadCropper->imgUploader($image, $target_file);




?>
<div class="col-xs-12 col-sm-8 text-right">
    <img src="uploaded_images/<?php echo $file_name; ?>" class="img-responsive" style="margin-top: 6px;" />
</div>
<div class="col-xs-12 col-sm-4">
    <p>Original mage (Not Cropped)</p>
</div>

