<?php 
class Controllerocebayproduct extends Controller { 
	private $error = array();

	public function index()
	{
		$this->load->language('module/ocebay');
		$this->document->setTitle($this->language->get('text_products_tab'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('account', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('text_products_tab');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true)
			);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/ocebay', 'token=' . $this->session->data['token'], true)
			);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_products_tab'),
			'href' => $this->url->link('ocebay/product', 'token=' . $this->session->data['token'], true)
			);

		$data['button_cancel']	= $this->language->get('button_cancel');
		$data['cancel'] 				= $this->url->link('module/ocebay', 'token=' . $this->session->data['token'], true);

		$data['action_get_products']		= $this->url->link('ocebay/product/getProductList', 'token=' . $this->session->data['token'], true);
		


		# PRODUCT LANGUAGE :: STARTS

		$this->load->language('catalog/product');

		$data['column_image'] = $this->language->get('column_image');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		# PRODUCT LANGUAGE :: ENDS		

		$data['header'] 	 			= $this->load->controller('common/header');
		$data['column_left'] 		= $this->load->controller('common/column_left');
		$data['footer'] 	 			= $this->load->controller('common/footer');

		$data['action_get_template_list']  = $this->url->link('ocebay/listingTemplate/getAllListingTemplate', 'token=' . $this->session->data['token'], true);

		$data['action_listitem'] = $this->url->link('ocebay/product/listItem', 'token=' . $this->session->data['token'], true);
		$data['action_relistitem'] = $this->url->link('ocebay/product/reListItem', 'token=' . $this->session->data['token'], true);
		$data['action_enditem'] = $this->url->link('ocebay/product/endItem', 'token=' . $this->session->data['token'], true);
		

		$this->response->setOutput($this->load->view('ocebay/product', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'ocebay/settings')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}

	public function getProductList()
	{
		$this->load->language('catalog/product');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		$this->load->model('ocebay/ocebay');
		$products = array();

		$product_total = $this->model_catalog_product->getTotalProducts(null);

		$results = $this->model_catalog_product->getProducts(null);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

			$special = false;

			$product_specials = $this->model_catalog_product->getProductSpecials($result['product_id']);

			$product_listing = $this->model_ocebay_ocebay->getProductListing(null, null,$result['product_id']);

			$ebay_id = '';
			$ebay_url = '';

			if($product_listing) {
				$ebay_id = trim($product_listing[0]['item_id']);
				$ebay_url = trim($product_listing[0]['item_url']);
			}

			$products[] = array(
				'product_id' => $result['product_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'model'      => $result['model'],
				'price'      => $result['price'],
				'quantity'   => $result['quantity'],
				'ebay_id'    => $ebay_id ,
				'ebay_url'   => $ebay_url,
				'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				
				);
		}

		echo json_encode($products);
	}

	public function listItem()
	{
		$template_id 	= $this->request->post['template_id'];
		$product_id 	= $this->request->post['product_id'];
		$item_data = $this->getItemDetails($product_id, $template_id);

		$this->load->model('ocebay/api');
		if($this->request->post['action'] == 'verify') {
			$result = $this->model_ocebay_api->verifyItem($item_data);
		}else if($this->request->post['action'] == 'add') {
			$result = $this->model_ocebay_api->addItem($item_data);

			if(!empty($result['success'])) {
				$item_id = $result['success']['item_id'];
				$get_item = $this->model_ocebay_api->getItem($item_id);
				if($get_item) {
					$this->load->model('ocebay/ocebay');
					$item_url = $get_item->Item->ListingDetails->ViewItemURL;

					$data = array(
						'template_id' => $template_id, 
						'product_id'	=> $product_id,
						'item_url'		=> $item_url,
						'item_id'			=> $item_id,
						'status'			=> 'Listed'
						);
					$this->model_ocebay_ocebay->saveListingHistory($data);
				}

			}
		}

		echo json_encode($result);
	}

