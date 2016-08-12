<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
        <button type="submit" class="btn btn-primary" id="save-setting" data-toggle="tooltip" title="<?php echo $button_save; ?>"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-cog"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form class="form-horizontal" id="ebay-setting-form">
          <div class="form-group required">
            <label class="col-sm-2 control-label">Application ID</label>
            <div class="col-sm-10">
              <div class="input-group col-xs-6">
                <input type="text" name="app_id" class="form-control" required value="<?= $app_id ?>" placeholder="Application ID">
              </div>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label">Developer ID</label>
            <div class="col-sm-10">
              <div class="input-group col-xs-6">
                <input type="text" name="dev_id" class="form-control" required value="<?= $dev_id ?>" placeholder="Developer ID">
              </div>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label">Certificate ID</label>
            <div class="col-sm-10">
              <div class="input-group col-xs-6">
                <input type="text" name="cert_id" class="form-control" required value="<?= $cert_id ?>" placeholder="Certificate ID">
              </div>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label">User Token</label>
            <div class="col-sm-10">
              <div class="input-group col-xs-6">
                <textarea name="user_token" rows="3" class="form-control" required placeholder="User Token"><?= $user_token?></textarea>
              </div>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label">Ebay Site</label>
            <div class="col-sm-10">
              <div class="input-group col-xs-6">
                <select class="form-control" required name="site_id">
                  <?php foreach ($site_list as $value):?>
                    <option value="<?= $value['site_id']; ?>"><?= $value['site_name'] ?> </option>

                  <?php endforeach;?>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label">Listing Mode</label>
            <div class="col-sm-10">
              <div class="input-group col-xs-6">
                <select class="form-control" required name="listing_mode">
                  <option value="sandbox" <?= ($listing_mode == 'sandbox') ? 'selected' : '' ?>>Sandbox</option>
                  <option value="production" <?= ($listing_mode == 'production') ? 'selected' : '' ?>>Production</option>
                </select>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" type="text/css" href="view/stylesheet/ocebay/main.css">
<script type="text/javascript" src="view/javascript/ocebay.js"></script>
<script type="text/javascript">
  var action_save = '<?= $action_save ?>';
  action_save = action_save.replace('amp;','');

  $(function() {
    $('#save-setting').click(function(event) {
      // $('form').submit();
      var data = $('form').serialize();
      
      if(validate($('form').serializeArray())) {
        $.ajax({
          url: action_save,
          type: 'POST',
          dataType: 'json',
          data: data,
          success:function(response) {
            if(response.success) {
              notify('success',response.msg ,$('.notify'));
            }else{
              notify('error',response.msg ,$('.notify'));
            }
          },
          error: function(response) {
            notify('error',response.msg ,$('.notify'));
          }
        });
      }
    });
    
    function validate(data) {
      var error_msg = 'Please fill followings, <br>';
      var validate_false = 0;
      $.each(data, function(index, val) {
        if(val.value == '') {
          var field_label = $('[name='+val.name+']').attr('placeholder');
          error_msg += '<b>'+field_label+'</b> is required.<br>';
          validate_false++;
        }
      });
      
      if(validate_false > 0) {
        notify('error',error_msg ,$('.notify'));
        return false;
      }else{
        return true;
      }

    }
  });

  
</script>
<?php echo $footer; ?>