/**
 * 削除ボタンをクリックしたときに確認ダイアログを表示する
 * @param id string 削除ボタンの要素Id
 */
function deleteConfirm(id) {
    $(`#${id}`).on('click', (event) => {
        if (!confirm("削除してもよろしいですか？")) return event.preventDefault();
    });
}
