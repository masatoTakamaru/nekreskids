/**
 * 都道府県を選択したら市町村一覧を表示する
 * 初期値に応じた都道府県・市町村を選択する
 */
function setPrefCity(elem) {
    const prefElem = $('#' + elem.prefElem);
    const cityElem = $('#' + elem.cityElem);
    const defaultPref = elem.defaultPref;
    const defaultCity = elem.defaultCity;
    const arrPref = JSON.parse(elem.arrPref);
    const arrCity = JSON.parse(elem.arrCity);

    function populateSelectBox(selectElem, item, defaultKey) {
        selectElem.empty();
        for (const [key, value] of Object.entries(item)) {
            const option = $('<option>', { value: key, text: value });
            if (key === defaultKey) option.prop('selected', true);
            selectElem.append(option);
        }
    }

    function updateCityOptions(cityData, targetElem) {
        targetElem.empty();
        
        if (!cityData) {
            const option = $('<option>', { value: '', text: '選択して下さい' });
            targetElem.append(option);
            return;
        }

        for (const [key, value] of Object.entries(cityData)) {
            const option = $('<option>', { value: key, text: value });
            targetElem.append(option);
        }
    }

    populateSelectBox(prefElem, arrPref, defaultPref);

    if (defaultCity) {
        populateSelectBox(cityElem, arrCity[defaultPref], defaultCity);
    } else {
        const option = $('<option>', { value: '', text: '選択して下さい' });
        cityElem.append(option);
    }

    prefElem.on('change', function () {
        const selectedPref = $(this).val();
        updateCityOptions(arrCity[selectedPref], cityElem);
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
    const yearElem = $('#' + obj.yearId);
    const monthElem = $('#' + obj.monthId);
    const dayElem = $('#' + obj.dayId);
    const inputElem = $('#' + obj.dateId);
    let currentYear = new Date().getFullYear();
    let currentMonth = (new Date()).getMonth() + 1;
    let currentDay = (new Date()).getDate();

    const updateYearOptions = () => {
        for (let year = currentYear; year >= 1940; year--) {
            const option = $('<option>', { value: year, text: year });
            if (year === currentYear) option.prop("selected", true);
            yearElem.append(option);
        }
    };

    const updateMonthOptions = () => {
        for (let month = 1; month <= 12; month++) {
            const option = $('<option>', { value: month, text: month });
            if (month === currentMonth) option.prop("selected", true);
            monthElem.append(option);
        }
    };

    const updateDayOptions = () => {
        const selectedYear = parseInt(yearElem.val());
        const selectedMonth = parseInt(monthElem.val());
        const daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();

        dayElem.empty();
        for (let day = 1; day <= daysInMonth; day++) {
            const option = $('<option>', { value: day, text: day });
            if (day === currentDay) option.prop("selected", true);
            dayElem.append(option);
        }
    };

    const updateInputValue = () => {
        const year = yearElem.val();
        const month = monthElem.val().padStart(2, '0');
        const day = dayElem.val().padStart(2, '0');
        inputElem.val(`${year}-${month}-${day}`);
    };

    $(window).on('load', function () {
        if (inputElem.val()) {
            const date = new Date(inputElem.val());
            currentYear = date.getFullYear();
            currentMonth = date.getMonth() + 1;
            currentDay = date.getDate();
        }

        updateYearOptions();
        updateMonthOptions();
        updateDayOptions();
        updateInputValue();
    });

    yearElem.add(monthElem).on('change', function () {
        updateDayOptions();
        updateInputValue();
    });

    dayElem.on('change', function () {
        updateInputValue();
    });
}

/**
 * 残り文字数カウンター
 * @param obj {
 *      textArea: textareaの要素ID,
 *      count: カウンタのP要素ID
 *      limit: 最大文字数,
 * }
 */
function setCounter(obj) {
    const textElem = $(`#${obj.textArea}`);
    const countElem = $(`#${obj.count}`);
    const limit = obj.limit;
    const regex = /(\r\n|\n|\r)/gm;
    const keys = [
        'Backspace',
        'ArrowUp',
        'ArrowDown',
        'ArrowLeft',
        'ArrowRight',
    ];

    function toggleReadOnly() {
        const text = textElem.val();
        const arrBreak = text.match(regex);
        const countBreak = Array.isArray(arrBreak) ? arrBreak.length : 0;
        if (text.length > limit + countBreak) {
            textElem.val(text.slice(0, limit + countBreak))
                .attr('readonly', true);
            countElem.addClass('edit__alert')
                .text('最大文字数を超えています。これ以上入力できません。');
        } else {
            textElem.removeAttr('readonly');
            const len = limit - text.replace(regex, '').length;
            countElem.removeClass('edit__alert')
                .text(`あと${len}文字`);
        }
    }

    $(window).on('load', toggleReadOnly);
    textElem.on('input', toggleReadOnly)
        .on('keydown', function (e) {
            if (textElem.attr('readonly') && keys.includes(e.key)) {
                toggleReadOnly();
            }
        });
}