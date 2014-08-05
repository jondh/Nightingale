<?php
class Student extends AppModel {

	// returns array of student tuple(s) if found for user, otherwise returns failure
	// $result['result'] = 'success' | 'failure'
	// if success => $result['return'] = $result['return'][i]['Student'].. 
	public function getStudents($user_id = -1){
		if ($user_id > 0){
			$students = $this->find('all', array(
				'joins' => array(
					array(
						'table' => 'teachers',
						'alias' => 'Teacher',
						'type' => 'INNER',
						'conditions' => array(
							'Student.teacher_id = Teacher.id'
						)
					),
					array(
						'table' => 'users',
						'alias' => 'User',
						'type' => 'INNER',
						'conditions' => array(
							'Student.teacher_id = User.id'
						)
					)
				),
				'conditions' => array(
					'Student.user_id' => $user_id
				),
				'fields' => array(
					'Student.*', 'Teacher.*', 'User.id', 'User.username', 'User.firstName', 'User.lastName', 'User.email'
				)
			));
			
			if($students){
				$result['result'] = 'success';
				$result['return'] = $students;
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