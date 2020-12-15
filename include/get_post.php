
<?php
  
  //date_default_timezone_set('PRC');

function wordTime($time) {
        $Stime = strtotime($time);
        $int = time() - (int)$Stime;
        $str = '';
        if ($int <= 2){
        $str = sprintf('刚刚', $int);
        }elseif ($int < 60){
        $str = sprintf('%d秒前', $int);
        }elseif ($int < 3600){
        $str = sprintf('%d分钟前', floor($int / 60));
        }elseif ($int < 86400){
        $str = sprintf('%d小时前', floor($int / 3600));
        }elseif ($int < 2592000){
        $str = sprintf('%d天前', floor($int / 86400));
        }else{
        $str = date('Y/m/d',strtotime($time));
        }
        return $str;
    }


function get_lastest_posts(){
    global $con;
    $per_page = 15;

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }else {
        $page=1;
    }
    $start_from = ($page-1) * $per_page;

    $get_posts = "select * from posts order by post_date DESC LIMIT $start_from, $per_page";

    echo mysqli_error($con);
    $run_posts = mysqli_query($con, $get_posts);
    echo mysqli_error($con);
    while ($row = mysqli_fetch_array($run_posts)) {
        echo mysqli_error($con); 
        $post_id = $row['post_id'];
        $post_content = $row['post_content'];
        if(preg_match('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$post_content,$match)){
        $post_img = $match[0];
        }else {
            $post_img = null;
        }
        $post_content = strip_tags($post_content);
        if (strlen($post_content) > 50) {
            $post_content = mb_substr($post_content,0, 60)."..<a href='../post.php?post_id=$post_id' target='_blank'>查看全文</a>";
        }

        $post_title = $row['post_title'];
        $post_date = $row['post_date'];
        $user_id = $row['user_id'];
        $post_like = $row['post_like'];
        $post_date = wordTime($post_date);
        $writer = "select * from users where user_id = '$user_id' AND posts ='yes'";
        $run_writer = mysqli_query($con, $writer);
        $row_writer = mysqli_fetch_array($run_writer);


        $user_name = $row_writer['user_name'];
        $user_image = $row_writer['user_image'];

        echo "
        <div class='col-md-12' style='padding:10px;padding-bottom:5px;border-top: 1px solid #f0f2f7;'>
            <div id='post-img'style='float:left;'>
                <a id='post_img'href='../post.php?post_id=$post_id' target='_blank'><span>$post_img</span></a>
            </div>
            <div style='width:100%'>
                <a href='../post.php?post_id=$post_id' target='_blank'>
                    <b style='line-height:1.4;font-size:1.3em;'>
                        $post_title
                    </b>
                </a>
                $post_date
                <br>
                <a id='image' href='../profile.php?u_id=$user_id' target='_blank' style='font-size:1em;'>
                    <img src='../$user_image' class='img-circle' style='width:20px;'> 
                </a>
                <a id='name' href='../profile.php?u_id=$user_id' target='_blank'style='font-size:1.1em;'>
                    $user_name  
                </a>
                :
                <a id='content' href='../post.php?post_id=$post_id' target='_blank'>
                    $post_content
                </a>
            </div>
            <div style='clear:both'></div>
        </div>
        <ul class='article-function'>
            <li>
                <button id='click_like'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart' viewBox='0 0 16 16'>
                    <path fill-rule='evenodd' d='M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z'/>
                    </svg>";
        if ($post_like == null) {
            echo "点赞";
        }else {
            echo $post_like;
        }           
                   
        echo    "</button>
            </li>
            <li>
                <button>
                    <a href='../post.php?post_id=$post_id' target='_blank'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'>
                        <path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/>
                        <path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/>
                        </svg>
                        评论
                    </a>
                </button>
            </li>
            <li>
                <button>
                    <a>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'>
                            <path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/>
                        </svg>
                        收藏
                    </a>
                </button>
            </li>
        </ul>
        <div style='clear:both'></div>
    ";
    }
    $query = "select * from posts";
    $result = mysqli_query($con, $query);

    $total_posts = mysqli_num_rows($result);

    $total_pages = ceil($total_posts / $per_page);

    echo "
    <center>
        <div class='pagination'>
        <a href='lastest.php?page=1'>首页</a>
    ";
    if ($page == 1) {
        for ($i=1; $i <= 3; $i++) { 
        echo "<a href='lastest.phppage=$i'>$i</a>";
        if ($i == $total_pages) {
            break;
        }
    }
    }elseif ($page == 2) {
        for ($i=1; $i <= $total_pages; $i++) { 
            if ($i == $page) {
                echo "<a href='universities.php?page=$i' style='color:red'>$i</a>";
            }else {
                echo "<a href='universities.php?page=$i'>$i</a>";
            }
            if ($i == $page +2) {
                break;
            }
        }
    }elseif ($page == $total_pages) {
        $pre2 = $page - 2;
        $pre1 = $page - 1;
        echo "<a href='lastest.php?page=$pre2' >$pre2</a>";
        echo "<a href='lastest.php?page=$pre1' >$pre1</a>";
        echo "<a style='color:red'>$page</a>";
    }
    else {
        $bac1 = $page + 1;
        $pre2 = $page - 2;
        $pre1 = $page - 1;
        echo "<a href='lastest.php?page=$pre2' >$pre2</a>";
        echo "<a href='lastest.php?page=$pre1' >$pre1</a>";
        echo "<a style='color:red'>$page</a>";
        echo "<a href='lastest.php?page=$bac1' >$bac1</a>";
    }
    
    
    echo "<a href='lastest.php?page=$total_pages'>尾页</a>";
    echo "<a>共 $total_pages 页</a>
    </div>";
}


