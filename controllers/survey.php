<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a survey module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	survey Module
 */
class Survey extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->model('survey_m');
		$this->lang->load('survey');

		$this->template
			->append_css('module::survey.css')
			->append_js('module::survey.js');
	}

	/**
	 * All items
	 */
	public function index($offset = 0)
	{
        $survey = $this->survey_m->get_all_survey();

        $this->template
            ->title($this->module_details['name'], 'the rest of the page title')
            ->set('survey', $survey)
            ->build('index');
	}

    public function save_survey(){
        $posted_data = $this->input->post();

        if($posted_data['survey_id']){
            // we are here to edit the data.
            $data = $this->survey_m->update_survey($posted_data);
        }else{
            // we here to ad new data
            $data = $this->survey_m->insert_survey($posted_data);
        }

        echo json_encode($data);
    }

    public function get_survey_by_id($id = ''){
        if($id){
            $query = $this->db->get_where('survey', array('id' => $id));
            echo json_encode($query->result());
        }
    }

    public function delete_survey($id = ''){

        if($id){
            $this->db->delete('survey', array('id' => $id));
        }
        redirect('survey');
    }
    // start of dpt ===============================
    public function dpt(){

        $dpt = $this->survey_m->get_all_dtp();

        $this->template
            ->title($this->module_details['name'], 'the rest of the page title')
            ->set('dpt', $dpt)
            ->append_js('module::dpt.js')
            ->build('dpt');
    }

    public function save_dpt(){
        $posted_data = $this->input->post();

        if($posted_data['dpt_id']){
            // we are here to edit the data.
            $data = $this->survey_m->update_dpt($posted_data);
        }else{
            // we here to ad new data
            $data = $this->survey_m->insert_dpt($posted_data);
        }

        echo json_encode($data);
    }

    public function get_dpt_by_id($id = ''){
        if($id){
            $query = $this->db->get_where('survey_dpt', array('id' => $id));
            echo json_encode($query->result());
        }
    }

    public function delete_dpt($id = ''){

        if($id){
            $this->db->delete('survey_dpt', array('id' => $id));
        }
        redirect('survey/dpt');
    }

    public function peers(){
        $this->load->view('peers');
    }
}