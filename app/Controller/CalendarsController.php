<?php

	App::import('Model', 'CalendarEntry');
	App::import('Model', 'Teacher');
	App::import('Model', 'Student');

	class CalendarsController extends AppController { 
	
		public function beforeFilter(){
			parent::beforeFilter();
			$this->Auth->allow('newLessions');
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
		
		public function newLessions($length = 30){
			$teacher_id = 1;
			$calendar = $this->Calendar->getCalendarForTeacher($teacher_id);
			if(!$calendar){
				throw new NotFoundException('Could not find that, sorry.');
			}
			if($this->Auth->loggedIn()){
				$user_id = $this->Auth->user('id');
			}
			else{
				$user_id = 0;
			}
			
			if($length != 60){ // either a 30min or 60min lession
				$length = 30;
			}
			
			$CalendarEntry = ClassRegistry::init('CalendarEntry');
			
			$this->set('myLessions', $CalendarEntry->getLessionsForCalendarAndUser($calendar['Calendar']['id'], $user_id));
			$this->set('otherLessions', $CalendarEntry->getLessionsForCalendarAndNotUser($calendar['Calendar']['id'], $user_id));
			$this->set('credits', $CalendarEntry->getLessonCreditsForUserAndLength($user_id, $length));
			$this->set('blocks', $CalendarEntry->getBlocksForCalendar($calendar['Calendar']['id']));
			$this->set('calendar', $calendar);
			$this->set('length', $length);
		}
		
	
	}
?>