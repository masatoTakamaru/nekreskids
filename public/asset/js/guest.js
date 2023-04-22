/**
 * 
 * パスワード入力用アイコン切り替え
 * 
 */

function togglePassIcon() {
    $(window).on('load', function () {
        const passElem = $('#password');
        const iconElem = $('#password__icon');
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
    });
}

/**
 * 
 * jPostal呼び出し
 * 
 */

function setJpostal() {
    $(window).on('load', function () {
        $('#zip').jpostal({
            postcode: ['#zip'],
            address: { '#pref': '%3', "#city": '%4', '#address': '%5' }
        });
    });
}

/**
 * セレクトボックスで日付を選択
 * 連結された日付を入力するinput要素をhiddenで設置する
 * 
 * @param obj object　年月日と日付のid
 * 例
 * obj = {
 *   yearId: 'yearId',
 *   monthId: 'monthId',
 *   dayId: 'dayId',
 *   dateId: 'dateId',
 * }
 */

function setDate(obj) {

    const now = new Date();         //現在の日付を初期値とする
    const inputDate = new Date($(`#${obj.date}`).val());
    const inputYear = inputDate.getFullYear();
    const inputMonth = inputDate.getMonth() + 1;
    const inputDay = inputDate.getDate();
    const date = new Date(inputYear, inputMonth, 0);
    const yearElem = $(`#${obj.yearId}`);
    const monthElem = $(`#${obj.monthId}`);
    const dayElem =$(`#${obj.dayId}`);
    const yearMonthElem = $(`#${obj.yearId},#${obj.monthId}`);
    const dateElem = $(`#${obj.dateId}`);

    for (let i = now.getFullYear(); i >= 1940; i--) {
        const elem = $(`<option value="${i}">${i}</option>`).appendTo(yearElem);
        if (i === inputYear) elem.prop('selected', true);
    }

    for (let i = 1; i <= 12; i++) {
        const elem = $(`<option value="${i}">${i}</option>`).appendTo(monthElem);
        if (i === inputMonth) elem.prop('selected', true);
    }

    for (let i = 1; i <= date.getDate(); i++) {
        const elem = $(`<option value="${i}">${i}</option>`).appendTo(dayElem);
        if (i === inputDay) elem.prop('selected', true);
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
        dateElem.val(`${year}-${month}-${day}`);
    });

    dayElem.on("change", () => {
        const date = `${yearElem.val()}-${monthElem.val()}-${dayElem.val()}`;
        dateElem.val(date);
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
 * 
 * 指導員ユーザー登録PR文字数カウンター
 * 
 */

function setPrCharsLimit() {
    const maxLength = 200;
    const pr_content = $('#pr_content');
    const pr_count = $('#pr_count');

    $(window).on('load', function () {
        pr_count.text(`あと${maxLength}文字`);
    });

    pr_content.on('input', function () {
        const text = pr_content.val().replace(/(\r\n|\n|\r)/gm, "");
        if (text.length >= maxLength) {
            pr_content.attr('readonly', true);
        } else {
            pr_content.removeAttr('readonly');
        }
        const len = maxLength - text.length;
        pr_count.text(`あと${len}文字`);
    });

    pr_content.on('keydown', function (e) {
        if (pr_content.attr('readonly')) {
            if (e.keyCode === 8 || e.keyCode === 46) {
                pr_content.removeAttr('readonly');
            }
        }
    });
}

