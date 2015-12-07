<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Magazine extends MY_Controller {
    
    public function __construct() {        
        parent::__construct();
    }
    
    /**
     * Index page for Magazine controller.
     */
    public function index($offset = 0) {
        $this->load->library('table');
        $this->load->library('pagination');
        
        $limit = 3;
        $where = NULL;//"issue_number != 123";
        $orderBy = "issue_number desc";
        $count = $this->count_issue($where);
        $magazines = $this->load_all($where, $limit, $offset, $orderBy);
        $this->data = array('magazines' => $magazines);

        $config['base_url'] = '/ci-2.2.5/magazine/index/';
        $config['total_rows'] = $count;
        $config['per_page'] = $limit; 

        $this->pagination->initialize($config); 
        
        $this->middle = 'magazines';
        $this->layout();
    }
    
    /**
     * Ajax Request
     */
    public function ajax_post(){
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $this->output->set_content_type('application/json');
        echo json_encode(array("ajaxSuccess" => "ddd", "str" => $data->id));
    }
    
    
    public function print_screen($offset = 0){
        $this->load->library('table');
        
        $where = NULL;//"issue_number = 123";
        $orderBy = "issue_number desc";
        $limit = $this->count_issue($where);
        $magazines = $this->load_all($where, $limit, $offset, $orderBy);
        $this->data = array('magazines' => $magazines);
        $this->middle = 'magazines_all';
        $this->layout_blank();
    }
    
    /**
     * Magazine Form
     * @param int $id
     */
    public function magazine_form($id = NULL){
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules(array(
           array(
               'field' => 'issue_number',
               'label' => 'Issue number',
               'rules' => 'required|is_numeric',
           ),
           array(
               'field' => 'issue_date_publication',
               'label' => 'Publication date',
               'rules' => 'required|callback_date_validation',
           ),
        ));
        $this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
        
        if ($this->form_validation->run()){
            $issue = $this->save_issue($this);
            
            $this->data = array('issue' => $issue);
            $this->middle = 'magazine_form_success';
        } else {
            $this->load->model("Issue");
            $issue = new Issue();
            if (!empty($id)){
                $issue->load($id);
            }
            $this->data = array('issue' => $issue);
            $this->middle = 'magazine_form';
        }
        
        $this->layout();
    }
    
    public function remove($id){
        $this->load->helper('url');
        $this->load->model('Issue');
        $this->Issue->load($id);
        $this->Issue->delete();
        
        redirect('/magazine/', 'refresh');
    }
    
    private function count_issue($where){
        $this->load->model(array('Issue'));
        return $this->Issue->count_by($where);
    }
    
    /**
     * Load ISSUE table and PUBLICATION table
     * @param type $where
     * @param type $limit
     * @param type $offset
     * @param type $orderBy
     * @return $magazines array
     */
    private function load_all($where, $limit, $offset, $orderBy){
        $magazines = array();
        $this->load->model(array('Issue', 'Publication'));
        
        $issues = $this->Issue->get($limit, $offset, $where, $orderBy);
        foreach ($issues as $issue) {
            $publication = new Publication();
            $publication->load($issue->publication_id);
            $magazines[] = array(
                $publication->publication_name,
                $issue->issue_number,
                $issue->issue_date_publication,
                "<a href=\"/ci-2.2.5/magazine/remove/". $issue->issue_id ."\">Del</a>"
                . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"/ci-2.2.5/magazine/magazine_form/". $issue->issue_id ."\">Edit</a>",
            );
        }
        
        return $magazines;
    }
    
    private function save_issue(){
        $this->load->model('Issue');
        $issue = new Issue();
        $id  = $this->input->post('issue_id');
        if (!empty($id)) {
            $issue->load($id);
        }
        $issue->issue_number = intval($this->input->post('issue_number'));
        $issue->issue_date_publication = $this->input->post('issue_date_publication');
        
        $issue->save();
        
        return $issue;
    }
    
    
    /**
     * Date validation callback.
     * @param string $input
     * @return boolean
     */
    public function date_validation($input) {
        $test_date = explode('-', $input);
        if (!@checkdate($test_date[1], $test_date[2], $test_date[0])) {
            $this->form_validation->set_message('date_validation', 'The %s field must be in YYYY-MM-DD format.');
            return FALSE;
        }
        return TRUE;  
    }
}