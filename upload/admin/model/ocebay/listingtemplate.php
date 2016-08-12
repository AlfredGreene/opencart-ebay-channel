<?php
class ModelOcebayListingtemplate extends Model { 
	
	public function getItemCondition()
	{
		return array (
			array('condition_id' => 1000,'condition_name' =>'New'),
			array('condition_id' => 1500,'condition_name' =>'New other'),
			array('condition_id' => 1750,'condition_name' =>'New with defects'),
			array('condition_id' => 2000,'condition_name' =>'Manufacturer refurbished'),
			array('condition_id' => 2500,'condition_name' =>'Seller refurbished' ),
			array('condition_id' => 2750,'condition_name' =>'Like New'),
			array('condition_id' => 3000,'condition_name' =>'Used'),
			array('condition_id' => 4000,'condition_name' =>'Very Good'),
			array('condition_id' => 5000,'condition_name' =>'Good'),
			array('condition_id' => 6000,'condition_name' =>'Acceptable'),
			array('condition_id' => 7000,'condition_name' =>'For parts or not working')
			);
	}

	public function getEbaySites()
	{
		return array(
			array(
				'site_id'		=> 0,
				'site_name'	=> 'United States',
				'site_code'	=> 'US',
				'currency'	=> 'USD',
				),
			array(
				'site_id'		=> 15,
				'site_name'	=> 'Australia',
				'site_code'	=> 'AU',
				'currency'	=> 'AUD',
				),
			array(
				'site_id'		=> 71,
				'site_name'	=> 'France',
				'site_code'	=> 'FR',
				'currency'	=> 'EUR',
				),
			array(
				'site_id'		=> 101,
				'site_name'	=> 'Italy',
				'site_code'	=> 'IT',
				'currency'	=> 'EUR',
				),
			array(
				'site_id'		=> 3,
				'site_name'	=> 'United Kingdom',
				'site_code'	=> 'UK',
				'currency'	=> 'GBP',
				),
			);
	}

	public function getShippingPackage()
	{
		return array (
			'BulkyGoods',
			'ExtraLargePack',
			'LargeEnvelope',
			'Letter',
			'UPSLetter',
			'USPSFlatRateEnvelope',
			'USPSLargePack',
			'VeryLargePack'
			);
	}

	public function getListingType()
	{
		return array('FixedPriceItem','Auction');
	}

	public function getListginDuration()
	{
		return array (
			'Days_1',
			'Days_3',
			'Days_5',
			'Days_7',
			'Days_10',
			'Days_14',
			'Days_21',
			'Days_30',
			'Days_60',
			'Days_90',
			'Days_120',
			'GTC'
			);
	}

	public function getShippingService()
	{
		return array (
			array(
				'type' 	=> 'UPS',
				'list'	=> array(
					array(
						'name' 	=> 'UPS Next Day Air',
						'value' => 'UPS2DayAirAM'
						),
					array(
						'name' 	=> 'UPS Ground',
						'value' => 'UPSGround'
						),
					array(
						'name' 	=> 'UPS 2nd Day',
						'value' => 'UPS2ndDay'
						),
					array(
						'name' 	=> 'UPS Next Day Air',
						'value' => 'UPS2DayAirAM'
						),
					array(
						'name' 	=> 'UPS Worldwide Express',
						'value' => 'UPSWorldWideExpress'
						),
					array(
						'name' 	=> 'UPS Worldwide Express Box 10 Kg',
						'value' => 'UPSWorldWideExpressBox10kg'
						),
					array(
						'name' 	=> 'UPS Worldwide Express Box 25 Kg',
						'value' => 'UPSWorldWideExpressBox25kg'
						),
					array(
						'name' 	=> 'UPS Worldwide Saver',
						'value' => 'UPSWorldwideSaver'
						),
					)
				),
			array(
				'type' 	=> 'USPS',
				'list'	=> array(
					array(
						'name' 	=> 'USPS Economy Parcel Post',
						'value' => 'USPSEconomyParcel'
						),
					array(
						'name' 	=> 'USPS First Class',
						'value' => 'USPSFirstClass'
						),
					array(
						'name' 	=> 'USPS Global Priority Mail',
						'value' => 'USPSGlobalPriority'
						),
					array(
						'name' 	=> 'USPS Global Priority Mail Large Envelope',
						'value' => 'USPSGlobalPriorityLargeEnvelope'
						),
					array(
						'name' 	=> 'USPS Priority',
						'value' => 'USPSPriority'
						),
					array(
						'name' 	=> 'USPS Standard Post',
						'value' => 'USPSStandardPost'
						),
					array(
						'name' 	=> 'USPS Global Express Mail',
						'value' => 'USPSGlobalExpress'
						),
					)
				),
			array(
				'type' 	=> 'FedEx',
				'list'	=> array(
					array(
						'name' 	=> 'FedEx International Economy',
						'value' => 'FedExInternationalEconomy'
						),
					array(
						'name' 	=> 'FedEx Home Delivery',
						'value' => 'FedExHomeDelivery'
						),
					array(
						'name' 	=> 'FedEx 2Day',
						'value' => 'FedEx2Day'
						),
					array(
						'name' 	=> 'FedEx Express Saver',
						'value' => 'FedExExpressSaver'
						),
					array(
						'name' 	=> 'FedEx International Ground',
						'value' => 'FedExInternationalGround'
						),
					array(
						'name' 	=> 'FedEx International Priority',
						'value' => 'FedExInternationalPriority'
						),
					array(
						'name' 	=> 'FedEx Standard Overnight',
						'value' => 'FedExStandardOvernight'
						),
					)
				),
			);
	}

