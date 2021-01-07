<style>
    .loginbtn{
        border:0;
    }
    .loginbtn:focus{
        outline:none;
    }
</style>
<script  type="text/javascript" src="https://unpkg.com/wangeditor/dist/wangEditor.min.js"></script>

<div class="box">
    <div id='write-box' style='float:right'>
        <?php
            if (isset($u_id)) {
            echo"    
            <a href=''data-toggle='modal' data-target='#write_article'>
                <span id='write' >
                    写文章
                </span>
            </a>
            <a href=''data-toggle='modal' data-target='#rise_question' style='float:right'>
                <button class='question_btn' type='submit'>提问</button></a>
            </a>";
            }else {
                echo "
                <a data-toggle='modal' data-target='#myModal'>
                <span id='write'>
                请登录
                </span>
                <a data-toggle='modal' data-target='#myModal'>
                <button class='question_btn'type='submit'>提问</button></a>
                </a>";
            }
        ?>
    </div>
</div> 

    <?php
        if (isset($u_id)) {
    ?>
        <div class="modal fade" id="rise_question" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content"style='width:80%'>
                    <div class="modal-body" >
                        <button type="button" class='close'data-dismiss="modal" aria-hidden="true" >
                            &times;
                        </button>
                        <div class="question-form" >
                            <form action="home.php" method="POST" style='margin:20px;'>
                                <input type="text" autoComplete="off" required placeholder="写下你的疑惑(不需要加问号)" maxlength="30" style="width:90%;border-bottom:1px solid #ccc" name="question" id="question-title">
                                <span style='font-weight:bold;color:#ccc'>?</span>                            
                                <div id="question-container" class="toolbar "></div>
                                <div id="question-toolbar" class="toolbar"></div>

                                <div id="question-text" class="text"></div>
                                <textarea id="question_des" name="question-content" style="width:100%; height:200px;display:none"></textarea>
                                <br>
                                <button class="go_write" type="submit">发布</button></a>
                            </form>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>

        <div class="modal fade" id="write_article" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content"style='width:100%'>
                    <div class="modal-body" >
                        <button type="button" class='close'data-dismiss="modal" aria-hidden="true" >
                            &times;
                        </button>
                        <div class="question-form" >
                            <form action="home.php" method="POST" style='margin:20px;'>
                                <input type="text" autoComplete="off" required placeholder="给故事起个标题...(20个字)" maxlength="20" style="width:80%" name="title" id="article-title">
                                <div id="toolbar-container" class="toolbar post"></div>
                                <div id="text-container" class="text"></div>
                                <textarea required id="text1" name="write-content" style="width:100%; height:200px;display:none"></textarea>
                                <br>
                                <button class="go_write" type="submit">发布</button></a>
                            </form>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
    <?php
        }
    ?>

    <form action="../result.php" method="POST" class='home_search'>
        <span>
            <input style='margin:2% 1%;margin-bottom: 0px;'class='form-control search' type="text" name='searchcontent' autocomplete="off" placeholder="关于留学的问题？" required='required'>
        </span>
        <span class="glyphicon glyphicon-search glyphicon-search-explore"></span>
        <a href="result.php"><button class='form-control search-btn btn btn-primary'type='submit'></button></a>
    </form>
    <div style='clear:both'></div>
    
<?php
    if (!empty($_POST['write-content'])) {
        $content = addslashes($_POST['write-content']);
        $title = addslashes($_POST['title']);
        $insert = "Insert into posts 
        (user_id, post_content,post_title, post_date, type, post_view, post_like) 
        values('$u_id', '$content','$title', NOW(), 'post', 0, 0)";
        mysqli_query($con, "set names 'utf8'");

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
    if (!empty($_POST['question'])) {
        if (!empty($_POST['question-content'])) {
            $question = addslashes($_POST['question']).'？';
            $question_des = addslashes($_POST['question-content']);
            $insert = "Insert into question 
            (user_id, question, qu_date, is_answered, qu_des) 
            values('$u_id','$question', NOW(), 'no', '$question_des')";
            mysqli_query($con, "set names 'utf8'");
    
            $run = mysqli_query($con, $insert);
            echo mysqli_error($con);
            if ($run) {
                echo "<script>alert('发布成功')</script>";
                echo "<script>window.open('question.php','_self')</script>";
    
            }else {
                echo "<script>alert('发布失败')</script>";
                mysqli_error($con);
                //echo "<script>window.open('home.php','_self')</script>";
            }
        }else {
            $question = addslashes($_POST['question']).'？';
            $question_des = addslashes($_POST['question-content']).'？';
            $insert = "Insert into question 
            (user_id, question, qu_date, is_answered) 
            values('$u_id','$question', NOW(), 'no')";
            mysqli_query($con, "set names 'utf8'");
    
            $run = mysqli_query($con, $insert);
            echo mysqli_error($con);
            if ($run) {
                echo "<script>alert('发布成功')</script>";
                echo "<script>window.open('question.php','_self')</script>";
    
            }else {
                echo "<script>alert('发布失败')</script>";
                mysqli_error($con);
                //echo "<script>window.open('home.php','_self')</script>";
            }
        }
        
    }

?>
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

        // 第一步，初始化 textarea 的值
        $text1.val(editor.txt.html())

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

        // 第一步，初始化 textarea 的值
        $text.val(editor.txt.html())
    </script>