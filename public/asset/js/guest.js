/**
 * 
 * 生年月日
 * 
 */

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

/**
 * 
 * 指導員ユーザー登録市区町村表示
 * 
 */

const actAreasElem = $('#actAreas');
const iconPrefAddElem = $('#edit__iconPrefAdd');
let areaLength = 1;

iconPrefAddElem.on('click', () => {
    const actAreaElem = $('<div>', {
        id: `actArea${areaLength + 1}`
    });
    const prefElem = $(`#pref${areaLength}`).clone()
        .attr('id', `pref${areaLength + 1}`)
        .val('')
        .appendTo(actAreaElem);
    const citiesElem = $(`#city${areaLength}`).clone()
        .attr('name', `city${areaLength + 1}`)
        .attr('id', `city${areaLength + 1}`)
        .empty()
        .appendTo(actAreaElem);
    actAreaElem.appendTo(actAreasElem);
    areaLength++;
    $(`#pref${areaLength}`).on('load change', { id: areaLength }, setCities);
});

const setCities = (event) => {
    const id = event.data.id;
    const prefValue = $(`#pref${id}`).val();
    const cities = arrCities[prefValue];
console.log(cities);
    const cityElem = $(`#city${id}`);
    cityElem.empty();
    if (cities) {
        Object.keys(cities).forEach((key) => {
            const optionElem = $('<option>', {
                value: key
            }).text(cities[key]).appendTo(cityElem);
        });
    }
}

$(window).on('load', { id: 1 }, setCities);
$('#pref1').on('change', { id: 1 }, setCities);

/**
 * 
 * 指導員ユーザー登録PR文字数カウンター
 * 
 */

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

