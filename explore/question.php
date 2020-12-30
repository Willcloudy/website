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
    <title>留学问答 - willcloudy</title>
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
                            <li><a href="oversealife.php">#海外生活</a></li>
                            <li class="active"><a href="#wt" data-toggle="tab">#留学问答</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade in active" id="wt">
                                <?php
                                    include('../include/get_post.php');
                                    $per_page = 15;

                                    if (isset($_GET['page'])) {
                                        $page = $_GET['page'];
                                    }else {
                                        $page=1;
                                    }
                                    $start_from = ($page-1) * $per_page;

                                    $get_posts = "select * from question order by qu_date DESC LIMIT $start_from, $per_page";
                                    mysqli_query($con, "set names 'utf8'");

                                    $run_posts = mysqli_query($con, $get_posts);
                                    while ($row = mysqli_fetch_array($run_posts)) {
                                        $qu_id = $row['qu_id'];
                                        $question = $row['question'];
                                        // if(preg_match('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$post_content,$match)){
                                        // $post_img = $match[0];
                                        // }else {
                                        //     $post_img = null;
                                        // }
                                        // $post_content = strip_tags($post_content);
                                        // if (strlen($post_content) > 50) {
                                        //     $post_content = mb_substr($post_content,0, 60)."..<a href='../post.php?post_id=$post_id' target='_blank'>查看全文</a>";
                                        // }
                                        $qu_date = $row['qu_date'];
                                        $user_id = $row['user_id'];
                                        $is_answered = $row['is_answered'];
                                        if ($is_answered == 'no') {
                                            $qu_content = "暂无回答";
                                        }
                                        $post_date = wordTime($qu_date);
                                        $writer = "select * from users where user_id = '$user_id'";
                                        mysqli_query($con, "set names 'utf8'");
                                        $run_writer = mysqli_query($con, $writer);
                                        $row_writer = mysqli_fetch_array($run_writer);

                                    if (!empty($row_writer['user_name'])) {
                                        $user_name = $row_writer['user_name'];
                                    }
                                    if (!empty($row_writer['user_image'])) {
                                        $user_image = $row_writer['user_image'];
                                    }
                                    

                                        echo "
                                        <div class='col-md-12' style='padding:10px;padding-bottom:5px;border-top: 1px solid #f0f2f7;'>
                                            <div style='width:100%'>
                                            
                                                <a id='image' href='../profile.php?u_id=$user_id' target='_blank' style='font-size:1em;'>
                                                    <img src='../$user_image' class='img-circle' style='width:30px;'> 
                                                </a>
                                        
                                                <a id='name' href='../profile.php?u_id=$user_id' target='_blank'style='rgb(91, 112, 131);font-size:1em;font-weight:bold'>
                                                    $user_name  :
                                                </a>

                                                <a href='../post.php?qu_id=$qu_id' target='_blank'>
                                                    <b style='line-height:1.4;font-size:1.3em;'>
                                                        $question
                                                    </b>
                                                </a>
                                                
                                                $post_date
                                                <br>
                                            </div>
                                            <div style='clear:both'></div>
                                        </div>
                                        <ul class='article-function'>
                                            <li>
                                            <a>
                                                <button class='btn btn-primary'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'>
                                                        <path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/>
                                                        <path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/>
                                                        </svg>
                                                        ";
                                                        if ($is_answered == 'no') {
                                                            echo $qu_content."
                                                            </button>
                                                            </a>";
                                                        }else {
                                                            $sql = "Select * from answer where qu_id = $qu_id";
                                                            mysqli_query($con, "set names 'utf8'");
                                                            $result = mysqli_query($con,$sql);
                                                            if ($result) {
                                                                $num = mysqli_num_rows($result);
                                                                echo    "查看回答
                                                                    </button>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                <a href='../post.php?qu_id=$qu_id' target='_blank'>
                                                                    <button id='click_like'>
                                                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-menu-up' viewBox='0 0 16 16'>
                                                                            <path fill-rule='evenodd' d='M15 3.207v9a1 1 0 0 1-1 1h-3.586A2 2 0 0 0 9 13.793l-1 1-1-1a2 2 0 0 0-1.414-.586H2a1 1 0 0 1-1-1v-9a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm-13 11a2 2 0 0 1-2-2v-9a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-3.586a1 1 0 0 0-.707.293l-1.353 1.354a.5.5 0 0 1-.708 0L6.293 14.5a1 1 0 0 0-.707-.293H2z'/>
                                                                            <path fill-rule='evenodd' d='M15 5.207H1v1h14v-1zm0 4H1v1h14v-1zm-13-5.5a.5.5 0 0 0 .5.5h6a.5.5 0 1 0 0-1h-6a.5.5 0 0 0-.5.5zm0 4a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 0-1h-11a.5.5 0 0 0-.5.5zm0 4a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 0-1h-8a.5.5 0 0 0-.5.5z'/>
                                                                        </svg>
                                                                        回答$num
                                                                    </button>
                                                                </a>
                                                                </li>";
                                                            }
                                                        }   
                                            echo "<li>
                                            <a href='../post.php?qu_id=$qu_id' target='_blank'>
                                                <button class='btn btn-outline-success'>
                                                    
                                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-cursor' viewBox='0 0 16 16'>
                                                            <path fill-rule='evenodd' d='M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103zM2.25 8.184l3.897 1.67a.5.5 0 0 1 .262.263l1.67 3.897L12.743 3.52 2.25 8.184z'/>
                                                        </svg>
                                                        我来回答
                                                </button>
                                                </a>
                                            </li>
                                        </ul>
                                        <div style='clear:both'></div>
                                    ";
                                    }
                                    $query = "select * from question";
                                    mysqli_query($con, "set names 'utf8'");
                                    $result = mysqli_query($con, $query);

                                    $total_posts = mysqli_num_rows($result);

                                    $total_pages = ceil($total_posts / $per_page);
                                if ($total_pages == 1 or $total_pages == 0) {
                                    # code...
                                }else {
                                    # code...

                                    echo "
                                    <center>
                                        <div class='pagination'>
                                        <a href='question.php?page=1'>首页</a>
                                    ";
                                    if ($page == 1) {
                                        for ($i=1; $i <= 3; $i++) { 
                                        echo "<a href='question.php?page=$i'>$i</a>";
                                        if ($i == $total_pages) {
                                            break;
                                        }
                                    }
                                    }elseif ($page == 2) {
                                        echo "<a href='question.php?page=1'>1</a>";
                                        for ($i=2; $i < 5; $i++) { 
                                            echo "<a href='question.php?page=$i'>$i</a>";
                                            if ($i == $total_pages) {
                                                break;
                                            }
                                        }
                                    }elseif ($page == $total_pages) {
                                        $pre2 = $page - 2;
                                        $pre1 = $page - 1;
                                        echo "<a href='question.php?page=$pre2' >$pre2</a>";
                                        echo "<a href='question.php?page=$pre1' >$pre1</a>";
                                        echo "<a style='color:#198754'>$page</a>";
                                    }
                                    else {
                                        $bac1 = $page + 1;
                                        $pre2 = $page - 2;
                                        $pre1 = $page - 1;
                                        echo "<a href='question.php?page=$pre2' >$pre2</a>";
                                        echo "<a href='question.php?page=$pre1' >$pre1</a>";
                                        echo "<a style='color:#198754'>$page</a>";
                                        echo "<a href='question.php?page=$bac1' >$bac1</a>";
                                        if (!$page + 2 > $total_pages) {
                                            $bac2 = $page + 2;
                                            echo "<a href='universities.php?page=$bac2' >$bac2</a>";
                                        }
                                    }
                                    
                                    
                                    echo "<a href='question.php?page=$total_pages'>尾页</a>";
                                    echo "<a>共 $total_pages 页</a>
                                    </div>";
                                }
                                ?>
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

    
</script>