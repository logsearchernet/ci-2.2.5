<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends MY_Controller {
  public function index() {
	

    $this->middle = 'dashboard';
    $this->layout();
  }
}

?>