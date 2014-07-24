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

// Survey finished and dpt started ===============================================================================

    public function get_all_dtp(){
        $query = $this->db->get('survey_dpt');

        return $query->result();
    }

    public function update_dpt($data){
        $dpt = array(
            'name'          => $data['dpt_name'],
            'description'   => $data['dpt_description'],
            'modified_by'   => $data['user_id'],
            'modified_date' => time(),
        );
        $this->db->where('id', $data['dpt_id']);
        return $this->db->update('survey_dpt', $dpt);
    }

    public function insert_dpt($data){
        $dpt = array(
            'name'          => $data['dpt_name'],
            'description'   => $data['dpt_description'],
            'created_by'    => $data['user_id'],
            'create_date'   => time(),
        );

        return $this->db->insert('survey_dpt', $dpt);
    }

    // dpt finished and question_categories started ===============================================================================

    public function get_all_question_categories(){
        $query = $this->db->get('survey_question_categories');

        return $query->result();
    }

    public function update_question_categories($data){
        $dpt = array(
            'name'          => $data['question_categories_name'],
            'description'   => $data['question_categories_description'],
            'modified_by'   => $data['user_id'],
            'modified_date' => time(),
        );
        $this->db->where('id', $data['question_categories_id']);
        return $this->db->update('survey_question_categories', $dpt);
    }

    public function insert_question_categories($data){
        $dpt = array(
            'name'          => $data['question_categories_name'],
            'description'   => $data['question_categories_description'],
            'created_by'    => $data['user_id'],
            'create_date'   => time(),
        );

        return $this->db->insert('survey_question_categories', $dpt);
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
        $query = $this->db->get_where('survey_clients', array('manager_uid'));

        return $query->row();
    }

    public function get_all_users_by_manager($manager_id){

        $client = $this->get_client_by_manager_id($manager_id); // got all the information as object

        $sql = 'select u.id as id, u.email as email, u.active as active, u.last_login as last_login, p.display_name as display_name
                from default_users u
                join default_profiles p
                on p.user_id = u.id
                join default_survey_participant sp
                on sp.uid = u.id
                where sp.cid = '.$client->id;
        $quuery = $this->db->query($sql);
        return $quuery->result();
    }

}
