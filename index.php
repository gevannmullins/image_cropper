<?php

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gevann Portfolio - Home</title>

    <!-- fonts -->
    <style>
    </style>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/jquery-ui-1.8.23.custom.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="assets/css/cropper-estrutura.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="assets/css/cropper-estilo.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="assets/css/custom_styles.css" />

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery3.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/jquery.cropper.0.1.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui-1.8.23.custom.min.js"></script>




</head>
<body>

<!-- header -->
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 text-center header_container">

                Image Cropper

            </div>
        </div>
    </div>
</section>

<section class="image_upload_section">
    <div class="container-fluid">
        <div class="row">

            <!-- left side container -->
            <div class="col-xs-12 col-md-6">
                <!-- file upload form contaner -->
                <div class="col-xs-12 upload_form_container">

                    <!-- the upload form -->
                    <form class="form" id="upload_cropper_form" action="upload.php" method="POST" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="image"><h3>File Upload:</h3></label>
                            <input type="file" name="image" class="form-control" id="image">
                        </div>

                        <input type="submit" class="btn btn-default"/>
                    </form>

                </div>

            </div>

            <!-- right side container -->
            <div class="col-xs-12 col-md-6 image_info_container">
                <!-- image preview will be loaded here -->
            </div>

        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 crop_tool_container">

                <div id="cropper"></div>
                <div id="imagemFinal"></div>
            </div>
        </div>
    </div>
</section>





<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- <script src="sites_manager/assets/js/jquery3.min.js"></script>-->
<!-- <script src="sites_manager/assets/js/jquery-1.11.3.min.js"></script> -->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!-- <script src="sites_manager/assets/js/bootstrap.js"></script>-->

<script language="javascript">
    $(document).ready(function () {

        $('#upload_cropper_form').submit(function(event){
            event.preventDefault();

            $.ajax({
                url: "upload.php", // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false
                success: function(data)   // A function to be called if request succeeds
                {
                    $('#loading').hide();
                    $('.image_info_container').html(data);
                    console.log(data);
                }
            });



        });

    });

</script>


<script type="text/javascript">
    function preview(img, selection) {
        var scaleX = <?php echo $thumb_width;?> / selection.width;
        var scaleY = <?php echo $thumb_height;?> / selection.height;

        $('#thumbnail + div > img').css({
            width: Math.round(scaleX * <?php echo $current_large_image_width;?>) + 'px',
            height: Math.round(scaleY * <?php echo $current_large_image_height;?>) + 'px',
            marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
            marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
        });
        $('#x1').val(selection.x1);
        $('#y1').val(selection.y1);
        $('#x2').val(selection.x2);
        $('#y2').val(selection.y2);
        $('#w').val(selection.width);
        $('#h').val(selection.height);
    }

    $(document).ready(function () {
        $('#save_thumb').click(function() {
            var x1 = $('#x1').val();
            var y1 = $('#y1').val();
            var x2 = $('#x2').val();
            var y2 = $('#y2').val();
            var w = $('#w').val();
            var h = $('#h').val();
            if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
                alert("You must make a selection first");
                return false;
            }else{
                return true;
            }
        });
    });

    $(window).load(function () {
        $('#thumbnail').imgAreaSelect({ aspectRatio: '1:<?php echo $thumb_height/$thumb_width;?>', onSelectChange: preview });
    });

</script>
</body>
</html>
