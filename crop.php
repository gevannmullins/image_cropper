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
$target_dir = "cropped_images/";
$target_file = $target_dir . basename($file_name);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

$uploadCropper->cropImg('uploaded_images/' . $file_name, $target_file, 10, 10, 200, 200);

$uploadCropper->cropImage('uploaded_images/' . $file_name, 20, 20, 150, 150);

$uploadCropper->cropImage2(20, 20, 20, 150, 'uploaded_images/' . $file_name);

//usage example
$uploadCropper->resize_crop_image(100, 100, 'uploaded_images/' . $file_name, $target_file);

?>
<div class="col-xs-12 text-right">
    <img src="uploaded_images/<?php echo $target_file; ?>" class="img-responsive" style="margin-top: 6px;" />
</div>



