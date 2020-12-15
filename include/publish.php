<div class="box">
    <?php
    if (isset($u_id)) {
        echo "
            <div id='write-box'>
                <a href='profile.php?u_id=$u_id'><img id='home-profile'src='$u_image' alt='profile' width='50px' class='img-circle'></a>
                <a  data-toggle='modal' data-target='#rise_question'>
                    <input type='text' autoComplete='off' required placeholder='对于留学生活的有疑惑?' maxlength='20' style='margin-left:20px;width:60%;border-bottom:1px solid #ccc' name='question' id='question-title'>
                    <button id='question'type='submit'>提问</button></a>
                </a>
                <a data-toggle='modal' data-target='#write_article'>
                    <span id='write' >
                        写文章
                    </span>
                </a>
            </div>
            <div style='clear:both'></div>
            ";
    }else {
        echo "
            <div style='text-align:center;margin-top:5%'>
                <button class='btn btn-primary' onclick=document.getElementById('login').click() >登录</button>后开启发布文章和提问题功能
            </div>";
    }
    ?>
    
</div> 

<div class="modal fade" id="rise_question" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"style='width:100%'>
                <div class="modal-body" >
                    <button type="button" class='close'data-dismiss="modal" aria-hidden="true" >
                        &times;
                    </button>
                    <div class="question-form" >
                        <form action="home.php" method="POST">
                            <input type="text" autoComplete="off" required placeholder="写下你的疑惑?(20字)" maxlength="20" style="width:80%;border-bottom:1px solid #ccc" name="question" id="article-title">?
                            <button id="question" type="submit">发布</button></a>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
<?php
    if (!empty($_POST['write-content'])) {
        $content = addslashes($_POST['write-content']);
        $title = addslashes($_POST['title']);
        $insert = "Insert into posts 
        (user_id, post_content,post_title, post_date) 
        values('$u_id', '$content','$title', NOW())";
    
        $run = mysqli_query($con, $insert);
        echo mysqli_error($con);
        if ($run) {
            echo "<script>alert('发布成功')</script>";
            echo "<script>window.open('home.php','_self')</script>";

            $update = "update users set 
            posts='yes' where user_id='$u_id'";
            $run_update = mysqli_query($con, $update);
        }else {
            echo "<script>alert('发布失败')</script>";
            mysqli_error($con);
            //echo "<script>window.open('home.php','_self')</script>";
        }
    }
    if (!empty($_POST['question'])) {
        $question = addslashes($_POST['question']);
        $insert = "Insert into question 
        (user_id, question, qu_date, is_answered) 
        values('$u_id','$question', NOW(), 'no')";
    
        $run = mysqli_query($con, $insert);
        echo mysqli_error($con);
        if ($run) {
            echo "<script>alert('发布成功')</script>";
            echo "<script>window.open('home.php','_self')</script>";

        }else {
            echo "<script>alert('发布失败')</script>";
            mysqli_error($con);
            //echo "<script>window.open('home.php','_self')</script>";
        }
    }

?>