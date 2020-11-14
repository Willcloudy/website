<link rel="stylesheet" href="css/signform.css">
<!-- <a href="./admin/in_info.php" style='float:right'>Admin</a> --> 
<div class="logo">
    <a id='logo'href="home.php">
        <img class='img-responsive' width='60%' src="img/logo.png" alt="logo">
    </a>
</div>

<div class="col-md-3" role="navigation">
    <ul class="list-unstyled leftbar nav nav-pills nav-stacked">
        <li>
            <a id='home' href="home.php">
                <svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-house" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                    <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                </svg> 
                Home/首页
            </a></li>
            
        <li>
        
            <a id='search' href="search.php">
                <span class="glyphicon glyphicon-globe"></span> 
                Search/搜索
            </a></li>
        <li>
            <a id='ranking' href="ranking.php">
                <span class="glyphicon glyphicon-edit"></span> 
                Ranking/大学排名
            </a>
        </li>
        <li><a id='group' href="group.php" style='font-size:19px'><span class="glyphicon glyphicon-user"></span> Group/兴趣组</a></li>
        <li id='sign'>
            <a  href="javascript:volid(0);"data-toggle="modal" data-target="#myModal">
                <span><!-- <img src="" alt="" width='40px' height='40px'>--> 
                    登录/注册
                </span>
            </a>
        </li>
        <li id='profile' style='display:none;'>
            <a href="profile.php">
                <span>
                    <img src="" alt="" width='40px' height='40px'> 
                    <?php echo $user_name; ?>
                </span>
            </a>
        </li>
    </ul>
    <br>
    <br>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >
                    &times;
                </button>
                <div class="signin-form">
                    <form action="" method='POST'>

                        <div class="form-header">
                            <h2>Sign In/登录</h2>
                            <p>Login to Willcloudy</p>
                        </div>

                        <div class="form-group">
                            <label for="">Email/邮箱</label>
                            <input type="email" class="form-control sign"
                            name="email" placeholder="anyemail@site.com"
                            autocomplete="off" required
                            >
                        </div>

                        <div class="form-group">
                            <label for="">Password/密码</label>
                            <input type="password" class="form-control sign"
                            name="password" placeholder="Password/密码"
                            autocomplete="off" required
                            >
                        </div>

                        <div class="small">忘记密码?
                        <a href="forget_pass.php">点击这里</a>
                        </div><br>

                        <div class="form-group">
                            <button type="submit" 
                            class="btn1 btn btn-primary btn-block btn-lg" 
                            name="sign_in">登录</button>
                            <?php include("include/login.php");?>
                        </div>
                    </form>
                    <div class="text-center small" 
                    style="font-size:14px;color: #191970;background-color:	#FFD700;
                    border-radius: 3px;
                    background: white;
                    padding:1px;margin-bottom:20px">
                    没有账号?
                    <a href="signup.php">创建一个</a>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
