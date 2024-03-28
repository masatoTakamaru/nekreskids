class sysCommon {
    /**
     * 都道府県を選択したら市町村一覧を表示する
     * 初期値に応じた都道府県・市町村を選択する
     */
    static setPrefCity(elem) {
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
    static setDate(obj) {
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
    static setCounter(obj) {
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

    /**
     * パスワード入力欄を表示する
     * @param id string パスワード入力欄の要素Id
     */
    static editPassword(id) {
        const passElem = $('#' + id);
        const noticeElem = $('<span>')
            .text('セキュリティのため非表示')
            .append('&nbsp;')
            .append($('<div>')
                .attr({
                    type: 'button',
                    id: 'password__editButton',
                    class: ''
                }).text('パスワード再設定'));
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

    /**
     * パスワード入力欄アイコン切り替え
     * @param string id パスワード入力欄の要素ID
     */
    static togglePassIcon(id) {
        const passElem = $('#' + id);
        const iconElem = $('<button>')
            .attr('id', 'passwordIcon')
            .attr('type', 'button')
            .addClass('password-icon')
            .addClass('password-eye')
            .insertAfter(passElem);

        iconElem.on('click', function () {
            const isPassword = passElem.attr('type') === 'password';
            passElem.attr('type', isPassword ? 'text' : 'password');
            iconElem.toggleClass('password-eye', !isPassword);
            iconElem.toggleClass('password-eyeslash', isPassword);
        });
    }

    /**
     * 削除ボタンをクリックしたときに確認ダイアログを表示する
     * @param id string 削除ボタンの要素Id
     */
    static deleteConfirm(id) {
        $(`#${id}`).on('click', (event) => {
            if (!confirm("削除してもよろしいですか？")) return event.preventDefault();
        });
    }

    /**
     * 
     * アバター画像設定
     * 
     */

    static setResizedImg(url) {
        const sri = new sendResizedImg('avatar_preview', 'avatar_upload', 'avatar');
        sri.create({
            mode: "crop",       //モード(nocrop|crop|original)
            preview: {
                maxWidth: 200,  //プレビュー画像の最大幅
                maxHeight: 200, //プレビュー画像の最大高さ
                imgData: url,  //画像読み込み前の初期画像(ファイル名|base64文字列)
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
     * セレクトボックスの選択によってinput要素を入力不可にする
     * @param obj {
     *      select: セレクトボックスの要素ID,
     *      condition: 入力不可にするvalue値（配列で指定）,
     *      target: 入力不可にする要素ID,
     * }
     */
    static toggleDisabled(obj) {
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

}

