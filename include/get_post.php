
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
        mysqli_query($con, "set names 'utf8'");
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
                $fee = $row['fee'];
                echo "
                <div class='col-md-13'>
                <ul style='list-style:none;padding-left:20px;padding-top:2px'>
                    <li>
                        <div class='uni-mini-info'>
                            <div style='float:left;'>
                                <a id='uni-img' href='topics.php?uni_name_zh=$uni_name_zh'><img src='$uni_icon'></a>
                            </div>
                            <div class='rank-info' style='padding:5px;'>
                                <h4 id='uni_name'style='margin-left:38px'><a href='topics.php?uni_name_zh=$uni_name_zh'> $uni_name_en $uni_name_zh</a></h4>
                                <div><h5 style='float:right;margin-right: 52px;'><b>排名:$qs_rank</b></h5></div>
                                <ul style='list-style:none'>
                                    <li><p>所在地/Location: $uni_location</p></li>
                                    <li><p>国家:<a href='country.php?selectednation=$uni_country'>$uni_country</a></p></li>
                                    <li><p>费用: $fee</p></li>
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
        
    }elseif (!empty($_GET['rank'])) {
        if ($_GET['rank'] == 'qs') {
            # code...
        
        echo '
        <hr>';
        $uni_info_query = "SELECT * FROM `university`where qs_rank != 0 order by qs_rank asc LIMIT $start_from, $per_page";
        mysqli_query($con, "set names 'utf8'");
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
                                    <li><p>费用: $fee</p></li>
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
            if ($total_pages == 1 or $total_pages == 0) {
                # code...
            }else {
                # code...
            
            echo mysqli_error($con);
            echo "
            <center>
                <div class='pagination'>
                <a href='universities.php?page=1'>首页</a>
            ";
            if ($page == 1) {
                for ($i=1; $i <= 3; $i++) { 
                    if ($i == $page) {
                        echo "<a href='universities.php?page=$i' style='color:#198754'>$i</a>";
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
                        echo "<a href='universities.php?page=$i' style='color:#198754'>$i</a>";
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
                echo "<a style='color:#198754'>$page</a>";
            }
            else {
                $bac1 = $page + 1;
                $pre2 = $page - 2;
                $pre1 = $page - 1;
                echo "<a href='universities.php?page=$pre2' >$pre2</a>";
                echo "<a href='universities.php?page=$pre1' >$pre1</a>";
                echo "<a style='color:#198754'>$page</a>";
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
    }else {
        echo '
        <hr>';
        $uni_info_query = "SELECT * FROM `university` LIMIT $start_from, $per_page";
        mysqli_query($con, "set names 'utf8'");
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
                                <ul style='list-style:none'>
                                    <li><p>国家/Country:<a href='country.php?selectednation=$uni_country'>$uni_country</a></p></li>
                                    <li><p>所在地/Location: $uni_location</p></li>
                                    <li><p>费用: $fee</p></li>
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
                        echo "<a href='universities.php?page=$i' style='color:198754'>$i</a>";
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
                        echo "<a href='universities.php?page=$i' style='color:#198754'>$i</a>";
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
                echo "<a style='color:#198754'>$page</a>";
            }
            else {
                $bac1 = $page + 1;
                $pre2 = $page - 2;
                $pre1 = $page - 1;
                echo "<a href='universities.php?page=$pre2' >$pre2</a>";
                echo "<a href='universities.php?page=$pre1' >$pre1</a>";
                echo "<a style='color:#198754'>$page</a>";
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
    mysqli_query($con, "set names 'utf8'");
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
            $fee = $row['fee'];
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
                                    <a href='topics.php?uni_name_zh=$uni_name_zh'><img src='$uni_icon' alt='' width='120px' height='120px' style='margin-left:10px;margin-bottom:15px;'></a>
                                </div>
                                <div class='rank-info'>
                                    <br>
                                    <h4 style='margin-left:38px'><a href='topics.php?uni_name_zh=$uni_name_zh'> $uni_name_en $uni_name_zh</a></h4>
                                    <ul style='list-style:none'>
                                        <li><p>所在地/Location: $uni_location in <a href='country.php?selectednation=$uni_country'>$uni_country</a></p></li>
                                        <li><p>费用: $fee</p></li>
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
        mysqli_query($con, "set names 'utf8'");
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
                        echo "<a href='country.php?selectednation=$cn_country&page=$i' style='color:#198754'>$i</a>";
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
                        echo "<a href='country.php?selectednation=$cn_country&page=$i' style='color:#198754'>$i</a>";
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
                echo "<a style='color:#198754'>$page</a>";
            }
            else {
                $bac1 = $page + 1;
                $pre2 = $page - 2;
                $pre1 = $page - 1;
                echo "<a href='country.php?selectednation=$cn_country&page=$pre2' >$pre2</a>";
                echo "<a href='country.php?selectednation=$cn_country&page=$pre1' >$pre1</a>";
                echo "<a style='color:#198754'>$page</a>";
                echo "<a href='country.php?selectednation=$cn_country&page=$bac1' >$bac1</a>";
            }
            
            
            echo "<a href='country.php?selectednation=$cn_country&page=$total_pages'>尾页</a>";
            echo "<a>共 $total_pages 页</a>
            </div>";
            echo "<br>
            <h5 style='font-weight:bold;text-align:center'>没有你想要的学校？<a href=#>点此反馈</a></h5>
            <br>";
    
}
?>