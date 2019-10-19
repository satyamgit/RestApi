<?php

/*
 * Unit_model
 * An easier way to construct your unit testing
 * and pass it to a really nice looking page.
 *
 * @author Satyam
 */

class Query_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('image_lib');
        $this->load->library('session');
    }

//==========Function for Insert ================//
    public function INSERTDATA($tablename, $feild = '') {

        if (!empty($tablename) && !empty($feild)):
            $this->db->set($feild);
        $insert = $this->db->insert($tablename);
        if ($insert):
            return $this->db->insert_id();
        endif;
        else: return "Invalid Input Provided";
        endif;
    }

//===========Function for Update==============//
    public function UPDATEDATA($tablename, $where = '', $feild = '') {

        if (!empty($tablename) && !empty($feild)):

            $this->db->where($where);

        $this->db->update($tablename, $feild);

        return true;

        else: return "Invalid Input Provided";

        endif;
    }

//=============Function for Delete data===============//
    public function DELETEDATA($tablename = '', $where = '') {

        if (!empty($tablename) && !empty($where)):

            $this->db->where($where);

        $this->db->delete($tablename);


        else: return "Invalid Input Provided";

        endif;
    }

//=============Function for Joins data====================//
    public function get_joins($table = '', $where = '', $joins = '', $columns = '', $like = '', $group_by = '', $order_by = '', $limit = '', $start = '', $where_or='') {

        if (!empty($columns))
            $this->db->select($columns);

        if (empty($columns))
            $this->db->select();

        if (is_array($joins) && count($joins) > 0) {

            foreach ($joins as $k => $v) {

                $this->db->join($v['table'], $v['condition'], $v['jointype']);
            }
        }

        if (!empty($group_by))
            $this->db->group_by($group_by);

        if (!empty($like))
            $this->db->like($like);

        if (!empty($limit))
            $this->db->limit($limit, $start);

        if (!empty($where))
            $this->db->where($where);

        if (!empty($where_or))
            $this->db->or_where($where_or);

        if (!empty($order_by))
            $this->db->order_by($order_by);

        $this->db->from($table);
        return $this->db->get()->result();
    }

//==============Function for Select data=========//
    public function get_sql_select_data($tablename, $where = '', $feild = '', $limit = '', $order_by = '', $distinct='',$like = '',$like_or = '') {

        if (!empty($feild))
            $this->db->select($feild);

        if (empty($feild))
            $this->db->select();

        if (!empty($where))
            $this->db->where($where);


        if (!empty($limit))
            $this->db->limit($limit);

        if (!empty($like))
            $this->db->like($like);

        if (!empty($like_or))
         $this->db->or_like($like_or);

     if (!empty($order_by))
        $this->db->order_by($order_by);

    if (!empty($distinct))
     $this->db->distinct($distinct);

 $this->db->from($tablename);

 $query = $this->db->get();

 return $query->result();
}

//============ Function for select with AJax data===============//
public function get_sql_select_data_ajax($tablename, $where = '', $feild = '', $limit = '', $order_by = '') {

    if (!empty($feild))
        $this->db->select($feild);

    if (empty($feild))
        $this->db->select();

    if (!empty($where))
        $this->db->where($where);

    if (!empty($limit))
        $this->db->limit($limit);

    if (!empty($order_by))
        $this->db->order_by($order_by);

    $this->db->from($tablename);

    $query = $this->db->get();

    return $query->result();
}

//=============Function for User information===========//

public function user_info($where = '', $limit = '', $feild = '') {

    if (empty($feild))
        $this->db->select('*');

    if (!empty($feild))
        $this->db->select($feild);

    $this->db->from('user');

    $this->db->join('user_profile', 'user.user_id = user_profile.user_id');

    if (!empty($where))
        $this->db->where($where);

    if (!empty($limit))
        $this->db->limit($limit);

    $query = $this->db->get();

    return $query->result();
}

//============Function for Joins for multiple=====================//
public function get_joinss($table = '', $where = '', $columns = '', $joins = '', $group_by = '') {

    $this->db->select($columns)->from($table);

    if (is_array($joins) && count($joins) > 0) {

        foreach ($joins as $k => $v) {

            $this->db->join($v['table'], $v['condition'], $v['jointype']);
        }
    }

    if (!empty($where))
        $this->db->where($where);

    if (!empty($group_by))
        $this->db->group_by($group_by);

    return $this->db->get()->result();
}

