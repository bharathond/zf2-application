<?php
namespace User;

 // Add these import statements:
 use User\Model\User;
 use User\Model\UserTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;
 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;

 use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
 use Zend\Authentication\Storage;
 use Zend\Authentication\AuthenticationService;

 class Module implements AutoloaderProviderInterface, ConfigProviderInterface
 {
     // getAutoloaderConfig() and getConfig() methods her

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                 __DIR__ . '/autoload_classmap.php',
             ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

     // Add this method:
     public function getServiceConfig()
     {
        return array(
            'factories'=>array(
                'User\Model\UserAuthStorage' => function($sm){
                    return new \User\Model\UserAuthStorage('zf');  
                },
                 
                'AuthService' => function($sm) {
                    $dbAdapter           = $sm->get('Zend\Db\Adapter\Adapter');
                    $dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter, 'zf_users','zu_email','zu_password', 'MD5(?)');
                    $authService = new AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);
                    $authService->setStorage($sm->get('User\Model\UserAuthStorage'));
                      
                    return $authService;
                },

                'Application\Model\UserTable' =>  function($sm) {
                     $tableGateway = $sm->get('UserTableGateway');
                     $table = new UserTable($tableGateway);
                     return $table;
                 },
                 'UserTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new User());
                     return new TableGateway('zf_users', $dbAdapter, null, $resultSetPrototype);
                 },
            ),
        );
     }
 }
