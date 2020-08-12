$(function () {
    $("[name=documento_cliente]").on('blur', function () {

        let input = $(this).val();
        input = input.replace(/\s/g, '');
        input = input.replace(/\./g, '');
        input = input.replace(/\-/g, '');
        input = input.replace(/\,/g, '');
        
        $(this).val(input);

        if ($(this).val().length == 11) {
            $(this).mask('999.999.999-99', {autoclear: false});
        } else if ($(this).val().length == 14) {
            $(this).mask('99.999.999/9999-99', {autoclear: false});
        }
    });

    $("[name=documento_cliente]").on('focus', function () {
        $(this).unmask();
    });

    $('.deleteCliente').click(function () {
        let cliente_id = $(this).attr('cliente_id')
        new duDialog('Remover Cliente', 'Tem certeza que deseja remover o item selecionado?', duDialog.OK_CANCEL, {
            okText: 'Remover',
            cancelText: 'Fechar',
            callbacks: {
                okClick: function () {
                    $.ajax({
                        method: 'DELETE',
                        url: '/api/clientes/remove/' + cliente_id,
                        dataType: 'json',
                        success: function (msg) {
                            if (msg.success === true) {
                                $.gritter.add({
                                    title: 'Sucesso!',
                                    text: 'Cliente removido com sucesso',
                                    class_name: 'color success'
                                });
                                $('.alert').html('Cliente removido com sucesso').removeClass('d-none').show();
                                location.reload();
                                $('.loadingModal').hide();
                            } else {
                                $('.modalError .modalErrorMsg').html(msg.error);
                                $('.modalError').modal('show');
                                $('.loadingModal').hide();
                            }
                        }
                    });
                    this.hide();
                },
                cancelClick: function () {
                    this.hide();
                }
            }
        });
    });

    $("#btn-atender").popover({
        trigger: 'hover'
    });

    $('[data-toggle="popover"]').popover({
        trigger: 'hover'
    });

    $(".btn_atender").on('click', function () {
        $("#blockonopenfromregister").html('<div class="col-md-12">\n' +
            '                            <select name="cliente_id" class="form-control select2" disabled>' +
            '                                <option value="' + $(this).attr('id_cliente') + '">' + $(this).attr('nome_cliente') + '</option>\n' +
            '</select>\n' +
            '                        </div>');
    });

    $("#toggleAdvancedSearch").on('click', function () {
        let currentdisplay = $('#advancedSearchForm').css('display');
        if (currentdisplay == 'none') {
            $("#search1").addClass('d-none');
            $("#toggleAdvancedSearch").removeClass('btn-secondary');
            $("#toggleAdvancedSearch").addClass('btn-primary');
            $('#advancedSearchForm').css({
                'display': 'block'
            });
        } else {
            $("#search1").removeClass('d-none');
            $("#toggleAdvancedSearch").removeClass('btn-primary');
            $("#toggleAdvancedSearch").addClass('btn-secondary');
            $('#advancedSearchForm').css({
                'display': 'none'
            });
        }
    })

    /*$(".sendForm").on('click', function (e) {
        e.preventDefault();
            let values2 = $('form[name=search_clientes]').serializeArray();
    });*/
});