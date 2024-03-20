/**
 * 削除ボタンをクリックしたときに確認ダイアログを表示する
 * @param id string 削除ボタンの要素Id
 */
function deleteConfirm(id) {
    $(`#${id}`).on('click', (event) => {
        if (!confirm("削除してもよろしいですか？")) return event.preventDefault();
    });
}

/**
 * パスワード入力欄を表示する
 * @param id string パスワード入力欄の要素Id
 */
function editPassword(id) {
    const passElem = $('#' + id);
    const noticeElem = $('<span>')
        .text('セキュリティのため非表示')
        .append('&nbsp;')
        .append($('<button>')
            .attr({
                type: 'button',
                id: 'password__editButton',
                class: ''
            }).text('パスワード再設定'));
    $(window).on('load', function () {
        passElem.after(noticeElem).hide();
        const buttonElem = $('#password__editButton');
        buttonElem.on('click', function () {
            noticeElem.hide();
            passElem.prop('disabled', false).show();
            togglePassIcon(id);
        });
    });
}

/**
 * パスワード入力欄アイコン切り替え
 * @param string id パスワード入力欄の要素ID
 */
function togglePassIcon(id) {
    const passElem = $('#' + id);
    const iconElem = $('<span>')
        .attr('id', 'password__icon')
        .addClass('password__icon')
        .addClass('password__eye')
        .insertAfter(passElem);

    iconElem.on('click', function () {
        const isPassword = passElem.attr('type') === 'password';
        passElem.attr('type', isPassword ? 'text' : 'password');
        iconElem.toggleClass('password__eye', isPassword);
        iconElem.toggleClass('password__eye-slash', !isPassword);
    });
}


/**
 * 
 * アバター画像設定
 * 
 */

function setResizedImg(url) {
    const sri = new sendResizedImg('avatar_preview', 'avatar_upload', 'avatar');
    sri.create({
        mode: "crop",       //モード(nocrop|crop|original)
        preview: {
            maxWidth: 200,  //プレビュー画像の最大幅
            maxHeight: 200, //プレビュー画像の最大高さ
            imgData: url,  //画像読み込み前の初期画像(ファイル名|base64文字列)
            //省略可。この場合デフォルト画像が表示される
        },
        send: {
            maxWidth: 200,  //送信画像の最大幅
            maxHeight: 200, //送信画像の最大高さ
            format: "jpg",  //画像形式(jpeg|png)
            quality: 0.9,   //画質(0.0～1.0)
        }
    });
}

/**
 * セレクトボックスの選択によってinput要素を入力不可にする
 * @param obj {
 *      select: セレクトボックスの要素ID,
 *      condition: 入力不可にするvalue値（配列で指定）,
 *      target: 入力不可にする要素ID,
 * }
 */
function toggleDisabled(obj) {
    const selectElem = $(`#${obj.select}`);
    const condition = obj.condition;
    const targetElem = $(`#${obj.target}`);

    function toggleAttr() {
        if (condition.includes(selectElem.val())) {
            targetElem.val('').attr('disabled', true);
        } else {
            targetElem.removeAttr('disabled');
        }
    }

    $(window).on('load', toggleAttr);
    selectElem.on('change', toggleAttr);
}