function get_university(){
    global $con;
    $per_page = 10;
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }else {
        $page=1;
    }
    $start_from = ($page-1) * $per_page;
    if (!empty($_GET['searchcontent'])) {
        $input = $_GET['searchcontent'];
        echo '<hr><h4 style="font-weight:bold;text-align:center"><small>搜索</small> "'.$input.'" <small>的结果</small></h4>';
        $recommend_query = "SELECT * FROM `university` where uni_name_en like '%$input%' OR zh like '%$input%' LIMIT $start_from, $per_page";
        $run_recommend = mysqli_query($con, $recommend_query);
        echo mysqli_error($con);
        if (!$run_recommend) {
            echo mysqli_error($con)."
            <h5 style='font-weight:bold;text-align:center'>没有你想要的学校？<a href=#>点此反馈</h5>";
        }else{
            while($row = mysqli_fetch_array($run_recommend)){
                $uni_name_en = $row['uni_name_en'];
                $uni_name_zh = $row['zh'];
                $uni_country = $row['uni_country'];
                $uni_location = $row['uni_location'];
                $uni_icon = $row['icon'];
                $uni_link = $row['uni_link'];
                $qs_rank = $row['qs_rank'];
                echo "
                <div class='col-md-13'>
                <ul style='list-style:none;padding-left:20px;padding-top:2px'>
                    <li>
                        <div class='uni-mini-info'>
                            <div style='float:left;'>
                                <a id='uni-img' href='topics.php?uni_name_zh=$uni_name_zh'><img src='$uni_icon'></a>
                            </div>
                            <div class='rank-info'>
                                <h4 id='uni_name'style='margin-left:38px'><a href='topics.php?uni_name_zh=$uni_name_zh'> $uni_name_en $uni_name_zh</a></h4>
                                <div><h5 style='float:right;margin-right: 52px;'><b>排名:$qs_rank</b></h5></div>
                                <ul style='list-style:none'>
                                    <li><p>所在地/Location: $uni_location</p></li>
                                    <li><p>国家:<a href='country.php?selectednation=$uni_country'>$uni_country</a></p></li>
                                    <li><p>官网: <a href='$uni_link' target='_blank'>$uni_link</a></p></li>
                                    <li><br></li>
                                </ul>
                                <div style='clear:both'></div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
                    
                        ";
            }
            echo mysqli_error($con)."<br>
            <h5 style='font-weight:bold;text-align:center'>没有你想要的学校？<a href=#>点此反馈</h5>
            <br>";
        }
        
    }else {
        echo '
        <hr>';
        echo "
        <h3 style='font-weight:bold;text-align:center'>QS大学排名</h3>";
        $uni_info_query = "SELECT * FROM `university`where qs_rank != 0 order by qs_rank asc LIMIT $start_from, $per_page";
        $run_uni_info = mysqli_query($con, $uni_info_query);
        echo mysqli_error($con);
        while($uni_info = mysqli_fetch_array($run_uni_info)){
            $qs_rank = $uni_info['qs_rank'];
            $uni_name_en = $uni_info['uni_name_en'];
            $uni_country = $uni_info['uni_country'];
            $uni_location = $uni_info['uni_location'];
            $uni_icon = $uni_info['icon'];
            $uni_link = $uni_info['uni_link'];
            $uni_name_zh = $uni_info['zh'];
            $toefl_request = $uni_info['toefl_request'];
            $ielt_request = $uni_info['ielt_request'];
            $fee = $uni_info['fee'];
            echo "
            <div class='col-md-13'>
                <ul style='list-style:none;padding-left:20px;padding-top:2px'>
                    <li>
                        <div class='uni-mini-info'>
                            <div style='float:left;'>
                                <br>
                                <a id='uni-img' href='topics.php?uni_name_zh=$uni_name_zh'><img src='$uni_icon'></a>
                            </div>
                            <div class='uni-mini-word-info'>
                                <br>
                                <h4 style='display:inline-block'><a href='topics.php?uni_name_zh=$uni_name_zh'>$uni_name_zh</a></h4>
                                <span style='font-size:5px;color:grey'>$uni_name_en</span>
                                <div><h5 style='float:right;margin-right: 52px;'><b>排名:$qs_rank</b></h5></div>
                                <ul style='list-style:none'>
                                    <li><p>国家/Country:<a href='country.php?selectednation=$uni_country'>$uni_country</a></p></li>
                                    <li><p>所在地/Location: $uni_location</p></li>
                                    <li><p>官网: <a href='$uni_link' target='_blank'>$uni_link</a></p></li>
                                    <li><br></li>
                                </ul>   
                                <div style='clear:both'></div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>";
            }
            
            $query = "select * from university where qs_rank != 0";
            $result = mysqli_query($con, $query);
            echo mysqli_error($con);
            $total_posts = mysqli_num_rows($result);
            echo mysqli_error($con);
            $total_pages = ceil($total_posts / $per_page);
            echo mysqli_error($con);
            echo "
            <center>
                <div class='pagination'>
                <a href='universities.php?page=1'>首页</a>
            ";
            if ($page == 1) {
                for ($i=1; $i <= 3; $i++) { 
                    if ($i == $page) {
                        echo "<a href='universities.php?page=$i' style='color:red'>$i</a>";
                    }else {
                        echo "<a href='universities.php?page=$i'>$i</a>";
                    }
                if ($i == $total_pages) {
                    break;
                }
            }
            }elseif ($page == 2) {
                for ($i=1; $i <= $total_pages; $i++) { 
                    if ($i == $page) {
                        echo "<a href='universities.php?page=$i' style='color:red'>$i</a>";
                    }else {
                        echo "<a href='universities.php?page=$i'>$i</a>";
                    }
                    if ($i == $page +2) {
                        break;
                    }
                }
                
            }elseif ($page == $total_pages) {
                $pre2 = $page - 2;
                $pre1 = $page - 1;
                echo "<a href='universities.php?page=$pre2' >$pre2</a>";
                echo "<a href='universities.php?page=$pre1' >$pre1</a>";
                echo "<a style='color:red'>$page</a>";
            }
            else {
                $bac1 = $page + 1;
                $pre2 = $page - 2;
                $pre1 = $page - 1;
                echo "<a href='universities.php?page=$pre2' >$pre2</a>";
                echo "<a href='universities.php?page=$pre1' >$pre1</a>";
                echo "<a style='color:red'>$page</a>";
                echo "<a href='universities.php?page=$bac1' >$bac1</a>";
                if (!$page + 2 > $total_pages) {
                    $bac2 = $page + 2;
                    echo "<a href='universities.php?page=$bac2' >$bac2</a>";
                }
            }
            
            
            echo "<a href='universities.php?page=$total_pages'>尾页</a>";
            echo "<a>共 $total_pages 页</a>
            </div>";
    }
}

