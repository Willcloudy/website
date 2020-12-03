<div class="box">
            <?php
            if (isset($u_id)) {
                echo "
                    <div id='write-box'>
                        <a href='profile.php?u_id=$u_id'><img id='home-profile'src='$u_image' alt='profile' width='65px' class='img-circle'></a>
                        <form action='write.php' method='GET'>
                            <input type='text' autoComplete='off' placeholder='给故事起个标题...' name='title' id='article-title'>
                            
                            <div id='toolbar-container' class='toolbar'></div>
                            <div id='text-container' class='text'></div>
                            <textarea id='text1' name='write-content'style='width:100%; height:200px;display:none;''></textarea>
                            <button id='goWrite' type='submit'>去分享</button></a>
                        </form>
                    </div>";
            }
            ?>
            <script type='text/javascript' src='//unpkg.com/wangeditor/dist/wangEditor.min.js'></script>
            <script>
                const E = window.wangEditor
                const editor = new E('#toolbar-container', '#text-container')
                editor.config.menus = [
                    'image',
                    'link',
                    'fontSize',
                    'fontName',
                    'italic',
                    'underline',
                    'indent',
                    'foreColor',
                ]
                editor.config.placeholder = '分享一个留学时候的故事'
                editor.config.showLinkImg = false   
                editor.config.uploadImgAccept = ['jpg', 'jpeg', 'png', 'gif', 'bmp']
                editor.config.uploadImgShowBase64 = true
                //editor.customConfig.customUploadImg = function (files, insert) {
                        // files 是 input 中选中的文件列表
                        // insert 是获取图片 url 后，插入到编辑器的方法

                        // 上传代码返回结果之后，将图片插入到编辑器中
                        //insert(imgUrl)
                    //}
                const $text1 = $('#text1')
                editor.config.onchange = function (html) {
                    // 第二步，监控变化，同步更新到 textarea
                    $text1.val(html)
                }
                editor.create()

                // 第一步，初始化 textarea 的值
                $text1.val(editor.txt.html())
            
            </script>
            </div> 