	public function getShippingRegion()
	{
		return array(
			'Domestic',
			'Africa',
			'Americas',
			'Asia',
			'Caribbean',
			'Europe',
			'EuropeanUnion',
			'LatinAmerica',
			'MiddleEast',
			'NorthAmerica',
			'Oceania',
			'SouthAmerica',
			'Worldwide'
			);
	}

	public function get($template_id = null)
	{
		$return_data = array();
		$query = "SELECT * FROM "	. DB_PREFIX . "ebay_listing_template"; 

		if(!empty($template_id)) {
			$query .= " WHERE template_id = ".$template_id."";
		}

		$data = $this->db->query($query);
		if ($data->num_rows > 0) {
			foreach ($data->rows as $row) {
				$return_data[] = $row;
			}
		} 
		return $return_data;
	}

	public function add($data)
	{
		if($data['default_template']) {
			$this->db->query("UPDATE `".DB_PREFIX."ebay_listing_template` set default_template = false");
		}

		$query = "INSERT INTO " . DB_PREFIX . "ebay_listing_template SET "; 
		$query .= "template_name = '".$data['template_name']."',";
		$query .= "listing_type = '".$data['listing_type']."',";
		$query .= "listing_duration = '".$data['listing_duration']."',";
		$query .= "default_template = '".$data['default_template']."',";
		$query .= "item_condition = '".$data['item_condition']."',";
		$query .= "condition_description = '".$data['condition_description']."',";
		
		$query .= "currency = '".$data['currency']."',";
		$query .= "country = '".$data['country']."',";
		$query .= "postal_code = '".$data['postal_code']."',";
		$query .= "pricing_mode = '".$data['pricing_mode']."',";
		$query .= "price_action = '".$data['price_action']."',";

		$query .= "price_method = '".$data['price_method']."',";
		$query .= "price_value = '".$data['price_value']."',";
		$query .= "category_id = '".$data['category_id']."',";
		$query .= "quantity = '".$data['quantity']."',";
		$query .= "payment_methods = '".$data['payment_methods']."',";

		$query .= "paypal_email = '".$data['paypal_email']."',";
		$query .= "return_accepted = '".$data['return_accepted']."',";
		$query .= "refund_option = '".$data['refund_option']."',";
		$query .= "return_within = '".$data['return_within']."',";
		$query .= "return_description = '".$data['return_description']."',";
		$query .= "return_cost_payed_by = '".$data['return_cost_payed_by']."',";

		$query .= "shipping_type = '".$data['shipping_type']."',";
		$query .= "package_type = '".$data['package_type']."',";
		$query .= "package_depth = '".$data['package_depth']."',";
		$query .= "package_length = '".$data['package_length']."',";
		$query .= "package_width = '".$data['package_width']."',";
		$query .= "package_weight = '".$data['package_weight']."',";
		$query .= "shipping_duration = '".$data['shipping_duration']."',";
		$query .= "shipping_details = '".$data['shipping_details']."'";

		if($this->db->query($query)) {
			return true;
		}else{
			return false;
		}
	}

	public function edit($data,$template_id)
	{
		if($data['default_template']) {
			$this->db->query("UPDATE `".DB_PREFIX."ebay_listing_template` set default_template = false");
		}

		$query = "UPDATE " . DB_PREFIX . "ebay_listing_template SET "; 
		$query .= "template_name = '".$data['template_name']."',";
		$query .= "listing_type = '".$data['listing_type']."',";
		$query .= "listing_duration = '".$data['listing_duration']."',";
		$query .= "default_template = '".$data['default_template']."',";
		$query .= "item_condition = '".$data['item_condition']."',";
		$query .= "condition_description = '".$data['condition_description']."',";
		$query .= "currency = '".$data['currency']."',";
		$query .= "country = '".$data['country']."',";
		$query .= "postal_code = '".$data['postal_code']."',";
		$query .= "pricing_mode = '".$data['pricing_mode']."',";
		$query .= "price_action = '".$data['price_action']."',";

		$query .= "price_method = '".$data['price_method']."',";
		$query .= "price_value = '".$data['price_value']."',";
		$query .= "category_id = '".$data['category_id']."',";
		$query .= "quantity = '".$data['quantity']."',";
		$query .= "payment_methods = '".$data['payment_methods']."',";

		$query .= "paypal_email = '".$data['paypal_email']."',";
		$query .= "return_accepted = '".$data['return_accepted']."',";
		$query .= "refund_option = '".$data['refund_option']."',";
		$query .= "return_within = '".$data['return_within']."',";
		$query .= "return_description = '".$data['return_description']."',";
		$query .= "return_cost_payed_by = '".$data['return_cost_payed_by']."',";

		$query .= "shipping_type = '".$data['shipping_type']."',";
		$query .= "package_type = '".$data['package_type']."',";
		$query .= "package_depth = '".$data['package_depth']."',";
		$query .= "package_length = '".$data['package_length']."',";
		$query .= "package_width = '".$data['package_width']."',";
		$query .= "package_weight = '".$data['package_weight']."',";
		$query .= "shipping_duration = '".$data['shipping_duration']."',";
		$query .= "shipping_details = '".$data['shipping_details']."'";
		$query .= "WHERE template_id = '".$template_id."'";

		if($this->db->query($query)) {
			return true;
		}else{
			return false;
		}
	}

	public function delete($template_id)
	{
		$query = $this->db->query("DELETE FROM ".DB_PREFIX . "ebay_listing_template WHERE template_id = ".$template_id);
		return $query;
	}

	public function listedProductCount($template_id)
	{
		$count_qry = $this->db->query("SELECT COUNT(product_id) AS listed_count FROM `" . DB_PREFIX . "ebay_listing_history` WHERE `template_id` = ".$template_id);
		return $count_qry->row['listed_count'];
	}
	
}
?>