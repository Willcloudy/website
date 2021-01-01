<?php 
    include('../include/connection.php');

    $post_id = $_POST['postId'];
    $user_id = $_POST['userId'];
    if ($user_id == 0) {
        # code...
    }
    $select_post = "SELECT * FROM `posts` WHERE post_id = '$post_id'";
    $select_query = mysqli_query($con, $select_post);
    echo mysqli_error($con);
    $row = mysqli_fetch_array($select_query);
    $post_like = $row['post_like'];
    $post_view = $row['post_view'];
    $update_like = $post_like + 1;

    $insert_like = "INSERT INTO like_post (post_id, user_id, like_date) values ('$post_id', '$user_id', NOW())";
    $insert_query = mysqli_query($con, $insert_like);

    echo mysqli_error($con);
    $like_post = "UPDATE `posts` SET `post_like` = $update_like WHERE post_id = '$post_id'";
    $update_query = mysqli_query($con, $like_post);

    $post_like = $update_like;
    echo mysqli_error($con);
    if ($update_query) {
        echo "
        <ul class='article-function'>
            <li>
                <button id='$post_id' name='$post_id' onclick='zanDel(this)' style='color:red;background-color:white;' class='btn btn-primary liked_post'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'>
                    <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'></path>
                    </svg>
                    <span id=$user_id>
                    $post_like
                    </span>
                </button>
            </li>
        <li><a href='../post.php?post_id=$post_id' target='_blank'><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>评论</button></a></li>
        <li><a><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg>收藏</button></a></li>
        
            </ul>
            <span style='float:right;margin-right:7%;margin-top:1%;font-size:0.1em;color:rgb(91, 112, 131);'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 -2 16 16'>
                <path fill-rule='evenodd' d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z'/>
                <path fill-rule='evenodd' d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                </svg>&nbsp;&nbsp;<span>$post_view</span>
            </span>
            <div style='clear:both'></div>
        ";
    }else {
        echo '点赞错误';
        echo "$post_id dakwdk $user_id".mysqli_error($con);
    }


?> 