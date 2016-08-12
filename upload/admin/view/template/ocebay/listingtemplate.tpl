<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
        <a href="<?php echo $action_add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="notify"></div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_listing; ?></h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered" id="list-table">
         <thead>
          <tr>
            <th>Template Name</th>
            <th>Summery</th>
            <th>Products</th>
            <th>Default</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
         <tr>
           <th>Template Name</th>
           <th>Summery</th>
           <th>Products</th>
           <th>Default</th>
           <th>Action</th>
         </tr>
       </tfoot>
     </table>
   </div>
 </div>
</div>
</div>
<script type="text/javascript" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/ocebay/main.css">
<script type="text/javascript">
  var action_edit = '<?= $action_edit; ?>';
  action_edit = action_edit.replace('amp;','');

  var action_delete = '<?= $action_delete; ?>';
  action_delete = action_delete.replace('amp;','');

  var action_get_template_list = '<?= $action_get_template_list; ?>';
  action_get_template_list = action_get_template_list.replace('amp;','');

  getListingTemplates();

  function getListingTemplates() {
    $.ajax({
      url: action_get_template_list,
      type: 'POST',
      dataType: 'json',
    })
    .done(function(response) {
      if (response.data.length > 0) {
        generateListingTable(response.data);
      }
    });
    setTimeout(function() {
      $('#list-table').DataTable();
    }, 500);

  }

  function generateListingTable(data) {
    html = '';
    for (var i = 0; i < data.length; i++) {
      html += '<tr>\
      <td>' + data[i].template_name + '</td>\
      <td>' + data[i].summery + '</td>\
      <td>' + data[i].products + '</td>\
      <td>' + data[i].is_default + '</td>\
      <td>\
        <a href="'+action_edit+'&template_id='+data[i].template_id+'" class="btn-sm btn btn-success list-edit" list-id="' + data[i].template_id + '">\
          <i class="fa fa-pencil-square-o" aria-hidden="true"></i>\
        </a>\
        <button class="btn-sm btn btn-danger list-delete" list-id="' + data[i].template_id + '" data-products="'+data[i].products+'">\
          <i class="fa fa-times" aria-hidden="true"></i>\
        </button>\
      </td>\
    </tr>';
  }
    // return html;

    $('#list-table > tbody').html(html);
  }

  $('body').on('click', '.list-delete', function(event) {
    event.preventDefault();
    var products = parseInt($(this).attr('data-products'));

    if(products > 0) {
      notify('error','Sorry. This Template has Listed Products.' ,$('.notify'));
    }else{
      var confirm_msg = confirm("Are you sure?");

      if (confirm_msg == true) {
        $.ajax({
          url: action_delete,
          type: 'POST',
          dataType: 'json',
          data: {
            template_id: $(this).attr('list-id')
          },
          success: function(response) {
            $('#list-table').dataTable().fnDestroy();
            getListingTemplates();
            if(response.success) {
              notify('success',response.msg ,$('.notify'));
            }else{
              notify('error',response.msg ,$('.notify'));
            }
          },
          error: function(res) {
            notify('error','Sorry. Internel Server Error.' ,$('.notify'));
          }
        });
      }
    }
  });


</script>
<script type="text/javascript" src="view/javascript/ocebay.js"></script>
<?php echo $footer; ?>