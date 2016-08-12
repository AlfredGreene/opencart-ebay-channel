<?php
class ControllerModuleOcebay extends Controller {
    private $error = array();


    public function index() {
        $this->load->language('module/ocebay');

        $this->load->model('ocebay/ocebay');
    		$get_settings = $this->model_ocebay_ocebay->install();

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('account', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');




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


		$data['action_home']                = $this->url->link('ocebay/home', 'token=' . $this->session->data['token'], true);
		$data['action_listing_template']    = $this->url->link('ocebay/listingTemplate', 'token=' . $this->session->data['token'], true);
		$data['action_import']              = $this->url->link('ocebay/import', 'token=' . $this->session->data['token'], true);
		$data['action_product']             = $this->url->link('ocebay/product', 'token=' . $this->session->data['token'], true);
		$data['action_settings']            = $this->url->link('ocebay/settings', 'token=' . $this->session->data['token'], true);

        $data['text_home']		= $this->language->get('text_home_tab');
        $data['text_listing']	= $this->language->get('text_listing_template_tab');
        $data['text_import']	= $this->language->get('text_import_tab');
        $data['text_products']	= $this->language->get('text_products_tab');
        $data['text_settings']	= $this->language->get('text_settings_tab');


        $data['button_save']	= $this->language->get('button_save');
		$data['button_cancel']	= $this->language->get('button_cancel');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);


		$data['header'] 	 = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] 	 = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/ocebay', $data));
    }

    protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/account')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function install() {
	    $this->load->language('module/ocebay');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('account', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}


	}
}
?>
