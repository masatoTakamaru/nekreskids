/*

アップロードした画像をプレビュー表示し，リサイズして送信する。
データはbase64文字列として送信する。バックエンド側で保存する場合は，
base64_decode()を利用してバイナリデータに変換した上で保存すると良い。

nocropの場合，枠の中に画像全体を収めるようにリサイズする。枠と画像の縦横比
が合わない場合，上下または左右に空白が作られる。
cropの場合，空白を作らないようにリサイズする。枠と画像の縦横比が合わない場合，
上下または左右のはみ出た部分がカットされる。
originalの場合，プレビュー画像はno - cropと同等になり，送信画像はmaxWidthと
maxHeightの値に関係なく，元の画像と同じサイズで送信する。

■ サンプルコード

フロント側

----------HTML ----------

<div id="image_preview"></div>

----------JavaScript ----------

const sri = new sendResizedImg('avatar_preview', 'avatar');
sri.create({
    mode: "crop", //モード(nocrop|crop|original)
    preview: {
      maxWidth: 200, //プレビュー画像の最大幅
      maxHeight: 200, //プレビュー画像の最大高さ
      imgData: "{{ old('avatar', $objData->avatar) }}",
        //画像読み込み前の初期画像(ファイル名|base64文字列)
        //省略可。この場合no-image画像が表示される
    },
    send: {
      maxWidth: 200, //送信画像の最大幅
      maxHeight: 200, //送信画像の最大高さ
      format: "jpeg", //画像形式(jpeg|png)
      quality: 0.9, //画質(0.0～1.0)
    }
        // モードがoriginalの場合は設定した数値に関わらず
        // もとの画像サイズで送信される
});

プレビュー画像と送信画像で異なる縦横比を指定すると，プレビューと異なる画像が
送信されるため縦横比を合わせることが望ましい。

バックエンド側(Laravel)：png画像の場合

if ($request -> has('image')) {
    $fileName = 'image';
    $data = base64_decode(str_replace('data:image/jpeg;base64,', '', $request -> image_file));
    Storage:: put($fileName. 'jpg', $data);
}
 
png画像の場合は'data:image/png;base64,'。また，保存ファイル名の拡張子を.pngとする。 

*/

class sendResizedImg {

    /**
     * 
     * @param {string} previewWrapperId プレビューを表示するDIV要素ID
     * @param {string} dataName         データを格納する変数名
     */
    constructor(previewWrapperId, dataName) {
        this.previewWrapperId = previewWrapperId;
        this.dataName = dataName;
    }

