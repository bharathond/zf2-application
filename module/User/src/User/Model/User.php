<?php
namespace User\Model;

 class User
 {
     public $zu_id;
     public $zu_name;
     public $zu_username;
     public $zu_email;
     public $zu_password;
     public $zu_phone;
     public $zu_reset_token;
     public $zu_created_date;
     public $zu_modified_date;

     public function exchangeArray($data)
     {
     	$dateTime = new \DateTime();
     	$currdate = $dateTime->format('Y-m-d H:i:s');
         $this->zu_name = (!empty($data['zu_name'])) ? $data['zu_name'] : null;
         $this->zu_username  = (!empty($data['zu_username'])) ? $data['zu_username'] : null;
         $this->zu_email = (!empty($data['zu_email'])) ? $data['zu_email'] : null;
         $this->zu_password  = (!empty($data['zu_password'])) ? md5($data['zu_password']) : null;
         $this->zu_phone = (!empty($data['zu_phone'])) ? $data['zu_phone'] : null;
         $this->zu_reset_token  = (!empty($data['zu_reset_token'])) ? $data['zu_reset_token'] : '';
         $this->zu_created_date = (!empty($data['zu_created_date'])) ? $data['zu_created_date'] : $currdate;
         $this->zu_modified_date  = (!empty($data['zu_modified_date'])) ? $data['zu_modified_date'] : $currdate;
     }
 }