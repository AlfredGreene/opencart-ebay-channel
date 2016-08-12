<?php 
class Controllerocebaysettings extends Controller { 
	private $error = array();

	public function index()
	{
		$this->load->language('module/ocebay');
		$this->document->setTitle($this->language->get('text_settings_tab'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('account', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('text_settings_tab');

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
			'text' => $this->language->get('text_settings_tab'),
			'href' => $this->url->link('ocebay/settings', 'token=' . $this->session->data['token'], true)
			);

		$data['button_cancel']	= $this->language->get('button_cancel');
		$data['cancel'] 				= $this->url->link('module/ocebay', 'token=' . $this->session->data['token'], true);

		$data['action_save']		= $this->url->link('ocebay/settings/save', 'token=' . $this->session->data['token'], true);
		$data['button_save']		= 'Save Settings';

		$data['header'] 	 			= $this->load->controller('common/header');
		$data['column_left'] 		= $this->load->controller('common/column_left');
		$data['footer'] 	 			= $this->load->controller('common/footer');

		# FROM DATA :: STARTS
		$this->load->model('ocebay/listingtemplate');

		$data['site_list']			= $this->model_ocebay_listingtemplate->getEbaySites();

		$this->load->model('ocebay/ocebay');
		$get_settings = $this->model_ocebay_ocebay->getSettings();

		if($get_settings) {
			$data['app_id'] = trim($get_settings['app_id']);
			$data['dev_id'] = trim($get_settings['dev_id']);
			$data['user_token'] = trim($get_settings['user_token']);
			$data['cert_id'] = trim($get_settings['cert_id']);
			$data['error_language'] = trim($get_settings['error_language']);
			$data['site_id'] = trim($get_settings['site_id']);
			$data['listing_mode'] = trim($get_settings['listing_mode']);
		}else{
			$data['app_id'] = '';
			$data['dev_id'] = '';
			$data['user_token'] = '';
			$data['cert_id'] = '';
			$data['error_language'] = '';
			$data['site_id'] = '';
			$data['listing_mode'] = '';
		}
		# FROM DATA :: ENDS

		$data['action_import_category'] = $this->url->link('ocebay/import/importCategory', 'token=' . $this->session->data['token'], true);
		$data['action_import_orders'] = $this->url->link('ocebay/import/importOrders', 'token=' . $this->session->data['token'], true);

		$this->response->setOutput($this->load->view('ocebay/settings', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'ocebay/settings')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}

	public function save()
	{
		$json_res = array();
		$language = strtoupper($lang = $this->language->get('code'));

		$data['app_id'] 		= trim($this->request->post['app_id']);
		$data['dev_id'] 		= trim($this->request->post['dev_id']);
		$data['user_token'] = trim($this->request->post['user_token']);
		$data['cert_id'] 		= trim($this->request->post['cert_id']);
		$data['site_id'] 		= trim($this->request->post['site_id']);
		$data['listing_mode'] 	= trim($this->request->post['listing_mode']);
		$data['error_language'] = $language;

		$this->load->model('ocebay/ocebay');
		$save_settings = $this->model_ocebay_ocebay->saveSettings($data);

		if($save_settings) {
			$json_res['success'] = true;
			$json_res['msg'] 		 = 'Success, Settings Saved.';
		}else{
			$json_res['success'] = false;
			$json_res['msg'] 		 = 'Sorry, Settings Not Saved Please Try Again.';
		}

		echo json_encode($json_res);
	}


}
?>