	public function reListItem()
	{
		$template_id 	= $this->request->post['template_id'];
		$product_id 	= $this->request->post['product_id'];
		$item_id 	= $this->request->post['item_id'];
		$item_data = $this->getItemDetails($product_id, $template_id);

		$item_data['item_id'] = $item_id;

		$this->load->model('ocebay/api');
		$result = $this->model_ocebay_api->updateItem($item_data);
		
		echo json_encode($result);
	}

	public function endItem()
	{
		$product_id 	= $this->request->post['product_id'];
		$item_id 	= $this->request->post['item_id'];
		$reason 	= $this->request->post['end_reason'];
		if($reason == '') {
			$reason = 'NotAvailable';
		}
		
		$data = array(
			'item_id' 		=> $item_id,
			'product_id' 	=> $product_id,
			'reason' 			=> $reason
			);
		$this->load->model('ocebay/api');
		$result = $this->model_ocebay_api->endItem($data);
		
		echo json_encode($result);	
	}

	private function getItemDetails($product_id, $template_id)
	{
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		$this->load->model('ocebay/ocebay');

		$this->load->model('ocebay/listingtemplate');

		$list = array();
		$template_data = $this->model_ocebay_listingtemplate->get($template_id);

		foreach ($template_data as $key => $value) {
			$list['template_name'] = trim($value['template_name']);
			$list['default_template'] = trim($value['default_template']);
			$list['category_id'] = trim($value['category_id']);
			$list['item_condition'] = trim($value['item_condition']);
			$list['condition_description'] = trim($value['condition_description']);
			$list['listing_type'] = trim($value['listing_type']);
			$list['listing_duration'] = trim($value['listing_duration']);

			$list['pricing_mode'] = trim($value['pricing_mode']);
			$list['price_action'] = trim($value['price_action']);
			$list['price_method'] = trim($value['price_method']);
			$list['price_value'] = trim($value['price_value']);
			$list['quantity'] = trim($value['quantity']);

			$list['currency'] = trim($value['currency']);
			$list['product_country'] = trim($value['country']);
			$list['postal_code'] = trim($value['postal_code']);
			$list['payment_methods'] = json_decode(trim($value['payment_methods']));
			$list['paypal_email'] = trim($value['paypal_email']);
			
			$list['accept_return'] = trim($value['return_accepted']);
			$list['return_within'] = trim($value['return_within']);
			$list['refund_option'] = trim($value['refund_option']);
			$list['shipping_cost_payer'] = trim($value['return_cost_payed_by']);
			$list['return_description'] = trim($value['return_description']);

			$list['shipping_type'] = trim($value['shipping_type']);
			$list['package_type'] = trim($value['package_type']);
			$list['package_depth'] = trim($value['package_depth']);
			$list['package_length'] = trim($value['package_length']);
			$list['package_width'] = trim($value['package_width']);
			$list['package_weight'] = trim($value['package_weight']);
			$list['shipping_duration'] = trim($value['shipping_duration']);

			$list['shipping_details'] = json_decode(trim($value['shipping_details']));
		}


		$list['site_code'] = $this->model_ocebay_ocebay->getSiteCode();

		$product = $this->model_catalog_product->getProduct($product_id);

		if (is_file(DIR_IMAGE . $product['image'])) {
			$image = $this->model_tool_image->resize($product['image'], 400, 400);
		} else {
			$image = $this->model_tool_image->resize('no_image.png', 400, 400);
		}


		$list['product_name'] = trim($product['name']);
		$list['product_description'] = trim($product['description']);

			# Product Price Set :: Starts
		$price = (float) trim($product['price']);

		if($list['pricing_mode'] != 'product_price') {
			$change_value = (float) $list['price_value'];

			if($list['price_method'] != 'amount') {
				$change_value =  ($price * ($change_value/100));
			}

			if($list['price_action'] == '+') {
				$price += $change_value;
			}else{
				$price -= $change_value;
			}
		}

		$list['product_price'] = $price;
			# Product Price Set :: Ends
		if($list['quantity'] == 'store_quantity') {
			$list['quantity'] = trim($product['quantity']);
		}else{
			$list['quantity'] = 1;
		}

		$list['product_image'] = $image;
		
		return $list;
	}
}

?>