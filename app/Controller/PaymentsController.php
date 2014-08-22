<?php
	class PaymentsController extends AppController { 
	
	
		public function beforeFilter(){
			parent::beforeFilter();
			$this->Auth->allow('processAndAdd');
       	}
		
		public function processAndAdd(){
			$this->layout = "ajax";
			
			if($this->request->is('post')){
				// verify that there is a user_id
				if(!array_key_exists('user_id', $this->request->data)){
					if($this->Auth->loggedIn()){
						$this->request->data['user_id'] = $this->Auth->user('id');
					}
					else{
						$result['result'] = 'failure';
						return new CakeResponse(array('body' => json_encode($result)));
					}
				}
				if(array_key_exists('number_of_lessons', $this->request->data) && array_key_exists('lesson_length', $this->request->data)){
					$db = $this->Payment->getDataSource();
					$db->begin();
					$result = $this->Payment->add($this->request->data);
					if($result['result'] == "success"){
						$processResult = $this->Payment->processPayment($this->request->data);
						if($processResult['result'] == "success"){
							$db->commit();
						}
						else{
							$db->rollback();
						}
						return new CakeResponse(array('body' => json_encode($processResult)));
					}
					else{
						$db->rollback();
						return new CakeResponse(array('body' => json_encode($result)));
					}
				}
				$result['result'] = 'failureTB';
				return new CakeResponse(array('body' => json_encode($this->request->data)));
			}
			$result['result'] = 'failureT';
			return new CakeResponse(array('body' => json_encode($result)));
		}
	
	}
?>