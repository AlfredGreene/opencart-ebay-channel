<?php
class ControllerOcebayListingTemplate extends Controller { 
	private $error = array();
	
	
	public function index() 
	{
		$this->load->language('module/ocebay');
		$this->document->setTitle($this->language->get('text_listing_template_tab'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('account', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('text_listing_template_tab');

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
			'text' => $this->language->get('text_listing_template_tab'),
			'href' => $this->url->link('ocebay/listingTemplate', 'token=' . $this->session->data['token'], true)
			);

		
		$data['action_add']                = $this->url->link('ocebay/listingTemplate/add', 'token=' . $this->session->data['token'], true);
		$data['action_edit']               = $this->url->link('ocebay/listingTemplate/add', 'token=' . $this->session->data['token'], true);
		$data['action_delete']               = $this->url->link('ocebay/listingTemplate/delete', 'token=' . $this->session->data['token'], true);
		$data['action_get_template_list']  = $this->url->link('ocebay/listingTemplate/getAllListingTemplate', 'token=' . $this->session->data['token'], true);
		
		
		$data['text_home']		= $this->language->get('text_home_tab');
		$data['text_listing']	= $this->language->get('text_listing_template_tab');
		
		
		
		$data['button_save']	= $this->language->get('button_save');
		$data['button_cancel']	= $this->language->get('button_cancel');
		
		$data['button_add']     = $this->language->get('button_add');
		$data['button_edit']    = $this->language->get('button_edit');
		$data['button_delete']  = $this->language->get('button_delete');
		$data['button_filter']  = $this->language->get('button_filter');

		/*$this->load->model('ocebay/listingtemplate');
		$list_templates = $this->model_ocebay_listingtemplate->get();*/


		$data['cancel'] = $this->url->link('module/ocebay', 'token=' . $this->session->data['token'], true);
		

		$data['header'] 	 = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] 	 = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('ocebay/listingtemplate', $data));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'ocebay/listingTemplate')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	
	public function add() {
		if(empty($this->request->post) || !empty($this->request->get['template_id'])) {

			$this->load->language('module/ocebay');
			$this->load->language('ocebay/listingtemplate');

			$this->document->setTitle($this->language->get('text_listing_template_tab'));

			$this->load->model('setting/setting');

			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
				$this->model_setting_setting->editSetting('account', $this->request->post);

				$this->session->data['success'] = $this->language->get('text_success');

				$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
			}

			$data['heading_title'] = $this->language->get('text_listing_template_tab');


		# WARNING :: STARTS
			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
			} else {
				$data['error_warning'] = '';
			}

			if (isset($this->error['width'])) {
				$data['error_width'] = $this->error['width'];
			} else {
				$data['error_width'] = '';
			}

			if (isset($this->error['height'])) {
				$data['error_height'] = $this->error['height'];
			} else {
				$data['error_height'] = '';
			}
		# WARNING :: ENDS

		# TAB DATA :: STARTS
			$data['tab_general']	= $this->language->get('tab_general');
			$data['tab_listing']	= $this->language->get('tab_listing');
			$data['tab_location']	= $this->language->get('tab_location');
			$data['tab_payment']	= $this->language->get('tab_payment');
			$data['tab_return']		= $this->language->get('tab_return');
			$data['tab_shipping_details']	= $this->language->get('tab_shipping_details');
		# TAB DATA :: ENDS

		# FROM TITLE
			$data['text_title']	= $this->language->get('text_title');

		# BUTTONS & LINKS :: STARTS
			$data['button_cancel']	= $this->language->get('button_cancel');
			$data['cancel'] = $this->url->link('ocebay/listingTemplate', 'token=' . $this->session->data['token'], true);
			$data['button_save']	= $this->language->get('button_save');

			$data['action_save'] = $this->url->link('ocebay/listingTemplate/add', 'token=' . $this->session->data['token'], true);
			$data['action_get_category'] = $this->url->link('ocebay/listingTemplate/getCategory', 'token=' . $this->session->data['token'], true);

