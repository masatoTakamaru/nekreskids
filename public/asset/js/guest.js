/**
 * 
 * 生年月日
 * 
 */

const setBirthday = () => {
    $(window).on("load", () => {
        const now = new Date();
        const year = now.getFullYear();
        const date_init = new Date($("#birth").val());
        const birth1 = date_init.getFullYear();
        const birth2 = date_init.getMonth() + 1;
        const birth3 = date_init.getDate();
        const date = new Date(birth1, birth2, 0);

        for (let i = year; i >= 1940; i--) {
            option_txt = `<option value="${i}" ${i === birth1 ? "selected" : null}>${i}</option>`;
            $("#birth1").append(option_txt);
        }

        for (let i = 1; i <= 12; i++) {
            option_txt = `<option value="${i}" ${i === birth2 ? "selected" : null}>${i}</option>`;
            $("#birth2").append(option_txt);
        }

        for (let i = 1; i <= date.getDate(); i++) {
            option_txt = `<option value="${i}" ${i === birth3 ? "selected" : null}>${i}</option>`;
            $("#birth3").append(option_txt);
        }
    });

    $("#birth1,#birth2").on("change", () => {
        const firstDay = new Date($("#birth1").val(), $("#birth2").val() - 1, 1);
        const lastDay = new Date($("#birth1").val(), $("#birth2").val(), 0);
        $("#birth3").empty();
        for (let i = 1; i <= lastDay.getDate(); i++) {
            const option_txt = `<option value="${i}">${i}</option>`;
            $("#birth3").append(option_txt);
        }
        $("#birth").val(firstDay);
    });

    $("#birth3").on("change", () => {
        const date = new Date($("#birth1").val(), $("#birth2").val() - 1, $("#birth3").val());
        $("#birth").val(date);
    });
}

/**
 * 
 * アバター画像設定
 * 
 */

const setResizedImg = () => {
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

const setActArea = () => {
    const actAreasElem = $('#actAreas');
    const iconPrefAddElem = $('#edit__iconPrefAdd');
    const iconPrefRemoveElem = $('#edit__iconPrefRemove');
    let areaLength = Object.keys(objActAreas).length;

    iconPrefAddElem.on('click', () => {
        areaLength++;
        createArea(areaLength);
        if (areaLength === 2) iconPrefRemoveElem.toggle();
        if (areaLength === 5) iconPrefAddElem.toggle();
        $(`#pref${areaLength}`).on('change', { id: areaLength }, setCities);
        $(`#pref${areaLength}`).trigger('change'); //強制イベント発火
    });

    iconPrefRemoveElem.on('click', () => {
        $(`#actArea${areaLength}`).remove();
        areaLength--;
        if (areaLength === 1) iconPrefRemoveElem.toggle();
        if (areaLength === 4) iconPrefAddElem.toggle();
    });

    const setCities = (event) => {
        const id = event.data.id;
        const prefElem = $(`#pref${id}`);
        prefElem.attr('name', `act_areas[${id}][pref]`);
        let cities = objCities[prefElem.val()];
        const cityElem = $(`#city${id}`);
        cityElem.attr('name', `act_areas[${id}][city]`)
        cityElem.empty();
        if (cities) {
            Object.keys(cities).forEach((key) => {
                $('<option>', {
                    value: key
                }).text(cities[key]).appendTo(cityElem);
            });
        }
    }

    const createArea = (id) => {
        const actAreaElem = $('<div>', {
            id: `actArea${id}`,
            class: 'edit__actArea'
        }).appendTo(actAreasElem);
        const prefElem = $('<select>', {
            id: `pref${id}`,
            name: `act_areas[${id}][pref]`,
        }).val('').appendTo(actAreaElem);
        Object.keys(objPrefs).forEach((key) => {
            const option = $('<option>', {
                class: ''
            }).val(key);
            if (key === objActAreas[id].pref) option.prop('selected', true);
            option.text(objPrefs[key]).appendTo(prefElem);
        });
        const cityElem = $('<select>', {
            id: `city${id}`,
            name: `act_areas[${id}][city]`
        }).appendTo(actAreaElem);
        prefElem.on('change', { id: id }, setCities);
        $(`#pref${id}`).trigger('change'); //強制イベント発火
    }

    Object.keys(objActAreas).forEach((index) => {
        createArea(index);
    });
}


/**
 * 
 * 指導員ユーザー登録PR文字数カウンター
 * 
 */

const setPrCharsLimit = () => {
    const maxLength = 200;
    const pr_content = $('#pr_content');
    const pr_count = $('#pr_count');

    $(window).on('load', () => {
        pr_count.text(`あと${maxLength}文字`);
    });

    pr_content.on('input', () => {
        const text = pr_content.val().replace(/(\r\n|\n|\r)/gm, "");
        if (text.length >= maxLength) {
            pr_content.attr('readonly', true);
        } else {
            pr_content.removeAttr('readonly');
        }
        const len = maxLength - text.length;
        pr_count.text(`あと${len}文字`);
    });

    pr_content.on('keydown', (e) => {
        if (pr_content.attr('readonly')) {
            if (e.keyCode === 8 || e.keyCode === 46) {
                pr_content.removeAttr('readonly');
            }
        }
    });
}



