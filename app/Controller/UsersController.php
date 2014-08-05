<?php
	class UsersController extends AppController { 
	
	
		public function beforeFilter(){
			parent::beforeFilter();
       		$this->Auth->allow('index', 'loginAjax', 'add');
		}
		
		public $components = array('UploadPic', 'AccessToken');
	
		public function index(){
			$this->layout = "home";
		}
		
		public function loginAjax(){
			$this->layout = "ajax";
			if ($this->request->is('post')) {
				$this->request->data['User']['username'] = $this->request->data['username'];
				$this->request->data['User']['password'] = $this->request->data['password'];
           		if ($this->Auth->login()) {
           			$result['result'] = "success";
           			$result['User'] = $this->Auth->user();
        			return new CakeResponse(array('body' => json_encode($result)));
          	  	}
       		}
       		$result['result'] = "failure";
        	return new CakeResponse(array('body' => json_encode($result)));
		}
    	
    	public function logoutAjax() {
         	$this->layout = "ajax";
       	 	$result['url'] = $this->Auth->logout();
        	return new CakeResponse(array('body' => json_encode($result)));
    	}
		
		public function add(){
			if($this->request->is('post')){
				$this->User->create();
				$this->request->data['User']['salt'] = Security::generateAuthKey();
				$this->request->data['User']['dateTime'] = null;
				 if ($this->User->save($this->request->data)) {
               		 $this->Session->setFlash(__('The user has been saved'));
               	 	 if ($this->Auth->login()) {
        			 	return $this->redirect($this->Auth->redirect());
          	  		 }
           		 }
           		 $this->Session->setFlash(__('The user could not be saved. Please, try again'));
			}
		}
		
		public function edit(){
 
            if ($this->request->is('post')) {
                $this->User->id = $this->Auth->user('id');
                
                if(!$this->User->exists()){
      				$this->Session->setFlash(__('Unable to find User.'));
   				}
                $success = true;
                $this->User->set($this->request->data);
                
                if($this->request->data['User']['firstNameEdit']){
                	if($this->User->Validates(array('fieldList' => array('firstNameEdit')))){
						if ($this->User->saveField('firstName', $this->request->data['User']['firstNameEdit'])) {
							$this->Session->write('Auth.User.firstName', $this->request->data['User']['firstNameEdit']);
							$success = true;
						}else { $success = false; }
					}else { $success = false; }
                }
                
                if($this->request->data['User']['lastNameEdit']){
                	if($this->User->Validates(array('fieldList' => array('lastNameEdit')))){
						if ($this->User->saveField('lastName', $this->request->data['User']['lastNameEdit'])) {
							$this->Session->write('Auth.User.lastName', $this->request->data['User']['lastNameEdit']);
							$success = true;
						}else { $success = false; }
					}else { $success = false; }
                }
                
                if($this->request->data['User']['emailEdit']){
                	if($this->User->Validates(array('fieldList' => array('emailEdit')))){
						if ($this->User->saveField('email', $this->request->data['User']['emailEdit'])) {
							$this->Session->write('Auth.User.email', $this->request->data['User']['emailEdit']);
							$success = true;
						}else { $success = false; }
					}else { $success = false; }
                }
                
                if($this->request->data['User']['passwordEdit']){
                	if($this->User->Validates(array('fieldList' => array('currentPassword', 'passwordEdit', 'passwordConfirmEdit')))){
						if ($this->User->saveField('password', $this->request->data['User']['passwordEdit'])) {
							$success = true;
						}else { $success = false; }
					}else { $success = false; }
                }
                
                if($success){
                    $this->Session->setFlash(__('The user has been updated'));
                    $this->redirect(array('action' => 'showProfile'));
                }else{
                   // $this->Session->setFlash(__('Unable to update your user.'));
                }
            }
		}
		
	}
?>