<?php
class Post extends AppModel {

	public $validate = array(
        'title' => array(
			'required' => array(
				'on'         => 'create',
				'rule'       => 'notEmpty',
				'message'    => 'Enter a Title',
				'required'   => true,
				'last'       => true
			),
            'between' => array( 
            	'on' => 'create',
                'rule' => array('between', 1, 64), 
                'required' => true, 
                'message' => 'Max length of 64 characters'
            ),
            'titleRegex' => array(
                'rule'    => array('titleRegex'),
                'message' => 'Not Valid Input'
            )
        ),
        'content' => array(
            'between' => array( 
                'rule' => array('between', 1, 2048), 
                'allowEmpty' => true, 
                'message' => 'Max length of 2048 characters'
            ),
            'contentRegex' => array(
                'rule'    => array('contentRegex'),
                'message' => 'Not Valid Input'
            )
        )	
    );
    
    public function titleRegex($check) {
        $value = array_values($check);
        $value = $value[0];
 
        return preg_match('/^[a-zA-Z0-9_ \-\'!@#*]*$/', $value);
    }
    
    public function contentRegex($check) {
        $value = array_values($check);
        $value = $value[0];
 
        return preg_match('/^[a-zA-Z0-9_ \-\'!@#*,.?]*$/', $value);
    }

	public function getPosts(){
		$posts = $this->find('all', array(
			'joins' => array(
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'INNER',
					'conditions' => array(
						'User.id = Post.user_id'
					)
				)
			),
			'order' => array(
				'updated DESC'
			),
			'fields' => array(
				'Post.*', 'User.*'
			)
		));
		
		return $posts;
	}
	
	public function getPost($id){
		
		$post = $this->find('first', array(
			'joins' => array(
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'INNER',
					'conditions' => array(
						'User.id = Post.user_id'
					)
				)
			),
			'conditions' => array(
				'Post.id' => $id
			),
			'fields' => array(
				'Post.*', 'User.*'
			)
		));
		
		return $post;
	}
	
	public function add($data){
    	$this->create();
		$data['dateTime'] = null;
		$data['updated'] = DboSource::expression('NOW()');
		if ($this->save($data)) {
			$result = $this->getPost($this->id);
			$result['result'] = "success";
			unset($result['User']['password']);
			unset($result['User']['salt']);
			unset($result['User']['public_access_token']);
			unset($result['User']['private_access_token']);
			return $result;
		}
		else{
			$result['result'] = "faliure";
			$result['errors'] = $this->validationErrors;
			return $result;
		}
    }

}