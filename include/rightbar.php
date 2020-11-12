
<div class="col-md-3" id='tuijian' style='margin-top: 15px'>
        <form action="result.php" method="POST">
            <span>
                <input class='form-control' type="text" name='searchcontent' style='font-size:1em;width:80%;float:left;display:inline-block;
                height:39px;margin-right:0;border-radius:15px 0px 0px 15px;' placeholder='搜索大学/文章/用户'>
            </span>
            <span class='span2'>
                <a href="result.php"><button class='form-control btn btn-primary'type='submit' style='float:right;
                height:38.5px;display:inline-block;width:20%;margin-left:0;border-radius:0px 15px 15px 0px;font-weight:bold;
                background-color: #00BFFF;'><span class="glyphicon glyphicon-search"></span></button></a>
            </span>
            <div style="clear:both;"></div>
            <br>
        </form>
    <div class='tuijian' >
        <div class='ulist'>
            <h4 style='font-weight:bold;text-align:center;margin-top:20px;'>对比国内外物价</h4>
            <div class="row">
                <div class='col-md-11' style='border:0px;box-shadow:none;'>
                    <ul style='list-style:none;padding-left:20px;padding-top:2px'>
                        <li>
                            <div class='toprank'>
                                <div >
                                    <a href='country.php?country=UK'><img src='img/enland.jpg' alt='' class='img-responsive' width='100px'></a>
                                </div>
                                    <a href="country.php?country=UK"><h4 style='text-align:center'>英国/Prices in British</h4></a>
                                </div>
                        </li>
                        <li>
                            <div class='toprank'>
                                <div>
                                    <a href='country.php?country=CAN'><img src='img/caland.jpg' alt='' class='img-responsive'width='100px'></a>
                                </div>
                                    <a href="country.php?country=CAN"><h4 style='text-align:center'>加拿大/Prices in Canada</h4></a>
                            </div>
                        </li>
                        <li>
                            <div class='toprank'>
                                <div >
                                    <a href='country.php?country=AUS'><img src='img/auland.jpg' alt='' class='img-responsive' width='100px'></a>
                                </div>
                                <a href="search.php?country=AUS"><h4 style='text-align:center'>Prices in Australia</h4></a>
                            </div>
                        </li>
                    </ul>
                </div>           
            </div>
            <br>
        </div>
    </div>
    <br>
</div>

<!-- <div class="col-md-3">
    <div class='tuijian'>
        <div class="plist">
            <h3 style='font-weight:bold;'>Who to follow</h3>
        </div>
    </div>
</div> -->

<script>
    $.fn.smartFloat = function() {
    var position = function(element) {
    var top = element.position().top, pos = element.css("position");
    var more = top + 80;
    $(window).scroll(function() {
    var scrolls = $(this).scrollTop();
    if (scrolls > more) {
        if (window.XMLHttpRequest) {
        element.css({
        "width" : "19.4%",
        "marginTop": "15px",
        position: "fixed",
        top: 0,
        left: 1050
        }); 
        } else {
        element.css({
        top: scrolls
        }); 
        }
    }else {
        element.css({
        width:"25%",
        position: pos,
        left:0
        }); 
    }
    });
    };
    return $(this).each(function() {
    position($(this));      
    });
    };
    $('#tuijian').smartFloat();


</script>