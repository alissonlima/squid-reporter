<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initDoctype()
	{
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->doctype('XHTML1_STRICT');
	}


	protected function _initNavigation() 
	{

		$this->bootstrap("layout");
		$layout = $this->getResource('layout');
		$view = $layout->getView();

		$config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml','nav');
		$navigation = new Zend_Navigation($config);

		$view->navigation($navigation);

	}

	protected function _initViewSettings()
	{
		$config = $this->getOptions();
		$this->bootstrap('view');
		$this->_view = $this->getResource('view');

		$this->_view->headScript()->appendFile('/js/lib/jquery.js', 'text/javascript');
		$this->_view->headScript()->appendFile('/js/lib/js/jquery-ui.js', 'text/javascript');
		$this->_view->headScript()->appendFile('/js/lib/superfish/supersubs.js', 'text/javascript');
		$this->_view->headScript()->appendFile('/js/lib/superfish/hoverIntent.js', 'text/javascript');
		$this->_view->headScript()->appendFile('/js/lib/superfish/superfish.js', 'text/javascript');
		$this->_view->headScript()->appendFile('/js/lib/jhtmlarea/scripts/jHtmlArea-0.7.0.js', 'text/javascript');


		$this->_view->headScript()->appendFile('/js/main.js', 'text/javascript');

		$this->_view->headLink()->appendStylesheet("/js/lib/css/ui-lightness/jquery-ui-1.8.16.custom.css");
		$this->_view->headLink()->appendStylesheet("/js/lib/jhtmlarea/style/jHtmlArea.css");
		$this->_view->headLink()->appendStylesheet("/js/lib/superfish/css/superfish.css");
		$this->_view->headLink()->appendStylesheet("/css/crud.css");
		$this->_view->headLink()->appendStylesheet("/css/global.css");

		$this->_view->addHelperPath(APPLICATION_PATH . '/views/helpers', "Application_View_Helper");
		$this->_view->addHelperPath('Reporter/View/Helper/', 'Reporter_View_Helper');
	}

}

