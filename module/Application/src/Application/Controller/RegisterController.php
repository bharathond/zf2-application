<?php
namespace Application\Controller;

		use Zend\Session\Container;
		use Zend\View\Model\ViewModel;
		use Application\Form\RegisterForm;
		use Application\Form\Filter\RegisterFilter;
		use User\Model\UserTable;
		use User\Model\User;
		use Zend\Mvc\Controller\AbstractActionController;

		class RegisterController extends AbstractActionController {
			
			protected $storage;
			protected $authservice;
			protected $userTable;
			
			public function indexAction(){       
				
				$request = $this->getRequest();
				
				$view = new ViewModel();
				$registerForm = new RegisterForm('RegisterForm');       
				$registerForm->setInputFilter(new RegisterFilter());
				
				if($request->isPost()){
					$data = $request->getPost();
					$registerForm->setData($request->getPost());
					if($registerForm->isValid()){            	
						try{
							$user = new User();
							$user->exchangeArray($registerForm->getData());
							$result = $this->getUserTable()->saveUser($user);
							$this->flashMessenger()->addMessage(array('success' => 'User Created Successfully'));
							return $this->redirect()->tourl(BASE_URL.'application/login');
						}
						catch (\Exception $e) {
		                    die($e->getMessage());
		                }
					}else{
						$errors = $registerForm->getMessages();
					}
				}        
				$this->flashMessenger()->addMessage(array('success' => ''));
				$view->setVariable('registerForm', $registerForm);
				return $view;
				
			}
			public function getUserTable()
		    {
		         if (!$this->userTable) {
		             $sm = $this->getServiceLocator();
		             $this->userTable = $sm->get('Application\Model\UserTable');
		         }
		         return $this->userTable;
		    }
			
			private function getAuthService()
			{
				if (! $this->authservice) {
					$this->authservice = $this->getServiceLocator()->get('AuthService');
				}
				return $this->authservice;
			}
		}
	?>	