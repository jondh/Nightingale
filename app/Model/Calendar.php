<?php
class Calendar extends AppModel {
	
	public function getCalendarForTeacher($teacher_id = -1){
		if($teacher_id > 0){
			$calendar = $this->find('first', array(
				'conditions' => array(
					'teacher_id' => $teacher_id
				)
			));	
			
			if($calendar){
				$result['result'] = 'success';
				$result['return'] = $calendar;
				return $result;
			}
			else{
				$result['result'] = 'failure';
				return $result;
			}
		}
		else{
			$result['result'] = 'failure';
			return $result;
		}
	}

}