		# ENTRY -> FROM LABELS :: STARTS
			$data['entry_list_name']        = $this->language->get('entry_list_name');
			$data['entry_default_template'] = $this->language->get('entry_default_template');
			$data['entry_item_condition'] 	= $this->language->get('entry_item_condition');
			$data['entry_item_condition_desc'] 	= $this->language->get('entry_item_condition_desc');
			$data['entry_list_type']        = $this->language->get('entry_list_type');
			$data['entry_list_duration']    = $this->language->get('entry_list_duration');
			$data['entry_currency'] 	    = $this->language->get('entry_currency');
			$data['entry_country'] 	     	= $this->language->get('entry_country');
			$data['entry_postal_code']      = $this->language->get('entry_postal_code');
			$data['entry_pricing_mode']     = $this->language->get('entry_pricing_mode');
			$data['entry_category']         = $this->language->get('entry_category');
			$data['entry_quantity']         = $this->language->get('entry_quantity');
			$data['entry_payment_method']   = $this->language->get('entry_payment_method');
			$data['entry_paypal_email']     = $this->language->get('entry_paypal_email');
			$data['entry_return_accept']    = $this->language->get('entry_return_accept');
			$data['entry_return_within']    = $this->language->get('entry_return_within');
			$data['entry_refund_option']    = $this->language->get('entry_refund_option');
			$data['entry_shipping_cost_payed_by']  = $this->language->get('entry_shipping_cost_payed_by');
			$data['entry_return_description']      = $this->language->get('entry_return_description');

		//  Entry Shipping
			$data['entry_ship_costing_type']  	 = $this->language->get('entry_ship_costing_type');
			$data['entry_shipping_type']      	 = $this->language->get('entry_shipping_type');
			$data['entry_shipping_service']    	 = $this->language->get('entry_shipping_service');
			$data['entry_shipping_priority']  	 = $this->language->get('entry_shipping_priority');
			$data['entry_international_shipto']  = $this->language->get('entry_international_shipto');
			$data['entry_shipping_package']      = $this->language->get('entry_shipping_package');
			$data['entry_package_handling_time'] = $this->language->get('entry_package_handling_time');
			$data['entry_dimension'] 						 = $this->language->get('entry_dimension');
			$data['entry_shipping_cost']         = $this->language->get('entry_shipping_cost');
			$data['entry_shipping_cost_additional'] = $this->language->get('entry_shipping_cost_additional');
			$data['entry_originating_postal_code']  = $this->language->get('entry_originating_postal_code');

		# LOAD MODELS HERE :: STARTS
			$this->load->model('localisation/country');
			$this->load->model('ocebay/listingtemplate');
			$this->load->model('ocebay/ocebay');

			$data['list_item_condition'] 	= $this->model_ocebay_listingtemplate->getItemCondition();
			$data['list_ebay_site']			= $this->model_ocebay_listingtemplate->getEbaySites();
			$data['list_shipping_package'] 	= $this->model_ocebay_listingtemplate->getShippingPackage();
			$data['list_listing_type'] 		= $this->model_ocebay_listingtemplate->getListingType();
			$data['list_listing_duration'] 	= $this->model_ocebay_listingtemplate->getListginDuration();
			$data['list_shipping_service'] 	= $this->model_ocebay_listingtemplate->getShippingService();
			$data['list_shipping_region'] 	= $this->model_ocebay_listingtemplate->getShippingRegion();
			$data['list_countries'] = $this->model_localisation_country->getCountries();
			

			$this->load->model('ocebay/ocebay');
			$data['list_category'] = $this->model_ocebay_ocebay->getCategory(null);


			$data['redirect_to'] = $this->url->link('ocebay/listingTemplate', 'token=' . $this->session->data['token'], true);
		# LOAD MODELS HERE :: ENDS
			
