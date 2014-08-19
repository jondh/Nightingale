<?php
	class CalendarEntriesController extends AppController { 
	
	
		public function beforeFilter(){
			parent::beforeFilter();
       	}
		
		public function index(){
			
		}
		
		public function addMany(){
			$this->layout = 'ajax';
			$data = file_get_contents('php://input');
			$data = json_decode($data, true);
			$result = $this->CalendarEntry->addMultiple($data);
			$result['data'] = $data;
			return new CakeResponse(array('body' => json_encode($result)));
		}
	}
?>