$(function () {
    $('form[name=search_usuario] .nome_usuario').select2({
        ajax: {
            url: '/api/users',
            processResults: function (data) {
                (data.data);
                return {
                    results: $.map(data.data, function (obj) {
                        return {id: obj.name, text: obj.name};
                    })
                };
            },
            dataType: 'json'
        },
        placeholder: 'Nome'
    });

    $('form[name=search_usuario] .email_usuario').select2({
        ajax: {
            url: '/api/users',
            processResults: function (data) {
                (data.data);
                return {
                    results: $.map(data.data, function (obj) {
                        return {id: obj.email, text: obj.email};
                    })
                };
            },
            dataType: 'json'
        },
        placeholder: 'E-mail'
    });
    $('form[name=search_usuario] .setor_usuario ').select2({
        ajax: {
            url: '/api/setor',
            processResults: function (data) {
                (data.data);
                return {
                    results: $.map(data.data, function (obj) {
                        return {id: obj.id, text: obj.titulo};
                    })
                };
            },
            dataType: 'json'
        },
        placeholder: 'Setor'
    });

    $('.deleteUser').click(function () {
        let user_id = $(this).attr('user_id');
        new duDialog('Remover Setor', 'Tem certeza que deseja remover o item selecionado?', duDialog.OK_CANCEL, {
            okText: 'Remover',
            cancelText: 'Fechar',
            callbacks: {
                okClick: function () {
                    $.ajax({
                        method: 'DELETE',
                        url: '/api/users/remove/' + user_id,
                        dataType: 'json',
                        success: function (msg) {
                            if (msg.success === true) {
                                $('.alert').html('Usuário removido com sucesso').removeClass('d-none').show();
                                setTimeout(() => {
                                    $('.alert').fadeOut();
                                    location.href = '/usuarios'
                                }, 3000);
                            } else {
                                $('.modalError .modalErrorMsg').html(msg.error);
                                $('.modalError').modal('show');
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
});