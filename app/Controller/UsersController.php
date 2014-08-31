<?php
	class UsersController extends AppController { 
	
	
		public function beforeFilter(){
			parent::beforeFilter();
       		$this->Auth->allow('index', 'loginAjax', 'add', 'addAjax', 'payment', 'getGravitarURL');
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
		
		public function addAjax(){
			$this->layout = 'ajax';
			if($this->request->is('post')){
				$result = $this->User->add($this->request->data);
				if($result['result'] == 'success'){
					$this->request->data['id'] = $result['id'];
					$this->Auth->login($this->request->data);
				}
				return new CakeResponse(array('body' => json_encode($result)));
			}
			else{
				$result['result'] = 'failure';
				return new CakeResponse(array('body' => json_encode($result)));
			}
		}
		
		public function payment(){
			$this->layout = 'ajax';
			// Set your secret key: remember to change this to your live secret key in production
			// See your keys here https://dashboard.stripe.com/account
			Stripe::setApiKey("sk_test_aUf11Be0B0Q90X8cfrEwwILA");

			// Create the charge on Stripe's servers - this will charge the user's card
			try {
				$charge = Stripe_Charge::create(array(
				  	"amount" => $this->request->data['amount'], // amount in cents, again
				  	"currency" => "usd",
				  	"card" => $this->request->data['token'],
				  	"description" => $this->request->data['email'],
			  	  	"receipt_email" => $this->request->data['email'])
				);
				return new CakeResponse(array('body' => json_encode($this->request->data)));
			} catch(Stripe_CardError $e) {
				return new CakeResponse(array('body' => json_encode($e)));
			}
		}
		
	}
?>