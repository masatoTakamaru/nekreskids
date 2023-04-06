/*
    生年月日
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
