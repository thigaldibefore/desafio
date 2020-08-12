/*!
 * Amaretti v2.0.0
 * https://foxythemes.net
 *
 * Copyright (c) 2018 Foxy Themes
 */

var App = (function () {
  'use strict';

  App.pageCalendar = function () {

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();


    /* initialize the calendar
    -----------------------------------------------------------------*/

    $('#calendar').fullCalendar({
      locale: 'pt-br',
      plugins: ['list'],
      contentHeight: 950,
      height: 950,
      aspectRatio: 1,
      header: {
        left: 'title',
        center: '',
        right: 'agendaWeek,month,list,today, prev,next',
      },
      defaultDate: date,
      editable: false,
      eventLimit: true,
      droppable: false,
      drop: function () {
        if ($('#drop-remove').is(':checked')) {
          $(this).remove();
        }
      },
      events: function (start, end, timezone, callback) {
        $.ajax({
          type: "GET",
          url: 'api/tarefas',
          dataType: "json",
          data: {},
          success: function (data) {
            var events = [];
            $.each(data.data, function (index, value) {
              events.push({
                id: value.id,
                title: value.titulo,
                start: value.data_entrega,
                dados: value
              })
            });
            callback(events);
          }
        });

      },
      eventClick: function (event) {
        var date = new Date(event.start);
        openModalTarefas(event.dados);
      },
    });

    // var event = { id: 1, title: 'New event aaaaaaaaaaa', start: new Date() };

    // $('#calendar').fullCalendar('renderEvent', event, true);
    $(document).on('change', '.check-input-checklist', function () {
      var checkgroup_id = $(this).parents('.group-checklist').attr('checkgroup_id');
      var checkeitem_id = $(this).parents('.check-item-content').attr('checkeitem_id');
      var obj = $(this).parents('.check-item-content');
      $.ajax({
        method: "POST",
        url: "api/tarefas/save-check-item",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          checkgroup_id: checkgroup_id,
          checkeitem_id: checkeitem_id,
          type: 'html'
        },
        dataType: 'html',
        success: function (msg) {
          $('.modalChecklist').modal('hide');
          obj.replaceWith(msg);
          $(this).siblings().toggleClass('line-through');
        },
        error: function (msg) {
          var _msg = JSON.parse(msg);
          alert(_msg.error);
        }
      });
    });

    $(document).on('click', '.btn-add-new-checklist-group', function () {
      var item_name = $('.input-new-checklistgroup-name');
      var tarefa_id = $('[name=tarefa_id]').val();
      if (item_name.val() !== '') {
        var clone = $('.group-checklist.clone').clone();
        $(clone).find('.check-group-titulo').html(item_name.val());
        $(clone).removeClass('d-none clone');
        $("#checklist-container").append(clone);
        $('.modalChecklist').modal('hide');
        item_name.val('');
      }
    });
    $('.modalChecklist').keypress(function (event) {
      if (event.keyCode == 13) {
        $('.modalChecklist .btn-add-new-checklist-group').trigger('click');
      }
    });
    $(document).on('click', '.btn-remove-group', function () {
      var checkgroup_id = $(this).attr('checkgroup_id');
      $.ajax({
        method: "DELETE",
        url: "tarefas/remove-check-group",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          checkgroup_id: checkgroup_id
        },
        dataType: 'json',
        success: function (msg) {
          if (msg.success) {
            $('div[checkgroup_id=' + checkgroup_id + ']').fadeOut(function () {
              $(this).remove();
            })
          }
        },
        error: function (msg) {
          alert(msg.error);
        }
      });
    });
    $(document).on('click', '.btn-add-new-check-item', function () {
      var item_name = $(this).parents('.checklist-append').find('[name="check-item-name"]');
      var checkgroup_id = $(this).attr('checkgroup_id');
      var obj = $(this).parents('.checklist-append');
      var clone = $('.check-item-line.clone').clone();
      $(clone).find('.custom-control-label').html(item_name.val());
      $(clone).removeClass('clone d-none');
      $(obj).before(clone);
    });
    $(document).on('keypress', '[name=check-item-name]', function (event) {
      if (event.keyCode == 13) {
        $(this).parents('.group-checklist').find('.btn-add-new-check-item').trigger('click');
      }
    });
    $(document).on('click', '.btn-add-new-feedback', function () {
      var item_feedback = $(this).parents('.feedback-comment').find('.input-feedback-comment');
      var tarefa_id = $('[name=tarefa_id]').val();
      var obj = $(this).parents('.feedback-comment');
      var clone = $('.feedback-content.clone').clone();
      $(clone).find('.feed').html(item_feedback.val());
      $(clone).find('.feed-user-name').html($('[name=feed_user_name]').val());
      $(clone).removeClass('d-none clone').addClass('d-flex new');
      $(obj).before(clone);
      item_feedback.val('');
    });
    $(document).on('click', '.btn-remove-feedback', function () {
      var feedback_id = $(this).attr('feedback_id');
      var tarefa_id = $('[name=tarefa_id]').val();
      var obj = $(this).parents('.feedback-content');
      if (feedback_id) {
        $.ajax({
          method: "DELETE",
          url: "api/tarefas/remove-feedback",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            feedback_id: feedback_id,
            tarefa_id: tarefa_id
          },
          dataType: 'json',
          success: function (msg) {
            $(obj).fadeOut().remove();
          },
          error: function (msg) {
            var _msg = JSON.parse(msg);
            alert(_msg.error);
          }
        });
      } else {
        $(obj).fadeOut().remove();
      }
    });
    $(document).on('click', '.btn-remove-member', function () {
      var member_id = $(this).attr('member_id');
      var tarefa_id = $('[name=tarefa_id]').val();
      var obj = $(this).parents('.member-content');
      $.ajax({
        method: "DELETE",
        url: "api/tarefas/remove-member",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          user_id: member_id,
          tarefas_id: tarefa_id
        },
        dataType: 'json',
        success: function (msg) {
          $(obj).fadeOut().remove();
        },
        error: function () {
          alert('Erro ao remover membro');
        }
      });
    });
    $(document).on('click', '.btn-remove-checkitem', function () {
      var checkitem_id = $(this).attr('checkitem_id');
      var tarefa_id = $('[name=tarefa_id]').val();
      var obj = $(this).parents('.check-item-content');
      $.ajax({
        method: "DELETE",
        url: "tarefas/remove-checkitem",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          checkitem_id: checkitem_id,
          tarefa_id: tarefa_id
        },
        dataType: 'json',
        success: function (msg) {
          $(obj).fadeOut().remove();
        },
        error: function (msg) {
          alert(msg.error);
        }
      });
    });
    $(document).on('click', '.btn-data-entrega', function () {
      var data_entrega = $('[name=data_entrega]').val();
      var tarefa_id = $('[name=tarefa_id]').val();
      $.ajax({
        method: "POST",
        url: "api/tarefas/update-data-entrega",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          data_entrega: data_entrega,
          tarefa_id: tarefa_id
        },
        dataType: 'json',
        success: function (msg) {
          if (msg.success) {
            alert("data alterada");
          }
        },
        error: function (msg) {
          alert(msg.error);
        }
      });
    });
    $(document).on('click', '.btn-status', function () {
      var status = $('[name=status] option:selected').val();
      var tarefa_id = $('[name=tarefa_id]').val();
      $.ajax({
        method: "POST",
        url: "api/tarefas/update-status",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          status: status,
          tarefa_id: tarefa_id
        },
        dataType: 'json',
        success: function (msg) {
          if (msg.success) {
            alert("status alterado");
          }
        },
        error: function (msg) {
          alert(msg.error);
        }
      });
    });
    $('.modalChecklist').on('hidden.bs.modal', function () {
      $('body').addClass('modal-open');
    });
    $('.modalTarefas').on('show.bs.modal', function () {
      $(".datetimepicker").datepicker({
        autoclose: true
      });
      //Select2
      $(".select2").select2({
        tags: true,
        width: '100%',
        dropdownParent: $('.modalTarefas .modal-content')
      });
      $('.select2').on('select2:select', function (e) {
        var data = e.params.data;
        var mydata = JSON.parse($(data.element).attr('data-info'));
        addMembro(mydata);
      });
    });

  };
  function addMembro(data) {
    var tarefa_id = $('[name=tarefa_id]').val();
    var clone = $('.member-content.clone').clone();
    $(clone).find('[name=member_id]').val(data.id);
    $(clone).find('.member-name').html(data.name);
    $(clone).removeClass('d-none clone').addClass('d-flex new');
    $('.member-list').append(clone);
  }

  return App;
})(App || {});