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
	
	//create a new item
	public function create($input){
		$to_insert = array(
			'name' => $input['name'],
			'slug' => $this->_check_slug($input['slug'])
		);

		return $this->db->insert('survey', $to_insert);
	}

	//make sure the slug is valid
	public function _check_slug($slug){
		$slug = strtolower($slug);
		$slug = preg_replace('/\s+/', '-', $slug);

		return $slug;
	}

    public function get_all_dtp(){
        $query = $this->db->get('survey_dpt');

        return $query->result();
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
}
