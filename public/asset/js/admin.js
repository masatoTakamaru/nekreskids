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
    const passElem = $(`#${id}`);
    const noticeElem = $('<span>セキュリティのため非表示</span><button type="button" id="password__editButton" class="">パスワードを入力</button>')

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
