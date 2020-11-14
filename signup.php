<!DOCTYPE html>
<html lang="en">
<head>
    <title>注册&nbsp;|&nbsp;Willcloudy</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
    body{
        overflow-x:hidden;
        background-color:#f6f6f6;
    }
    .main-content{
        width:400px;
        height:50%;
        margin:10px auto;
        background-color: #fff;
        border:2px solid #e6e6e6;
        padding: 40px 50px;
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
    #signup{
        width:60%;
        border-radius:30px;
    }
    p{
        margin:20px 0 15px;
        font-size:15px;
        line-height:normal;
        font-family: 'Courgette', sans-serif;
    }
    strong{
        font-size: 28px;
        font-weight: bold;
        margin:0 0 10px;
        font-family: 'Pacifico', sans-serif;
    }
    h1{
        font-size: 35px;
        font-weight: bold;
        margin:0 0 10px;
        font-family: 'Pacifico', sans-serif;
    }
    a{
        color:#00BFFF;
    }
    a:hover{
        text-decoration: underline;
    }
    .btn{
        border-radius:7px;
        font-weight:bold;
        background-color: #00BFFF;
    }
    form{
        color: #999;
        background: white;
    }
</style>
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
        <div class="col-sm-12">
            <div class="main-content">
                <div class="header">
                    <h3 style="text-align:center;">
                        <strong>Sign Up/账号注册</strong>
                        <p>Fill put this form and start chating with other students</p>
                        <hr>    
                    </h3>
                </div>
                <div class="l-part">
                    <form action="" method="POST" onsubmit="return checkForm(this);">
                        <div class="form-group">
                            <label for="">Username/昵称</label>
                            <input type="text" class="form-control"
                            name="user_name" placeholder="例如:MarkHe"
                            autocomplete="off" required
                            >
                        </div>

                        <div class="form-group">
                            <label for="">Email/邮箱</label>
                            <input type="email" id='email' class="form-control"
                            name="user_email" placeholder="例如:123456@site.com"
                            autocomplete="off" required
                            >
                            <div id="checkEmail"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Password/密码</label>
                            <input type="password" class="form-control"
                            name="user_password"
                            autocomplete="off" required
                            >
                        </div>

                        <div class="form-group">
                            <label for="">Repeat Password/重复密码</label>
                            <input type="password" class="form-control"
                            name="user_password2"
                            autocomplete="off" required
                            >
                        </div>

                        

                        <div class="form-group">
                            <label for="" class="checkbox-inline">
                                <input type="checkbox" required>
                                我接受 <a href="">使用条款</a>
                                &amp; <a href="#">隐私政策</a>
                            </label>
                        </div>
                        <br>

                        <div class="form-group">
                                <button type="submit" 
                                class="btn btn-primary btn-block btn-lg" 
                                name="sign_up">注册</button>
                        </div>

                    </form>
                    <?php include('include/insert_user.php')?>

                    <div class="text-center small" 
                    style="color: #999;background-color:	#FFD700;
                    border-radius: 3px;
                    background: white;
                    padding:1px;
                    margin-top:0px;
                    margin-bottom:1px;">
                    已经有账户了?
                    <a href="home.php?from=login">在这里登录</a>
                    </div>
                    
                </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script>
	// email.onchange = function(){
	// 	var email = this.value;
	// 	var reg = /^([a-zA-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4})$/;
	// 	if(reg.test(email)){
    //         document.getElementById("checkEmail").style.color = "green" ;
    //         document.getElementById("checkEmail").innerHTML= "邮箱格式正确";
	// 	}else{
    //         document.getElementById("checkEmail").style.color = "red" ;
	// 		document.getElementById("checkEmail").innerHTML= "邮箱格式不正确";
	// 	}
	// }
    function checkForm(form) {
        if(form.user_name.value == "") {
            alert("错误：用户名不能为空！");
            form.username.focus();
            return false;
        }
        re = /^\w+$/;
        se = /[\u4e00-\u9fa5]/;
        if(!re.test(form.user_name.value) && !se.test(form.user_name.value)) {
            alert("错误：用户名必须只包含字母、数字和下划线！");
            form.user_name.focus();
            return false;
        }
        if(form.user_password.value != "" && form.user_password.value == form.user_password2.value) {
            if(form.user_password.value.length < 6) {
                alert("错误：密码必须至少包含六个字符！");
                form.user_password.focus();
                return false;
            }
            if(form.user_password.value == form.user_name.value) {
                alert("错误：密码必须与用户名不同！");
                form.user_password.focus();
                return false;
            }
            re = /[0-9]/;
            if(!re.test(form.user_password.value)) {
                alert("错误：密码必须包含至少一个数字（0至9）！");
                form.user_password.focus();
                return false;
            }
            re = /[a-z]/;
            if(!re.test(form.user_password.value)) {
                alert("错误：密码必须包含至少一个小写字母(a-z)!");
                form.user_password.focus();
                return false;
            }
            re = /[A-Z]/;
            if(!re.test(form.user_password.value)) {
                alert("错误：密码必须包含至少一个大写字母(A-Z)!");
                form.user_password.focus();
                return false;
            }
        } else {
            alert("错误：请检查并确认您输入的密码是否一致！");
            form.user_password.focus();
            return false;
        }
        return true;
        }
</script>