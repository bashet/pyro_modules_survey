<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a survey module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	survey Module
 */
class survey_m extends MY_Model {

	public function __construct(){
		parent::__construct();
		
		/**
		 * If the survey module's table was named "surveys"
		 * then MY_Model would find it automatically. Since
		 * I named it "survey" then we just set the name here.
		 */
		$this->_table = 'survey';
	}

    public function get_all_survey(){
        $query = $this->db->get('survey');

        return $query->result();
    }

    public function update_survey($data){
        $survey = array(
            'name'          => $data['survey_name'],
            'description'   => $data['survey_description'],
            'modified_by'   => $data['user_id'],
            'modified_date' => time(),
        );
        $this->db->where('id', $data['survey_id']);
        return $this->db->update('survey', $survey);
    }

    public function insert_survey($data){
        $survey = array(
            'name'          => $data['survey_name'],
            'description'   => $data['survey_description'],
            'created_by'    => $data['user_id'],
            'create_date'   => time(),
        );

        return $this->db->insert('survey', $survey);
    }

// Survey finished and programme started ===============================================================================

    public function get_all_programme(){
        $query = $this->db->get('survey_programme');

        return $query->result();
    }

    public function update_programme($data){
        $programme = array(
            'name'          => $data['programme_name'],
            'description'   => $data['programme_description'],
            'modified_by'   => $data['user_id'],
            'modified_date' => time(),
        );
        $this->db->where('id', $data['programme_id']);
        return $this->db->update('survey_programme', $programme);
    }

    public function insert_programme($data){
        $programme = array(
            'name'          => $data['programme_name'],
            'description'   => $data['programme_description'],
            'created_by'    => $data['user_id'],
            'create_date'   => time(),
        );

        return $this->db->insert('survey_programme', $programme);
    }

    // programme finished and question_categories started ===============================================================================

    public function get_all_question_categories(){
        $query = $this->db->get('survey_question_categories');

        return $query->result();
    }

    public function update_question_categories($data){
        $programme = array(
            'name'          => $data['question_categories_name'],
            'description'   => $data['question_categories_description'],
            'modified_by'   => $data['user_id'],
            'modified_date' => time(),
        );
        $this->db->where('id', $data['question_categories_id']);
        return $this->db->update('survey_question_categories', $programme);
    }

    public function insert_question_categories($data){
        $programme = array(
            'name'          => $data['question_categories_name'],
            'description'   => $data['question_categories_description'],
            'created_by'    => $data['user_id'],
            'create_date'   => time(),
        );

        return $this->db->insert('survey_question_categories', $programme);
    }

    // default options ============================================

    public function get_all_options(){
        $query = $this->db->get_where('survey_default_options', array('id'=>1));

        return $query->row();
    }

    // for managing question ==========================================

    public function get_all_questions($survey_id = ''){
        $query = $this->db->get_where('survey_questions', array('survey_id'=>$survey_id));
        return $query->result();
    }

    public function question_form_validate($data){
        $validate = true;
        foreach($data as $field=>$value){
            if($field == 'survey_id' || $field == 'user_id'){

            }else{
                if($value == ''){
                    $validate = false;
                }
            }
        }

        return $validate;
    }

    // =============================== clients ====================================

    public function get_all_clients(){
        $this->db->order_by('name');
        $query = $this->db->get('survey_clients');

        return $query->result();
    }

    public function update_client($data){
        $client = array(
            'name'          => $data['client_name'],
            'modified_by'   => $data['user_id'],
            'modified_date' => time(),
        );
        $this->db->where('id', $data['client_id']);
        return $this->db->update('survey_clients', $client);
    }

    public function insert_client($data){
        $client = array(
            'name'          => $data['client_name'],
            'created_by'    => $data['user_id'],
            'create_date'   => time(),
        );

        return $this->db->insert('survey_clients', $client);
    }

    public function get_client_by_manager_id($manager_id){
        $query = $this->db->get_where('survey_clients', array('manager_uid'=>$manager_id));

        return $query->row();
    }

    public function get_all_users_by_client($client_id){

        $sql = 'select u.id as id, u.email as email, u.active as active, u.last_login as last_login, p.display_name as display_name
                from default_users u
                join default_profiles p
                on p.user_id = u.id
                join default_survey_participant sp
                on sp.uid = u.id
                where sp.cid = '.$client_id.' order by display_name';
        $quuery = $this->db->query($sql);
        return $quuery->result();
    }

    public function get_all_users_for_admin(){

        $sql = 'select u.id as id, u.email as email, c.name as org, u.active as active, u.last_login as last_login, concat(p.first_name, " ", p.last_name) as full_name, p.cohort as cohort
                from default_users u
                join default_profiles p
                on p.user_id = u.id
                join default_survey_participant sp
                on sp.uid = u.id
				join default_survey_clients c
				on sp.cid = c.id
				order by full_name';
        $quuery = $this->db->query($sql);
        $data = array();
        $i = 1;
        foreach($quuery->result() as $row){
            $this_row = array($i, $row->full_name, $row->email, $row->org, $row->cohort);

            if($row->active){
                $this_row[] = '<button activate id="activate_user-'.$row->id.'-0" class="btn btn-link"><span class="glyphicon glyphicon-ok"></span></button>';
            }else{
                $this_row[] = '<button activate id="activate_user-'.$row->id.'-1" class="btn btn-link"><span class="glyphicon glyphicon-remove"></span></button>';
            }
            $this_row[] = '<a href="history/'.$row->id.'"><span class="glyphicon glyphicon-list-alt"></span>';
            $this_row[] = date('d/m/Y : h:i:s a', $row->last_login);
            $i++;
            $data[] = $this_row;
        }
        //return $quuery->result();
        return $data;
    }

    public function get_current_participation($id = ''){
        $query = $this->db->get_where('survey_participant', array('uid'=>$id, 'active'=>1)); // expected to get only one row

        return $query->row();

    }

}
