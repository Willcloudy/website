
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
                            <?php
                                include("include/login.php");
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

