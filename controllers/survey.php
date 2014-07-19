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


	public function index($offset = 0)
	{
        $survey = $this->survey_m->get_all_survey();

        $this->template
            ->title($this->module_details['name'], 'manage survey')
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

    public function get_survey_by_id($id = '', $output = 'json'){
        if($id){
            $query = $this->db->get_where('survey', array('id' => $id));
            if($output == 'json'){
                echo json_encode($query->result());
            }else{
                // expected output object
                return $query->result();
            }

        }
    }

    public function delete_survey($id = ''){

        if($id){
            $this->db->delete('survey', array('id' => $id));
        }
        redirect('survey');
    }
// ============================================= Manage department =====================================================
    public function dpt(){

        $dpt = $this->survey_m->get_all_dtp();

        $this->template
            ->title($this->module_details['name'], 'manage departments')
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
// ============================================= Manage questions ======================================================

    public function questions($survey_id = ''){
        if($survey_id){
            // we will go ahead to do the next job
            $questions = $this->survey_m->get_all_questions($survey_id);
        }else{
            // wrong entry kick to ass
            $questions = '';
        }



        $this->template
            ->title($this->module_details['name'], 'manage questions')
            ->set('questions', $questions)
            ->set('survey_id', $survey_id)
            ->append_js('module::question.js')
            ->build('questions');
    }

    public function add_new_question($survey_id = ''){
        if($survey_id){
            // we will go ahead to do the next job
            $survey     = $this->get_survey_by_id($survey_id, $output = 'object');
        }else{
            // wrong entry kick to ass
            $survey     = '';
        }

        $this->template
            ->title($this->module_details['name'], 'manage questions')
            ->set('survey_id', $survey_id)
            ->set('survey', $survey)
            ->append_css('module::question.css')
            ->append_js('module::question.js')
            ->build('questions');
    }

// ============================================= Manage peers ==========================================================
    public function peers(){
        $this->load->view('peers');
    }
}