<?php
	App::import('Model', 'Payment');

	class CalendarEntriesController extends AppController { 
	
	
		public function beforeFilter(){
			parent::beforeFilter();
       	}
		
		public function index(){
			
		}
		
		public function deleteAjax(){
			$this->layout = 'ajax';
			if($this->request->is('post')){
				if(array_key_exists('id', $this->request->data)){
					$result = $this->CalendarEntry->setDelete($this->request->data['id']);
					return new CakeResponse(array('body' => json_encode($result)));
				}
			}
			$result['result'] = "failure";
			return new CakeResponse(array('body' => json_encode($result)));
		}
		
		public function addMany(){
			$this->layout = 'ajax';
			$data = file_get_contents('php://input');
			$data = json_decode($data, true);
			
			$user_id = $this->Auth->user('id');
			$t30 = 0;
			$t60 = 0;

			for($i = 0; $i < count($data); $i++){
				if($data[$i]['user_id'] != $user_id){
					$result['result'] = "failure";
					return new CakeResponse(array('body' => json_encode($result)));
				}
				if($data[$i]['length'] == 30){
					$t30++;
				}
				else if($data[$i]['length'] == 60){
					$t60++;
				}
				else{
					unset($data[$i]);
				}
			}
			
			$credit30 = $this->CalendarEntry->getLessonCreditsForUserAndLength($user_id, 30);
			$credit60 = $this->CalendarEntry->getLessonCreditsForUserAndLength($user_id, 60);

			if($credit30 >= $t30 && $credit60 >= $t60){
				$result = $this->CalendarEntry->addMultiple($data);
			}
			else{
				$result['result'] = 'failure';
				$result['reason'] = "You do not have permission to add these lessons.";
			}
			
			return new CakeResponse(array('body' => json_encode($result)));
		}
	}
?>