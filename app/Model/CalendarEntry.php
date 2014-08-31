<?php

App::import('Model', 'Payment');

class CalendarEntry extends AppModel {
	
	public function addMultiple($data = -1){
		$db = ConnectionManager::getDataSource('default');
		$db->expression('NOW()');
		if($data != -1){
			if( $this->saveAll($data) ){
				$result['result'] = "success";
				return $result;
			}
		}
		$result['result'] = "faliure";
		$result['errors'] = $this->validationErrors;
		return $result;
	}
	
	public function setDelete($id = -1){
		if($id > 0){
			$db = ConnectionManager::getDataSource('default');
			$data['id'] = $id;
			$data['deleted'] = '1';
			$data['updated'] = $db->expression('NOW()');
			if( $this->save($data) ){
				$result['result'] = "success";
				return $result;
			}
		}
		$result['result'] = "faliure";
		$result['errors'] = $this->validationErrors;
		return $result;
	}
	
	public function getNumberOfLessonsForUserAndLength($user_id = -1, $length = 30){
		if($user_id > 0){
			$count = $this->find('count', array(
				'conditions' => array(
					'user_id' => $user_id,
					'length' => $length,
					'deleted' => 0
				)
			));
			return $count;
		}
	}
	
	public function getLessonCreditsForUserAndLength($user_id = -1, $length = 30){
		if($user_id > 0){
			$Payment = ClassRegistry::init('Payment');
			$schedLessons = $this->getNumberOfLessonsForUserAndLength($user_id, $length);
			$paidLessons = $Payment->getLessonsForUserAndLength($user_id, $length);
			return $paidLessons - $schedLessons;
		}
	}
	
	public function getEntriesForCalendar($calendar_id = -1){
		if($calendar_id > 0){
			$entries = $this->find('all', array(
				'joins' => array(
					array(
						'table' => 'users',
						'alias' => 'User',
						'type' => 'INNER',
						'conditions' => array(
							'CalendarEntry.user_id = User.id'
						)
					)
				),
				'conditions' => array(
					'CalendarEntry.calendar_id' => $calendar_id,
					'CalendarEntry.deleted' => 0
				),
				'fields' => array(
					'CalendarEntry.*', 'User.id', 'User.username', 'User.firstName', 'User.lastName', 'User.email'
				)
			));	
			
			if($entries){
				$result['result'] = 'success';
				$result['return'] = $entries;
				return $result;
			}
			else{
				$result['result'] = 'empty';
				return $result;
			}
		}
		else{
			$result['result'] = 'failure';
			return $result;
		}
	}
	
	public function getLessionsForCalendarAndUser($calendar_id = -1, $user_id = -1){
		if($calendar_id > 0 && $user_id > -1){
			$entries = $this->find('all', array(
				'joins' => array(
					array(
						'table' => 'users',
						'alias' => 'User',
						'type' => 'INNER',
						'conditions' => array(
							'CalendarEntry.user_id = User.id'
						)
					)
				),
				'conditions' => array(
					'CalendarEntry.calendar_id' => $calendar_id,
					'CalendarEntry.user_id' => $user_id,
					'CalendarEntry.type' => '1',
					'CalendarEntry.deleted' => 0
				),
				'fields' => array(
					'CalendarEntry.*', 'User.id', 'User.username', 'User.firstName', 'User.lastName', 'User.email'
				)
			));	
			
			return $entries;
		}
	}
	
	public function getUpcomingLessionsForCalendarAndUser($calendar_id = -1, $user_id = -1){
		$db = ConnectionManager::getDataSource('default');
		if($calendar_id > 0 && $user_id > -1){
			$entries = $this->find('all', array(
				'joins' => array(
					array(
						'table' => 'users',
						'alias' => 'User',
						'type' => 'INNER',
						'conditions' => array(
							'CalendarEntry.user_id = User.id',
						)
					)
				),
				'conditions' => array(
					'CalendarEntry.calendar_id' => $calendar_id,
					'CalendarEntry.user_id' => $user_id,
					'CalendarEntry.type' => '1',
					'CalendarEntry.time >=' => date('Y-m-d H:i:s'),
					'CalendarEntry.deleted' => 0
				),
				'order' => array(
					'CalendarEntry.time ASC'
				),
				'fields' => array(
					'CalendarEntry.*', 'User.id', 'User.username', 'User.firstName', 'User.lastName', 'User.email'
				)
			));	
			
			return $entries;
		}
	}
	
