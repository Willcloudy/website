<?php
// include('../include/connection.php');
// if (isset($_POST['submit'])) {
//     $uni_name_zh = $_POST['uni_name_zh'];
//     $uni_img = $_FILES['uni_img']['name'];
//     $image_tmp = $_FILES['uni_img']['tmp_name'];
//     $random_number = rand(1,1000);
//     if(move_uploaded_file($image_tmp, '../img/avertar'.$uni_img)){
//         $update = "UPDATE university SET uni_img = 'img/$uni_img' where uni_name_zh ='$uni_name_zh'";
                            
//         $run = mysqli_query($con, $update);
//     }else {
//         echo 'false';
//     }
    
// }else {
//     echo "no files";
// }

    header('Content-Type:application/json; charset=utf-8');
    //图片文件的生成
    $savename = date('YmdHis',time()).mt_rand(0,9999).'.jpeg';//localResizeIMG压缩后的图片都是jpeg格式
    //获取图片文件的名字
    $fileName = $_FILES["file"]["name"];
    //图片保存的路径
    $savepath = 'img/articleimg/'.$savename;
    //生成一个URL获取图片的地址
    $url = "http://localhost:8080/website/" . $savepath;
    //返回数据。wangeditor3 需要用到的数据 json格式的
    $data["errno"] = 0;
    $data["data"] = $savepath;
    $data['url'] = $url;

    //可有可无的一段，也就是图片文件移动。
    move_uploaded_file($_FILES["file"]["tmp_name"],$savepath);
    //返回数据
    echo json_encode($data);

     //创建文件夹 权限问题
// function mkdirs($dir, $mode = 0777){
//     if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;
//     if (!mkdirs(dirname($dir), $mode)) return FALSE;
//     return @mkdir($dir, $mode);
// }