function get_country($cn_country){
    global $con;
    global $en_country;
    $per_page = 10;
    
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }else {
        $page=1;
    }
    $start_from = ($page-1) * $per_page;
    $uni_query = "SELECT * FROM `university` where uni_country = '$cn_country' LIMIT $start_from, $per_page";
    $run_recommend = mysqli_query($con, $uni_query);
    echo mysqli_error($con);
    if (!$run_recommend) {
        echo "<h5 style='font-weight:bold;text-align:center'>没有你想要的学校？<a href=#>点此反馈</a></h5>";
    }else {
        while($row = mysqli_fetch_array($run_recommend)){
            $uni_name_en = $row['uni_name_en'];
            $uni_name_zh = $row['zh'];
            $uni_country = $row['uni_country'];
            $uni_location = $row['uni_location'];
            $uni_icon = $row['icon'];
            $uni_link = $row['uni_link'];
            $local_rank = $row['local_rank'];
            if ($local_rank == 0) {
                $local_rank = null;
            }else {
                $local_rank = $row['local_rank'];
            }
            // $insert_search_num = "UPDATE rank SET search_rank = search_rank + 1 WHERE uni_name_zh = '$uni_name_zh'";
            // $run_query = mysqli_query($con, $insert_search_num);
            // echo mysqli_error($con);
            
            echo "
                <div class='col-md-13'>
                    <ul style='list-style:none;padding-left:20px;padding-top:2px'>
                        <li>
                            <div class='uni-mini-info'>
                                <div style='float:left;'>
                                    <br>
                                    <a href='info.php?uni_name_zh=$uni_name_zh'><img src='$uni_icon' alt='' width='120px' height='120px' style='margin-left:10px;margin-bottom:15px;'></a>
                                </div>
                                <div class='rank-info'>
                                    <br>
                                    <h4 style='margin-left:38px'><a href='topics.php?uni_name_zh=$uni_name_zh'> $uni_name_en $uni_name_zh</a></h4>
                                    <div><h5 style='float:right;margin-right: 52px;'><b>$local_rank</b></h5></div>
                                    <ul style='list-style:none'>
                                        <li><p>所在地/Location: $uni_location in <a href='country.php?selectednation=$uni_country'>$uni_country</a></p></li>
                                        <li><p>官网: <a href='$uni_link' target='_blank'>$uni_link</a></p></li>
                                        <li><br></li>
                                    </ul>
                                    <div style='clear:both'></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                    ";
                }
    }
        $query = "select * from university where uni_country = '$cn_country'";
            $result = mysqli_query($con, $query);
            echo mysqli_error($con);
            $total_posts = mysqli_num_rows($result);
            echo mysqli_error($con);
            $total_pages = ceil($total_posts / $per_page);
            echo mysqli_error($con);
            echo "
            <center>
                <div class='pagination'>
                <a href='country.php?selectednation=$cn_country&page=1'>首页</a>
            ";
            if ($page == 1) {
                for ($i=1; $i <= 3; $i++) { 
                    if ($i == $page) {
                        echo "<a href='country.php?selectednation=$cn_country&page=$i' style='color:red'>$i</a>";
                    }else {
                        echo "<a href='country.php?selectednation=$cn_country&page=$i'>$i</a>";
                    }
                if ($i == $total_pages) {
                    break;
                }
            }
            }elseif ($page == 2) {
                for ($i=1; $i <= $total_pages; $i++) { 
                    if ($i == $page) {
                        echo "<a href='country.php?selectednation=$cn_country&page=$i' style='color:red'>$i</a>";
                    }else {
                        echo "<a href='country.php?selectednation=$cn_country&page=$i'>$i</a>";
                    }
                    if ($i == $page +2) {
                        break;
                    }
                }
            }elseif ($page == $total_pages) {
                $pre2 = $page - 2;
                $pre1 = $page - 1;
                echo "<a href='country.php?selectednation=$cn_country&page=$pre2' >$pre2</a>";
                echo "<a href='country.php?selectednation=$cn_country&page=$pre1' >$pre1</a>";
                echo "<a style='color:red'>$page</a>";
            }
            else {
                $bac1 = $page + 1;
                $pre2 = $page - 2;
                $pre1 = $page - 1;
                echo "<a href='country.php?selectednation=$cn_country&page=$pre2' >$pre2</a>";
                echo "<a href='country.php?selectednation=$cn_country&page=$pre1' >$pre1</a>";
                echo "<a style='color:red'>$page</a>";
                echo "<a href='country.php?selectednation=$cn_country&page=$bac1' >$bac1</a>";
            }
            
            
            echo "<a href='country.php?selectednation=$cn_country&page=$total_pages'>尾页</a>";
            echo "<a>共 $total_pages 页</a>
            </div>";
            echo "<br>
            <h5 style='font-weight:bold;text-align:center'>没有你想要的学校？<a href=#>点此反馈</a></h5>
            <br>";
    
}

