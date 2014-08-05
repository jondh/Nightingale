<?php
	class PostsController extends AppController { 
	
	
		public function beforeFilter(){
			parent::beforeFilter();
       	}
		
		public function index(){
			
			$posts = $this->Post->getPosts();
			$this->set('posts', $posts);
		}
		
		public function add(){
			$this->layout = "ajax";
			
			if($this->request->is('post')){
				$this->request->data['user_id'] = $this->Auth->user('id');
				$result = $this->Post->add($this->request->data);
				return new CakeResponse(array('body' => json_encode($result)));
			}
			$result['result'] = 'failure';
			return new CakeResponse(array('body' => json_encode($result)));
		}
	
	}
?>