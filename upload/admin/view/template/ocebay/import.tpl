<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
        <h3 class="panel-title"><i class="fa fa-cloud-download"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="entry-tax-percentage">Import Categories<span data-toggle="tooltip" data-container="#tab-import" title="Update ebay category list"></span></label>
            <div class="col-sm-10">
              <div class="input-group col-xs-2">
                <button class="btn btn-default" id="update-category"><i class="fa fa-refresh"></i> <span>Import</span></button>
              </div>
              <p class="text-info last-update-category">Last Update <b><?= $category_import_date ?></b></p>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="entry-tax-percentage">Import Orders<span data-toggle="tooltip" data-container="#tab-import" title="Import orders from ebay"></span></label>
            <div class="col-sm-10">
              <div class="input-group col-xs-2">
                <button class="btn btn-default" id="import-orders"><i class="fa fa-refresh" disabled></i> <span>Import</span></button>
              </div>
              <p class="text-info last-update-order">Last Update <b><?= $order_import_date ?></b></p>
            </div>
          </div>
        </form>
      </div>
    </div>
    <link rel="stylesheet" type="text/css" href="view/stylesheet/ocebay/main.css">
    <style type="text/css">
      .last-update-category,
      .last-update-order {
        margin-top:5px;
      }
    </style>
    <script type="text/javascript">
      var action_import_category = '<?= $action_import_category ?>';
      action_import_category = action_import_category.replace('amp;','');

      

      $(function() {
       $('#import-orders').click(function(event) {
        event.preventDefault();
        notify('info','Sorry. This feature is not available.',$('.notify'));
      });
       $('#update-category').click(function(event) {
        messageWait($('#update-category'));

        $.ajax({
          url: action_import_category,
          type: 'POST',
          dataType: 'json',
        })
        .done(function(res) {
          if (res.success) {
            messageSuccess($('#update-category'));
            notify('success',res.msg,$('.notify'));
          } else {
            alert(res.msg[0]);
            messageFailed($('#update-category'));
            notify('error',res.msg,$('.notify'));
          }
        })
        .fail(function(res) {
          messageFailed($('#update-category'));
          notify('error','Unexpected Error, Please try again.',$('.notify'));
        });

      });
     });
   </script>
   <script type="text/javascript" src="view/javascript/ocebay.js"></script>
   <?php echo $footer; ?>