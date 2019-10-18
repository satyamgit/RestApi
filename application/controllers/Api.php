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
    }
    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function index_get() {
        $data ='aaa';
        $this->response($data, REST_Controller::HTTP_OK);
    }
   
}
