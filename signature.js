const signature = {
    pad: "",
    result: "",
    img_result: "",
    submit: "",
    clear: "",
    camera: "",
    snapshot: "",
    img: "",
    init: function() {
        const result = this.result;
        const img_result = this.img_result;
        let img = this.img;
        // init signaturepad
        var signaturePad = new SignaturePad(document.getElementById(this.pad), {
                backgroundColor: 'rgba(255, 255, 255, 0)',
        penColor: 'rgb(0, 0, 0)'
        });
    
        // get image data and put to hidden input field
        function getSignaturePad() {
            var imageData = signaturePad.toDataURL('image/png');
            $(result).val(imageData)
            $(img_result).attr('src',"data:"+imageData);
        }
    
        // form action
        $('#save').click(function() {
            getSignaturePad();
            return false; // set true to submits the form.
        });
    
        // action on click button clear
        $('#clear').click(function(e) {
            e.preventDefault();
            signaturePad.clear();
        })
        
        //CAMERA
        // CAMERA SETTINGS.
        Webcam.set({
            width: 120,
            height: 120,
            image_format: 'jpeg',
            jpeg_quality: 50
        });
        Webcam.attach(this.camera);
        
        // SHOW THE SNAPSHOT.
        // A button for taking snaps
        takeSnapShot = function () {
            // take snapshot and get image data
            Webcam.snap(function (data_uri) {
                console.log(data_uri);
                $("#data_uri").val(data_uri);
                // generateQR(data_uri, img);
            });
        }
    },

    upload_signuri: function (e) {
        e.preventDefault();
        if(!document.querySelector(this.img_result).src.includes('data:image')) {
            alert("Tanda tangan harus diisi");
            return null
        }

        if ($("#data_uri").val() == '') {
            alert("Harus mengambil foto!");
            return null
        }     
        
        const data = new FormData();
        const image = document.querySelector(this.img_result);
        const file = dataURLtoFile(image.src, "signature.png")

        data.append("signature", file);
        data.append("data_uri", $("#data_uri").val());
        data.append("id_kegiatan", $("#id_kegiatan").val());

        $.ajax({
            type:'POST',
            url: e.target.action,
            data,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                console.log(data);
                data = JSON.parse(data);
                const message = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success: ${data.message}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
                $(".alert-message").html(message);
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
        });
    },

    generateQR: function (e) {
        e.preventDefault();
        const payload = `{
            id: ${$("#id_peserta").val()},
            link: "https://lib.ilkomdigitalsignature.my.id/verify.php?id=${$("#id_peserta").val()}",
            foto: "https://lib.ilkomdigitalsignature.my.id/base64.php?id=${$("#id_kegiatan").val()}"
        }`;
    
        $('form').append(`<input type="hidden" name="qrc_link" value="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${payload}" />`)

        const data = new FormData();
        data.append("id_kegiatan", $("#id_kegiatan").val());
        data.append("id_peserta", $("#id_peserta").val());
        data.append("id_data_dokumen", $("#id_data_dokumen").val());
        data.append("qrc", `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${payload}`)


        $.ajax({
            type:'POST',
            url: 'uploadqrcode.php',
            data,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                console.log(data)
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
        })
    }
}

function dataURLtoFile(dataurl, filename) {
    var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
    bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
    while(n--){
        u8arr[n] = bstr.charCodeAt(n);
    }
    return new File([u8arr], filename, {type:mime});
}