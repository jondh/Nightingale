<?php
class Payment extends AppModel {
	
	public function getLessonsForUser($user_id = -1){
		if($user_id > 0){
			$lessons = $this->find('all', array(
				'conditions' => array(
					'user_id' => $user_id
				),
				'fields' => array(
					'number_of_lessons', 'lesson_length'
				)
			));
			return $lessons;
		}
	}
	
	public function getLessonsForUserAndLength($user_id = -1, $length = 30){
		if($user_id > 0){
			$lessons = $this->find('all', array(
				'conditions' => array(
					'user_id' => $user_id,
					'lesson_length' => $length
				),
				'fields' => array(
					'number_of_lessons'
				)
			));
			
			if($lessons){
				$total = 0;
				for($i = 0; $i < count($lessons); $i++){
					$total += $lessons[$i]["Payment"]["number_of_lessons"];
				}
				return $total;
			}
		}
		return 0;
	}
	
	public function add($data){
		$data['dateTime'] = null;
		if ($this->save($data)) {
			$result['result'] = "success";
			return $result;
		}
		else{
			$result['result'] = "faliure";
			$result['type'] = "add";
			$result['errors'] = $this->validationErrors;
			return $result;
		}
    }
	
	public function processPayment($data = -1){
		if($data != -1){
			if(array_key_exists('amount', $data) && array_key_exists('token', $data) && array_key_exists('email', $data))
			// Set your secret key: remember to change this to your live secret key in production
			// See your keys here https://dashboard.stripe.com/account
			Stripe::setApiKey("sk_test_aUf11Be0B0Q90X8cfrEwwILA");

			// Create the charge on Stripe's servers - this will charge the user's card
			try {
				$charge = Stripe_Charge::create(array(
				  	"amount" => $data['amount'], // amount in cents, again
				  	"currency" => "usd",
				  	"card" => $data['token'],
				  	"description" => $data['email'],
			  	  	"receipt_email" => $data['email'])
				);
				$result['result'] = "success";
				return $result;
			} catch(Stripe_CardError $e) {
				$result['result'] = "faliure";
				$result['errors'] = $e;
				return $result;
			}
		}
		$result['result'] = "faliure";
		return $result;
	}

}