$('button.send').click(function (event) {

  event.preventDefault();

  event.stopPropagation()

  jsonObj = [];

  var isToAll = $('input.check_all').is(":checked")

  if (isToAll) {
    $('.users-table tr').each(function (index) {

      var id = $(this).find('input[name=_userid]').val()

      jsonObj.push(id);

    });
  }
  else {
    $('.users-table tr').each(function (index) {

      if ($(this).find('input.checkbox_check').is(":checked")) {

        var id = $(this).find('input[name=_userid]').val()

        jsonObj.push(id);
      }
    });
  }

  var jsonObjCleared = jsonObj.filter(function (el) {
    return el != null;
  });

  var formData = new FormData(document.getElementById("email-form"));

  var file = $("input[name='upload_file']")

  // var color = $("input[name=background_color]").val()

  formData.append('upload_file', file)

  formData.append('subject', $('input[name=subject]').val())

  formData.append('message', $('textarea[name=message]').val())

  formData.append('backgroud_color', $("input[name=background_color]").val())

  if (jsonObjCleared.length !== 0)
  {
      formData.append('usersIds', JSON.stringify(jsonObjCleared))
  }

  $('.loading_email').show()

  $.ajax({
    url: '/dashboard/send/email/user',
    type: 'POST',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: formData,
    processData: false,
    contentType: false
  }).done(function (response) {
    console.log(response)

    $('.loading_email').hide()

    $.isEmptyObject(response.error) ?  printSucessMsg(response.success) : printErrorMsg(response.error);
  
  })
    .fail(function (error) {

      console.log(error);

      // printErrorMsg([]);
    })
    .always(function () {

    });
})

function printErrorMsg(msg) {
  $(".print-error-msg").find("ul").html('');

  $(".print-error-msg").css('display', 'block');

  $.each(msg, function (key, value) {
    $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
  });

  $(".print-error-msg").delay(10000).fadeOut()
}

function printSucessMsg(msg) {

  $(".print-success-msg").html(msg);

  $(".print-success-msg").css('display', 'block');

  $(".print-success-msg").delay(10000).fadeOut()
}