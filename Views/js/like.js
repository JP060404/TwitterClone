////////////////////////////////////////
//いいね！用のJavaScript
////////////////////////////////////////

$(function(){  //$(function)はjQueryの書き方で、HTMLの処理を終えてから処理をされるようになる。
    // いいね!がクリックされたとき
    $('.js-like').click(function() {
        const this_obj = $(this);　//$(this)はイベントが発生する要素、すなわちここではクリックされるjs-like (いいねのハートマークに指定したクラス)
        const like_id = $(this).data('like-id');　　//クリックしたときにlike-idを取得。like-idはいいねが押されたかどうかを判断するものでnullか1。
        const like_count_obj = $(this).parent().find('.js-like-count');//js-like-countクラスはいいねのハートマークの横にある数字の要素。parent()とfind()を一緒に使うことで、親要素の指定したタグやクラスの情報を取れる。
        let like_count = Number(like_count_obj.html());　　//letは変数を指定するときの書き方。html()はhtmlの要素をとってくる。ここではlike_count_objすなわち、js-like-countの数字をとってくる。Number()で文字列等をNumber型に変換。

        if (like_id) {　
            // like_idがあれば、つまりすでにいいねを押していれば
            // いいね！取り消し
            // いいね！カウントを減らす
            like_count--;
            like_count_obj.html(like_count);// htmlに書き込むために.html()を使っている。
            
            this_obj.data('like-id', null);　
            // いいねを取り消したときはlike-idにnullを設定する

            //いいね！ボタンの色をグレーに変更
            $(this).find('img').attr('src', '../Views/img/icon-heart.svg');　//find)とattr()を組み合わせて使うことで、要素を置換することが出来る。
        } else{
            // いいね！付与
            // いいね！カウントを増やす
            like_count++;
            like_count_obj.html(like_count);
            this_obj.data('like-id', true);

            // いいね！ボタンの色を青に変更
            $(this).find('img').attr('src', '../Views/img/icon-heart-twitterblue.svg');

        }
    })
})