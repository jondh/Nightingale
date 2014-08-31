<?php
class Calendar extends AppModel {
	
	public function getCalendarFromId($id = -1){
		if($id > 0){
			$calendar = $this->find('first', array(
				'conditions' => array(
					'id' => $id
				)
			));	
			return $calendar;
		}
	}
	
	public function getCalendarForTeacher($teacher_id = -1){
		if($teacher_id > 0){
			$calendar = $this->find('first', array(
				'conditions' => array(
					'teacher_id' => $teacher_id
				)
			));	
			return $calendar;
		}
	}

}