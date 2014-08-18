<?php
	class CalendarEntriesController extends AppController { 
	
	
		public function beforeFilter(){
			parent::beforeFilter();
       	}
		
		public function index(){
			
		}
		
		public function addMany(){
			$this->layout = 'ajax';
		}
	}
?>