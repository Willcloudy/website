<?php
    include('../include/connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>admin - Willcloudy</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script> 
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.js" integrity="sha512-oqBsjjSHWqkDx4UKoU+5IUZN2nW2qDp2GFSKw9+mcFm+ZywqfBKp79nfWmGPco2wzTWuE46XpjtCjZ9tFmI12g==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.css" integrity="sha512-949FvIQOibfhLTgmNws4F3DVlYz3FmCRRhJznR22hx76SKkcpZiVV5Kwo0iwK9L6BFuY+6mpdqB2+vDIGVuyHg==" crossorigin="anonymous" />
</head>
<body>
    <div class="container">
        <div class="col-md-2" style='border:1px solid red'>
            <div class="nav">
            <h2>Admin</h2>
                <ul style='list-style:none;'>
                    <li><a href="">大学信息</a></li>
                    <li><a href="">插入大学</a></li>
                    <li><a href=""></a></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>
        <div class="col-md-8" style='border:1px solid red'>
            <form action="insert_uni.php" method='GET'>
                <div class='form-group'>
                <h2 >录入大学信息</h2>
                    <label for="uni_name_en">学校英文名</label>
                    <input type="text" name='uni_name_en' placeholder="英文大学名称" class='form-control' id='uni_name_en' required="required">
                    
                    <label for="uni_name_zh">学校中文名</label>
                    <input type="text" name='uni_name_zh' placeholder="中文大学名称" class='form-control' id='uni_name_zh'required="required">
                    
                    <label for="uni_country">学校所在国家</label>
                    <input type="text" name='uni_country' placeholder="大学所在国家" class='form-control' id='uni_country'required="required">
                    
                    <label for="uni_location">学校所在城市</label>
                    <input type="text" name='uni_location' placeholder="大学所在城市" class='form-control' id='uni_location'required="required">
                    
                    
                    <label for="uni_link">学校官网链接</label>
                    <input type="text" name='uni_link' class='form-control' id='uni_link' required="required">

                    <button type='submit'>提交</button>
                </div>
            </form>
        </div>
    </div>
            
</body>
</html>

