<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>编辑个人资料&nbsp;|&nbsp;Willcloudy</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/css.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.js" integrity="sha512-oqBsjjSHWqkDx4UKoU+5IUZN2nW2qDp2GFSKw9+mcFm+ZywqfBKp79nfWmGPco2wzTWuE46XpjtCjZ9tFmI12g==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.css" integrity="sha512-949FvIQOibfhLTgmNws4F3DVlYz3FmCRRhJznR22hx76SKkcpZiVV5Kwo0iwK9L6BFuY+6mpdqB2+vDIGVuyHg==" crossorigin="anonymous" />
    <?php
        session_start();
        include('include/connection.php');
        if (isset($_SESSION['user_email'])) {
            $user = $_SESSION['user_email'];
            $get_user = "select * from users where user_email = '$user'";
            $run_user = mysqli_query($con, $get_user);
            $row = mysqli_fetch_array($run_user);
            $user_id = $row['user_id'];
            $user_image = $row['user_image'];
            $user_name = $row['user_name'];
            $user_cover = $row['user_cover'];
            $user_des = $row['user_des'];
            $user_country = $row['user_country'];
            $user_gender = $row['user_gender'];
            echo $user_gender;
            if ($user_gender = '1') {
                echo '<script>document.getElementById("selector").options[0].selected=true</script>';
            }elseif ($user_gender = '0') {
                echo '<script>document.getElementById("selector").options[1].selected=true;</script>';
            }elseif ($user_gender = '2') {
                echo '<script>document.getElementById("selector").options[2].selected=true;</script>';
            }
        }else {
        header('location:home.php?from=login');
        }

    ?>
</head>
<style>
    body{
        overflow-x:hidden;
        background-color:#f6f6f6;
    }
    .well{
        min-height:70px;
        background-color:white;
        margin-bottom:0;
    }
    h1{
        margin-top:-30px;
        margin-left:-50px;
        margin:0 auto;
        font-size: 35px;
        font-weight: bold;
        margin:0 0 0px;
        font-family: 'Pacifico', sans-serif;
    }
    .avatar{
        margin:0px;
        padding:0px;
        position:absolute;
        top:70px;
        left:20px;
        border:2px solid white;
    }
    .info, .des{
        margin-top:10%;
        color:black;
        font-weight: bold;
        font-size:1.3em;
        margin-left:10%;
        width:100%;
    }
    .info input, .des input, .des select{
        border:0;
        border-bottom:1px solid grey;
        color:black;
        font-weight: bold;
        font-size:1em;
        width:50%;
        float:right;
        margin-right:20%;
        
    }
    .info input:focus, .des input:focus,.des select:focus{
        outline:none;
        border-bottom:2px solid #00BFFF;
        transition:0.5s;
    }
    .submit_btn{
        font-weight:bold;
        color: #00BFFF;
        border:1px solid #00BFFF;
        border-radius: 2px;
        background:white;
        font-size:1.5em;
        float:right;
        margin-right:10%;
        margin-bottom:5%;
    }
    .submit_btn:focus{
        outline:none;
    }
    .submit_btn:hover{
        background:#00BFFF;
        color:white;
        border:1px solid white;
        border-radius: 2px;
    }
    /* #uploaded_image:hover{
        border:5px solid #00BFFF;
        transition:0.3s;
    } */
    #img_camera{
        display:none;
        position: absolute;
        width: 10%;
        top: 14%;
        left: 7%;
        color:grey;
    }
    #uploaded_image:hover #img_camera{
        display:inline-block;
    }
    
    .uploaded_cover{
        position:relative;
    }
    #cover_camera{
        display:none;
        position:absolute;
        width: 23%;
        position: absolute;
        left: 35%;
        top: -7%;
        color:grey;
    }
    #uploaded_cover:hover #cover_camera{
        display:inline-block;
    }
    #uploaded_cover:hover{
        filter: blur(2px);
    }

