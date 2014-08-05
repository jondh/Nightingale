<?php
class User extends AppModel {

    /* validate data enetered by user */
    /* Validation taken from tutorial http://miftyisbored.com/a-complete-login-and-authentication-application-tutorial-for-cakephp-2-3/ */
    public $validate = array(
        'username' => array(
			'required' => array(
				'on'         => 'create',
				'rule'       => 'notEmpty',
				'message'    => 'Enter your username',
				'required'   => true,
				'last'       => true
			),
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required',
                'allowEmpty' => false
            ),
            'between' => array( 
            	'on' => 'create',
                'rule' => array('between', 5, 15), 
                'required' => true, 
                'message' => 'Usernames must be between 5 to 15 characters'
            ),
             'unique' => array(
                'rule'    => array('isUniqueUsername'),
                'message' => 'This username is already in use'
            ),
            'alphaNumericDashUnderscore' => array(
                'rule'    => array('alphaNumericDashUnderscore'),
                'message' => 'Username can only be letters, numbers and underscores'
            ),
        ),
        'firstName' => array(
        	'required' => array(
				'on'         => 'create',
				'rule'       => 'notEmpty',
				'message'    => 'Enter your first name',
				'required'   => true,
				'last'       => true
			),
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'A first name is required',
                'allowEmpty' => false
            ),
            'between' => array( 
            	'on' => 'create',
                'rule' => array('between', 1, 15), 
                'required' => true, 
                'message' => 'Names must be between 1 to 15 characters'
            ),
            'alphaNumericDashUnderscore' => array(
                'rule'    => array('alphaNumericDashUnderscore'),
                'message' => 'Name can only be letters, numbers and underscores'
            ),
        ),
        'lastName' => array(
        	'required' => array(
				'on'         => 'create',
				'rule'       => 'notEmpty',
				'message'    => 'Enter your last name',
				'required'   => true,
				'last'       => true
			),
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'A last name is required',
                'allowEmpty' => false
            ),
            'between' => array( 
            	'on' => 'create',
                'rule' => array('between', 1, 15), 
                'required' => true, 
                'message' => 'Names must be between 1 to 15 characters'
            ),
            'alphaNumericDashUnderscore' => array(
                'rule'    => array('alphaNumericDashUnderscore'),
                'message' => 'Name can only be letters, numbers and underscores'
            ),
        ),
        'password' => array(
        	'required' => array(
				'on'   => 'create',
				'rule' => array('notEmpty'),
                'message' => 'A password is required'
			),
            'min_length' => array(
                'rule' => array('minLength', '6'),  
                'message' => 'Password must have a mimimum of 6 characters'
            )
        ),
         
        'passwordConfirm' => array(
            'required' => array(
            	'on'   => 'create',
                'rule' => array('notEmpty'),
                'message' => 'Please confirm your password'
            ),
             'equaltofield' => array(
                'rule' => array('equaltofield','password'),
                'message' => 'Both passwords must match.'
            )
        ),
         
        'email' => array(
            'required' => array(
            	'on'   => 'create',
                'rule' => array('email', true),    
                'message' => 'Please provide a valid email address.'   
            ),
             'unique' => array(
                'rule'    => array('isUniqueEmail'),
                'message' => 'This email is already in use',
            ),
            'between' => array( 
                'rule' => 'email', 
                'message' => 'Please enter proper email'
            )
        ),
        
        'firstNameEdit' => array(
            'between' => array( 
                'rule' => array('between', 1, 15), 
                'message' => 'Names must be between 1 to 15 characters',
                'allowEmpty' => true,
                'required' => false
            ),
            'alphaNumericDashUnderscore' => array(
                'rule'    => array('alphaNumericDashUnderscore'),
                'message' => 'Name can only be letters, numbers and underscores'
            ),
        ),
        'lastNameEdit' => array(
            'between' => array( 
                'rule' => array('between', 1, 15), 
                'message' => 'Names must be between 1 to 15 characters',
                'allowEmpty' => true,
                'required' => false
            ),
            'alphaNumericDashUnderscore' => array(
                'rule'    => array('alphaNumericDashUnderscore'),
                'message' => 'Name can only be letters, numbers and underscores'
            ),
        ),
        'emailEdit' => array(
             'unique' => array(
                'rule'    => array('isUniqueEmailEdit'),
                'message' => 'This email is already in use',
                'allowEmpty' => true,
                'required' => false
            ),
            'between' => array( 
                'rule' => 'email', 
                'message' => 'Please enter proper email',
                'allowEmpty' => true,
                'required' => false
            )
        ),
        'currentPassword' => array(
        	'match' => array(
        		'rule' => array('checkPassword'),
        		'message' => 'Incorrect Password'
        	)
        ), 
        'passwordEdit' => array(
            'min_length' => array(
                'rule' => array('minLength', '6'),   
                'message' => 'Password must have a mimimum of 6 characters',
                'allowEmpty' => true,
                'required' => false
            )
        ),
        'passwordConfirmEdit' => array(
             'equaltofield' => array(
                'rule' => array('equaltofield','passwordEdit'),
                'message' => 'Both passwords must match.',
                'required' => false,
            )
        )
 
         
    );
     
        /**
     * Before isUniqueUsername
     * @param array $options
     * @return boolean
     */
    function isUniqueUsername($check) {
        $username = $this->find(
            'first',
            array(
                'fields' => array(
                    'User.id',
                    'User.username'
                ),
                'conditions' => array(
                    'User.username' => $check['username']
                )
            )
        );
 
        if(!empty($username)){
            return false;
        }else{
            return true; 
        }
    }
 
    /**
     * Before isUniqueEmail
     * @param array $options
     * @return boolean
     */
    function isUniqueEmail($check) {
        $email = $this->find(
            'first',
            array(
                'fields' => array(
                    'User.id'
                ),
                'conditions' => array(
                    'User.email' => $check['email']
                )
            )
        );
 
        if(!empty($email)){
            return false;
        }else{
            return true; 
        }
    }
    
    function isUniqueEmailEdit($check) {
 		if(!$check['emailEdit']){
 			return true;
 		}
        $email = $this->find(
            'first',
            array(
                'fields' => array(
                    'User.id'
                ),
                'conditions' => array(
                    'User.email' => $check['emailEdit']
                )
            )
        );
 
        if(!empty($email)){
            if($this->data[$this->alias]['id'] == $email['User']['id']){
                return true; 
            }else{
                return false; 
            }
        }else{
            return true; 
        }
    }
    
    public function checkPassword($check) {
    	$pass = $this->find('first', array(
    		'fields' => array(
    			'User.password'
    		),
    		'conditions' => array(
    			'User.id' => CakeSession::read("Auth.User.id")
    		)
    	));
    	if($pass['User']['password'] == AuthComponent::password($check['currentPassword'])){
    		return true;
    	}
    	return false;
    }
     
    public function alphaNumericDashUnderscore($check) {
        // $data array is passed using the form field name as the key
        // have to extract the value to make the function generic
        $value = array_values($check);
        $value = $value[0];
 
        return preg_match('/^[a-zA-Z0-9_ \-]*$/', $value);
    }
     
    public function equaltofield($check,$otherfield) 
    { 
        //get name of field 
        $fname = ''; 
        foreach ($check as $key => $value){ 
            $fname = $key; 
            break; 
        } 
        return $this->data[$this->name][$otherfield] === $this->data[$this->name][$fname]; 
    } 
 
    /**
     * Before Save
     * @param array $options
     * @return boolean
     */
     public function beforeSave($options = array()) {
     /*
        // hash our password
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
         
        // if we get a new password, hash it
        if (isset($this->data[$this->alias]['password_update']) && !empty($this->data[$this->alias]['password_update'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password_update']);
        }
     
        // fallback to our parent
        return parent::beforeSave($options);
    */
    
    	if (isset($this->data[$this->alias]['password']) && isset($this->data[$this->alias]['salt'])) {
        	$this->data[$this->alias]['password'] = 
            	Security::hash(Security::hash(Security::hash($this->data[$this->alias]['password'].
        			$this->data[$this->alias]['salt'])));
   		}
   		return true;
   	
   	/*
   		if(isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = Security::hash($this->data[$this->alias]['password'], 'blowfish');
			unset($this->data['User']['passwd']);
		}

		return true;
		*/
    }
    
    public function getUser($userId){
    	if($userId){
    		$user = $this->find('first', array(
    			'conditions' => array(
    				'id' => $userId
    			)
    		));
    		
    		return $user;
    	}
    }
}