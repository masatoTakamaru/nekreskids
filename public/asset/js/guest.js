/**
 * 
 * パスワード入力用アイコン切り替え
 * 
 */

function togglePassIcon() {
    $(window).on('load', function (){
        $('#my-image').attr('src', '/asset/image/common/eye-solid.svg');
        $('#my-image').attr('src', '/asset/image/common/eye-slash-solid.svg');
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
 * 
 * 生年月日
 * 
 */

function setBirthday() {
    $(window).on("load", function () {
        const now = new Date();
        const year = now.getFullYear();
        const date_init = new Date($("#birth").val());
        const birth1 = date_init.getFullYear();
        const birth2 = date_init.getMonth() + 1;
        const birth3 = date_init.getDate();
        const date = new Date(birth1, birth2, 0);

        for (let i = year; i >= 1940; i--) {
            const elem = $(`<option value="${i}">${i}</option>`).appendTo("#birth1");
            if (i === birth1) elem.prop('selected', true);
        }

        for (let i = 1; i <= 12; i++) {
            const elem = $(`<option value="${i}">${i}</option>`).appendTo("#birth2");
            if (i === birth2) elem.prop('selected', true);
        }

        for (let i = 1; i <= date.getDate(); i++) {
            const elem = $(`<option value="${i}">${i}</option>`).appendTo("#birth3");
            if (i === birth3) elem.prop('selected', true);
        }
    });

    $("#birth1,#birth2").on("change", function () {
        const beginOfMonth = new Date($("#birth1").val(), $("#birth2").val() - 1, 1);
        const endOfMonth = new Date($("#birth1").val(), $("#birth2").val(), 0);
        const year = beginOfMonth.getFullYear();
        const month = beginOfMonth.getMonth() + 1;
        const day = beginOfMonth.getDate();
        $("#birth3").empty();
        for (let i = 1; i <= endOfMonth.getDate(); i++) {
            $("#birth3").append(`<option value="${i}">${i}</option>`);
        }
        $("#birth").val(`${year}-${month}-${day}`);
    });

    $("#birth3").on("change", () => {
        const date = `${$("#birth1").val()}-${$("#birth2").val()}-${$("#birth3").val()}`;
        $("#birth").val(date);
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
        Object.keys(objPrefs).forEach(function (key) {
            const option = $(`<option value="${key}">${objPrefs[key]}</option>`).appendTo(prefElem);
            if (key === objActAreas[id].pref) option.prop('selected', true);
        });
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
            Object.keys(cities).forEach(function (key) {
                const option = $(`<option value="${key}">${cities[key]}</option>`).appendTo(cityElem);
                if (key === objActAreas[id].city) option.prop('selected', true);
            });
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

    Object.keys(objActAreas).forEach(function (index) { createArea(index); });
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

