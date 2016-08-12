<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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

      <div class="menu-main">
        <div class="menu-row">
          <a href="<?= $action_listing_template; ?>">
            <div class="menu-cards">
              <h5>
                <i class="fa fa-th-list" aria-hidden="true"></i>
                <br>
                <?= $text_listing; ?>
              </h5>
            </div>
          </a>
          <a href="<?= $action_import; ?>">
            <div class="menu-cards">
              <h5>
                <i class="fa fa-cloud-download" aria-hidden="true"></i>
                <br>
                <?= $text_import; ?>
              </h5>
            </div>
          </a>

          
          
          <a href="<?= $action_product; ?>">
            <div class="menu-cards">
              <h5>
                <i class="fa fa-opencart" aria-hidden="true"></i>
                <br>
                <?= $text_products; ?>
              </h5>
            </div>
          </a>
          <a href="<?= $action_settings; ?>">
            <div class="menu-cards">
              <h5>
                <i class="fa fa-cog" aria-hidden="true"></i>
                <br>
                <?= $text_settings; ?>
              </h5>
            </div>
          </a>
          
        </div>

      </div>
    </div>
    <link rel="stylesheet" type="text/css" href="view/stylesheet/ocebay/main.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <?php echo $footer; ?>