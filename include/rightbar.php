
<div class="col-md-3" id='rightbar' style='margin-top: 15px'>
    <form action="result.php" method="POST">
        <span>
            <input class='form-control search' type="text" name='searchcontent' placeholder='搜索大学/文章/用户' required='required'/>
        </span>
        <span class='span2'>
            <a href="result.php">
                <button class='form-control btn btn-primary'type='submit'>
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </a>
        </span>
        <div style="clear:both;"></div>
        <br>
    </form>
    <div class='rightbar' >
        <div class='ulist'>
            <h4 style='font-weight:bold;text-align:center;margin-top:20px;'>对比国内外物价</h4>
            <div class="row">
                <div class='col-md-11' style='border:0px;box-shadow:none;'>
                    <ul style='list-style:none;padding-left:20px;'>
                        <li>
                            <div>
                                <div >
                                    <a href='country.php?country=UK'><img src='img/enland.jpg' alt='' class='img-responsive'/></a>
                                </div>
                                    <a href="country.php?country=UK" ><h4 style='text-align:center;margin:0px'>英国/Prices in British</h4></a>
                                </div>
                        </li>
                        <li>
                            <div>
                                <div>
                                    <a href='country.php?country=CAN'><img src='img/caland.jpg' alt='' class='img-responsive'/></a>
                                </div>
                                    <a href="country.php?country=CAN"><h4 style='text-align:center;margin:0px'>加拿大/Prices in Canada</h4></a>
                            </div>
                        </li>
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
    var more = top + 100;
    $(window).scroll(function() {
    var scrolls = $(this).scrollTop();
    if (scrolls > more) {
        if (window.XMLHttpRequest) {
        element.css({
        "width" : "19%",
        "marginTop": "15px",
        position: "fixed",
        top: 0,
        left: 1050,
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