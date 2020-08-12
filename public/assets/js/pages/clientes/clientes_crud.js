$(document).ready(function () {

    $('.cpf').mask('999.999.999-99', {
        autoclear: false
    });

    if ($('[name=tipo]').val() == 'F') {
        $('[name=documento]').prop("disabled", false);
        $('[name=documento]').mask('999.999.999-99', {
            autoclear: false
        });
    } else if ($('[name=tipo]').val() == 'J') {
        $('[name=documento]').prop("disabled", false);
        $('[name=documento]').mask('99.999.999/9999-99', {
            autoclear: false
        });
    } else {
        $('[name=documento]').prop("disabled", true);
    }

    $(document).on('change', ".form-control.error", function () {
        $(this).next('.parsley-errors-list').fadeOut();
    });

    $('form[name=formContato]').submit(function (event) {
        event.preventDefault();
    });   

    $('[name=tipo]').change(function () {
        if ($(this).val() == 'F') {
            $('[name=documento]').val('');
            $('[name=documento]').prop("disabled", false);
            $('[name=documento]').mask('999.999.999-99', {
                autoclear: false
            });
        } else if ($('[name=tipo]').val() == 'J') {
            $('[name=documento]').val('');
            $('[name=documento]').prop("disabled", false);
            $('[name=documento]').mask('99.999.999/9999-99', {
                autoclear: false
            });
        } else {
            $('[name=documento]').val('');
            $('[name=documento]').prop("disabled", true);
        }
    });

    $(".sendForm").on("click", function (e) {
        e.preventDefault();
        $('.loadingModal').fadeIn();
        var form = $('form');
        var values = form.serializeArray();
        values = values.concat(
            jQuery('form input[type=checkbox]:not(:checked)').map(
                function () {
                    return {
                        "name": this.name,
                        "value": 0
                    };
                }).get()
            );
        $.ajax({
            method: form.attr('method'),
            url: form.attr('action'),
            data: values,
            dataType: 'json',
            cache: true,
            success: function (msg) {
                if (msg.success === true) {
                    window.location.href = '/clientes';
                } else {
                    $('.loadingModal').fadeOut();
                    $.each(msg.error, function (item) {
                        $('[name=' + item + ']').addClass('error');
                        $('ul[for=' + item + ']').fadeIn();
                        $('ul[for=' + item + '] li').html(msg.error[item][0]).prev().show();
                    });
                }
            }
        });
    });


    if ($("[name=id]").val() != 'undefined' && $("[name=id]").val() != null && $("[name=id]").val() != '') {
        searchCep();
    }
});