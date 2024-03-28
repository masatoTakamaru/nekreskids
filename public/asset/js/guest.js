/**
 * パスワード入力欄アイコン切り替え
 * @param string id パスワード入力欄の要素ID
 */
function togglePassIcon(id) {
    const passElem = $(`#${id}`);
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

function setResizedImg() {
}

/**
 * 都道府県を選択したら市町村一覧を表示する
 */
function setPrefToCity(elem) {
    const prefElem = $(`#${elem.pref}`);
    const cityElem = $(`#${elem.city}`);
    const arrPrefCity = JSON.parse(elem.arrCity);
    prefElem.on('change', () => {
        cityElem.empty();
        const arrCity = arrPrefCity[prefElem.val()];
        Object.entries(arrCity).forEach(([key, value]) => {
            const option = $('<option>')
                .attr('value', key)
                .text(value);
            cityElem.append(option);
        });
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

/**
 * セレクトボックスを選択するとsubmitを実行
 * @param string id セレクトボックスの要素ID
 */
function onchangeSubmit(id) {
    $(`#${id}`).on('change', function () {
        this.form.submit();
    });
}
