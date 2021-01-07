<?php
    session_start();
    include('include/connection.php');
    if (isset($_SESSION['user_email'])) {
        $user = $_SESSION['user_email'];
        $get_user = "select * from users where user_email = '$user'";
        mysqli_query($con, "set names 'utf8'");
        $run_user = mysqli_query($con, $get_user);
        $row = mysqli_fetch_array($run_user);
        $u_name = $row['user_name'];
        $u_image = $row['user_image'];
        $u_id = $row['user_id'];
    }else {
        echo "<script>alert('非法进入')</script>";
        echo "<script>window.open('home.php', '_self')</script>";
    }
    if ($_GET['qu_id']) {
        $type = 'question';
        $get_qu_id = $_GET['qu_id'];

        $get_qu = "select * from question where qu_id = '$get_qu_id'";

        $run_qu = mysqli_query($con, $get_qu);
        if ($run_qu == null) {
            echo "<script>alert('问题消失了！？')</script>";
            echo "<script>window.open('home.php', '_self')</script>";
        }else {
            $row1 = mysqli_fetch_array($run_qu);
            $question = $row1['question'];
            $title = $row1['question'];
            $qu_des = $row1['qu_des'];
            $user_id = $row1['user_id'];
            if ($user_id !== $u_id) {
                echo "<script>alert('不是你的问题哦')</script>";
                echo "<script>window.open('home.php', '_self')</script>";
            }
        }
    }elseif ($_GET['post_id']) {

        $type = 'post';

        $get_post_id = $_GET['post_id'];

        $get_post = "select * from posts where post_id = '$get_post_id'";

        $run_post = mysqli_query($con, $get_post);
        if ($run_post == null) {
            echo "<script>alert('文章消失了！？')</script>";
            echo "<script>window.open('home.php', '_self')</script>";
        }else {
            $row = mysqli_fetch_array($run_post);
            $post_title = $row['post_title'];
            $title = $row['post_title'];
            $post_content = $row['post_content'];
            $user_id = $row['user_id'];
            if ($user_id !== $u_id) {
                echo "<script>alert('不是你的文章哦')</script>";
                echo "<script>window.open('home.php', '_self')</script>";
            }
            $post_type = $row['type'];
            if ($post_type == 'answer') {
                $input = 'disabled="disabled"';
            }else {
                $input = '';
            }
        }
    }else {
        echo "<script>alert('非法进入')</script>";
        echo "<script>window.open('home.php', '_self')</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script rel='prefetch' type="text/javascript" src="//unpkg.com/wangeditor/dist/wangEditor.min.js"></script>

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="icon" type="image/x-ico" href="img/logo.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="stylesheet" href="css/css.css">

    <title>编辑 - willcloudy</title>
    <style>
        body{
            overflow-x:hidden;
            background-color:#f6f6f6;
        }
        
        .well{
            min-height:80px;
            background-color:white;
        }
        h1{
            margin-top:-30px;
            margin-left:-50px;
            margin:0 auto;
        }
        h1{
            font-size: 35px;
            font-weight: bold;
            margin:0 0 10px;
            font-family: 'Pacifico', sans-serif;
        }
        .post{
            width:100%;
        }
        .text{
            width:100%;
        }
    </style>
</head>
<body>
    <div class="row">
            <div class="col-sm-12">
                <div class="well">
                    <div class="center" style="text-align:center">
                        <h1>WillCloudy</h1>
                    </div>
                </div>
            </div>    
        </div>
        <div class="row">
            <div class="col-md-6 midbar" style='float:none !important;margin:10px auto;width:37%;'>
                <?php
                    if ($type == 'question') {
                ?>
                        <h3 style='font-weight:bold;padding-top:20px;text-align:center'>编辑问题</h3>
                        <hr>
                        <div class="question-form" >
                            <form method="POST">
                                <small style='color:#ccc;font-size:5px;'>不可以修改问题，可以修改问题补充</small>
                                <input type="text"  name="question_title"  autoComplete ="off" required placeholder="写下你的疑惑" value='<?php echo $question; ?>' maxlength="30" style="width:100%;border-bottom:1px solid #ccc"disabled="disabled" id="question-title"> 
                                <div id="question-container" class="toolbar "></div>
                                <div id="question-toolbar" class="toolbar"></div>
                                <hr style='margin:0px;'>  
                                <div id="question-text" class="text"></div>
                                <textarea id="question_des" name="question-content" style="width:100%; height:200px;display:none" ></textarea>
                                <br>
                                <button class="go_write" type="submit">发布</button>
                            </form>
                        </div>
                        <script>
                            const A = window.wangEditor
                            const editor1 = new A('#question-toolbar', '#question-text')
                            editor1.config.menus = [
                                'underline',
                                'foreColor',
                                'link',
                                'quote',
                                'image',
                                'undo',
                                'redo',
                            ]
                            editor1.config.placeholder = '对于问题的补充(可选)'
                            editor1.config.uploadImgAccept = ['jpg', 'jpeg', 'png', 'gif', 'bmp']
                            editor1.config.uploadImgServer = "insert_img.php";
                            editor1.config.uploadFileName = 'file'; //设置文件上传的参数名称
                            editor1.config.uploadImgMaxSize = 3 * 1024 * 1024; // 将图片大小限制为 3M
                            //自定义上传图片事件
                            editor1.config.uploadImgHeaders = {    //header头信息 
                                'Accept': 'text/x-json'
                            }
                            // 将图片大小限制为 3M
                            editor1.config.uploadImgShowBase64 = false;   // 使用 base64 保存图片
                            // editor.customConfig.customAlert = function (info) { //自己设置alert错误信息
                            //     // info 是需要提示的内容
                            //     alert('自定义提示：' + '图片上传失败，请重新上传')
                            // };
                            editor1.config.debug = true; //是否开启Debug 默认为false 建议开启 可以看到错误
                            // editor.customConfig.debug = location.href.indexOf('wangeditor_debug_mode=1') > 0; // 同上 二选一
                            //图片在编辑器中回显
                            editor1.config.uploadImgHooks = {  
                                error: function (xhr, editor) {
                                    alert("2：" + xhr + "请查看你的json格式是否正确，图片并没有上传");
                                    // 图片上传出错时触发  如果是这块报错 就说明文件没有上传上去，直接看自己的json信息。是否正确
                                    // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
                                },
                                fail: function (xhr, editor, result) {
                                    //  如果在这出现的错误 就说明图片上传成功了 但是没有回显在编辑器中，我在这做的是在原有的json 中添加了
                                    //  一个url的key（参数）这个参数在 customInsert也用到
                                    //  
                                    alert("1：" + xhr + "请查看你的json格式是否正确，图片上传了，但是并没有回显");
                                },
                                success:function(xhr, editor, result){
                                    //成功 不需要alert 当然你可以使用console.log 查看自己的成功json情况 
                                    //console.log(result)
                                    // insertImg('https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo/bd_logo1_31bdc765.png')
                                },
                                customInsert: function (insertImg, result, editor) {
                                    //console.log(result);
                                    // 图片上传并返回结果，自定义插入图片的事件（而不是编辑器自动插入图片！！！）
                                    // insertImg 是插入图片的函数，editor 是编辑器对象，result 是服务器端返回的结果
                                    // 举例：假如上传图片成功后，服务器端返回的是 {url:'....'} 这种格式，即可这样插入图片：
                                    insertImg(result.url);
                                }
                            };
                            const $text = $('#question_des')
                            editor1.config.onchange = function (html) {
                                // 第二步，监控变化，同步更新到 textarea
                                $text.val(html)
                            }
                            editor1.create()
                            editor1.txt.html('<?php echo $qu_des;?>');
                            // 第一步，初始化 textarea 的值
                            $text.val(editor.txt.html())
                        </script>
                <?php
                        if (!empty($_POST['question-content'])) {
                            if (!empty($_POST['question-content'])) {
                                $changed_question_des = addslashes($_POST['question-content']);
                                $update = "UPDATE question SET qu_des='$changed_question_des', qu_date =NOW() WHERE qu_id ='$get_qu_id'";
                        
                                $run = mysqli_query($con, $update);
                                if ($run) {
                                    echo "<script>alert('修改成功')</script>";
                                    echo "<script>window.open('question.php','_self')</script>";
                                }else {
                                    echo "<script>alert('修改失败')</script>";
                                    echo mysqli_error($con);
                                    //echo "<script>window.open('home.php','_self')</script>";
                                }
                                echo "<script>alert('修改失败')</script>";
                            }else {
                                $changed_question = addslashes($_POST['question']);
                                $update = "UPDATE question SET question='$changed_question', qu_date =NOW() WHERE qu_id ='$get_qu_id'";
                               
                                $run = mysqli_query($con, $update);
                                echo mysqli_error($con);
                                if ($run) {
                                    echo "<script>alert('修改成功')</script>";
                                    echo "<script>window.open('question.php','_self')</script>";
                        
                                }else {
                                    echo "<script>alert('修改失败')</script>";
                                    echo mysqli_error($con);
                                    //echo "<script>window.open('home.php','_self')</script>";
                                }
                            }
                            
                        }
                    }elseif ($type == 'post') { 
                ?>  
                        <h3 style='font-weight:bold;padding-top:20px;text-align:center'>编辑文章</h3>
                        <hr>
                        <div class="question-form" >
                            <form action="" method="POST">
                                <small style='color:#ccc;font-size:5px;'>文章如果是一篇回答则不可编辑标题</small>
                                <input type="text" autoComplete="off" required placeholder="给故事起个标题...(20个字)" maxlength="20" style="width:100%" name="title" value='<?php echo $post_title;?>' <?php echo $input; ?>id="article-title">
                                <div id="toolbar-container" class="toolbar post"></div>
                                <div id="text-container" class="text"></div>
                                <textarea required id="text1" name="write-content" style="width:100%; height:200px;display:none"></textarea>
                                <br>
                                <button class="go_write" type="submit">发布</button></a>
                            </form>
                        </div>
                        
                        <script>
                            const E = window.wangEditor
                                    const editor = new E('#toolbar-container', '#text-container')
                                    editor.config.menus = [
                                        'head',
                                        'bold',
                                        'fontSize',
                                        'italic',
                                        'underline',
                                        'strikeThrough',
                                        'indent',
                                        'lineHeight',
                                        'foreColor',
                                        'link',
                                        'list',
                                        'justify',
                                        'quote',
                                        'image',
                                        'splitLine',
                                        'undo',
                                        'redo',
                                    ]
                                    editor.config.placeholder = '分享一个留学时候的故事或是动态(编写时请勿刷新)'
                                    editor.config.uploadImgAccept = ['jpg', 'jpeg', 'png', 'gif', 'bmp']
                                    editor.config.uploadImgServer = "insert_img.php";
                                    editor.config.uploadFileName = 'file'; //设置文件上传的参数名称
                                    editor.config.uploadImgMaxSize = 3 * 1024 * 1024; // 将图片大小限制为 3M
                                    //自定义上传图片事件
                                    editor.config.uploadImgHeaders = {    //header头信息 
                                        'Accept': 'text/x-json'
                                    }
                                    // 将图片大小限制为 3M
                                    editor.config.uploadImgShowBase64 = false;   // 使用 base64 保存图片
                                    // editor.customConfig.customAlert = function (info) { //自己设置alert错误信息
                                    //     // info 是需要提示的内容
                                    //     alert('自定义提示：' + '图片上传失败，请重新上传')
                                    // };
                                    editor.config.debug = true; //是否开启Debug 默认为false 建议开启 可以看到错误
                                    // editor.customConfig.debug = location.href.indexOf('wangeditor_debug_mode=1') > 0; // 同上 二选一
                                    //图片在编辑器中回显
                                    editor.config.uploadImgHooks = {  
                                        error: function (xhr, editor) {
                                            alert("2：" + xhr + "请查看你的json格式是否正确，图片并没有上传");
                                            // 图片上传出错时触发  如果是这块报错 就说明文件没有上传上去，直接看自己的json信息。是否正确
                                            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
                                        },
                                        fail: function (xhr, editor, result) {
                                            //  如果在这出现的错误 就说明图片上传成功了 但是没有回显在编辑器中，我在这做的是在原有的json 中添加了
                                            //  一个url的key（参数）这个参数在 customInsert也用到
                                            //  
                                            alert("1：" + xhr + "请查看你的json格式是否正确，图片上传了，但是并没有回显");
                                        },
                                        success:function(xhr, editor, result){
                                            //成功 不需要alert 当然你可以使用console.log 查看自己的成功json情况 
                                            //console.log(result)
                                            // insertImg('https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo/bd_logo1_31bdc765.png')
                                        },
                                        customInsert: function (insertImg, result, editor) {
                                            //console.log(result);
                                            // 图片上传并返回结果，自定义插入图片的事件（而不是编辑器自动插入图片！！！）
                                            // insertImg 是插入图片的函数，editor 是编辑器对象，result 是服务器端返回的结果
                                            // 举例：假如上传图片成功后，服务器端返回的是 {url:'....'} 这种格式，即可这样插入图片：
                                            insertImg(result.url);
                                        }
                                    };
                                    const $text1 = $('#text1')
                                    editor.config.onchange = function (html) {
                                        // 第二步，监控变化，同步更新到 textarea
                                        $text1.val(html)
                                    }
                                    editor.create()
                                    editor.txt.html('<?php echo $post_content;?>');
                                    // 第一步，初始化 textarea 的值
                                    $text1.val(editor.txt.html())
                        </script>

                <?php
                        if (!empty($_POST['write-content'])) {
                            $changed_post_content = addslashes($_POST['write-content']);
                            $changed_post_title = addslashes($_POST['title']);
                            $insert = "UPDATE posts SET post_title='$changed_post_title', post_content='$changed_post_content', post_date=NOW() WHERE post_id ='$get_post_id'";
                            mysqli_query($con, "set names 'utf8'");
                    
                            $run = mysqli_query($con, $insert);
                            echo mysqli_error($con);
                            if ($run) {
                                echo "<script>alert('发布成功')</script>";
                                echo "<script>window.open('home.php','_self')</script>";
                            }else {
                                echo "<script>alert('发布失败')</script>";
                                mysqli_error($con);
                                //echo "<script>window.open('home.php','_self')</script>";
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </body>
</html>
