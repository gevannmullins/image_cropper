<?php

$image = 'image';

function returnData()
{
    $returnData = [];

    // check f the file uploaded
    if(isset($_FILES['image'])){
        $errors= array();
        // get details of the uploaded file
        $file_name = $_FILES['image']['name'];
        $file_size =$_FILES['image']['size'];
        $file_tmp =$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
        $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

        //return file information
        $returnData['file_info'] = [$file_name, $file_size, $file_type, $file_ext];

        $expensions= array("jpeg","jpg","png");
        if(in_array($file_ext,$expensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }
        if($file_size > 2097152){
            $errors[]='File size must be excately 2 MB';
        }

        // return errors
        $returnData['errors'] = $errors;

        if(empty($errors)==true){
            move_uploaded_file($file_tmp,"uploaded_images/".$file_name);
            $message = "Successfully uploaded Image";

            $success_html = '<div class="row">';
            $success_html .= '<div class="col-xs-6">';
            $success_html .= '<img src="uploaded_images/<?php echo $file_name; ?>" class="img-responsive" />';
            $success_html .= '</div>';
            $success_html .= '<div class="col-xs-6">';
            $success_html .= '<p>Image Name: <?php echo $file_name; ?></p>';
            $success_html .= '<p>File Type: <?php echo $file_type; ?></p>';
            $success_html .= '<p>File Size: <?php echo $file_size; ?></p>';
            $success_html .= '</div>';
            $success_html .= '</div>';

            $returnData['successHtml'] = $success_html;

            return $returnData;
        }else{
//        print_r($errors);
            $errors = 'No image selected.';
            $errors .= 'Please select an Image to continue';
            return $returnData;

        }
    }

}

returnData();

?>

<script type="text/javascript">
            $(function() {
                var imagem = "uploaded_images/<?php echo $_FILES['image']['name']; ?>";
                $("#cropper").cropper({
                    imageOriginal : imagem,
                    aspectRatio:true,
                    onsave   : function(finalFile) {
                        $('#imagemFinal').html('<img src='+finalFile+' />');
                    },
                    oncancel   : function(finalFile) {
                        $('#imagemFinal').html('<img src='+finalFile+' />');
                    }
                });
            });
</script>


