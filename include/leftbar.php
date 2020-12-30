<meta name="baidu-site-verification" content="code-QrKX38uGyq" />
<div class="col-md-3" role="navigation" id='leftbar'>
    <a id='logo' href="/home.php">
        <img class='logo' width='300px' height='100%;' src="/img/logo.png" alt="logo"/>
    </a>
    <ul class="list-unstyled leftbar nav nav-pills nav-stacked">
        <li>
            <a id='home' href="/home.php">
                <svg style='color:#FFCC33'width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-house" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                    <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                </svg> 
                Home/首页
            </a>
        </li>
            
        <li>
            <a id='search' href="/explore">
                <span style='color:#99CC99'class="glyphicon glyphicon-globe"></span> 
                Explore/探索
            </a>
        </li>

        <li>
            <a id='ranking' href="/universities.php">
                <span style='color:#FF9900'class="glyphicon glyphicon-edit"></span> 
                院校库
            </a>
        </li>

        <li>
            <a id='group' href="/topics.php" style='font-size:19px'>
                <span style='color:#0099FF'class="glyphicon glyphicon-user"></span> 
                #Topic/话题
            </a>
        </li>

        <li id='sign' style='display:none;'>
            <a data-toggle="modal" data-target="#myModal">
                <span id="login" >
                    登录/注册
                </span>
            </a>
        </li>
        
        <li id='profile' style='display:none;'>
        <?php 
        if (!empty($u_id)) {
            if ($webpage =='home') {
                echo "
                <a id='profileA' href='profile.php?u_id=$u_id' class='popup'style='padding:2%'>";
            }else {
                echo "
                <a id='profileA' href='../profile.php?u_id=$u_id' class='popup'style='padding:2%'>";
            }
        
        ?>
                <img src="<?php echo '/'.$u_image?>" alt="avatar" width='60px' height='60px' class='img-circle' style='border:1px solid white'/> 
                <?php echo '&nbsp;&nbsp;&nbsp;'.$u_name;}  ?>
            </a>
        </li>
    </ul>
    <br>
    <br>
</div>
<!-- 登陆注册浮窗界面 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close"style='margin-right: 30px;'data-dismiss="modal" aria-hidden="true" >
                    &times;
                </button>
                <div class="signin-form">
                    <form action="" method='POST'>

                        <div class="form-header">
                            <h2>登录积云🌩️</h2>
                            <p>Login to Willcloudy</p>
                        </div>

                        <div class="form-group">
                            <label for="">Email/邮箱</label>
                            <input type="email" class="form-control sign"
                            name="email" placeholder="请输入邮箱"
                            autocomplete="off" required/>
                        </div>

                        <div class="form-group">
                            <label for="">Password/密码</label>
                            <input type="password" class="form-control sign"
                            name="password" placeholder="请输入密码"
                            autocomplete="off" required/>
                        </div>
                        <div id="checkEmail"></div>
                        <div class="small">忘记密码?
                        <a href="forget_pass.php">点击这里</a>
                        </div><br>

                        <div class="form-group">
                            <button type="submit" 
                            class="btn1 btn btn-primary btn-block btn-lg" 
                            name="sign_in">登录</button>
                            <?php if($webpage == 1){
                                include("include/login.php");
                            }elseif ($webpage == 2) {
                                include("../include/login.php");
                            }
                            ?>
                        </div>
                    </form>
                    <div class="text-center small" 
                    style="font-size:14px;color: #191970;background-color:	#FFD700;
                    border-radius: 3px;
                    background: white;
                    padding:1px;margin-bottom:20px">
                    没有账号?
                    <a href="/signup.php">创建一个</a>
                    </div>
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
                        <form action="home.php" method="POST">
                            <input type="text" autoComplete="off" required placeholder="给故事起个标题...(20个字)" maxlength="20" style="width:80%" name="title" id="article-title">
                            <div id="toolbar-container" class="toolbar post"></div>
                            <div id="text-container" class="text"></div>
                            <textarea required id="text1" name="write-content" style="width:100%; height:200px;display:none"></textarea>
                            <br>
                            <button id="goWrite" type="submit">发布</button></a>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>

<script type="text/javascript" src="//unpkg.com/wangeditor/dist/wangEditor.min.js"></script>
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