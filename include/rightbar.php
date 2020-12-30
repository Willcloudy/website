<style>
    .tuij li span{
        color:#0099FF;
    }
</style>
<div class="col-md-3" id='rightbar'>
    <div id="search-small">
        <form action="result.php" method="POST">
            <span>
                <input class='form-control search' type="text" name='searchcontent'autocomplete="off" placeholder='搜索大学/文章/用户' required='required' style='width:100%'/>
            </span>
            <span class='span2'>
                <a href="result.php" style='position:relative'>
                    <span class="glyphicon glyphicon-search search-sm-icon"></span>
                    <button class='form-control btn btn-primary'type='submit' style='display:none'>
                    </button>
                </a>
            </span>
            <div style="clear:both;"></div>
        </form>
    </div>
    <div id="topic" style='display:none;'>
        <div class='rightbar' >
                <div class='ulist'>
                    <h4 style='font-weight:bold;text-align:center;padding-top:15px;'>推荐话题</h4>
                    <div class="row">
                        <div class='col-md-11' style='border:0px;box-shadow:none;'>
                        <ul class='tuij'style='list-style:none;float:left;padding-left:20px;'>
                            <li>
                                    <div>
                                        <a href="../country.php?selectednation=UK" ><h4 style='font-weight:bold;text-align:center;margin:0px'><span>#</span>英国</h4></a>
                                    </div>
                                </li>
                                <br>
                                <li>
                                    <div>
                                        <a href="../country.php?selectednation=CAN"><h4 style='font-weight:bold;text-align:center;margin:0px'><span>#</span>加拿大</h4></a>
                                    </div>
                                </li>
                                <br>
                                <li>
                                    <div>
                                        <a href="../country.php?selectednation=AUS"><h4 style='font-weight:bold;text-align:center;margin:0px'><span>#</span>澳大利亚</h4></a>
                                    </div>
                                </li>
                            </ul>
                            <ul style='list-style:none;float:right;padding-left:20px;' class='tuij'>
                                <li>
                                    <div>
                                        <a href="oversealife.php" ><h4 style='font-weight:bold;text-align:center;margin:0px'><span>#</span>海外留学</h4></a>
                                    </div>
                                </li>
                                <br>
                                <li>
                                    <div>
                                        <a href="../topics.php?"><h4 style='font-weight:bold;text-align:center;margin:0px'><span>#</span>留学归来</h4></a>
                                    </div>
                                </li>
                                <br>
                                <li>
                                    <div>
                                        <a href="question.php"><h4 style='font-weight:bold;text-align:center;margin:0px'><span>#</span>留学问答</h4></a>
                                    </div>
                                </li>
                            </ul>
                        </div>           
                    </div>
                    <br>
                </div>
        </div>
        <br>
        <div class='rightbar' >
            <div class='ulist'>
                <h4 style='font-weight:bold;text-align:center;padding-top:15px;'>推荐用户</h4>
                <div class="row">
                    <div class='col-md-11' style='border:0px;box-shadow:none;'>
                        <ul style='list-style:none;padding-left:20px;'>
                            <?php
                                $user_query = 'Select * from `users` order by rand() limit 3';
                                $run_user = mysqli_query($con, $user_query);
                                while($row_user = mysqli_fetch_array($run_user)){
                                    $user_id = $row_user['user_id'];
                                    $user_name = $row_user['user_name'];
                                    $user_image = $row_user['user_image'];
                                    $user_des = $row_user['user_des'];

                                    echo "
                                        <li>
                                            <div >
                                                <a href='../profile.php?u_id=$user_id'><img src='../$user_image' class='img-circle' style='float:left;margin-left:5px;width:45px'></a>
                                                <div style='margin-left:65px;'>
                                                <a href='../profile.php?u_id=$user_id'><h5>$user_name</h5></a>
                                                <small style='color:rgb(91, 112, 131)'>$user_des</small>
                                                </div>
                                            </div>
                                        </li>
                                        <br>
                                    ";
                                }
                            ?>
                        </ul>
                    </div>           
                </div>
                <br>
                
            </div>
        </div>
    </div>
    <div id='other'>
        <div class='rightbar' >
            <div class='ulist'>
                <h4 style='font-weight:bold;text-align:center;padding-top:15px;'>推荐话题</h4>
                <div class="row">
                    <div class='col-md-11' style='border:0px;box-shadow:none;'>
                        <ul class='tuij'style='list-style:none;float:left;padding-left:20px;'>
                            <li>
                                <div>
                                    <a href="country.php?selectednation=UK" ><h4 style='font-weight:bold;text-align:center;margin:0px'><span>#</span>英国</h4></a>
                                </div>
                            </li>
                            <br>
                            <li>
                                <div>
                                    <a href="country.php?selectednation=CAN"><h4 style='font-weight:bold;text-align:center;margin:0px'><span>#</span>加拿大</h4></a>
                                </div>
                            </li>
                            <br>
                            <li>
                                <div>
                                    <a href="country.php?selectednation=AUS"><h4 style='font-weight:bold;text-align:center;margin:0px'><span>#</span>澳大利亚</h4></a>
                                </div>
                            </li>
                        </ul>
                        <ul style='list-style:none;float:right;padding-left:20px;' class='tuij'>
                            <li>
                                <div>
                                    <a href="explore/oversealife.php" ><h4 style='font-weight:bold;text-align:center;margin:0px'><span>#</span>海外留学</h4></a>
                                </div>
                            </li>
                            <br>
                            <li>
                                <div>
                                    <a href="topics.php?"><h4 style='font-weight:bold;text-align:center;margin:0px'><span>#</span>留学归来</h4></a>
                                </div>
                            </li>
                            <br>
                            <li>
                                <div>
                                    <a href="explore/question.php"><h4 style='font-weight:bold;text-align:center;margin:0px'><span>#</span>留学问答</h4></a>
                                </div>
                            </li>
                        </ul>
                    </div>           
                </div>
                <br>
                
            </div>
        </div>
        <br>
        <div class='rightbar' >
            <div class='ulist'>
                <h4 style='font-weight:bold;text-align:center;padding-top:15px;'>🔥热榜</h4>
                <div class="row">
                    <div class='col-md-11' style='border:0px;box-shadow:none;'>
                        <ul style='list-style:none;padding-left:5px;'>
                            <?php
                                $get_posts = "select * from posts order by post_view DESC LIMIT 3";
                                mysqli_query($con, "set names 'utf8'");
                                $run_posts = mysqli_query($con, $get_posts);
                                mysqli_query($con, "set names 'utf8'");
                                echo mysqli_error($con);
                                while ($row = mysqli_fetch_array($run_posts)) {
                                    $post_id = $row['post_id'];
                                    $post_content = $row['post_content'];

                                    $post_content = strip_tags($post_content);
                                    if (strlen($post_content) > 50) {
                                        $post_content = mb_substr($post_content,0, 4)."..<a href='../post.php?post_id=$post_id' class='view_more' target='_blank'>查看全文</a>";
                                    }

                                    $post_title = $row['post_title'];
                                    $post_view = $row['post_view'];
                                    
                                    echo "
                                    <div class='col-md-12' style='padding:10px;padding-bottom:5px;'>
                                        <div style='float:left'>
                                            <a href='../post.php?post_id=$post_id' target='_blank'>
                                                <b style='line-height:1.4;font-size:1em;'>
                                                    $post_title
                                                </b>
                                            </a>
                                            <span style='float:right;margin-left:5px;font-size:0.1em;color:rgb(91, 112, 131);'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 -2 16 16'>
                                    <path fill-rule='evenodd' d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z'/>
                                    <path fill-rule='evenodd' d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                    </svg>&nbsp;&nbsp;<span>$post_view</span></span>
                                        </div>
                                        
                                    </div>
                                    <div style='clear:both'></div>
                                    
                                ";
                                }
                            ?>
                        </ul>
                    </div>           
                </div>
                <br>
            </div>
        </div>
    <br>
    <a id='about' href="about.php" style='color:grey'><span class="glyphicon glyphicon-question-sign"></span> About/关于我们</a>
    <a href="#" style='color:grey'><span class="glyphicon glyphicon-question-sign"></span> 隐私政策</a>
</div>



<script>
    $.fn.smartFloat = function() {
    var position = function(element) {
    var top = element.position().top, pos = element.css("position");
    var more = top + 80;
    $(window).scroll(function() {
    var scrolls = $(this).scrollTop();
    if (scrolls > more) {
        if (window.XMLHttpRequest) {
        $('#search-small').css('display','block');
        $('#topic').css('marginTop','0px');
        element.css({
        "width" : "19%",
        "marginTop": "15px",
        position: "fixed",
        top: 0,
        left: "70%",
        }); 
        } else {
        element.css({
        top: scrolls
        }); 
        }
    }else {
        element.css({
        position: pos,
        left:0,
        "width" : "25%",
        "margin-top":"0",
        }); 
    }
    });
    };
    return $(this).each(function() {
    position($(this));      
    });
    };
    $('#rightbar').smartFloat();
</script>