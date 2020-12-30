<?php
    session_start();
    include('../include/connection.php');
    $webpage = 2;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>海外生活 - willcloudy</title>
    <link rel="stylesheet" href="../css/css.css">
    <style>
        .col-md-12 #content:hover{
            text-decoration: none;
            color:#646464;
        }
        .like button{
            margin-left:10px;
            padding:0;
            background-color:transparent;
            border:none;
        }
        .like button:hover{
            color:#068ab6;
        }
        .like span button:focus{
            outline:0;
        }
        #content{
            font-size:1em;
        }
        #myTab{
            padding:0;
            text-align:center;
        }
        #myTab li{
        }
        #myTab li a{
        }
        @media(max-width:992px)
        {
            #post-img img{
                display:none;
            }
            #content{
                font-size:0.9em;
            }
            #myTab li a{
                font-size:0.5em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
            <?php 
                if (isset($_SESSION['user_email'])) {
                    $user = $_SESSION['user_email'];
                    $get_user = "select * from users where user_email = '$user'";
                    mysqli_query($con, "set names 'utf8'");
                    $run_user = mysqli_query($con, $get_user);
                    $row = mysqli_fetch_array($run_user);
                    $u_name = $row['user_name'];
                    $u_image = $row['user_image'];
                    $u_id = $row['user_id'];
                    require('../include/leftbar.php');
                    echo "
                        <script>
                            var profile = document.getElementById('profile');
                            profile.style.display='block';
                            document.getElementById('sign').style.display='none' 
                        </script>";
                }else {
                    require('../include/leftbar.php');
                    echo "<script>document.getElementById('sign').style.display='block' </script>";
                }
            ?>
            <div class="col-md-6 midbar" style='padding:0'id='mid'>
                <div class="box">
                    <form action="../result.php" method="POST">
                        <span>
                            <input style='margin:2% 3%;width:90%;margin-bottom: 0px;'class='form-control search' type="text" name='searchcontent' autocomplete="off" placeholder="关于留学的问题？" required='required'>
                        </span>
                            <span class="glyphicon glyphicon-search glyphicon-search-explore"></span>
                            <a href="result.php"><button class='form-control search-btn btn btn-primary'type='submit'></button></a>
                        
                    </form>
                    <div>
                        <ul id="myTab" class="nav nav-tabs ">
                            <li><a href="hot.php">#热榜</a></li>
                            <li><a href="lastest.php">#最新</a></li>
                            <li class="active"><a href="#sq" data-toggle="tab">#海外生活</a></li>
                            <li><a href="question.php">#留学问答</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade in active" id="sq">
                                
                            </div>

                            
                        </div>
                    </div>
                </div>  
            </div>
            <?php
                require('../include/rightbar.php');
            ?>
            
    </div>
</body>
</html>
<script>
    var ele = document.getElementById("search");
    ele.href="javascript:void(0);";
    //ele.style.backgroundColor = "rgb(181,212,213)";
    ele.style.color ="#198754";
    ele.onmouseover =  function () {
    this.style.backgroundColor = "white";
    }

    var rightbar = document.getElementById('topic');
    rightbar.style.display='block';
    document.getElementById('other').style.display='none'
    document.getElementById('topic').style.marginTop= "70px"
    document.getElementById('search-small').style.display='none'

    $(document).ready(function(){ 
        $('.like_post').click(function(){ 
            var clickBtnValue = $(this).attr("name"); 
            console.log(clickBtnValue);
            $.ajax({
                type:"GET",
                url: "../include/like.php", 
                dataType:"JSON",
                contentType:"application/json",
                data:{id:clickBtnValue,}, 
                success: function(status){
                    $(this).style.color = '#198754';
                    $(this).style.backgroundColor = 'white';
                },
                error:function(XMLHttpRequest, textStatus, errorThrown){
                    // 状态码
                    console.log(XMLHttpRequest.status);
                    // 状态
                    console.log(XMLHttpRequest.readyState);
                    // 错误信息
                    console.log(textStatus);
                    alert("点赞失败");


                }
            }); 
        }); 

    }); 
</script>