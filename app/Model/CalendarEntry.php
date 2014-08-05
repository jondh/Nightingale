<?php
class CalendarEntry extends AppModel {
	
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
					'CalendarEntry.calendar_id' => $calendar_id
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
					)
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