<?php
class ModelOcebayApi extends Model {
	public function importCategory()
	{
		$json = array();
		$method = "GetCategories";
		$post 	= " <DetailLevel>ReturnAll</DetailLevel>
		<ViewAllNodes>TRUE</ViewAllNodes>
		";


		$categories =  $this->apiCall($post,$method);

		if($categories && empty($categories->Errors)) {
			$categories = $categories->CategoryArray->Category;
			$this->db->query("DELETE FROM ". DB_PREFIX . "ebay_category ");

			foreach ($categories as $key => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ebay_category 
					SET category_id = '" . $value->CategoryID . "', 
					category_parent = '" . $value->CategoryParentID . "', 
					category_level = '" . $value->CategoryLevel . "', 
					category_name = '" . $this->db->escape($value->CategoryName) . "', 
					bestofferenabled = '" . $value->BestOfferEnabled . "', 
					autopayenabled = '" . $value->AutoPayEnabled . "'
					");
			}

			$json['success'] = true;
			$json['msg']		= 'Success. Categories Import Completed.';
		}else{
			$json['success'] = false;
			$json['msg'] = $categories->Errors->ErrorClassification.'.'.$categories->Errors->LongMessage;
		}

		return $json;
	}

	private function apiCall($post = null, $method = null)
	{
		$credintials = $this->getCredintials();
		$url = "";

		if($credintials['listing_mode'] == 'production') {
			$url = "https://api.ebay.com/ws/api.dll";
		}else{
			$url = "https://api.sandbox.ebay.com/ws/api.dll";
		}

		$post_fields = '<?xml version="1.0" encoding="utf-8"?>
		<'.$method.'Request xmlns="urn:ebay:apis:eBLBaseComponents">
		<RequesterCredentials>
			<eBayAuthToken>'.trim($credintials['user_token']).'</eBayAuthToken>
		</RequesterCredentials>
		<ErrorLanguage>en_US</ErrorLanguage>
		<WarningLevel>High</WarningLevel>
		'.$post.'
		</'.$method.'Request>';

		

		if($credintials) {
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_SSL_VERIFYHOST => 0,
				CURLOPT_SSL_VERIFYPEER => 0,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $post_fields,
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache",
					"content-type: application/xml",
					"x-ebay-api-app-name: ".trim($credintials['app_id']),
					"x-ebay-api-call-name: ".$method,
					"x-ebay-api-cert-name: ".trim($credintials['cert_id']),
					"x-ebay-api-compatibility-level: 963",
					"x-ebay-api-dev-name: ".trim($credintials['dev_id']),
					"x-ebay-api-siteid: ".trim($credintials['site_id']),
					),
				));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);

			if ($err) {
				return false;
			} else {
				$response = new SimpleXMLElement($response);
				return $response;
			}
		}else{
			return false;
		}
		

		
	}

	private function getCredintials()
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ebay_settings");

		if(count($query->row) > 0) {
			return $query->row;
		}else{
			return false;
		}

	}

	private function createItemXML($data)
	{
		$item_xml  = "<Item>";
		if(isset($data['item_id'])) {
			$item_xml  .= "<ItemID>".$data['item_id']."</ItemID>";
		}
		$item_xml .= "<Title><![CDATA[".$data['product_name']."]]></Title>";
		// $item_xml .= "<Description><![CDATA[".$data['product_description']."]]></Description>";
		$item_xml .= "<Description>".$data['product_description']."</Description>";
		$item_xml .= "<PrimaryCategory>";
		$item_xml .= "<CategoryID>".$data['category_id']."</CategoryID>";
		$item_xml .= "</PrimaryCategory>";
		$item_xml .= "<StartPrice>".$data['product_price']."</StartPrice>";
		$item_xml .= "<CategoryMappingAllowed>true</CategoryMappingAllowed>";
		$item_xml .= "<ConditionID>".$data['item_condition']."</ConditionID>";
		$item_xml .= "<Country>".$data['product_country']."</Country>";
		
		$item_xml .= "<Currency>".$data['currency']."</Currency>";
		$item_xml .= "<DispatchTimeMax>3</DispatchTimeMax>";
		$item_xml .= "<ListingDuration>".$data['listing_duration']."</ListingDuration>";
		$item_xml .= "<ListingType>".$data['listing_type']."</ListingType>";
		
		$item_xml .= "<Location>".$data['product_country']."</Location>";
		foreach ($data['payment_methods'] as $key => $payment_methods) {
			$item_xml .= "<PaymentMethods>".$payment_methods."</PaymentMethods>";
		}

		$item_xml .= "<PayPalEmailAddress>".$data['paypal_email']."</PayPalEmailAddress>";
		
		$item_xml .= "<PictureDetails>";
		$item_xml .= "<PictureURL>".$data['product_image']."</PictureURL>";
		$item_xml .= "</PictureDetails>";
		
		$item_xml .= "<PostalCode>".$data['postal_code']."</PostalCode>";
		$item_xml .= "<Quantity>".$data['quantity']."</Quantity>";
		

		$item_xml .= "<ReturnPolicy>";
		$item_xml .= "<ReturnsAcceptedOption>".$data['accept_return']."</ReturnsAcceptedOption>";
		$item_xml .= "<RefundOption>".$data['refund_option']."</RefundOption>";
		$item_xml .= "<ReturnsWithinOption>".$data['return_within']."</ReturnsWithinOption>";
		$item_xml .= "<Description><![CDATA[".$data['return_description']."]]></Description>";
		$item_xml .= "<ShippingCostPaidByOption>".$data['shipping_cost_payer']."</ShippingCostPaidByOption>";
		$item_xml .= "</ReturnPolicy>";
		
		$item_xml .= "<ShippingDetails>";
		$item_xml .= "<ShippingType>".$data['shipping_type']."</ShippingType>";

		if($data['shipping_type'] != 'Flat' && (($data['package_depth'] != "" && $data['package_length'] != "" && $data['package_length'] != "") || $data['package_weight'] != "")) {
			$item_xml .= "<CalculatedShippingRate>";
			$item_xml .= "<OriginatingPostalCode>".$data['postal_code']."</OriginatingPostalCode>";
			$item_xml .= '<PackagingHandlingCosts currencyID="'.$data['currency'].'">0.0</PackagingHandlingCosts>';
			$item_xml .= "<MeasurementUnit>English</MeasurementUnit>";
			$item_xml .= "<ShippingPackage>".$data['package_type']."</ShippingPackage>";
			
			if($data['package_weight'] == "") {
				$item_xml .= "<PackageDepth unit=\"in\">".$data['package_depth']."</PackageDepth>";
				$item_xml .= "<PackageLength unit=\"in\">".$data['package_length']."</PackageLength>";
				$item_xml .= "<PackageWidth unit=\"in\">".$data['package_width']."</PackageWidth>";
			}else{
				$item_xml .= '<WeightMajor unit="lbs">'.$data['package_weight'].'</WeightMajor>';
				$item_xml .= '<WeightMinor unit="oz">0</WeightMinor>';
				
			}
			$item_xml .= "</CalculatedShippingRate>";
		}

		// $item_xml .= "<ShippingPackage>".$data['package_type']."</ShippingPackage>";
		foreach ($data['shipping_details'] as $key => $shipping) {
			if(($shipping->shipping_to != 'Domestic')) {
				$item_xml .= "<InternationalShippingServiceOption>";
				$item_xml .= "<ShippingService>".$shipping->shipping_service."</ShippingService>";
				if($shipping->shipping_cost == "") {
					$item_xml .= "<FreeShipping>True</FreeShipping>";
				}else{
					$item_xml .= '<ShippingServiceAdditionalCost currencyID="'.$data['currency'].'">'.$shipping->shipping_cost_additional.'</ShippingServiceAdditionalCost>';
					$item_xml .= '<ShippingServiceCost currencyID="'.$data['currency'].'">'.$shipping->shipping_cost.'</ShippingServiceCost>';
				}
				$item_xml .= "<ShippingServicePriority>".$shipping->ShippingServicePriority."</ShippingServicePriority>";
				$item_xml .= "<ShipToLocation>".$shipping->shipping_to."</ShipToLocation>";
				$item_xml .= "</InternationalShippingServiceOption>";
			}else{
				$item_xml .= "<ShippingServiceOptions>";
				$item_xml .= "<ShippingServicePriority>".$shipping->ShippingServicePriority."</ShippingServicePriority>";
				$item_xml .= "<ShippingService>".$shipping->shipping_service."</ShippingService>";
				if($shipping->shipping_cost == "") {
					$item_xml .= "<FreeShipping>True</FreeShipping>";
				}else{
					$item_xml .= '<ShippingServiceCost currencyID="'.$data['currency'].'">'.$shipping->shipping_cost.'</ShippingServiceCost>';
					$item_xml .= '<ShippingServiceAdditionalCost currencyID="'.$data['currency'].'">'.$shipping->shipping_cost_additional.'</ShippingServiceAdditionalCost>';
				}
				$item_xml .= "</ShippingServiceOptions>";
			}
		}
		
		$item_xml .= "</ShippingDetails>";
		
		$item_xml .= "<Site>".$data['site_code']."</Site>";
		
		$item_xml .= "</Item>";
		return $item_xml;
	}

	public function getOrder()
	{
		$method = "GetOrders";
		$createTimeTo = date('Y-m-d').'T'.date('H:m:s');
		$xml  = "<CreateTimeFrom>2007-12-01T20:34:44.000Z</CreateTimeFrom>";
		$xml .= "<CreateTimeTo>2007-12-10T20:34:44.000Z</CreateTimeTo>";
		$xml .= "<OrderRole>Seller</OrderRole>";
		$xml .= "<OrderStatus>Active</OrderStatus>";
	}

	public function verifyItem($data)
	{
		$xml = $this->createItemXML($data);
		$method = "VerifyAddItem";
		$post 	= $xml;
		$verify_item =  $this->apiCall($post,$method);

		$prices = array();
		$error = array();
		

		if(!empty($verify_item->Errors)) {
			foreach ($verify_item->Errors as $value) {
				$error[] = array( 
					'short_message' => $value->ShortMessage,
					'long_message'  => $value->LongMessage
					);
			}
		}elseif(!empty($verify_item->Fees)){
			foreach ($verify_item->Fees->Fee as $value) {
				$prices[] = array(
					'name'  => $value->Name[0],
					'fee'		=> (float) $value->Fee[0],
					'currency'		=> $value->Fee['currencyID'][0],
					);
			}
		}

		return array('errors' => $error, 'prices' => $prices);
		
	}

	public function addItem($data)
	{
		$xml = $this->createItemXML($data);
		$method = "AddItem";
		$post 	= $xml;
		$add_item =  $this->apiCall($post,$method);

		$item_id = $add_item->ItemID;

		$success 	= array();
		$error 		= array();
		
		if(!empty($add_item->Errors)) {
			foreach ($add_item->Errors as $value) {
				$error[] = array( 
					'short_message' => $value->ShortMessage,
					'long_message'  => $value->LongMessage
					);
			}
		}elseif(!empty($add_item->Ack) && $add_item->Ack == 'Success'){
			$success = array('msg' => 'Success. Item Listed', 'item_id' => $item_id);
		}

		return array('errors' => $error,'success' => $success);
	}

	public function updateItem($data)
	{
		$xml = $this->createItemXML($data);
		$method = "RelistItem";
		$post 	= $xml;
		$add_item =  $this->apiCall($post,$method);

		$item_id = $add_item->ItemID;

		$success 	= array();
		$error 		= array();
		
		if(!empty($add_item->Errors)) {
			foreach ($add_item->Errors as $value) {
				$error[] = array( 
					'short_message' => $value->ShortMessage,
					'long_message'  => $value->LongMessage
					);
			}
		}elseif(!empty($add_item->Ack) && $add_item->Ack == 'Success'){
			$success = array('msg' => 'Success. Item Listed', 'item_id' => $item_id);
		}

		return array('errors' => $error,'success' => $success);
	}

	public function endItem($data)
	{
		$method = "EndItem";
		$post 	= '<ItemID>'.$data['item_id'].'</ItemID>
		<EndingReason><![CDATA['.$data['reason'].']]></EndingReason>';

		$end_item =  $this->apiCall($post,$method);

		$success 	= array();
		$error 		= array();
		
		if(!empty($end_item->Errors)) {
			foreach ($end_item->Errors as $value) {
				$error[] = array( 
					'short_message' => $value->ShortMessage,
					'long_message'  => $value->LongMessage
					);
			}
		}elseif(!empty($end_item->Ack) && $end_item->Ack == 'Success'){
			$this->db->query("DELETE FROM ". DB_PREFIX . "ebay_listing_history WHERE item_id=".$data['item_id']." AND product_id =".$data['product_id']);
			$success = array('msg' => 'Success. Item Ended.');
		}

		return array('errors' => $error,'success' => $success);
	}

	public function getItem($item_id)
	{
		$method = "GetItem";
		$post 	= "<ItemID>".$item_id."</ItemID>
		<IncludeItemSpecifics>true</IncludeItemSpecifics>";
		$getItem =  $this->apiCall($post,$method);

		if(empty($getItem->Errors)) {
			return $getItem;
		}else{
			$error = array();
			foreach ($getItem->Errors as $value) {
				$error[] = array( 
					'short_message' => $value->ShortMessage,
					'long_message'  => $value->LongMessage
					);
			}
			return $error;
		}
	}
}
?>