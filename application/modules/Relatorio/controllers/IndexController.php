<?php

class Relatorio_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {

		$form = new Relatorio_Form_Filtro();
		echo $form;
                $request = $this->getRequest();
                if ($this->getRequest()->isPost()) 
		{
			if ($form->isValid($request->getPost())) 
			{
				$data 		= $form->getValues();
				$date_begin 	= $form->getValue('date_begin');	
				$date_end 	= $form->getValue('date_end');
                                $date_month     = $form->getValue('date_month');
                                $date_year      = $form->getValue('date_year');
	
				#$this->insert('access-day');
				$filtro = new Relatorio_Model_FiltroData();
                               # echo $filtro->Build($date_month, $date_year);
				echo $filtro->Build($date_year, $date_month, $date_begin, $date_end);
			}
		}


    }

    public function logUserAction()
    {

	       $filtro = new Relatorio_Model_FiltroData();

               $username = $this->_request->getParam('username');
               $date_begin = $this->_request->getParam('begin');
               $date_end = $this->_request->getParam('end');
                              
	       echo $filtro->logUser( $username, $date_begin, $date_end);
              
               
    } 
    
     public function logDetailedAction()
    {
       
               $filtro = new Relatorio_Model_FiltroData();
               $detailed = $this->_request->getParam('detailed');
               $username = $this->_request->getParam('username');
               $date_begin = $this->_request->getParam('date_begin');
               $date_end = $this->_request->getParam('date_end');
               
	       echo $filtro->logDetailed($detailed, $username, $date_begin, $date_end);
              


    }
}