	public function getPreviousLessionsForCalendarAndUser($calendar_id = -1, $user_id = -1){
		$db = ConnectionManager::getDataSource('default');
		if($calendar_id > 0 && $user_id > -1){
			$entries = $this->find('all', array(
				'joins' => array(
					array(
						'table' => 'users',
						'alias' => 'User',
						'type' => 'INNER',
						'conditions' => array(
							'CalendarEntry.user_id = User.id',
						)
					)
				),
				'conditions' => array(
					'CalendarEntry.calendar_id' => $calendar_id,
					'CalendarEntry.user_id' => $user_id,
					'CalendarEntry.type' => '1',
					'CalendarEntry.time <=' => date('Y-m-d H:i:s'),
					'CalendarEntry.deleted' => 0
				),
				'order' => array(
					'CalendarEntry.time DESC'
				),
				'fields' => array(
					'CalendarEntry.*', 'User.id', 'User.username', 'User.firstName', 'User.lastName', 'User.email'
				)
			));	
			
			return $entries;
		}
	}
	
	public function getLessionsForCalendarAndNotUser($calendar_id = -1, $user_id = -1){
		if($calendar_id > 0 && $user_id > -1){
			$entries = $this->find('all', array(
				'joins' => array(
					array(
						'table' => 'users',
						'alias' => 'User',
						'type' => 'INNER',
						'conditions' => array(
							'CalendarEntry.user_id = User.id'
						)
					)
				),
				'conditions' => array(
					'CalendarEntry.calendar_id' => $calendar_id,
					'CalendarEntry.user_id !=' => $user_id,
					'CalendarEntry.type' => '1',
					'CalendarEntry.deleted' => 0
				),
				'fields' => array(
					'CalendarEntry.*', 'User.id', 'User.username', 'User.firstName', 'User.lastName', 'User.email'
				)
			));	
			
			return $entries;
		}
	}
	
	public function getBlocksForCalendar($calendar_id = -1){
		if($calendar_id > 0){
			$entries = $this->find('all', array(
				'conditions' => array(
					'CalendarEntry.calendar_id' => $calendar_id,
					'CalendarEntry.type' => '0',
					'CalendarEntry.deleted' => 0
				),
				'fields' => array(
					'CalendarEntry.*'
				)
			));	
			
			return $entries;
		}
	}
	
	public function getEntriesForUser($user_id = -1){
		if($user_id > 0){
			$entries = $this->find('all', array(
				'joins' => array(
					array(
						'table' => 'users',
						'alias' => 'User',
						'type' => 'INNER',
						'conditions' => array(
							'CalendarEntry.user_id = User.id'
						)
					),
					array(
						'table' => 'calendars',
						'alias' => 'Calendar',
						'type' => 'LEFT',
						'conditions' => array(
							'Calendar.id = CalendarEntry.calendar_id'
						)
					)
				),
				'conditions' => array(
					'OR' => array(
						'CalendarEntry.user_id' => $user_id,
						'Calendar.teacher_id' => $user_id
					),
					'CalendarEntry.deleted' => 0
				),
				'fields' => array(
					'CalendarEntry.*', 'User.id', 'User.username', 'User.firstName', 'User.lastName', 'User.email'
				)
			));	
			
			if($entries){
				$result['result'] = 'success';
				$result['return'] = $entries;
				return $result;
			}
			else{
				$result['result'] = 'empty';
				return $result;
			}
		}
		else{
			$result['result'] = 'failure';
			return $result;
		}
	}

}