function get_hot_posts(){
    global $con;
    $per_page = 15;

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }else {
        $page=1;
    }
    $start_from = ($page-1) * $per_page;

    $get_posts = "select * from posts order by post_like DESC LIMIT $start_from, $per_page";

    echo mysqli_error($con);
    $run_posts = mysqli_query($con, $get_posts);
    echo mysqli_error($con);
    while ($row = mysqli_fetch_array($run_posts)) {
        echo mysqli_error($con); 
        $post_id = $row['post_id'];
        $post_content = $row['post_content'];
        if(preg_match('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$post_content,$match)){
        $post_img = $match[0];
        }else {
            $post_img = null;
        }
        $post_content = strip_tags($post_content);
        if (strlen($post_content) > 50) {
            $post_content = mb_substr($post_content,0, 60)."..<a href='../post.php?post_id=$post_id' target='_blank'>查看全文</a>";
        }

        $post_title = $row['post_title'];
        $post_date = $row['post_date'];
        $user_id = $row['user_id'];
        $post_like = $row['post_like'];
        $post_date = wordTime($post_date);
        $writer = "select * from users where user_id = '$user_id' AND posts ='yes'";
        $run_writer = mysqli_query($con, $writer);
        $row_writer = mysqli_fetch_array($run_writer);


        $user_name = $row_writer['user_name'];
        $user_image = $row_writer['user_image'];

        echo "
        <div class='col-md-12' style='padding:10px;padding-bottom:5px;border-top: 1px solid #f0f2f7;'>
            <div id='post-img'style='float:left;'>
                <a id='post_img'href='../post.php?post_id=$post_id' target='_blank'><span>$post_img</span></a>
            </div>
            <div style='width:100%'>
                <a href='../post.php?post_id=$post_id' target='_blank'>
                    <b style='line-height:1.4;font-size:1.3em;'>
                        $post_title
                    </b>
                </a>
                $post_date
                <br>
                <a id='image' href='../profile.php?u_id=$user_id' target='_blank' style='font-size:1em;'>
                    <img src='../$user_image' class='img-circle' style='width:20px;'> 
                </a>
                <a id='name' href='../profile.php?u_id=$user_id' target='_blank'style='font-size:1.1em;'>
                    $user_name  
                </a>
                :
                <a id='content' href='../post.php?post_id=$post_id' target='_blank'>
                    $post_content
                </a>
            </div>
            <div style='clear:both'></div>
        </div>
        <ul class='article-function'>
            <li>
                <button id='click_like'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart' viewBox='0 0 16 16'>
                    <path fill-rule='evenodd' d='M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z'/>
                    </svg>";
        if ($post_like == null) {
            echo "点赞";
        }else {
            echo $post_like;
        }           
                   
        echo    "</button>
            </li>
            <li>
                <button>
                    <a href='../post.php?post_id=$post_id' target='_blank'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'>
                        <path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/>
                        <path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/>
                        </svg>
                        评论
                    </a>
                </button>
            </li>
            <li>
                <button>
                    <a>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'>
                            <path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/>
                        </svg>
                        收藏
                    </a>
                </button>
            </li>
        </ul>
        <div style='clear:both'></div>
    ";
    }
    $query = "select * from posts";
    $result = mysqli_query($con, $query);

    $total_posts = mysqli_num_rows($result);

    $total_pages = ceil($total_posts / $per_page);

    echo "
    <center>
        <div class='pagination'>
        <a href='hot.php?page=1'>首页</a>
    ";
    if ($page == 1) {
        for ($i=1; $i <= 3; $i++) { 
            if ($i == $page) {
                echo "<a href='hot.php?page=$i' style='color:red'>$i</a>";
            }else {
                echo "<a href='hot.php?page=$i'>$i</a>";
            }
        if ($i == $total_pages) {
            break;
        }
    }
    }elseif ($page == 2) {
        echo "<a href='hot.php?page=1'>1</a>";
        for ($i=2; $i < 5; $i++) { 
            if ($i == $page) {
                echo "<a href='hot.php?page=$i' style='color:red'>$i</a>";
            }else {
                echo "<a href='hot.php?page=$i'>$i</a>";
            }
            
            if ($i == $total_pages) {
                break;
            }
        }
    }elseif ($page == $total_pages) {
        $pre2 = $page - 2;
        $pre1 = $page - 1;
        echo "<a href='hot.php?page=$pre2' >$pre2</a>";
        echo "<a href='hot.php?page=$pre1' >$pre1</a>";
        echo "<a style='color:red'>$page</a>";
    }
    else {
        $bac1 = $page + 1;
        $pre2 = $page - 2;
        $pre1 = $page - 1;
        echo "<a href='hot.php?page=$pre2' >$pre2</a>";
        echo "<a href='hot.php?page=$pre1' >$pre1</a>";
        echo "<a style='color:red'>$page</a>";
        echo "<a href='hot.php?page=$bac1' >$bac1</a>";
    }
    
    
    echo "<a href='hot.php?page=$total_pages'>尾页</a>";
    echo "<a>共 $total_pages 页</a>
    </div>";
}