    create(obj) {
        // バリデーション

        const result = this.validateData(obj);

        if (!result) return;

        //初期状態

        const previewWrapperEl = document.getElementById(this.previewWrapperId);
        previewWrapperEl.style.display = "flex";
        previewWrapperEl.style.flexDirection = "column"; // 要素を縦並び

        // プレビューを表示するキャンバス要素

        const previewCvsEl = previewWrapperEl.appendChild(document.createElement("canvas"));
        previewCvsEl.id = this.previewWrapperId + "_previewImageCanvas";
        previewCvsEl.width = obj.preview.maxWidth;
        previewCvsEl.height = obj.preview.maxHeight;
        previewCvsEl.style.width = obj.preview.maxWidth + "px";
        previewCvsEl.style.height = obj.preview.maxHeight + "px";
        let previewCtx = previewCvsEl.getContext("2d");

        // 送信画像用データを格納するキャンバス要素

        const sendCvsEl = previewWrapperEl.appendChild(document.createElement("canvas"));
        sendCvsEl.style.display = "none";
        sendCvsEl.id = this.previewWrapperId + "__sendImageCanvas";
        sendCvsEl.width = obj.send.maxWidth;
        sendCvsEl.height = obj.send.maxHeight;
        let sendCtx = sendCvsEl.getContext("2d");

        // 画像データbase64文字列を格納するinput要素

        const dataEl = previewWrapperEl.appendChild(document.createElement("input"));
        dataEl.type = "hidden";
        dataEl.name = this.dataName;
        dataEl.id = this.dataName;
        dataEl.value = obj.preview.imgData;

        // 画像ファイルを入力するinput要素

        const fileEl = previewWrapperEl.appendChild(document.createElement("input"));
        fileEl.type = "file";
        fileEl.style.margin = "10px";
        fileEl.accept = ".jpg, .png, .gif";

        // プレビューまたは送信画像キャンバスに画像を描画

        const loadImage = (img, src, ctx, type, obj, dataEl) => {
            img.src = src;
            img.addEventListener("load", () => {
                ctx.imageSmoothingQuality = "medium";
                const objCoord = this.getCoordinate(obj, img, type);

                ctx.drawImage(img, objCoord.sx, objCoord.sy, objCoord.sw, objCoord.sh,
                    objCoord.dx, objCoord.dy, objCoord.dw, objCoord.dh);

                if (type === "send") {
                    dataEl.value = ctx.canvas.toDataURL("image/" + obj.send.format, obj.send.quality);
                }
            });
        };

        // キャンバス要素にプロパティを設定

        const setImageProperties = (img, src, obj, dataEl, ctx, type) => {
            img.src = src || this.getNoImage();
            if (obj.preview.imgData) img.src = obj.preview.imgData;
            if (dataEl.value) img.src = dataEl.value;
            loadImage(img, img.src, ctx, type, obj, dataEl);
        };

        //ファイルアップロード時の処理
        fileEl.addEventListener("change", (event) => {
            const file = event.target.files[0];

            if (!file) return;

            // 指定外のファイル形式は受けつけない

            const allowedTypes = ["image/jpeg", "image/png", "image/gif"];

            if (!allowedTypes.includes(file.type)) {
                alert("選択したファイルのタイプは許可されていません。jpg、png、gifのみアップロードできます。");
                fileEl.value = ""; // ファイル選択をクリア
                return;
            }

            const reader = new FileReader();
            reader.readAsDataURL(file);

            reader.addEventListener("load", (event) => {
                const loadImage = (img, type) => {
                    img.src = event.target.result;
                    img.addEventListener("load", () => {
                        if (obj.mode === "original") {
                            obj.send.maxWidth = img.naturalWidth;
                            obj.send.maxHeight = img.naturalHeight;
                            sendCvsEl.width = obj.send.maxWidth;
                            sendCvsEl.height = obj.send.maxHeight;
                        }

                        const objCoord = this.getCoordinate(obj, img, type);
                        const ctx = type === "send" ? sendCtx : previewCtx;
                        const maxW = type === "send" ? obj.send.maxWidth : obj.preview.maxWidth;
                        const maxH = type === "send" ? obj.send.maxHeight : obj.preview.maxHeight;

                        ctx.clearRect(0, 0, maxW, maxH);
                        ctx.drawImage(img, objCoord.sx, objCoord.sy, objCoord.sw, objCoord.sh,
                            objCoord.dx, objCoord.dy, objCoord.dw, objCoord.dh);

                        if (type === "send") {
                            dataEl.value = sendCvsEl.toDataURL("image/" + obj.send.format,
                                obj.send.quality);
                        }
                    });
                };

                const sendImg = new Image();
                const previewImg = new Image();

                loadImage(sendImg, "send");
                loadImage(previewImg, "preview");
            });
        });

        // 送信画像初期設定
        const sendImg = new Image();
        setImageProperties(sendImg, null, obj, dataEl, sendCtx, "send");

        // プレビュー画像初期設定
        const previewImg = new Image();
        setImageProperties(previewImg, null, obj, dataEl, previewCtx, "preview");
    }