			if(!empty($this->request->get['template_id'])) {
				$template_data = $this->model_ocebay_listingtemplate->get($this->request->get['template_id']);

				$data['template_id'] = $this->request->get['template_id'];

				$data['text_title'] = 'Edit';
				

				$fill_form = array();

				foreach ($template_data as $key => $value) {
					$fill_form['template_name'] = trim($value['template_name']);
					$fill_form['default_template'] = trim($value['default_template']);
					$fill_form['ebay_category'] = trim($value['category_id']);
					$fill_form['item_condition'] = trim($value['item_condition']);
					$fill_form['condition_description'] = trim($value['condition_description']);
					$fill_form['listing_type'] = trim($value['listing_type']);
					$fill_form['listing_duration'] = trim($value['listing_duration']);

					$fill_form['pricing_mode'] = trim($value['pricing_mode']);
					$fill_form['price_action'] = trim($value['price_action']);
					$fill_form['price_method'] = trim($value['price_method']);
					$fill_form['price_value'] = trim($value['price_value']);
					$fill_form['quantity'] = trim($value['quantity']);

					$fill_form['currency'] = trim($value['currency']);
					$fill_form['country'] = trim($value['country']);
					$fill_form['postal_code'] = trim($value['postal_code']);
					$fill_form['payment_method'] = json_decode(trim($value['payment_methods']));
					$fill_form['paypal_email'] = trim($value['paypal_email']);
					$fill_form['accept_return'] = trim($value['return_accepted']);

					$fill_form['return_within'] = trim($value['return_within']);
					$fill_form['refund_option'] = trim($value['refund_option']);
					$fill_form['return_cost_payed_by'] = trim($value['return_cost_payed_by']);
					$fill_form['return_description'] = trim($value['return_description']);

					$fill_form['shipping_type'] = trim($value['shipping_type']);
					$fill_form['package_type'] = trim($value['package_type']);
					$fill_form['package_depth'] = trim($value['package_depth']);
					$fill_form['package_length'] = trim($value['package_length']);
					$fill_form['package_width'] = trim($value['package_width']);
					$fill_form['package_weight'] = trim($value['package_weight']);
					$fill_form['shipping_duration'] = trim($value['shipping_duration']);
					$data['category_name'] = $this->model_ocebay_ocebay->getCategoryName(trim($value['category_id']));
					$data['shipping_details'] = json_decode(trim($value['shipping_details']));
				}
				$data['template_data'] = json_encode($fill_form);
				$data['shipping_details'] = json_encode($data['shipping_details']);

			}

