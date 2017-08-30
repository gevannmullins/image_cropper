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
    <link rel="stylesheet" href="assets/css/croppic.css" />
    <link rel="stylesheet" href="assets/css/custom_styles.css" />

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery3.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/croppic.js"></script>
<!--    <script type="text/javascript" src="assets/js/jquery.imgareaselect.pack.js" > </script>-->
<!--    <script type="text/javascript" src="assets/js/jquery.cropper.0.1.js"></script>-->
<!--    <script type="text/javascript" src="assets/js/jquery-ui-1.8.23.custom.min.js"></script>-->

</head>
<body>


<section class="image_upload_section">
    <div class="container-fluid">
        <div class="row">

            <!-- file upload form contaner -->
            <div class="col-xs-12 col-md-4 upload_form_container">

                <div class="col-xs-12">
                    <!-- the upload form -->
                    <form class="form-horizontal" id="upload_cropper_form" action="upload.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="image">Image Upload:</label>
                            <input type="file" name="image" class="form-control" id="image">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-default"/>
                        </div>
                    </form>
                </div>

            </div>

            <!-- right side container -->
            <div class="col-xs-12 col-md-8 image_info_container">
                <!-- image info will be loaded here -->
            </div>

        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 original_image_container">



            </div>
        </div>
    </div>
</section>

<style>
    #yourId {
        width: 400px;
        height: 250px;
        position:relative; /* or fixed or absolute */
    }
</style>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 cropped_image_container">



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
                dataType: 'text',
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false
                success: function(data)   // A function to be called if request succeeds
                {
                    console.log(data);
                    $('.image_info_container').html(data);
                    $('.original_image_container').html(data);

                    $.ajax({
                        url: "crop.php",
                        type: "POST",
                        data: new FormData(this),
                        dataType: 'text',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(origData)
                        {
                            console.log(origData);
                            $('.original_image_container').html(origData);
                            $('.cropped_image_container').html(origData);

                            $.ajax({
                                url: "imgUpload.php",
                                type: "POST",
                                data: new FormData(this),
                                dataType: 'text',
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function(cropData)
                                {
                                    console.log(cropData);
                                    $('.cropped_image_container').html(cropData);

                                }
                            });


                        }
                    });


                }
            });




        });


        var cropperHeader = new Croppic('yourId');


    });

</script>

</body>
</html>