</style>
<body>
<div class="row">
        <div class="col-sm-12" style='wdith:100%;padding:0'>
            <div class="well">
                <div class="center" style="text-align:center">
                    <h1>WillCloudy</h1>
                </div>
            </div>
        </div>    
    </div>
    <div class="col-md-4 midbar" style='padding:0;margin-left:33%;margin-top:1%;margin-bottom:3%'>
        <div class="box" style='margin-top:0;position:relative'>
            <div class="cover_area">   
                <form action="" method='POST' enctype='multipart/form-data'>
                    <label for="upload_cover" width='100%' >
                        <div id="uploaded_cover" style='width:505px'>
                        <img src="<?php echo $user_cover;?>" alt="cover" width='100%' height='100px'style='margin:0;padding:0;border-radius:10px 10px 0px 0px'>
                            <svg id='cover_camera' viewBox="0 0 16 16" class="bi bi-camera" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M15 12V6a1 1 0 0 0-1-1h-1.172a3 3 0 0 1-2.12-.879l-.83-.828A1 1 0 0 0 9.173 3H6.828a1 1 0 0 0-.707.293l-.828.828A3 3 0 0 1 3.172 5H2a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                                <path fill-rule="evenodd" d="M8 11a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                <path d="M3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                            </svg>
                        </div>
                    </label>
                    <input type="file" name='u_cover' class='form-control' id='upload_cover' accept="image/*" style='display:none'>
                </form>
            </div> 
            <div class="modal fade" id="modal_cover" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style='width:100%'>
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">裁剪背景</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style='margin:15%'>
                            <div class="img-container">
                                <img alt="simple_image" id='simple_image_cover' class='img-responsive'>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <button type="button" id='crop_cover' class="btn btn-primary">保存</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="img_area">   
                <form action="" method='POST' enctype='multipart/form-data'>
                    <label for="upload_image" >
                        <div id="uploaded_image">
                            <img src="<?php echo $user_image;?>" alt="avatar" width='16%' class='img-circle avatar'>
                            <svg id='img_camera' viewBox="0 0 16 16" class="bi bi-camera" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M15 12V6a1 1 0 0 0-1-1h-1.172a3 3 0 0 1-2.12-.879l-.83-.828A1 1 0 0 0 9.173 3H6.828a1 1 0 0 0-.707.293l-.828.828A3 3 0 0 1 3.172 5H2a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                                <path fill-rule="evenodd" d="M8 11a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                <path d="M3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                            </svg>
                        </div>
                    </label>
                    <input type="file" name='u_image' class='form-control' id='upload_image' accept="image/*" style='display:none'>
                </form>
                <span style='margin-left:20%;color:grey;font-weight:bold;'>点击头像上传新头像</span>
            </div> 
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style='width:100%'>
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">裁剪头像</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style='margin:0 auto;padding:50px'>
                            <div class="img-container">
                                <img alt="simple_image" id='simple_image' class='img-responsive'>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <button type="button" id='crop' class="btn btn-primary">保存</button>
                        </div>
                    </div>
                </div>
            </div>
            <form action="" method='POST'>
                <p class='info'>昵称:<input required name='edited_name'type="text" value='<?php echo $user_name;?>'></p>
                <br>
                <p class="des">个人简介<small style='color:grey'>(15个字)</small>:<input required name='edited_des' type="text" value='<?php echo $user_des;?>' maxlength=15></p>
                <br>
                <p class="des" >性别:
                    <select id="selector" name='edited_gender'>
                        <option value="1">男</option>
                        <option value="0">女</option>
                        <option selected value="2">保密</option>
                    </select>
                </p>
                <br>
                <p class="des">目前所在国家: <input type="text" name='edited_country' required value='<?php echo $user_country;?>'></p>
                <br>
                <br>
                <button type='submit' name='submit'class='submit_btn'>保存</button>
                <a href="<?php echo "profile.php?u_id=$user_id"; ?>" style='float:right;margin-right:5%;margin-top:1.5%'>返回</a>
            </form>
            <?php
                if (isset($_POST['submit'])) {
                    $edited_name = $_POST['edited_name'];
                    $edited_des = $_POST['edited_des'];
                    $edited_gender = $_POST['edited_gender'];
                    $edited_country = $_POST['edited_country'];
                    $update_info = "UPDATE `users` SET `user_name`= '$edited_name',`user_des`='$edited_des',`user_country`='$edited_country',`user_gender`='$edited_gender' where user_id ='$user_id'";
                    $run_update = mysqli_query($con, $update_info);
                    if ($run_update) {
                        echo "<script>alert('修改成功')</script>";
                        echo "<script>window.open('profile.php?u_id=$user_id','_self')</script>";
                    }else {
                        echo "<script>alert('修改失败')</script>";
                    }
                }
            ?>
        </div>
</body>
</html>
<script>
    
    $(document).ready(function(){
        var $modal = $('#modal');

        var image = document.getElementById('simple_image');
        
        var cropper;

        $('#upload_image').change(function(event){
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
                        url:'update.php',
                        method:'POST',
                        data:{image:base64data},
                        success:function(data){
                            $('#modal').modal('hide');
                            $('#uploaded_img').attr('src', data);
                        }
                    })
                }
            })
        });

    });


    $(document).ready(function(){
        var $modal = $('#modal_cover');

        var image = document.getElementById('simple_image_cover');
        
        var cropper;

        $('#upload_cover').change(function(event){
            var files = event.target.files;

            var done = function(url){
                image.src = url;
                $('#modal_cover').modal('show');
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

        $('#modal_cover').on('shown.bs.modal', function(){
            cropper = new Cropper(image,{
                aspectRatio:5.68/1,
                viewMode:3,
                preview:$('.preview'),
                width: 960,
                height:540
            });
        }).on('hidden.bs.modal', function(){
            cropper.destroy();
            cropper = null
        });

        $('#crop_cover').click(function(){
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
                        url:'update.php',
                        method:'POST',
                        data:{bc_image:base64data},
                        success:function(data){
                            $('#modal_cover').modal('hide');
                            $('#uploaded_cover').attr('src', data);
                        }
                    })
                }
            })
        });

    });
</script>