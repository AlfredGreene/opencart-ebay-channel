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
      <div class="notify"></div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-opencart"></i> <?php echo $heading_title; ?></h3>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-hover" id="product-table">
            <thead>
              <tr>
                <th class="text-center"><?php echo $column_image; ?></th>
                <th class="text-left"><?php echo $column_name; ?></th>
                <th class="text-left"><?php echo $column_model; ?></th>
                <th class="text-right"><?php echo $column_price; ?></th>
                <th class="text-right"><?php echo $column_quantity; ?></th>
                <th class="text-left"><?php echo $column_status; ?></th>
                <th class="text-left">Ebay ID</th>
                <th class="text-right"><?php echo $column_action; ?></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                <th class="text-center"><?php echo $column_image; ?></th>
                <th class="text-left"><?php echo $column_name; ?></th>
                <th class="text-left"><?php echo $column_model; ?></th>
                <th class="text-right"><?php echo $column_price; ?></th>
                <th class="text-right"><?php echo $column_quantity; ?></th>
                <th class="text-left"><?php echo $column_status; ?></th>
                <th class="text-left">Ebay ID</th>
                <th class="text-right"><?php echo $column_action; ?></th>
              </tr>
            </tfoot>
          </table>

        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" tabindex="-1" role="dialog" id="myModel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Product Action</h4>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btn-nxt" data-value='1'>Next</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <script type="text/javascript" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="view/stylesheet/ocebay/main.css">
  <script type="text/javascript">
    var action_get_products = '<?= $action_get_products ?>';
    action_get_products = action_get_products.replace('amp;','');

    var action_listitem = '<?= $action_listitem ?>';
    action_listitem = action_listitem.replace('amp;','');

    var action_relistitem = '<?= $action_relistitem ?>';
    action_relistitem = action_relistitem.replace('amp;','');

    var action_enditem = '<?= $action_enditem ?>';
    action_enditem = action_enditem.replace('amp;','');

    var action_get_template_list = '<?= $action_get_template_list; ?>';
    action_get_template_list = action_get_template_list.replace('amp;','');

    $(function() {
      getProductList();
      function getProductList() {
        $.ajax({
         url: action_get_products,
         type: 'POST',
         dataType: 'json',
         success:function(response) {
          if(response.length > 0) {
            generateProductListTable(response)
          }
        },
        error:function(response) {

        }
      });
        
        setTimeout(function() {
          $('#product-table').DataTable();
        }, 500);  
      }

      function generateProductListTable(data) {
        var html = '';

        for (var i = 0; i < data.length; i++) { 
          html += '<tr>\
          <td class="text-center"><img src="'+data[i].image+'" class="img-responsive" /></td>\
          <td class="text-left">'+data[i].name+'</td>\
          <td class="text-left">'+data[i].model+'</td>\
          <td class="text-right">'+data[i].price+'</td>\
          <td class="text-right">'+data[i].quantity+'</td>\
          <td class="text-left">'+data[i].status+'</td>\
          <td class="text-left">';
            html += ((data[i].ebay_id == '')? 'Not Listed' : '<a href="'+data[i].ebay_url+'">'+data[i].ebay_id+'</a>');
            html += '</td>\
            <td>\
              <div class="btn-group">\
                <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\
                  Action <span class="caret"></span>\
                </button>\
                <ul class="dropdown-menu" product-id="'+data[i].product_id+'" data-item-id="'+data[i].ebay_id+'">\
                 <li><a href="#" class="list_on_ebay">List on Ebay</a></li>\
                 <li><a href="#" class="sync">Synchronize</a></li>\
                 <li><a href="#" class="end_item">End Item</a></li>\
               </ul>\
             </div>\
           </td>\
         </tr>';
       }

       $('#product-table tbody').html(html);
     }

     var product_id   = null;
     var template_id  = null;
     var item_id      = null;


     $('body').on('click', '.list_on_ebay, .sync, .end_item', function(event) {
       event.preventDefault();
       $('#btn-nxt').attr('data-value', 1);
       $('#btn-nxt').prop('disabled', false);
       product_id = $(this).parent().parent().attr('product-id');
       
       if($(this).parent().parent().attr('data-item-id') != '') {
        item_id = $(this).parent().parent().attr('data-item-id');
      }
      
      if($(this).hasClass('list_on_ebay')) {
        getListingTemplates();
        $('#myModel').modal('show');
        $('.modal-body').html(loader());
      }

      if($(this).hasClass('sync')) {
        if(item_id == null) {
          $('#myModel').modal('hide');
          notify('error','Sorry. This Product Is Not Listed.' ,$('.notify')); 
        }else{
          $('#myModel').modal('show');
          $('.modal-body').html(loader());
          getListingTemplates();
          $('#btn-nxt').attr('data-value', 3);
        }
      }

      if($(this).hasClass('end_item')) {
        if(item_id == null) {
          $('#myModel').modal('hide');
          notify('error','Sorry. This Product Is Not Listed.' ,$('.notify')); 
        }else{
          $('#myModel').modal('show');
          $('.modal-body').html(loader());
          $('.modal-body').html(generateEndReason());
          $('#btn-nxt').attr('data-value', 4);
        }
      }

    });

     $('body').on('click', '#btn-nxt', function(event) {
      event.preventDefault();
      $(this).prop('disabled', true);
      var btn_value = parseInt($(this).attr('data-value'));
      
      if(template_id == null) {
        template_id = $('select[name=listing_template]').val();
      }

      var action_url = '';
      var data = null;
      switch (btn_value) {
        case 1 :
        action_url = action_listitem;
        data = {product_id:product_id,template_id:template_id,action:'verify'};
        break;
        case 2 :
        action_url = action_listitem;
        data = {product_id:product_id,template_id:template_id,action:'add'};
        break;
        case 3 :
        action_url = action_relistitem;
        data = {product_id:product_id,template_id:template_id,item_id:item_id,action:'relist'};
        break;
        case 4 :
        action_url = action_enditem;
        var end_reason = $('textarea[name="end_reason"]').val();
        data = {product_id:product_id,item_id:item_id,end_reason:end_reason,action:'end'};
        break;

      }

      console.log(data);

      $('.modal-body').html(loader());
      $.ajax({
        url: action_url,
        type: 'POST',
        dataType: 'json',
        data: data,
        success:function(response) {
          if(response.errors && response.errors.length > 0) {
            $('.modal-body').html(genrateError(response.errors));
          }else if(response.prices && response.prices.length > 0) {
            $('#btn-nxt').prop('disabled', false).attr('data-value', 2);
            $('.modal-body').html(generatePriceTable(response.prices));
          }else if(response.success) {
            if(response.success.msg) {
              $('#myModel').modal('hide');
              notify('success',response.success.msg ,$('.notify'));
              getProductList();
            }
          }else{
            $('#myModel').modal('hide');
            notify('error','Sorry. Internel Error, Try later.' ,$('.notify'));  
          }
        },
        error:function(response) {
          $('#myModel').modal('hide');
          notify('error','Sorry. Internel Error.' ,$('.notify'));
        }
      });
    });

     function getListingTemplates() {
      $.ajax({
        url: action_get_template_list,
        type: 'POST',
        dataType: 'json',
      })
      .done(function(response) {
        if (response.data.length > 0) {
          $('.modal-body').html(generateSelectForm(response.data));
          
        }
      });
    }

    function generateSelectForm(data) {
      var form_html = '';
      form_html = '<div class="form-group required" style="height: 70px;">';
      form_html += '<label class="col-sm-5 control-label">Listing Template</label>';
      form_html += '<div class="col-sm-7">';
      form_html += '<div class="input-group col-xs-12">';
      form_html += '<select name="listing_template" class="form-control">';
      
      $.each(data, function(index, val) {
        form_html += '<option value="'+val.template_id+'"';
        if(val.default_template) {
          form_html += ' selected';
        }
        form_html +='>'+val.template_name+'</option>';
      });

      form_html += '</select>';
      form_html += '</div>';
      form_html += '</div>';
      form_html += '</div>';
      return form_html;
    }

    function genrateError(data) {
      var error_html = '<div class="error-body">';
      error_html += '<h5 style="font-size: 2em;"><i class="fa fa-exclamation-circle"></i> Please Check Followings.</h5>';
      error_html += '<ol type="1">';

      $.each(data, function(index, val) {
        error_html += '<li>'+val.long_message[0]+'</li>';
      });
      
      error_html += '</ol>';
      error_html += '</div>';
      return error_html;
    }

    function generateEndReason() {
      var form_html = '';
      form_html = '<div class="form-group required" style="height: 70px;">';
      form_html += '<label class="col-sm-5 control-label">Listing Template</label>';
      form_html += '<div class="col-sm-7">';
      form_html += '<div class="input-group col-xs-12">';
      form_html += '<textarea class="form-control" name="end_reason" placeholder="Reason for ending this item."></textarea>';
      form_html += '</div>';
      form_html += '</div>';
      form_html += '</div>';
      return form_html;
    }

    function generatePriceTable(data) {
      var total_fee = 0;
      var currency = '';
      var price_html = '<div class="price-table">';
      price_html += '<h5 style="color: #4CAF50;font-size: 2em;">';
      price_html += '<i class="fa fa-check-circle"></i> Success.<small> Item Verified, Click next to list on ebay</small>';
      price_html += '</h5>';
      price_html += '<table class="table table-bordered">';
      price_html += '<thead>';
      price_html += '<tr>';
      price_html += '<th>Fee Description</th>';
      price_html += '<th>Fee</th>';
      price_html += '</tr>';
      price_html += '</thead>';
      price_html += '<tbody>';
      
      $.each(data, function(index, val) {
        total_fee += val.fee;
        currency = val.currency[0];
        if(val.fee > 0) {
          price_html += '<tr>';
          price_html += '<td>'+val.name[0]+'</td>';
          price_html += '<td>'+val.fee+' '+val.currency[0]+'</td>';
          price_html += '</tr>';
        }
      });

      if(total_fee == 0) {
        price_html += '<tr>';
        price_html += '<td colspan="2">No Fee</td>';
        price_html += '</tr>';
      }
      price_html += '</tbody>';
      price_html += '<tfoot>';
      price_html += '<tr>';
      price_html += '<th>Total Fee</th>';
      price_html += '<th>'+total_fee+' '+ currency+'</th>';
      price_html += '</tr>';
      price_html += '</tfoot>';
      price_html += '</table>';
      price_html += '</div>';
      return price_html;
    }
  });
</script>
<script type="text/javascript" src="view/javascript/ocebay.js"></script>
<?php echo $footer; ?>