    getCoordinate(obj, image, type) {
        let result = {};
        const maxW = (type === "send") ? obj.send.maxWidth : obj.preview.maxWidth;
        const maxH = (type === "send") ? obj.send.maxHeight : obj.preview.maxHeight;
        const scaleX = maxW / image.width;
        const scaleY = maxH / image.height;
        let trimX, trimY;
        const isHeightOverflow = image.height * scaleX >= maxH;

        switch (obj.mode) {
            case "nocrop":
            case "original":
                //試しに幅で合わせてみたら画像高さがはみでる場合高さで合わせる
                //画像幅がはみでる場合幅で合わせる
                trimX = Math.abs(maxW - image.width * scaleY);
                trimY = Math.abs(maxH - image.height * scaleX);
                result = {
                    sx: 0,
                    sy: 0,
                    sw: isHeightOverflow ? image.width : image.width,
                    sh: isHeightOverflow ? image.height : image.height,
                    dx: isHeightOverflow ? trimX / 2 : 0,
                    dy: isHeightOverflow ? 0 : trimY / 2,
                    dw: isHeightOverflow ? image.width * scaleY : image.width * scaleX,
                    dh: isHeightOverflow ? image.height * scaleY : image.height * scaleX
                };
                break;
            case "crop":
                trimY = Math.abs(maxH / scaleX - image.height);
                trimX = Math.abs(maxW / scaleY - image.width);
                //試しに幅で合わせてみたら画像高さがはみでる場合
                //幅で合わせて画像上下をカット
                //画像幅がはみでる場合高さで合わせて画像左右をカット
                result = {
                    sx: isHeightOverflow ? 0 : trimX / 2,
                    sy: isHeightOverflow ? trimY / 2 : 0,
                    sw: isHeightOverflow ? image.width : image.width - trimX,
                    sh: isHeightOverflow ? image.height - trimY : image.height,
                    dx: 0,
                    dy: 0,
                    dw: maxW,
                    dh: maxH,
                };
                break;
            default:
        }

        return result;
    }

    validateData(obj) {
        function isFileNameOrBase64(input) {
            const fileNamePattern = /\.[0-9a-z]+$/i;
            const base64Pattern = /^data:image\/(png|jpeg|gif);base64,/i;
            const isFileName = fileNamePattern.test(input);
            const isBase64 = base64Pattern.test(input);

            return isFileName || isBase64 || input === '' || input === null;
        }

        let result = false;

        switch (true) {
            case !["nocrop", "crop", "original"].includes(obj.mode):
                console.log("ERROR: preview.mode must be one of nocrop, crop, or original.");
                break;
            case obj.preview.maxWidth < 0 || obj.preview.maxWidth > 5000:
                console.log("ERROR: Please specify a value for preview.maxWidth between 0 and 5000.");
                break;
            case obj.preview.maxHeight < 0 || obj.preview.maxHeight > 5000:
                console.log("ERROR: Please specify a value for preview.maxHeight between 0 and 5000.");
                break;
            case !isFileNameOrBase64(obj.preview.imgData):
                console.log("ERROR: preview.imgData must be either a file name, a base64 string, empty string or null.");
                break;
            case obj.send.maxWidth < 0 || obj.send.maxWidth > 5000:
                console.log("ERROR: Please specify a value for send.maxWidth between 0 and 5000.");
                break;
            case obj.send.maxHeight < 0 || obj.send.maxHeight > 5000:
                console.log("ERROR: Please specify a value for send.maxHeight between 0 and 5000.");
                break;
            case !["jpeg", "png"].includes(obj.send.format):
                console.log("ERROR: send.format must be one of jpeg or png.");
                break;
            case obj.send.quality < 0 || obj.send.quality > 1:
                console.log("ERROR: Please specify a value for send.quality between 0.0 and 1.0.");
                break;
            default:
                result = true;
        }

        return result;
    }

