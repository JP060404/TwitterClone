<script> //JSをHTMLに組み込む場合最後にすることで読み込みスピードが上がる。
    document.addEventListener('DOMContentLoaded' , function() {　//第一引数にDOMContentLoadedを指定することで、ブラウザがHTMLを読み込み完了したタイミングで第二引数の処理を開始する。
        $('.js-popover').popover({
            container: 'body'
        })
    }, false);
</script>