function get_question(){
    global $con;
    $per_page = 15;

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }else {
        $page=1;
    }
    $start_from = ($page-1) * $per_page;

    $get_posts = "select * from question order by qu_date DESC LIMIT $start_from, $per_page";

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
        $writer = "select * from users where user_id = '$user_id' AND posts ='yes'";
        $run_writer = mysqli_query($con, $writer);
        $row_writer = mysqli_fetch_array($run_writer);


        $user_name = $row_writer['user_name'];
        $user_image = $row_writer['user_image'];

        echo "
        <div class='col-md-12' style='padding:10px;padding-bottom:5px;border-top: 1px solid #f0f2f7;'>
            <div style='width:100%'>
            
                <a id='image' href='../profile.php?u_id=$user_id' target='_blank' style='font-size:1em;'>
                    <img src='../$user_image' class='img-circle' style='width:30px;'> 
                </a>
        
                <a id='name' href='../profile.php?u_id=$user_id' target='_blank'style='font-size:1.2em;'>
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
                <button>
                <a >
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'>
                        <path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/>
                        <path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/>
                        </svg>
                        ";
                        if ($is_answered == 'no') {
                            echo $qu_content."
                            </button>";
                        }else {
                            $sql = "Select * from answer where qu_id = $qu_id";
                            $result = mysqli_query($con,$sql);
                            if ($result) {
                                $num = mysqli_num_rows($result);
                                echo    "查看回答</a>
                                    </button>
                                </li>
                                <li>
                                    <button id='click_like'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-menu-up' viewBox='0 0 16 16'>
                                            <path fill-rule='evenodd' d='M15 3.207v9a1 1 0 0 1-1 1h-3.586A2 2 0 0 0 9 13.793l-1 1-1-1a2 2 0 0 0-1.414-.586H2a1 1 0 0 1-1-1v-9a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm-13 11a2 2 0 0 1-2-2v-9a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-3.586a1 1 0 0 0-.707.293l-1.353 1.354a.5.5 0 0 1-.708 0L6.293 14.5a1 1 0 0 0-.707-.293H2z'/>
                                            <path fill-rule='evenodd' d='M15 5.207H1v1h14v-1zm0 4H1v1h14v-1zm-13-5.5a.5.5 0 0 0 .5.5h6a.5.5 0 1 0 0-1h-6a.5.5 0 0 0-.5.5zm0 4a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 0-1h-11a.5.5 0 0 0-.5.5zm0 4a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 0-1h-8a.5.5 0 0 0-.5.5z'/>
                                        </svg>
                                        回答$num
                                    </button>
                                </li>";
                            }
                        }   
            echo "<li>
                <button>
                    <a href='../post.php?qu_id=$qu_id' target='_blank'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-cursor' viewBox='0 0 16 16'>
                            <path fill-rule='evenodd' d='M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103zM2.25 8.184l3.897 1.67a.5.5 0 0 1 .262.263l1.67 3.897L12.743 3.52 2.25 8.184z'/>
                        </svg>
                        我来回答
                    </a>
                </button>
            </li>
        </ul>
        <div style='clear:both'></div>
    ";
    }
    $query = "select * from question";
    $result = mysqli_query($con, $query);

    $total_posts = mysqli_num_rows($result);

    $total_pages = ceil($total_posts / $per_page);

    echo "
    <center>
        <div class='pagination'>
        <a href='question.php?page=1'>首页</a>
    ";
    if ($page == 1) {
        for ($i=1; $i <= 3; $i++) { 
        echo "<a href='question.phppage=$i'>$i</a>";
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
        echo "<a style='color:red'>$page</a>";
    }
    else {
        $bac1 = $page + 1;
        $pre2 = $page - 2;
        $pre1 = $page - 1;
        echo "<a href='question.php?page=$pre2' >$pre2</a>";
        echo "<a href='question.php?page=$pre1' >$pre1</a>";
        echo "<a style='color:red'>$page</a>";
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