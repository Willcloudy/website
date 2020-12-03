<?php
//大学推荐
$recommend_query = "SELECT * FROM `university` ORDER BY Rand() LIMIT 10";
$run_recommend = mysqli_query($con, $recommend_query);
while($row = mysqli_fetch_array($run_recommend)){
    $uni_name_en = $row['uni_name_en'];
    $uni_name_zh = $row['uni_name_zh'];
    $uni_country = $row['uni_country'];
    $uni_location = $row['uni_location'];
    $uni_icon = $row['uni_icon'];
    $uni_link = $row['uni_link'];

    echo "
    <div class='col-md-13'>
        <ul style='list-style:none;padding-left:20px;padding-top:2px'>
            <li>
                <div class='uni-mini-info'>
                    <div style='float:left;'>
                        <br>
                        <a href='info.php?uni_name_zh=$uni_name_zh'><img src='$uni_icon' alt='' width='120px' height='120px' style='margin-left:10px;margin-bottom:15px;'></a>
                    </div>
                    <div class='uni-mini-word-info'>
                        <br>
                        <h4 style='margin-left:38px'><a href='info.php?uni_name_zh=$uni_name_zh'> $uni_name_en $uni_name_zh</a></h4>
                        <ul style='list-style:none'>
                            <li><p>所在地/Location: $uni_location in <a href='country.php?country=$uni_country'>$uni_country</a></p></li>
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
?>
<!-- 大学排行 -->
<div class="row" >
    <div class="col-md-12 ranknav">
        <ul id="myTab" class="rank nav nav-tabs ">
            <li class="active"><a href="#trend" data-toggle="tab">Trend</a></li>
            <li><a href="#top100" data-toggle="tab">QSTop100</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="trend">
                <img src="img/toprankbc.jpg" alt="" class='img-responsive' style='margin:0;padding:0;'>
                <h4 class='searchRank'>搜索次数排名</h4>
                <div style='clear:both'></div>
                <div class="col-md-13">
                    <ul style='list-style:none;padding-left:20px;padding-top:2px'>
                        <?php
                            $search_rank_query = "SELECT * FROM rank order by search_rank desc ";
                            $run_search_rank = mysqli_query($con, $search_rank_query);
                            while(@$row = mysqli_fetch_array($run_search_rank)) {
                                $uni_name_zh = $row['uni_name_zh'];
                                $qs_rank = $row['qs_rank'];
                                $search_rank = $row['search_rank'];
                                
                                @$uni_info_query = "SELECT * FROM `university` where uni_name_zh = '$uni_name_zh'";
                                @$run_uni_info = mysqli_query($con, $uni_info_query);
                                @$uni_info = mysqli_fetch_array($run_uni_info);
                                @$uni_name_en = $uni_info['uni_name_en'];
                                @$uni_country = $uni_info['uni_country'];
                                @$uni_location = $uni_info['uni_location'];
                                @$uni_icon = $uni_info['uni_icon'];
                                @$uni_link = $uni_info['uni_link'];
                                echo "
                                <li>
                                    <div class='uni-mini-info'>
                                        <div style='float:left;'>
                                            <br>
                                            <a href='info.php?uni_name_zh=$uni_name_zh'><img src='$uni_icon' alt='' width='120px' height='120px' style='margin-left:10px'></a>
                                        </div>
                                        <div class='uni-mini-word-info'>
                                            <br>
                                            <h4 style='margin-left:10px;display:inline-block'><a href='info.php?uni_name_zh=$uni_name_zh'>$uni_name_zh</a></h4>
                                            <span style='font-size:5px;color:grey'>$uni_name_en</span>
                                            <div><h5 style='float:right;margin-right: 52px;'><b>搜索次数:$search_rank</b></h5></div>
                                            <ul style='list-style:none'>
                                                <li><p>国家/Country: <a href='country.php?country=$uni_country'>$uni_country</a></p></li>
                                                <li><p>所在地/Location: $uni_location</p></li>
                                                <li><p>官网: <a href='$uni_link' target='_blank'>$uni_link</a></p></li>
                                                <li><span></span></li>
                                                <li><br></li>
                                            </ul>   
                                            <div style='clear:both'></div>
                                        </div>
                                    </div>
                                </li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>

            <div class="tab-pane fade" id="top100">
                <img src="img/toprankbc.jpg" alt="" class='img-responsive' style='margin:0;margin-top:1px;padding:0;'>
                <h2 class='searchRank'>QS大学排名</h2>
                <div style='clear:both'></div>
                <div class="col-md-13">
                    <ul style='list-style:none;padding-left:20px;padding-top:2px'>
                    <?php
                        $qs_rank_query = "SELECT * FROM rank order by qs_rank asc";
                        $run_qs_rank = mysqli_query($con, $qs_rank_query);
                        while($row = mysqli_fetch_array($run_qs_rank)) {
                            $uni_name_zh = $row['uni_name_zh'];
                            $qs_rank = $row['qs_rank'];

                            $uni_info_query = "SELECT * FROM `university` where uni_name_zh = '$uni_name_zh'";
                            $run_uni_info = mysqli_query($con, $uni_info_query);
                            
                            while($uni_info = mysqli_fetch_array($run_uni_info)){
                            $uni_name_en = $uni_info['uni_name_en'];
                            $uni_country = $uni_info['uni_country'];
                            $uni_location = $uni_info['uni_location'];
                            $uni_icon = $uni_info['uni_icon'];
                            $uni_link = $uni_info['uni_link'];
                            echo "
                            <li>
                                <div class='uni-mini-info'>
                                    <div style='float:left;'>
                                        <br>
                                        <a href='info.php?uni_name_zh=$uni_name_zh'><img src='$uni_icon' alt='' width='120px' height='120px' style='margin-left:10px'></a>
                                    </div>
                                    <div class='uni-mini-word-info'>
                                        <br>
                                        <h4 style='margin-left:10px;display:inline-block'><a href='info.php?uni_name_zh=$uni_name_zh'>$uni_name_zh</a></h4>
                                        <span style='font-size:5px;color:grey'>$uni_name_en</span>
                                        <div><h5 style='float:right;margin-right: 52px;'><b>排名:$qs_rank</b></h5></div>
                                        <ul style='list-style:none'>
                                            <li><p>国家/Country:<a href='country.php?country=$uni_country'>$uni_country</a></p></li>
                                            <li><p>所在地/Location: $uni_location</p></li>
                                            <li><p>官网: <a href='$uni_link' target='_blank'>$uni_link</a></p></li>
                                            <li><br></li>
                                        </ul>   
                                        <div style='clear:both'></div>
                                    </div>
                                </div>
                            </li>";}
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


