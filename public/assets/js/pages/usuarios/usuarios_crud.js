Dropzone.options.myAwesomeDropzone = {
    paramName: "file",
    maxFilesize: 2,
    uploadMultiple: false,
    maxFiles: 1,
    autoProcessQueue: false,
    acceptedFiles: 'image/*',
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    init: function () {
        this.on("processing", function (file) {
            this.options.url = "/usuarios/uploadAvatar";
            this.options.params = {'id': $('[name=id]').val()};
        });
        this.on("success", function (file, response) {
            if (response.success) {
                location.href = '/usuarios';
            } else {
                alert('erro ao fazer upload success');
                $('.loadingModal').hide();
            }
        });
        this.on("error", function (file, response) {
            alert('erro ao fazer upload');
            $('.loadingModal').hide();
        });
    }
};

$(function () {
    $('.ip_mask').mask('000');
    $('.timepicker').timepicker({
        timeFormat: 'HH:mm',
        interval: 15,
        minTime: '00:00am',
        maxTime: '23:45pm',
        defaultTime: null,
        startTime: '00:00',
        dynamic: false,
        dropdown: true,
        scrollbar: false,
        zindex: 9999
    });


    $(document).on('change', ".form-control.error", function () {
        $(this).next('.parsley-errors-li1st').fadeOut();
    });
    $('.deleteLogo').click(function () {
        $('.modalConfirm').modal('show').find('.btn-removeLogo').attr('conta_id', $(this).attr('conta_id'));
    });
    $('.btn-removeLogo').click(function () {
        $.ajax({
            method: 'POST',
            url: '/usuarios/removeAvatar',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'id': $(this).attr('user_id')},
            dataType: 'json',
            success: function (msg) {
                if (msg.success === true) {
                    $('.cardLogo').fadeOut();
                }
            }
        });
    });
    $('.btn-show-password-fields').click(function () {
        $('.hidde-password').toggleClass('d-none');
    });
    $('form[name=formContato]').keypress(function (event) {
        if (event.keyCode == 13) {
            $('.sendForm').trigger('click');
        }
    });
    $('.sendForm').click(function () {
        $('.loadingModal').fadeIn();
        var form = $('form');
        var values = form.serializeArray();
        values = values.concat(
            jQuery('form input[type=checkbox]:not(:checked)').map(
                function () {
                    return {"name": this.name, "value": 0};
                }).get()
        );
        var myDropzone = Dropzone.forElement("#my-awesome-dropzone");
        $.ajax({
            method: form.attr('method'),
            url: form.attr('action'),
            data: values,
            dataType: 'json',
            success: function (msg) {
                if (msg.success === true) {
                    $('[name=id]').val(msg.data.id);
                    if (myDropzone.files.length > 0) {
                        myDropzone.processQueue();
                    } else {
                        //location.href = '/usuarios';
                    }
                } else {
                    $('.loadingModal').fadeOut();
                    $.each(msg.error, function (item) {
                        $('[name=' + item + ']').addClass('error');
                        $('ul[for=' + item + ']').fadeIn();
                        $('ul[for=' + item + '] li').html(msg.error[item][0]).prev().show();
                    });
                }
            },
            error: function () {
                $('.loadingModal').fadeIn();
            }
        });
    });
});