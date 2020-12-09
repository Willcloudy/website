<div class="box">
    <?php
    if (isset($u_id)) {
        echo "
            <div id='write-box'>
                <a href='profile.php?u_id=$u_id'><img id='home-profile'src='$u_image' alt='profile' width='65px' class='img-circle'></a>
                <form action='home.php' method='POST'>
                    <input type='text' autoComplete='off' required placeholder='给故事起个标题...(20个字)' maxlength='20' style='width:80%' name='title' id='article-title'>
                    <div id='toolbar-container' class='toolbar'></div>
                    <div id='text-container' class='text'></div>
                    <textarea required id='text1' name='write-content' style='width:100%; height:200px;display:none'></textarea>
                    <button id='goWrite' type='submit'>去分享</button></a>
                </form>
            </div>";
    }else {
        echo "
            <div style='text-align:center;margin-top:5%'>
                <button class='btn btn-primary' onclick=document.getElementById('login').click() >登录</button>后开启发布文章功能
            </div>";
    }
    ?>
    <script type='text/javascript' src='//unpkg.com/wangeditor/dist/wangEditor.min.js'></script>
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
            'emoticon',
            'image',
            'code',
            'splitLine',
            'undo',
            'redo',
        ]
        editor.config.placeholder = '分享一个留学时候的故事(编写时请勿刷新)'
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

        // 第一步，初始化 textarea 的值
        $text1.val(editor.txt.html())

    </script>
</div> 

<?php
    if (!empty($_POST['write-content'])) {
        $content = $_POST['write-content'];
        $title = $_POST['title'];
        $insert = "Insert into posts 
        (user_id, post_content,post_title, post_date) 
        values('$u_id', '$content','$title', NOW())";
    
        $run = mysqli_query($con, $insert);
        echo mysqli_error($con);
        if ($run) {
            echo "<script>alert('发布成功')</script>";
            echo "<script>window.open('home.php','_self')</script>";

            $update = "update users set 
            posts='yes' where user_id='$u_id'";
            $run_update = mysqli_query($con, $update);
        }else {
            echo "<script>alert('发布失败')</script>";
            mysqli_error($con);
            //echo "<script>window.open('home.php','_self')</script>";
        }
    }

?>