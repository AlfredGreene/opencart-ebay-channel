
function messageWait(el) {
  el.find('i').addClass('fa-spin');
  el.find('span').text('wait...');
  el.prop('disabled', true);
}

function messageSuccess(el) {
  el.removeClass('btn-default').addClass('btn-success');
  el.find('span').text('Done');
  el.find('i').removeClass('fa-spin');

  setTimeout(function() {
    el.removeClass('btn-success').addClass('btn-default');
    el.find('span').text('Save');
    el.find('i').removeClass('fa-spin');
    el.prop('disabled', false);
  }, 2000);
}
function messageFailed(el) {
  el.removeClass('btn-default').addClass('btn-danger');
  el.find('span').text('Failed');
  el.find('i').removeClass('fa-spin');

  setTimeout(function() {
    el.removeClass('btn-danger').addClass('btn-default');
    el.find('span').text('Save');
    el.find('i').removeClass('fa-spin');
    el.prop('disabled', false);
  }, 2000);
}
function notify(event,message,injectto) {
  var event_class = '';
  var icon = ''
  switch (event) {
    case 'success':
    event_class = 'alert-success';
    icon = 'fa-check-circle';
    break;
    case 'info':
    event_class = 'alert-info';
    icon = 'fa-question-circle';
    break;
    case 'error':
    event_class = 'alert-danger';
    icon = 'fa-exclamation-circle';
    break;
  }

  var notify_box = '<div class="alert '+event_class+'"><i class="fa '+icon+'"></i> \
  '+message+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>';

  injectto.html(notify_box);
  injectto.slideDown('500');

  if(event == 'success') {
    setTimeout(function() {injectto.slideUp('500')}, 6000);
  }
}
$(function() {
  $('body').on('click', '.category-item', function(event) {
    event.preventDefault();
    var parent_id = $(this).attr('data-value');
    var name = $(this).text();
    getCategory(parent_id, name);
  });

  $('#category_id').click(function(event) {
    $('.category-list-main').show();
    if($.trim($('.category-list-main').html()) == '') {
      notify('info','Sorry. Please import categories.' ,$('.notify'));
    }
  }).blur(function(event) {
    $("body").click(function(event) {
      if (!$(event.target).hasClass('category-item') && event.target.id != 'category_id') {
        $('.category-list-main').hide();
      }
    });

  });
});


function getCategory(parent_id, name) {
  name = $.trim(name);
  if (name != '') {
    $('.cat-name').text($('.cat-name').text() + ' >> '+name);
  }
  $.ajax({
    url: action_get_category,
    type: 'POST',
    dataType: 'json',
    data: {
      parent_id: parent_id
    },
  })
  .done(function(res) {
    if (res.length > 0) {
      categoryFilter(res);
    } else {
      $('#category_id').val(parent_id);

      $('.category-list-main').hide();
      getCategory(null);
    }
  })
  .fail(function(res) {
    $('.category-list-main').hide();
    $('#category_id').val('Please Retry.');
  });
}

function categoryFilter(data) {
  $('.category-list-main').html('<i class="fa fa-spinner fa-spin fa-3x"></i>');
  html = "";
  for (var i = 0; i < data.length; i++) {
    html += '<a href="#!" class="list-group-item category-item" data-value="' + data[i].category_id + '">\
    ' + $.trim(data[i].category_name) + '</a>';
  }
  $('.category-list-main').html(html);
}

function loader() {
  return '<p style="text-align: center;">Please Wait!</p><span class="loader"><span class="loader-inner"></span></span>';
}
