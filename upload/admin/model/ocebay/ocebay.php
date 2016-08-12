<?php
class ModelOcebayOcebay extends Model {

	public function install()
	{
		$this->db->query("
			CREATE TABLE IF NOT EXIST `" . DB_PREFIX . "ebay_category` (
			`category_id` bigint(20) NOT NULL DEFAULT '0',
			`category_parent` bigint(20) DEFAULT NULL,
			`category_level` int(11) DEFAULT NULL,
			`category_name` varchar(250) DEFAULT NULL,
			`bestofferenabled` varchar(50) DEFAULT NULL,
			`autopayenabled` varchar(50) DEFAULT NULL,
			`time_log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`category_id`)
			)");

		$this->db->query("
			CREATE TABLE IF NOT EXIST `" . DB_PREFIX . "ebay_listing_history` (
			`history_id` int(11) NOT NULL AUTO_INCREMENT,
			`product_id` int(11) NOT NULL,
			`template_id` int(11) NOT NULL,
			`item_id` int(11) NOT NULL,
			`item_url` varchar(300) NOT NULL,
			`status` varchar(50) NOT NULL,
			`time_log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`history_id`)
			)");

		$this->db->query("
			CREATE TABLE IF NOT EXIST `" . DB_PREFIX . "ebay_listing_template` (
			`template_id` int(11) NOT NULL AUTO_INCREMENT,
			`template_name` varchar(200) DEFAULT NULL,
			`listing_type` varchar(100) DEFAULT NULL,
			`listing_duration` varchar(50) DEFAULT NULL,
			`default_template` tinyint(1) NOT NULL DEFAULT '0',
			`item_condition` bigint(10) DEFAULT NULL,
			`condition_description` text,
			`currency` varchar(3) DEFAULT NULL,
			`country` varchar(2) DEFAULT NULL,
			`postal_code` bigint(10) DEFAULT NULL,
			`pricing_mode` varchar(50) DEFAULT NULL,
			`price_action` varchar(1) DEFAULT NULL,
			`price_method` varchar(10) DEFAULT NULL,
			`price_value` varchar(20) DEFAULT NULL,
			`category_id` bigint(10) DEFAULT NULL,
			`quantity` varchar(20) DEFAULT NULL,
			`payment_methods` text,
			`paypal_email` varchar(200) DEFAULT NULL,
			`return_accepted` varchar(100) DEFAULT NULL,
			`refund_option` varchar(200) DEFAULT NULL,
			`return_within` varchar(50) DEFAULT NULL,
			`return_description` text,
			`return_cost_payed_by` varchar(150) DEFAULT NULL,
			`shipping_type` varchar(50) DEFAULT NULL,
			`package_type` varchar(50) DEFAULT NULL,
			`package_depth` varchar(10) DEFAULT NULL,
			`package_length` varchar(10) DEFAULT NULL,
			`package_width` varchar(10) DEFAULT NULL,
			`package_weight` varchar(10) DEFAULT NULL,
			`shipping_duration` varchar(10) DEFAULT NULL,
			`shipping_details` text,
			`time_log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`template_id`)
			)
			");

		$this->db->query("
			CREATE TABLE IF NOT EXIST `" . DB_PREFIX . "ebay_settings` (
			`setting_id` int(11) NOT NULL AUTO_INCREMENT,
			`user_token` text,
			`dev_id` text,
			`app_id` text,
			`cert_id` text,
			`error_language` varchar(5) DEFAULT NULL,
			`site_id` int(1) DEFAULT NULL,
			`listing_mode` varchar(150) DEFAULT NULL,
			PRIMARY KEY (`setting_id`)
			)");
	}

	public function getCategory($parent = null) 
	{
		$json = array();

		if (empty($parent)) {
			$cat_qry = $this->db->query("SELECT * FROM `" . DB_PREFIX . "ebay_category` WHERE `category_id` = `category_parent`");
		} else {
			$cat_qry = $this->db->query("SELECT * FROM `" . DB_PREFIX . "ebay_category` WHERE `category_parent` = '" . $parent . "'");
		}

		if ($cat_qry->num_rows > 0) {
			foreach ($cat_qry->rows as $row) {
				$json[] = $row;
			}
			
		} 

		return $json;
	}

	public function getCategoryName($category_id)
	{
		$cat_qry = $this->db->query("SELECT * FROM `" . DB_PREFIX . "ebay_category` WHERE `category_id` = ".$category_id);
		if(!empty($cat_qry->row['category_name'])) {
			return $cat_qry->row['category_name'];
		}else{
			return '';
		}
	}

	public function saveSettings($data)
	{
		$this->db->query("DELETE FROM ". DB_PREFIX . "ebay_settings");
		$query = "INSERT INTO " . DB_PREFIX . "ebay_settings 
		SET 
		dev_id = '" . $data['dev_id'] . "', 
		app_id = '" . $data['app_id'] . "', 
		cert_id = '" . $data['cert_id'] . "', 
		error_language = '" . $data['error_language'] . "', 
		user_token = '" . $data['user_token'] . "', 
		site_id = " . $data['site_id'] .", 
		listing_mode = '" . $data['listing_mode'] . "'
		";
		
		if($this->db->query($query)) {
			return true;
		}else{
			return false;
		}
		
	}

	public function getSettings()
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ebay_settings");
		
		if(count($query->row) > 0) {
			return $query->row;
		}else{
			return false;
		}
	}

	public function getProductListing($listing_id = null, $template_id = null, $product_id = null)
	{
		$query = "SELECT * FROM `" . DB_PREFIX . "ebay_listing_history`";
		
		if($listing_id != null) {
			$query .= " WHERE listing_id = ".$listing_id;
		}

		if($template_id != null) {
			$query .= " WHERE template_id = ".$template_id;
		}

		if($product_id != null) {
			$query .= " WHERE product_id = ".$product_id;
		}

		$query .= " ORDER BY time_log DESC";

		$product_listing = $this->db->query($query);
		

		if ($product_listing->num_rows > 0) {
			return $product_listing->rows;
		}else{
			return false;
		}
	}

	public function getListingTemplate($template_id)
	{
		$query = "SELECT * FROM ".DB_PREFIX . "ebay_channel_list_template WHERE template_id = ".$template_id;
		$query = $this->db->query();
		return $query;
	}

	public function deleteListingTemplate($template_id)
	{
		$query = $this->db->query("DELETE FROM ".DB_PREFIX . "ebay_channel_list_template WHERE template_id = ".$template_id);
		return $query;
	}

	public function getOrder()
	{
		$json = array();
		$order_history = $this->db->query("SELECT * FROM `" . DB_PREFIX . "ebay_order_history`");

		if ($order_history->num_rows > 0) {
			foreach ($order_history->rows as $row) {
				$json[] = $row;
			}
			
		} 
		return $json;
	}

	public function getCurrency()
	{
		$this->load->model('ocebay/listingtemplate');

		$sites = $this->model_ocebay_listingtemplate->getEbaySites();
		$site_id = $this->getSettings()['site_id'];

		foreach ($sites as $value) {
			if($site_id ==$value['site_id']) {
				return $value['currency'];

			}
		}

	}

	public function getSiteCode()
	{
		$this->load->model('ocebay/listingtemplate');

		$sites = $this->model_ocebay_listingtemplate->getEbaySites();
		$site_id = $this->getSettings()['site_id'];

		foreach ($sites as $value) {
			if($site_id ==$value['site_id']) {
				return $value['site_code'];

			}
		}

	}

	public function saveListingHistory($data)
	{
		$query = "INSERT INTO " . DB_PREFIX . "ebay_listing_history 
		SET 
		product_id = '" . $data['product_id'] . "', 
		template_id = '" . $data['template_id'] . "', 
		item_id = '" . $data['item_id'] . "', 
		item_url = '" . $data['item_url'] . "', 
		status = '" . $data['status'] . "'
		";
		
		if($this->db->query($query)) {
			return true;
		}else{
			return false;
		}
	}

	
}

?>