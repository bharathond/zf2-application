<?php
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Element\Csrf;

class RegisterForm extends Form {

    public function __construct($name) {
        
        parent::__construct($name);
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'zu_name',
            'type' => 'text',
            'options' => array(
                'label' => 'Name',
                'id' => 'zu_name',
                'placeholder' => 'Please Enter Your Name'             
            )
        ));

        $this->add(array(
            'name' => 'zu_username',
            'type' => 'text',
            'options' => array(
                'label' => 'User Name',
                'id' => 'zu_username',
                'placeholder' => 'Choose Your Username'             
            )
        ));

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
            'name' => 'zu_phone',
            'type' => 'text',
            'options' => array(
                'label' => 'Phone',
                'id' => 'zu_phone',
                'placeholder' => 'Enter Your Phone Number'             
            )
        ));

       $this->add(array(
            'name' => 'zu_password',
            'type' => 'password',
            'options' => array(
                'label' => 'Password',
                'id' => 'zu_password',
                'placeholder' => 'Password'
            )
       ));

       $this->add(array(
            'name' => 'zu_repassword',
            'type' => 'password',
            'options' => array(
                'label' => 'Confirm Password',
                'id' => 'zu_repassword',
                'placeholder' => 'Retype Password'
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