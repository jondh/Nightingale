<?php

	App::import('Model', 'CalendarEntry');
	App::import('Model', 'Teacher');
	App::import('Model', 'Student');

	class CalendarsController extends AppController { 
	
	
		public function beforeFilter(){
			parent::beforeFilter();
       	}
		
		public function index(){
			$user_id = $this->Auth->user('id');
			
			$Student = ClassRegistry::init('Student');
			$Teacher = ClassRegistry::init('Teacher');
			$CalendarEntry = ClassRegistry::init('CalendarEntry');
			
			$students = $Student->getStudents($user_id);
			$teacher = $Teacher->getTeacher($user_id);
			$myEntries = $CalendarEntry->getEntriesForUser($user_id);
			
			if($students['result'] == 'success'){
				for($i = 0; $i < count($students['return']); $i++){
					$entries = $CalendarEntry->getEntriesForCalendar($students['return'][$i]['Teacher']['calendar_id']);
					$students['return'][$i]['Entry'] = $entries;
				}
			}
			
			if($teacher['result'] == 'success'){
				$entries = $CalendarEntry->getEntriesForCalendar($teacher['return']['Teacher']['calendar_id']);
				$teacher['return']['Entry'] = $entries;
			}
			
			
			
			$this->set('students', $students);
			$this->set('teacher', $teacher);
			$this->set('entries', $myEntries);
		}
		
	
	}
?>