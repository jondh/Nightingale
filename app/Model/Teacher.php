<?php
class Teacher extends AppModel {
	
	public $belongsTo = array(
			
	);
	
	// returns teacher tuple if found for user, otherwise returns failure
	// $result['result'] = 'success' | 'failure'
	// if success => $result['return'] = $result['return']['Teacher'].. 
	public function getTeacher($user_id = -1){
		if ($user_id > 0){
			$teacher = $this->find('first', array(
				'conditions' => array(
					'user_id' => $user_id
				)
			));
			
			if($teacher){
				$result['result'] = 'success';
				$result['return'] = $teacher;
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