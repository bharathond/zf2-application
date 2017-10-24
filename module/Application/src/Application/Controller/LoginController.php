<?php
namespace Application\Controller;

		use Zend\Session\Container;
		use Zend\View\Model\ViewModel;
		use Application\Form\LoginForm;
		use Application\Form\Filter\LoginFilter;
		use Zend\Mvc\Controller\AbstractActionController;

		class LoginController extends AbstractActionController {
			
			protected $storage;
			protected $authservice;
			
			public function indexAction(){       
				
				$session = new Container('User');
				if ($session->offsetExists ( 'email' )) {
		        	return $this->redirect()->tourl(BASE_URL.'success');
		        }
		        else{
		        	
					$request = $this->getRequest();
					
					$view = new ViewModel();
					$loginForm = new LoginForm('loginForm');       
					$loginForm->setInputFilter(new LoginFilter() );
					
					if($request->isPost()){
						$data = $request->getPost();
						$loginForm->setData($data);
						
						if($loginForm->isValid()){            	
							$data = $loginForm->getData();        

							$encyptPass = $data['zu_password'];
							
							$result = $this->getAuthService()->getAdapter()
							->setIdentity($data['zu_email'])
							->setCredential($encyptPass)->authenticate();
							
							if ($result->isValid()) {
								$resultRow = $this->getAuthService()->getAdapter()->getResultRowObject();
								$session = new Container('User');
								$session->offsetSet('username', $resultRow->zu_username);
								$session->offsetSet('email', $data['zu_email']);
								$session->offsetSet('phone', $resultRow->zu_phone);
								
								$this->flashMessenger()->addMessage(array('success' => 'Login Success.'));
								return $this->redirect()->tourl(BASE_URL.'success');
								// Redirect to page after successful login
							}else{
								$this->flashMessenger()->addMessage(array('error' => 'invalid credentials.'));
								// Redirect to page after login failure
								return $this->redirect()->tourl(BASE_URL.'application/login');
							}
							//
							// Logic for login authentication                
						}else{
							$errors = $loginForm->getMessages();
							//prx($errors);  
						}
					}        
					$this->flashMessenger()->addMessage(array('success' => ''));
					$view->setVariable('loginForm', $loginForm);
					return $view;
				}
			}
			
			private function getAuthService()
			{
				if (! $this->authservice) {
					$this->authservice = $this->getServiceLocator()->get('AuthService');
				}
				return $this->authservice;
			}

            public function logoutAction(){
            	$session = new Container('User');
                $session->getManager()->destroy();
                $this->getAuthService()->clearIdentity();
                return $this->redirect()->toUrl(BASE_URL.'application/login');
            }
		}
	?>	