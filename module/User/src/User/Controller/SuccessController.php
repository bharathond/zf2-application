<?php
namespace User\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
 
class SuccessController extends AbstractActionController
{
    public function indexAction()
    {
    	$session = new Container('User');
        if ($session->offsetExists ( 'email' )) {
        	return new ViewModel();
        }
        else{
        	return $this->redirect()->tourl(BASE_URL.'application/login');
        }
    }
}