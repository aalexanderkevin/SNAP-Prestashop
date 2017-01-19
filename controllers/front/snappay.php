<?php

session_start();

class MidtransPaySnappayModuleFrontController extends ModuleFrontController
{
	public $ssl = true;

	/**
	 * @see FrontController::initContent()
	 */
	public function initContent()
	{
		$this->display_column_left = false;
		$this->display_column_right = false;
		parent::initContent();

		$cart = $this->context->cart;
		if (!$this->module->checkCurrency($cart))
			Tools::redirect('index.php?controller=order');

		$status = 'token_exist';

		// Add snap JS libray
		// $this->context->controller->addJS('https://app.sandbox.veritrans.co.id/snap/assets/snap.js');

		$moduleUrl = substr($this->context->link->getModuleLink('midtranspay','?'), 0, -1);
		// error_log($moduleUrl); // debugan

		$this->context->smarty->assign(array(
			'status' => $status,
			'snap_script_url' => Configuration::get('MT_ENVIRONMENT') == 'production' ? "https://app.midtrans.com/snap/snap.js" : "https://app.sandbox.midtrans.com/snap/snap.js",
			'client_key' => Configuration::get('MT_CLIENT_KEY'),
			'snap_token' => $_GET['snap_token'],
			'this_path' => $this->module->getPathUri(),
			'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->module->name.'/',
			'shop_url' => __PS_BASE_URI__,
			'moduleUrl' => $moduleUrl
		));
		$this->setTemplate('snappay.tpl');
	}

}


		