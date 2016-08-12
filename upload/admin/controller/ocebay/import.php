<?php 
class Controllerocebayimport extends Controller { 
	private $error = array();

	public function index()
	{
		$this->load->language('module/ocebay');
		$this->document->setTitle($this->language->get('text_import_tab'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('account', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('text_import_tab');

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
			'text' => $this->language->get('text_import_tab'),
			'href' => $this->url->link('ocebay/import', 'token=' . $this->session->data['token'], true)
			);

		$data['button_cancel']	= $this->language->get('button_cancel');
		$data['cancel'] = $this->url->link('module/ocebay', 'token=' . $this->session->data['token'], true);
		$data['header'] 	 = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] 	 = $this->load->controller('common/footer');

		# LAST UPDATED :: STARTS
		$this->load->model('ocebay/ocebay');
		$category = $this->model_ocebay_ocebay->getCategory(null);

		if(count($category) > 0) {
			$data['category_import_date'] = $category[0]['time_log'];
		}else{
			$data['category_import_date'] = 'None';
		}

		$order = $this->model_ocebay_ocebay->getOrder();

		if(count($order) > 0) {
			$data['order_import_date'] = $order[0]['time_log'];
		}else{
			$data['order_import_date'] = 'None';
		}

		$data['action_import_category'] = $this->url->link('ocebay/import/importCategory', 'token=' . $this->session->data['token'], true);
		$data['action_import_orders'] = $this->url->link('ocebay/import/importOrders', 'token=' . $this->session->data['token'], true);

		$this->response->setOutput($this->load->view('ocebay/import', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'ocebay/import')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}

	public function importCategory()
	{
		$this->load->model('ocebay/api');
		$response = $this->model_ocebay_api->importCategory();
		echo json_encode($response);
	}
}
?>