    getNoImage() {
        return "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAACxMAAAsTAQCanBgAABF6aVRYdFhNTDpjb20uYWRvYmUueG1wAAAAAAA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/Pg0KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxNDggNzkuMTY0MDM2LCAyMDE5LzA4LzEzLTAxOjA2OjU3ICAgICAgICAiPg0KICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPg0KICAgIDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIgeG1sbnM6dGlmZj0iaHR0cDovL25zLmFkb2JlLmNvbS90aWZmLzEuMC8iIHhtbG5zOmV4aWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20vZXhpZi8xLjAvIiB4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ9InhtcC5kaWQ6MDA1ODFlODgtNmE2MS00YjBhLWE0NmQtYWM3ZTYwMTJmMGQxIiB4bXBNTTpEb2N1bWVudElEPSJhZG9iZTpkb2NpZDpwaG90b3Nob3A6M2E3ZjQ0YTItZWZjMC0yZTRhLWE3MGYtYTlmMWMzYTAxMTgxIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjAyYWJiZjg3LWJjNTQtNDM2Yi04NzhhLTg4NjkzZmE4ODQxMiIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ0MgMjAxOSAoTWFjaW50b3NoKSIgeG1wOkNyZWF0ZURhdGU9IjIwMTktMDgtMjVUMjE6NTc6MjkrMDk6MDAiIHhtcDpNb2RpZnlEYXRlPSIyMDIwLTA1LTA1VDIzOjI2OjEzKzA5OjAwIiB4bXA6TWV0YWRhdGFEYXRlPSIyMDIwLTA1LTA1VDIzOjI2OjEzKzA5OjAwIiBkYzpmb3JtYXQ9ImltYWdlL3BuZyIgcGhvdG9zaG9wOkNvbG9yTW9kZT0iMyIgcGhvdG9zaG9wOklDQ1Byb2ZpbGU9InNSR0IgSUVDNjE5NjYtMi4xIiB0aWZmOk9yaWVudGF0aW9uPSIxIiB0aWZmOlhSZXNvbHV0aW9uPSI3MjAwMDAvMTAwMDAiIHRpZmY6WVJlc29sdXRpb249IjcyMDAwMC8xMDAwMCIgdGlmZjpSZXNvbHV0aW9uVW5pdD0iMiIgZXhpZjpDb2xvclNwYWNlPSIxIiBleGlmOlBpeGVsWERpbWVuc2lvbj0iNjQwIiBleGlmOlBpeGVsWURpbWVuc2lvbj0iNjQwIj4NCiAgICAgIDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjdkNDYwN2E5LTc4MWMtNGI4MC1hNzZmLTQ4YmE0ZThmMWVkYiIgc3RSZWY6ZG9jdW1lbnRJRD0iYWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOjQ1NTIxNDhkLTZkOTctOTE0NC05YjkyLWJlN2Q0MjE2NmI0YiIgc3RSZWY6b3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjAwNTgxZTg4LTZhNjEtNGIwYS1hNDZkLWFjN2U2MDEyZjBkMSIgLz4NCiAgICAgIDx4bXBNTTpIaXN0b3J5Pg0KICAgICAgICA8cmRmOlNlcT4NCiAgICAgICAgICA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6N2E2NDNkYmUtMjI2OS00YzkyLWFmODktYzNmMzIzZjQ0ODJmIiBzdEV2dDp3aGVuPSIyMDE5LTExLTI1VDA4OjI5OjUzKzA5OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ0MgMjAxOSAoTWFjaW50b3NoKSIgc3RFdnQ6Y2hhbmdlZD0iLyIgLz4NCiAgICAgICAgICA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY29udmVydGVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJmcm9tIGltYWdlL3BuZyB0byBhcHBsaWNhdGlvbi92bmQuYWRvYmUucGhvdG9zaG9wIiAvPg0KICAgICAgICAgIDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJkZXJpdmVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJjb252ZXJ0ZWQgZnJvbSBpbWFnZS9wbmcgdG8gYXBwbGljYXRpb24vdm5kLmFkb2JlLnBob3Rvc2hvcCIgLz4NCiAgICAgICAgICA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6NjY1YzA1Y2EtZGU3Ni00Y2RiLWJhNTEtMWQxNmU4ZTRjMjY3IiBzdEV2dDp3aGVuPSIyMDE5LTExLTI1VDA4OjI5OjUzKzA5OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ0MgMjAxOSAoTWFjaW50b3NoKSIgc3RFdnQ6Y2hhbmdlZD0iLyIgLz4NCiAgICAgICAgICA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6M2NlODJkMTgtZjhjYi00ODM5LTkxOTItZWI5ZGVkZGM1MzlmIiBzdEV2dDp3aGVuPSIyMDIwLTAxLTA5VDAwOjMwOjAzKzA5OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgMjEuMCAoTWFjaW50b3NoKSIgc3RFdnQ6Y2hhbmdlZD0iLyIgLz4NCiAgICAgICAgICA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY29udmVydGVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJmcm9tIGFwcGxpY2F0aW9uL3ZuZC5hZG9iZS5waG90b3Nob3AgdG8gaW1hZ2UvcG5nIiAvPg0KICAgICAgICAgIDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJkZXJpdmVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJjb252ZXJ0ZWQgZnJvbSBhcHBsaWNhdGlvbi92bmQuYWRvYmUucGhvdG9zaG9wIHRvIGltYWdlL3BuZyIgLz4NCiAgICAgICAgICA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6YThjYzk5YWEtM2NkMi00MGUwLTk5YWQtNDc2ZTUwMTY4NGQyIiBzdEV2dDp3aGVuPSIyMDIwLTAxLTA5VDAwOjMwOjAzKzA5OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgMjEuMCAoTWFjaW50b3NoKSIgc3RFdnQ6Y2hhbmdlZD0iLyIgLz4NCiAgICAgICAgICA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6NGYwNjBjNGItM2Y4ZC00ZGYzLThmOWUtNTEzN2Y1ZjEyNmU4IiBzdEV2dDp3aGVuPSIyMDIwLTA0LTE4VDE1OjU0OjE0KzA5OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgMjEuMSAoTWFjaW50b3NoKSIgc3RFdnQ6Y2hhbmdlZD0iLyIgLz4NCiAgICAgICAgICA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY29udmVydGVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJmcm9tIGltYWdlL3BuZyB0byBhcHBsaWNhdGlvbi92bmQuYWRvYmUucGhvdG9zaG9wIiAvPg0KICAgICAgICAgIDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJkZXJpdmVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJjb252ZXJ0ZWQgZnJvbSBpbWFnZS9wbmcgdG8gYXBwbGljYXRpb24vdm5kLmFkb2JlLnBob3Rvc2hvcCIgLz4NCiAgICAgICAgICA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6YjBjODFhYjYtMGNjZC00NjU3LWJjYmUtZWE4NzE2MmFkMzdlIiBzdEV2dDp3aGVuPSIyMDIwLTA0LTE4VDE1OjU0OjE0KzA5OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgMjEuMSAoTWFjaW50b3NoKSIgc3RFdnQ6Y2hhbmdlZD0iLyIgLz4NCiAgICAgICAgICA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6N2Q0NjA3YTktNzgxYy00YjgwLWE3NmYtNDhiYTRlOGYxZWRiIiBzdEV2dDp3aGVuPSIyMDIwLTA1LTA1VDIzOjI2OjEzKzA5OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgMjEuMSAoTWFjaW50b3NoKSIgc3RFdnQ6Y2hhbmdlZD0iLyIgLz4NCiAgICAgICAgICA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY29udmVydGVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJmcm9tIGFwcGxpY2F0aW9uL3ZuZC5hZG9iZS5waG90b3Nob3AgdG8gaW1hZ2UvcG5nIiAvPg0KICAgICAgICAgIDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJkZXJpdmVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJjb252ZXJ0ZWQgZnJvbSBhcHBsaWNhdGlvbi92bmQuYWRvYmUucGhvdG9zaG9wIHRvIGltYWdlL3BuZyIgLz4NCiAgICAgICAgICA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6MDJhYmJmODctYmM1NC00MzZiLTg3OGEtODg2OTNmYTg4NDEyIiBzdEV2dDp3aGVuPSIyMDIwLTA1LTA1VDIzOjI2OjEzKzA5OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgMjEuMSAoTWFjaW50b3NoKSIgc3RFdnQ6Y2hhbmdlZD0iLyIgLz4NCiAgICAgICAgPC9yZGY6U2VxPg0KICAgICAgPC94bXBNTTpIaXN0b3J5Pg0KICAgIDwv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";
    }
}