//============Function for Joins with ajax data==============//
public function get_joins_ajax($table, $where, $columns, $joins, $group = '', $order_by = '', $like = '') {

    $this->db->select($columns)->from($table);

    if (is_array($joins) && count($joins) > 0) {
        foreach ($joins as $k => $v) {
            $this->db->join($v['table'], $v['condition'], $v['jointype']);
        }
    }

    $this->db->where($where);

    if (!empty($like))
        $this->db->like($like);

    if (!empty($group))
        $this->db->group_by($group);

    if (!empty($order_by))
        $this->db->order_by($order_by);

    return $this->db->get()->result();
}

//=========Function for User =============//
public function user_view($limit = '', $start = '', $order_by = '') {

    $this->db->from('user_profile');
    $this->db->where('user_id !=', '1');
    if (!empty($limit))
        $this->db->limit($limit, $start);
    if (!empty($order_by))
        $this->db->order_by($order_by);

    $query = $this->db->get();
    return $query->result();
}

public function user_Details($limit = '', $start = '', $order_by = '') {

    $this->db->from('user');
    $this->db->where('user_id !=', '1');
    if (!empty($limit))
        $this->db->limit($limit, $start);
    if (!empty($order_by))
        $this->db->order_by($order_by);

    $query = $this->db->get();
    return $query->result();
}

/* **************Get Image By Past Select Image************ */

public function GetImagesByUid($id) {
    $this->db->select('image');
    $this->db->from('exhibitions_image');
    $this->db->where('user_id', $id);
    $query = $this->db->get();
    return $query->result();
}

/*     * ****************************************************** Get Image By For Artist Press********************************** */

public function GetArtistImageId($id) {
    $this->db->select('image');
    $this->db->from('press_image');
    $this->db->where('press_id', $id);
    $query = $this->db->get();
    return $query->result();
}

    //======================================Check number of rows Ib table=========================//
function getNumsLikesRows($tbl, $data) {

    $this->db->select('*');
    $this->db->from($tbl);
    $this->db->where($data);
    $query = $this->db->get();
    return $query->num_rows();
}

    //Search Functionality For Suppliers and By suppliers name,country city and Town

public function searchSuppliers($suppliername, $country, $city, $town) {

    $this->db->select('');
    $this->db->where('user_id !=', 1);
    if (!empty($suppliername))
        $this->db->like($suppliername);
    if (!empty($country))
        $this->db->where($country);
    if (!empty($city))
        $this->db->where($city);
    if (!empty($town))
        $this->db->where($town);

    $this->db->order_by('user_name', 'asc');

    $this->db->from('user');
    $this->db->join('country','user.country =country.id');
    $this->db->join('states','user.state =states.state_code');
    $this->db->join('tbl_categorydesign','user.user_id =tbl_categorydesign.uId');

    $query = $this->db->get();

    return $query->result();
}

  //User name thet comments on designes ............
public function userNameBycomments($id) {

    $this->db->select('*');
    $this->db->from('user');
    $this->db->where('user_id', $id);
    $query = $this->db->get();
    return $query->result();
}  

public function  usercvBycomments($id) {

    $this->db->select('*');
    $this->db->from('user');
    $this->db->where('user_id', $id);
    $query = $this->db->get();
    return $query->result();
}  

 //Getcategory name by CatId in list........

public function getCatName($id) {
    $this->db->select('cat_name');
    $this->db->from('category');
    $this->db->where('cat_id', $id);
    $query = $this->db->get();
    return $query->result();
}    
  //=============================================Function for User information data==============================================================//

public function getFavoriteDesigns($where = '', $limit = '', $feild = '') {

    if (empty($feild))
        $this->db->select('*');

    if (!empty($feild))
        $this->db->select($feild);

    $this->db->from('tbl_userFallow');

    $this->db->join('tbl_categorydesign', 'tbl_userFallow.user =  tbl_categorydesign.uId');

    if (!empty($where))
        $this->db->where($where);

    if (!empty($limit))
        $this->db->limit($limit);

    $this->db->order_by('tbl_categorydesign.designId', 'desc');

    $query = $this->db->get();

    return $query->result();
}


   //***********************************************Get user data for not in Following Section ******************************************//

