<?php
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Element\Csrf;

class LoginForm extends Form {

    public function __construct($name) {
        
        parent::__construct($name);
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'zu_email',
            'type' => 'text',
            'options' => array(
                'label' => 'Email',
                'id' => 'zu_email',
                'placeholder' => 'example@example.com'             
            )
        ));

       $this->add(array(
            'name' => 'zu_password',
            'type' => 'password',
            'options' => array(
                'label' => 'Password',
                'id' => 'zu_password',
                'placeholder' => '**********'
            )
       ));
       
       $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'loginCsrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 3600
                )
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Submit',
            ),
        ));
    }
}