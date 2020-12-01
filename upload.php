<div id="Editable-panel">
    <p>欢迎使用 <b>wangEditor</b> 富文本编辑器</p>
</div>

<script type="text/javascript" src="//unpkg.com/wangeditor/dist/wangEditor.min.js"></script>
<script type="text/javascript">
    const E = window.wangEditor
    const editor = new E('#Editable-panel')
    // 或者 const editor = new E( document.getElementById('div1') )
    editor.create()
</script>