public function getDataNotFollowing($id){
    $this->db->select('*');

    $this->db->from('user');
    $this->db->where_not_in('user_id', array('1'));
    $this->db->where_not_in('user_id', $id);
    $query = $this->db->get();
    return $query->result();

}


   //=============================function to generate unique code ========================//
public function uniqueId(){
 $this->load->helper('string');
}
   //******************************function to generate forgetpassword*************************//
public function email_exists(){
    $email = $this->input->post('email');
    $query = $this->db->query("SELECT email, password FROM user WHERE email='$email'");  
    if($row = $query->row()){
        return TRUE;
    }else{
        return FALSE;
    }
}
public function temp_reset_password($temp_pass){
    $data =array(
        'email' =>$this->input->post('email'),
        'reset_pass'=>$temp_pass);
    $email = $data['email'];

    if($data){
        $this->db->where('email', $email);
        $this->db->update('user', $data);
        return TRUE;
    }else{
        return FALSE;
    }

}
//=======================================================header notification ========================================//
public function is_temp_pass_valid($temp_pass){

  $this->db->where('reset_pass', $temp_pass);
  $query = $this->db->get('user');
  echo $query;
  exit();
  if($query->num_rows() == 1){
    return TRUE;
}
else return FALSE;
}

public function notification(){

    $where= array('user.user_id' => $this->session->userdata('user_id'),'tbl_comments.status' => '1'
);

    $this->db->select('tbl_categorydesign.* , tbl_comments.* , user.* , commentuser.firstname');
    $this->db->from('tbl_categorydesign');
    $this->db->join('tbl_comments','tbl_categorydesign.designId = tbl_comments.designId');
    $this->db->join('user','user.user_id = tbl_categorydesign.Uid');
    $this->db->join('user as commentuser','commentuser.user_id = tbl_comments.uId');
    $this->db->where($where);
    $this->db->limit(10);
    $this->db->order_by('tbl_comments.commentsId', 'desc');
    $query = $this->db->get();
    //echo $this->db->last_query();
    return $query->result();

}
public function dislike_uid_notify(){
   $where= array('tbl_dislikes.designId' => $this->uri->segment(3));

   $this->db->select('*');
   $this->db->from('tbl_dislikes');
   $this->db->where($where);
   $query = $this->db->get();

   return $query->result();
}


/* Get followers*/

function getfollowesid($id)
{
 $this->db->select('user');
 $this->db->from('tbl_userFallow');
 $this->db->where('uId',$id);
 $query = $this->db->get();
 return $query->result_array();
}

/* Get followers*/
function getfollowersid($id)
{
 $this->db->select('uId');
 $this->db->from('tbl_userFallow');
 $this->db->where('user',$id);
 $query = $this->db->get();
 return $query->result_array();
}


/*for getting data as array values*/
//**---JOIN DATA
public function get_array_joins($tablename = '', $where = '', $joins = '', $columns = '', $like = '', $group_by = '', $order_by = '', $limit = '', $start = '', $where_create = '', $or_where='', $where_in='') {

    @$weekstartday = date("Y-m-d H:i:s",(strtotime('monday this week')));
    @$weekendday = date("Y-m-d H:i:s",(strtotime('monday this week + 7 day')));

    if(!empty($columns))$this->db->select($columns);
    if(empty($columns))$this->db->select('*');



    if (is_array($joins) && count($joins) > 0) {

        foreach ($joins as $k => $v) {

            $this->db->join($v['table'], $v['condition'], $v['jointype']);
        }
    }

    if (!empty($group_by))
        $this->db->group_by($group_by);

    if (!empty($like))
        $this->db->or_like($like);

    if (!empty($limit))
        $this->db->limit($limit, $start);

    if (!empty($where))
        $this->db->where($where);

    if (!empty($where_create))
        $this->db->where('createdate BETWEEN "'.$weekstartday.'" AND "'.$weekendday.'"');

    if (!empty($order_by))    
        $this->db->order_by($order_by);

    if (!empty($where_in))    
        $this->db->where_in($where_in);

    if (!empty($or_where))
        $this->db->or_where($or_where);

    $this->db->from($tablename);

    $query = $this->db->get();

    return $query->result_array();

}

}//End class