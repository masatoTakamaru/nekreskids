/**
 * パスワード入力欄アイコン切り替え
 * @param string id パスワード入力欄の要素ID
 */
function togglePassIcon(id) {
    const passElem = $(`#${id}`);
    const iconElem = $('<span class="password__icon password__eye"></span>');
    passElem.after(iconElem);
    iconElem.on('click', function () {
        if (passElem.attr('type') === 'password') {
            passElem.attr('type', 'text');
            iconElem.removeClass('password__eye');
            iconElem.addClass('password__eye-slash');
        } else {
            passElem.attr('type', 'password');
            iconElem.removeClass('password__eye-slash');
            iconElem.addClass('password__eye');
        }
    });
}

/**
 * jPostal呼び出し
 * @param obj obj{
 *      zip: string,
 *      pref: string,
 *      city: string,
 *      address: string,
 * }    郵便番号，都道府県，市区町村，それ以外の要素ID
 */
function setJpostal(obj) {
    $(window).on('load', function () {
        $(`#${obj.zip}`).jpostal({
            postcode: [`#${obj.zip}`],
            address: { [`#${obj.pref}`]: '%3', [`#${obj.city}`]: '%4', [`#${obj.address}`]: '%5' }
        });
    });
}

/**
 * セレクトボックスで日付を選択
 * 連結された日付を入力するinput要素をhiddenで設置する
 * @param obj object{
 *      yearId: string,
 *      monthId: string,
 *      dayId: string,
 *      dateId: string}　年月日と日付のid
 */
function setDate(obj) {

    const yearElem = $(`#${obj.yearId}`);
    const monthElem = $(`#${obj.monthId}`);
    const yearMonthElem = $(`#${obj.yearId},#${obj.monthId}`);
    const dayElem = $(`#${obj.dayId}`);
    const inputElem = $(`#${obj.dateId}`);
    const date = inputElem.val() ? new Date(inputElem.val()) : new Date();
    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    const day = date.getDate();
    const endOfMonth = new Date(year, month, 0);

    for (let i = endOfMonth.getFullYear(); i >= 1940; i--) {
        const elem = $(`<option value="${i}">${i}</option>`).appendTo(yearElem);
        if (i === year) elem.prop("selected", true);
    }

    for (let i = 1; i <= 12; i++) {
        const elem = $(`<option value="${i}">${i}</option>`).appendTo(monthElem);
        if (i === month) elem.prop("selected", true);
    }

    for (let i = 1; i <= endOfMonth.getDate(); i++) {
        const elem = $(`<option value="${i}">${i}</option>`).appendTo(dayElem);
        if (i === day) elem.prop("selected", true);
    }

    yearMonthElem.on("change", function () {
        const beginOfMonth = new Date(yearElem.val(), monthElem.val() - 1, 1);
        const endOfMonth = new Date(yearElem.val(), monthElem.val(), 0);
        const year = beginOfMonth.getFullYear();
        const month = beginOfMonth.getMonth() + 1;
        const day = beginOfMonth.getDate();
        dayElem.empty();
        for (let i = 1; i <= endOfMonth.getDate(); i++) {
            dayElem.append(`<option value="${i}">${i}</option>`);
        }
        inputElem.val(`${year}-${month}-${day}`);
    });

    dayElem.on("change", () => {
        const date = `${yearElem.val()}-${monthElem.val()}-${dayElem.val()}`;
        inputElem.val(date);
    });
}

/**
 * 
 * アバター画像設定
 * 
 */

function setResizedImg() {
    const sri = new sendResizedImg('avatar_preview', 'avatar_upload', 'avatar');
    sri.create({
        mode: "crop",       //モード(nocrop|crop|original)
        preview: {
            maxWidth: 200,  //プレビュー画像の最大幅
            maxHeight: 200, //プレビュー画像の最大高さ
            imgInit: null,  //画像読み込み前の初期画像(ファイル名|base64文字列)
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
 * 
 * 指導員ユーザー登録市区町村表示
 * 
 */

function setActArea(obj) {
    const objActAreas = obj.actAreas;
    const objPrefs = obj.prefs;
    const objCities = obj.cities;
    const actAreasElem = $('#actAreas');
    const iconPrefAddElem = $('#edit__iconPrefAdd');
    const iconPrefRemoveElem = $('#edit__iconPrefRemove');
    let areaLength = Object.keys(objActAreas).length;

    function createArea(id) {
        if (!objActAreas[id]) objActAreas[id] = { pref: '', city: '' };
        const actAreaElem = $(`<div id="actArea${id}" class: "edit__actArea"></div>`).appendTo(actAreasElem);
        if (id > 1) actAreaElem.hide();
        const prefElem = $(`<select id="pref${id}" name="act_areas[${id}][pref]"></select>`).appendTo(actAreaElem);
        for (const key in objPrefs) {
            const option = $(`<option value="${key}">${objPrefs[key]}</option>`).appendTo(prefElem);
            if (key === objActAreas[id].pref) option.prop('selected', true);
        }
        const cityElem = $(`<select id="city${id}" name="act_areas[${id}][city]"></select>`).appendTo(actAreaElem);
        prefElem.on('change', function () { setCities(id) });
        setCities(id);
        if (id > 1) actAreaElem.slideDown();
    }

    function setCities(id) {
        let cities = objCities[$(`#pref${id}`).val()];
        const cityElem = $(`#city${id}`);
        cityElem.empty();
        if (cities) {
            for (const key in cities) {
                const option = $(`<option value="${key}">${cities[key]}</option>`).appendTo(cityElem);
                if (key === objActAreas[id].city) option.prop('selected', true);
            }
        }
    }

    iconPrefAddElem.on('click', function () {
        areaLength++;
        createArea(areaLength);
        if (areaLength === 2) iconPrefRemoveElem.toggle();
        if (areaLength === 5) iconPrefAddElem.toggle();
        $(`#pref${areaLength}`).on('change', function () { setCities(areaLength); });
        setCities(areaLength);
    });

    iconPrefRemoveElem.on('click', function () {
        const actArea = $(`#actArea${areaLength}`);
        actArea.slideUp().queue(() => { actArea.remove(); });
        areaLength--;
        console.log(areaLength);
        if (areaLength === 1) iconPrefRemoveElem.toggle();
        if (areaLength === 4) iconPrefAddElem.toggle();
    });

    for (const index in objActAreas) { createArea(index); };
}

/**
 * 残り文字数カウンター
 * @param obj obj{textArea: string, count: string} textareaとカウンタを表示する要素のID
 */
function setCounter(obj) {
    const maxLength = 200;  //最大文字数
    const textElem = $(`#${obj.textArea}`);
    const countElem = $(`#${obj.count}`);
    $(window).on('load', function () {
        countElem.text(`あと${maxLength}文字`);
    });

    textElem.on('input', function () {
        const text = textElem.val().replace(/(\r\n|\n|\r)/gm, "");
        if (text.length >= maxLength) {
            textElem.attr('readonly', true);
        } else {
            textElem.removeAttr('readonly');
        }
        const len = maxLength - text.length;
        countElem.text(`あと${len}文字`);
    });

    textElem.on('keydown', function (e) {
        if (textElem.attr('readonly')) {
            if (e.keyCode === 8 || e.keyCode === 46) {
                textElem.removeAttr('readonly');
            }
        }
    });
}

