<?php

	App::import('Model', 'CalendarEntry');
	App::import('Model', 'Post');
	App::import('Model', 'Teacher');
	App::import('Model', 'Student');

	class CalendarsController extends AppController { 
		
		var $helpers = array("Gravatar");
	
		public function beforeFilter(){
			parent::beforeFilter();
			$this->Auth->allow('newLessions');
       	}
		
		public function index(){
			$user_id = $this->Auth->user('id');
			
			$CalendarEntry = ClassRegistry::init('CalendarEntry');
			$Post = ClassRegistry::init('Post');
			
			$calendar_id = 1;
			
			$this->set('calendar', $this->Calendar->getCalendarFromId($calendar_id));
			$this->set('upcomingLessons', $CalendarEntry->getUpcomingLessionsForCalendarAndUser($calendar_id, $user_id));
			$this->set('previousLessons', $CalendarEntry->getPreviousLessionsForCalendarAndUser($calendar_id, $user_id));
			$this->set('posts', $Post->getPosts());
			$this->set('postAuth', true);
		}
		
		public function newLessons($length = 30){
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