			# BREADCRUMBS :: STARTS
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
				'text' => $this->language->get('text_listing_template_tab'),
				'href' => $this->url->link('ocebay/listingTemplate', 'token=' . $this->session->data['token'], true)
				);

			$data['breadcrumbs'][] = array(
				'text' => $data['text_title'],
				'href' => $this->url->link('ocebay/listingTemplate/add', 'token=' . $this->session->data['token'], true)
				);
		# BREADCRUMBS :: ENDS
			




			$data['header'] 	 = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] 	 = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('ocebay/listingtemplateform', $data));
		}else{
			$this->load->model('ocebay/listingtemplate');
			$this->load->model('ocebay/ocebay');

			$form_data['template_name'] = (!empty($this->request->post['template_name']) ? $this->request->post['template_name'] : null);
			$form_data['default_template'] = (!empty($this->request->post['default_template']) ? $this->request->post['default_template'] : false);
			$form_data['category_id'] = (!empty($this->request->post['ebay_category']) ? $this->request->post['ebay_category'] : null);
			$form_data['item_condition'] = (!empty($this->request->post['item_condition']) ? $this->request->post['item_condition'] : null);
			$form_data['condition_description'] = (!empty($this->request->post['condition_description']) ? $this->request->post['condition_description'] : null);
			$form_data['listing_type'] = (!empty($this->request->post['listing_type']) ? $this->request->post['listing_type'] : null);
			$form_data['listing_duration'] = (!empty($this->request->post['listing_duration']) ? $this->request->post['listing_duration'] : null);

			$form_data['pricing_mode'] = (!empty($this->request->post['price_mode']) ? $this->request->post['price_mode'] : null);
			$form_data['price_action'] = (!empty($this->request->post['price_action']) ? $this->request->post['price_action'] : null);
			$form_data['price_method'] = (!empty($this->request->post['price_method']) ? $this->request->post['price_method'] : null);
			$form_data['price_value'] = (!empty($this->request->post['price_value']) ? $this->request->post['price_value'] : null);
			$form_data['quantity'] = (!empty($this->request->post['quantity']) ? $this->request->post['quantity'] : null);

			$form_data['currency'] = $this->model_ocebay_ocebay->getCurrency();
			$form_data['country'] = (!empty($this->request->post['country']) ? $this->request->post['country'] : null);
			$form_data['postal_code'] = (!empty($this->request->post['postal_code']) ? $this->request->post['postal_code'] : null);
			$form_data['payment_methods'] = (!empty($this->request->post['payment_method']) ? json_encode($this->request->post['payment_method']) : null);
			$form_data['paypal_email'] = (!empty($this->request->post['paypal_email']) ? $this->request->post['paypal_email'] : null);
			$form_data['return_accepted'] = (!empty($this->request->post['accept_return']) ? $this->request->post['accept_return'] : 'ReturnsNotAccepted');

			$form_data['return_within'] = (!empty($this->request->post['return_duration']) ? $this->request->post['return_duration'] : null);
			$form_data['refund_option'] = (!empty($this->request->post['refund_option']) ? $this->request->post['refund_option'] : null);
			$form_data['return_cost_payed_by'] = (!empty($this->request->post['return_payed_by']) ? $this->request->post['return_payed_by'] : null);
			$form_data['return_description'] = (!empty($this->request->post['return_policy']) ? $this->request->post['return_policy'] : null);

			$form_data['shipping_type'] = (!empty($this->request->post['shipping_type']) ? $this->request->post['shipping_type'] : null);
			$form_data['package_type'] = (!empty($this->request->post['package_type']) ? $this->request->post['package_type'] : null);
			$form_data['package_depth'] = (!empty($this->request->post['depth']) ? $this->request->post['depth'] : null);
			$form_data['package_length'] = (!empty($this->request->post['length']) ? $this->request->post['length'] : null);
			$form_data['package_width'] = (!empty($this->request->post['width']) ? $this->request->post['width'] : null);
			$form_data['package_weight'] = (!empty($this->request->post['weight']) ? $this->request->post['weight'] : null);
			$form_data['shipping_duration'] = (!empty($this->request->post['shipping_duration']) ? $this->request->post['shipping_duration'] : null);

			$shipping_details = array();

			for($i = 0; $i < 5;$i++) {
				if($this->request->post["shipping_service_".$i][0] != '') {
					$shipping_details[] = array(
						'shipping_service' 	=> $this->request->post["shipping_service_".$i][0],
						'shipping_cost' 		=> $this->request->post["shipping_cost_".$i][0],
						'shipping_cost_additional' 	=> $this->request->post["shipping_cost_additional_".$i][0],
						'shipping_to' 			=> $this->request->post["shipping_to_".$i][0],
						'ShippingServicePriority' => ($i+1)
						);
				}
			}

			$form_data['shipping_details'] = json_encode($shipping_details);

			if(empty($this->request->post['template_id'])) {
				$save_template = $this->model_ocebay_listingtemplate->add($form_data);
			}else{
				$save_template = $this->model_ocebay_listingtemplate->edit($form_data,$this->request->post['template_id']);
			}

			$json_res = array();

			if($save_template) {
				$json_res['success'] = true;
				$json_res['msg'] 		 = 'Success, Template Saved.';
			}else{
				$json_res['success'] = false;
				$json_res['msg'] 		 = 'Sorry, Template Not Saved Please Try Again.';
			}

			echo json_encode($json_res);



		}

	}

	public function getCategory()
	{
		$this->load->model('ocebay/ocebay');
		$parent = $this->request->post['parent_id'];
		$result = $this->model_ocebay_ocebay->getCategory($parent);
		echo json_encode($result);
	}

	public function getAllListingTemplate()
	{
		$this->load->model('ocebay/listingtemplate');
		$this->load->model('ocebay/ocebay');
		$result = $this->model_ocebay_listingtemplate->get();
		$json = array();

		if($result) {
			$data = array();
			foreach ($result as $key => $value) {
				$category = $this->model_ocebay_ocebay->getCategoryName(trim($value['category_id']));
				$temp_array = array(
					'template_id' 		=> $value['template_id'],
					'template_name' 	=> $value['template_name'],
					'summery' 				=> "<b>Category</b> ".$category."<br><b>Listing Type</b> ".$value['listing_type'],
					'products'				=> $this->model_ocebay_listingtemplate->listedProductCount($value['template_id']),
					'default_template'=> ($value['default_template']) ? true : false,
					'is_default' 			=> ($value['default_template']) ? '<i class="fa fa-check-circle fa-3" aria-hidden="true" style="color:green"></i> Yes' : 'No'
					);
				array_push($data, $temp_array);
			}
			$json['data'] = $data;
		}else{
			$json['success'] = false;
		}
		echo json_encode($json);

	}

	public function delete()
	{
		$json_res = array();
		$this->load->model('ocebay/listingtemplate');
		$result = $this->model_ocebay_listingtemplate->delete($this->request->post['template_id']);
		if($result) {
			$json_res['success'] = true;
			$json_res['msg'] 		 = 'Success, Template Deleted..';
		}else{
			$json_res['success'] = false;
			$json_res['msg'] 		 = 'Sorry, Template Not Deleted Please Try Again.';
		}
		echo json_encode($json_res);
	}
}
?>