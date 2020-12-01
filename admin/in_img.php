<?php
    $uni_name_zh = $_GET['uni_name_zh'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin - Willcloudy</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script> 
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.js" integrity="sha512-oqBsjjSHWqkDx4UKoU+5IUZN2nW2qDp2GFSKw9+mcFm+ZywqfBKp79nfWmGPco2wzTWuE46XpjtCjZ9tFmI12g==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.css" integrity="sha512-949FvIQOibfhLTgmNws4F3DVlYz3FmCRRhJznR22hx76SKkcpZiVV5Kwo0iwK9L6BFuY+6mpdqB2+vDIGVuyHg==" crossorigin="anonymous" />
</head>
<body>
    <form action="in_info.php" method='POST' enctype='multipart/form-data'>
        <div class='form-group' style='width:500px; margin:0 auto;margin-top:60px;'>
            <h2><?php echo "<div id='uni_name_zh'>$uni_name_zh</div>";?>的图片</h2>
            <input type="text"  name='uni_name_zh' value=<?php echo $uni_name_zh ?> readonly>
            <label for="uni_icon">学校校徽</label>
            <input type="file" name='uni_icon' class='form-control' id='uni_icon' accept="image/*">
            
            <a href="in_info.php"><button type='submit' name='submit'>提交</button></a>
        </div>
    </form>
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">裁剪图片</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="img-container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="" alt="simple_image" id='simple_image' class='img-responsive'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" id='crop' class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
</body>
</html>

<script>
    
    $(document).ready(function(){
        var $modal = $('#modal');

        var image = document.getElementById('simple_image');
        
        var cropper;

        $('#uni_icon').change(function(event){
            var files = event.target.files;

            var done = function(url){
                image.src = url;
                $('#modal').modal('show');
            };
            
            if (files && files.length > 0) 
            {
                reader = new FileReader();
                reader.onload = function(event){
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $('#modal').on('shown.bs.modal', function(){
            cropper = new Cropper(image,{
                aspectRatio:1,
                viewMode:3,
                preview:$('.preview'),
                width: 150,
                height: 150
            });
        }).on('hidden.bs.modal', function(){
            cropper.destroy();
            cropper = null
        });

        $('#crop').click(function(){
            canvas = cropper.getCroppedCanvas({
                width:400,
                height:400
            });

            canvas.toBlob(function(blob){
                url = URL.createObjectURL(blob);
                var reader =new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function(){
                    var base64data = reader.result;
                    $.ajax({
                        url:'upload.php',
                        method:'POST',
                        data:{image:base64data,
                            uni_name_zh:$("#uni_name_zh").text(),},
                        success:function(data){
                            $('#modal').modal('hide');
                            $('#uni_img').attr('src', data);
                        }
                    })
                }
            })
        });

    });
</script>

