<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
        <button type="button" class="btn btn-primary" id="save-template" data-toggle="tooltip" title="<?php echo $button_save; ?>"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="" method="post" enctype="multipart/form-data" id="form-template" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-listing" data-toggle="tab"><?php echo $tab_listing; ?></a></li>
            <li><a href="#tab-location" data-toggle="tab"><?php echo $tab_location; ?></a></li>
            <li><a href="#tab-payment" data-toggle="tab"><?php echo $tab_payment; ?></a></li>
            <li><a href="#tab-return" data-toggle="tab"><?php echo $tab_return; ?></a></li>
            <li><a href="#tab-shipping" data-toggle="tab"><?php echo $tab_shipping_details; ?></a></li>
          </ul>
          <div class="tab-content">
            <!-- GENERAL STARTS -->
            <div class="tab-pane active" id="tab-general">
              <div class="form-group required">
                <label class="col-sm-2 control-label"><?= $entry_list_name ?></label>
                <div class="col-sm-7">
                  <div class="input-group col-xs-6">
                    <input type="text" name="template_name" class="form-control" required placeholder="<?= $entry_list_name ?>" >
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?= $entry_default_template ?></label>
                <div class="col-sm-7">
                  <div class="input-group col-xs-1">
                    <input type="checkbox" name="default_template" value="1">
                    <?php if(isset($template_id)): ?>
                      <input type="hidden" name="template_id" value="<?= $template_id ?>">
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label"><?= $entry_category ?></label>
                <div class="col-sm-7">
                  <div class="input-group col-xs-6">
                    <input type="text" name="ebay_category" class="form-control" value="" required id="category_id" placeholder="<?= $entry_category ?>">
                    <div class="list-group category-list-main">
                      <?php foreach ($list_category as $value):?>
                        <a href="#!" class="list-group-item category-item" data-value="<?= $value['category_id']; ?>">
                          <?= trim($value['category_name']) ?>
                        </a>
                      <?php endforeach;?>
                    </div>
                    <p class="text-info"><small class="cat-name"><?= (isset($category_name)) ? $category_name : '' ?></small></p>
                  </div>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label"><?= $entry_item_condition ?></label>
                <div class="col-sm-7">
                  <div class="input-group col-xs-6">
                    <select name="item_condition" class="form-control" required placeholder="<?= $entry_item_condition ?>">
                      <option value="">-- Select --</option>
                      <?php foreach($list_item_condition as $value): ?>
                        <option value="<?= $value['condition_id'] ?>"><?= $value['condition_name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?= $entry_item_condition_desc ?></label>
                <div class="col-sm-7">
                  <div class="input-group col-xs-6">
                    <textarea name="condition_description" placeholder="<?= $entry_item_condition_desc ?>" class="form-control"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <!-- GENERAL ENDS -->
            <!-- LISTING STARTS -->
            <div class="tab-pane" id="tab-listing">
              <div class="form-group required">
                <label class="col-sm-2 control-label"><?= $entry_list_type ?></label>
                <div class="col-sm-7">
                  <div class="input-group col-xs-6">
                    <select name="listing_type" class="form-control">
                      <?php foreach($list_listing_type as $value): ?>
                        <option value="<?= $value; ?>"><?= $value; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label"><?= $entry_list_duration ?></label>
                <div class="col-sm-7">
                  <div class="input-group col-xs-6">
                    <select name="listing_duration" class="form-control">
                      <option value="Days_1">Days 1</option>
                      <option value="Days_7">Days 7</option>
                      <option value="Days_30">Days 30</option>
                      <option value="Days_60">Days 60</option>
                      <option value="Days_90">Days 90</option>
                      <option value="GTC" selected>Good 'Til Cancelled</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Buy It Now Price</span></label>
                <div class="col-sm-7">
                  <div class="input-group col-xs-6">
                    <select name="price_mode" class="form-control">
                      <option value="product_price" selected>Product Price</option>
                      <option value="modify_price">Modify Product Price</option>
                    </select>
                  </div>
                  <div class="modify_price input-group col-xs-6">
                    <div class="input-group">
                      <div class="input-group-addon input-sm">
                        <select name="price_action">
                          <option value="+">+</option>
                          <option value="-">-</option>
                        </select>
                      </div>
                      <div class="input-group-addon input-sm">
                        <select name="price_method">
                          <option value="amount">Amount</option>
                          <option value="percentage">Percentage</option>
                        </select>
                      </div>
                      <input type="number" name="price_value" class="form-control" placeholder="Value" min="1" step="any">
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label"><?= $entry_quantity ?></span></label>
                <div class="col-sm-7">
                  <div class="input-group col-xs-6">
                    <select name="quantity" class="form-control">
                      <option value="1">One Item</option>
                      <option value="store_quantity" selected>Store Avaiable Items</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <!-- LISTING ENDS -->
            <!-- LOCATION STARTS -->
            <div class="tab-pane" id="tab-location">
              <div class="form-group required">
                <label class="col-sm-2 control-label"><?= $entry_country ?></label>
                <div class="col-sm-7">
                  <div class="input-group col-xs-6">
                    <select name="country" class="form-control" required placeholder="<?= $entry_country ?>">
                      <option value="">-- Select --</option>
                      <?php foreach ($list_countries as $country) { ?>
                      <option value="<?= $country['iso_code_2']; ?>"><?= $country['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label"><?= $entry_postal_code ?></label>
                <div class="col-sm-7">
                  <div class="input-group col-xs-6">
                    <input type="text" name="postal_code" class="form-control" required placeholder="<?= $entry_postal_code ?>">
                  </div>
                </div>
              </div>
            </div>
            <!-- LOCATION ENDS -->
            <!-- PAYMENT STARTS -->
            <div class="tab-pane" id="tab-payment">
              <div class="form-group required">
                <label class="col-sm-2 control-label"><?= $entry_payment_method ?></label>
                <div class="col-sm-7">
                  <div class="input-group col-xs-6">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="payment_method[]" value="VisaMC"> Visa / Master Card
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="payment_method[]" value="CashOnPickup"> Cash On Pickup
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="payment_method[]" value="PayPal" checked> PayPal
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label"><?= $entry_paypal_email ?></label>
                <div class="col-sm-7">
                  <div class="input-group col-xs-6">
                    <input type="email" name="paypal_email" class="form-control" required placeholder="<?= $entry_paypal_email ?>">
                  </div>
                </div>
              </div>

            </div>
            <!-- PAYMENT ENDS -->
            <!-- RETURN STARTS -->
            <div class="tab-pane" id="tab-return">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?= $entry_return_accept ?></label>
                <div class="col-sm-7">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="accept_return" value="ReturnsAccepted">
                    </label>
                  </div>
                </div>
              </div>
              <div class="return-detail">
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?= $entry_return_within ?></label>
                  <div class="col-sm-7">
                    <div class="input-group col-xs-6">
                      <select name="return_duration" class="form-control">
                        <option value="Days_3" selected>Days 3</option>
                        <option value="Days_7" selected>Days 7</option>
                        <option value="Days_14" selected>Days 14</option>
                        <option value="Days_30">Days 30</option>
                        <option value="Days_60">Days 60</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?= $entry_refund_option ?></label>
                  <div class="col-sm-7">
                    <div class="input-group col-xs-6">
                      <select name="refund_option" class="form-control">
                        <option value="MoneyBack">Money Back</option>
                        <option value="MoneyBackOrExchange" selected>Money Back Or Exchange</option>
                        <option value="MoneyBackOrReplace">Money Back Or Replace</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?= $entry_shipping_cost_payed_by ?></label>
                  <div class="col-sm-7">
                    <div class="input-group col-xs-6">
                      <select name="return_payed_by" class="form-control">
                        <option value="Buyer" selected>Buyer</option>
                        <option value="Seller">Seller</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?= $entry_return_description ?></label>
                  <div class="col-sm-7">
                    <div class="input-group col-xs-6">
                      <textarea name="return_policy" class="form-control" placeholder="<?= $entry_return_description ?>"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- RETURN ENDS -->
            <div class="tab-pane" id="tab-shipping">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?= $entry_ship_costing_type; ?></label>
                <div class="col-sm-7">
                  <div class="input-group col-xs-6">
                    <select name="shipping_type" class="form-control">
                      <option value="Flat">Flat</option>
                      <option value="Calculated">Calculated</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?= $entry_shipping_type ?></label>
                <div class="col-sm-7">
                  <div class="input-group col-xs-6">
                    <select name="package_type" class="form-control">
                      <option value="Package">Package</option>
                      <option value="Large Package">Large Package</option>
                      <option value="Letter">Letter</option>
                      <option value="Large Envelope">Large Envelop</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group dimensions required">
                <label class="col-sm-2 control-label"><?= $entry_dimension ?></label>
                <div class="col-sm-7">
                  <div class="input-group col-xs-7">
                    <div class="input-group-addon input-sm">Depth</div>
                    <input type="number" class="form-control input-sm" name="depth" placeholder="0" min="1" step="any">
                    <div class="input-group-addon input-sm">Length</div>
                    <input type="number" class="form-control input-sm" name="length" placeholder="0" min="1" step="any">
                    <div class="input-group-addon input-sm">Width</div>
                    <input type="number" class="form-control input-sm" name="width" placeholder="0" min="1" step="any">
                  </div>
                  <p class="text-info"><small>(enter dimensions in inches)</small></p>
                  <p class="text-warning">-- OR --</p>
                  <div class="input-group col-xs-3">
                    <div class="input-group-addon input-sm">Weight</div>
                    <input type="number" class="form-control input-sm" name="weight" placeholder="1" min="1" step="any">
                  </div>
                  <p class="text-info"><small>(enter weight in lbs)</small></p>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?= $entry_package_handling_time; ?></label>
                <div class="col-sm-7">
                  <div class="input-group col-xs-6">
                    <select name="shipping_duration" class="form-control">
                      <option value="Days_0">Days 0</option>
                      <option value="Days_1">Days 1</option>
                      <option value="Days_3">Days 3</option>
                      <option value="Days_5">Days 5</option>
                      <option value="Days_10">Days 10</option>
                      <option value="Days_15">Days 15</option>
                      <option value="Days_20">Days 20</option>
                      <option value="Days_30">Days 30</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group required">
                <label class="col-sm-2 control-label"><?= $entry_shipping_service ?></label>
                <div class="col-sm-10">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><?= $entry_shipping_service ?></th>
                        <th><?= $entry_shipping_cost ?></th>
                        <th><?= $entry_shipping_cost_additional ?></th>
                        <th><?= $entry_international_shipto ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php for($i = 0; $i < 5;$i++): ?>
                        <tr>
                          <td>
                            <select name="shipping_service_<?= $i ?>[]" class="form-control input-sm">
                              <option value="">-- Select --</option>}
                              option
                              <?php foreach ($list_shipping_service as $value): ?>
                                <optgroup label="<?= $value['type'] ?>">
                                  <?php foreach ($value['list'] as $key => $list): ?>
                                    <option value="<?= $list['value'] ?>"><?= $list['name'] ?></option>
                                  <?php endforeach ?> ?>
                                </optgroup>
                              <?php endforeach ?> ?>
                            </select>
                          </td>
                          <td>
                            <input type="number" class="form-control input-sm" name="shipping_cost_<?= $i ?>[]" placeholder="1" min="1" step="any">
                          </td>
                          <td>
                            <input type="number" class="form-control input-sm" name="shipping_cost_additional_<?= $i ?>[]" placeholder="1" min="1" step="any">
                          </td>
                          <td>
                            <select name="shipping_to_<?= $i ?>[]" class="form-control input-sm">
                              <?php foreach ($list_shipping_region as $value): ?>
                                <option value="<?= $value ?>"><?= $value ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                        </tr>
                      <?php endfor; ?>
                    </tbody>
                  </table>
                  <p class="text-info"><small>Leave <?= $entry_shipping_cost_additional ?> empty for free shipping</small></p>
                </div>
              </div>

            </div>
          </div>
        </form>  
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" type="text/css" href="view/stylesheet/ocebay/main.css">
<style type="text/css">
  .category-list-main{
    max-height: 430px;
    overflow: auto;
    display: none;
    position: absolute;
    z-index: 10;
    box-shadow: 0px 7px 12px -8px #000;
    min-width: 275px;
  }
  .modify_price, .dimensions, .return-detail{
    display: none;
  }
  .cat-name{
    margin-top:5px;
  }
</style>
<script type="text/javascript">
  var action_save = '<?= $action_save; ?>';
  action_save = action_save.replace('amp;','');

  var redirect_to = '<?= $redirect_to; ?>';
  redirect_to = redirect_to.replace('amp;','');

  var action_get_category = '<?php echo $action_get_category; ?>';
  action_get_category = action_get_category.replace('amp;','');

  $('[name=price_mode]').change(function(event) {
    if($(this).val() == 'modify_price') {
      $('.modify_price').show('500');
    }else{
      $('.modify_price').hide('500');
    }
  });
  $('[name=shipping_type]').change(function(event) {
    if($(this).val() == 'Calculated') {
      $('.dimensions').show('500');
    }else{
      $('.dimensions').hide('500');
    }
  });
  $('[name=accept_return]').change(function(event) {
    if($(this).is(':checked')) {
      $('.return-detail').show('500');
    }else{
      $('.return-detail').hide('500');
    }
  });
  $('#save-template').click(function(event) {
    var data = $('#form-template').serialize();
    if(validate()){
      $.ajax({
        url: action_save,
        type: 'POST',
        dataType: 'json',
        data: data,
        success:function(response) {
          if(response.success) {
            notify('success',response.msg ,$('.notify'));
            setTimeout(function() {window.location.replace(redirect_to)}, 3000);
          }else{
            notify('error',response.msg ,$('.notify'));
          }
        },
        error:function(response) {
          notify('error','Sorry. Internal Server Error.' ,$('.notify'));
        }
      });

    }
  });

  function validate() {
    var error_msg = 'Please fill followings, <br>';
    var validate_false = 0;
    $('input[type="text"], input[type="email"], select').each(function(index, el) {
      var req = $(this).attr('required');
      if($(this).val() == '' && req == 'required') {
        var field_label = $(this).attr('placeholder');
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
</script>
<?php if(isset($template_id)): ?>
  <script type="text/javascript">
    var template_data = escapeSpecialChars('<?= $template_data ?>');
    template_data = $.parseJSON(template_data);
    loadUpdateListForm(template_data);

    function loadUpdateListForm(data) {
      $.each(data, function(index, val) {
        if (index == 'default_template') {
          if (val == '0') {
            $('[name=' + index + ']').prop('checked', false);
          } else {
            $('[name=' + index + ']').prop('checked', true);
          }
        } else if (index == 'accept_return') {
          if ($.trim(val) == 'ReturnsAccepted') {
            $('[name=' + index + ']').prop('checked', true);
            $('.return-detail').slideDown('500');
          } else {
            $('[name=' + index + ']').prop('checked', false);
          }
        } else if (index == 'return_policy_detail') {
          $('[name=' + index + ']').text($.trim(val));
        } else if (index == 'payment_method') {
          if (payment_method = val) {
            if (payment_method.length > 0) {
              $.each(payment_method, function(index, val) {
                $('[value='+val+']').prop('checked',true);
              });
            }
          }
        } else {
          $('[name=' + index + ']').val($.trim(val));
        }
      });
    }

    function escapeSpecialChars(jsonString) {

      return jsonString.replace(/\n/g, "\\n")
      .replace(/\r/g, "\\r")
      .replace(/\t/g, "\\t")
      .replace(/\f/g, "\\f");

    }

    var shipping_details = escapeSpecialChars('<?= $shipping_details ?>');
    shipping_details = $.parseJSON(shipping_details);
    loadShippingDetails(shipping_details);
    function loadShippingDetails(data) {
      $.each(data, function(index, val) {
        var nxt = val;
        var ar_i = index;
        $.each(nxt, function(index, val) { 
          if(index == 'shipping_service') {
            $('select[name="'+index+'_'+ar_i+'[]"]').val(val);
          }else if(index == 'shipping_to'){
            $('select[name="'+index+'_'+ar_i+'[]"]').val(val);
          }else{
            $('input[name="'+index+'_'+ar_i+'[]"]').val(val);
          }
        });
      });
    }

  </script>
<?php endif; ?>

<script type="text/javascript" src="view/javascript/ocebay.js"></script>
<?php echo $footer; ?>