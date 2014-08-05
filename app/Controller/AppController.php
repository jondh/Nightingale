<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
App::uses('Security', 'Utility');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array(
        'Session',
        /* add Auth component and set  the urls that will be loaded after the login and logout actions is performed */
        'Auth' => array(
        	'authenticate' => array('SaltForm'),
            'loginRedirect' => array('controller' => 'posts', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'index')
        )
    );

    public function beforeFilter() {
        /* set actions that will not require login */
        //$this->Auth->authenticate = array('Custom');
        
        parent::beforeFilter();
		
		require_once(APP. 'Vendor' . DS . 'Mobile_Detect.php');
		
		$mobileDetect = new Mobile_Detect;
		
		if( $mobileDetect->isMobile() ){
			$this->set('mobile', 'true');
		}
		else{
			$this->set('mobile', 'false');
		}
        
        $this->set('loginURL', $this->Auth->redirectUrl() ); 
        if($this->Auth->loggedIn()){
			$login['login'] = $this->Auth->user('username');
			$login['user'] = $this->Auth->user();
			$this->set('login', $login);
		}
		else{
			$login['login'] = false;
			$login['user'] = $this->Auth->user();
			$this->set('login', $login);
		}
        
        Security::setHash('sha512');
        $this->Auth->allow('login', 'add', 'loginMobile');
    }
}
