<?php
require APPPATH . 'libraries/REST_Controller.php';
class Api extends REST_Controller {
    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    }
    /**
     * Get All Data from this method.
     *
     * @return Response
     */
   
    /*Function for Login*/
    public function login_post() {

     $email=trim($this->input->post('email'));
     $password=(md5($this->input->post('password')));

     $where=array('email'=>$email,'password'=>$password);
     $field=array('id','fullname','contact','role','email');
     $data=($this->query_model->get_joins('users',$where,'',$field));

     if (!empty($data)){
        $this->response(array(
            'errorCode' => 0,
            'status' => true,
            'message' => 'Login successfully',
            'data' => $data,
        ),REST_Controller::HTTP_OK);   
    }
    else
    {
        $this->response(array(
            'errorCode' => 1,
            'status' => false,
            'message' => 'Username or password incorrect'
        ),REST_Controller::HTTP_OK);

    }  
    }  

}
