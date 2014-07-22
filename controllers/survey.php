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
        $this->load->helper('survey');

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
                echo json_encode($query->row());
            }else{
                // expected output object
                return $query->row();
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
 //============================================= Manage question categories=============================================
    public function question_categories(){

        $question_categories = $this->survey_m->get_all_question_categories();

        $this->template
            ->title($this->module_details['name'], 'manage question categories')
            ->set('question_categories', $question_categories)
            ->append_js('module::question_categories.js')
            ->build('question_categories');
    }

    public function save_question_categories(){
        $posted_data = $this->input->post();

        if($posted_data['question_categories_id']){
            // we are here to edit the data.
            $data = $this->survey_m->update_question_categories($posted_data);
        }else{
            // we here to ad new data
            $data = $this->survey_m->insert_question_categories($posted_data);
        }

        echo json_encode($data);
    }

    public function get_question_categories_by_id($id = ''){
        if($id){
            $query = $this->db->get_where('survey_question_categories', array('id' => $id));
            echo json_encode($query->result());
        }
    }

    public function delete_question_categories($id = ''){

        if($id){
            $this->db->delete('survey_question_categories', array('id' => $id));
        }
        redirect('survey/question_categories');
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
        $categories = $this->survey_m->get_all_question_categories();

        $this->template
            ->title($this->module_details['name'], 'manage questions')
            ->set('questions', $questions)
            ->set('categories', $categories)
            ->set('survey_id', $survey_id)
            ->append_css('module::question.css')
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
        $question_categories = $this->survey_m->get_all_question_categories();

        $this->template
            ->title($this->module_details['name'], 'manage questions')
            ->set('survey_id', $survey_id)
            ->set('survey', $survey)
            ->set('question_categories', $question_categories)
            ->append_js('module::question.js')
            ->build('add_new_question');
    }

    public function save_question(){
        $data = $this->input->post();

        if($this->survey_m->question_form_validate($data)){
            $question = array(
                'survey_id'     => $data['survey_id'],
                'cat_id'        => $data['question_category'],
                'title'         => $data['question_title'],
                'description'   => $data['description'],
                'matter'        => $data['matter'],
                'text1'         => $data['question_text1'],
                'text2'         => $data['question_text2'],
                'created_by'    => $data['user_id'],
                'create_date'   => time(),
            );


            if($this->db->insert('survey_questions', $question)){
                $q_id = $this->db->insert_id();

                $answers = array(
                    'question_id'   => $q_id,
                    'option_1'      => $data['option_1'],
                    'option_2'      => $data['option_2'],
                    'option_3'      => $data['option_3'],
                    'option_4'      => $data['option_4'],
                    'created_by'    => $data['user_id'],
                    'create_date'   => time(),
                );

                $this->db->insert('survey_answer_options', $answers);
            }
            echo json_encode(array('survey_id'=>$data['survey_id'], 'validate'=>true));
        }else{
            echo json_encode(array('survey_id'=>$data['survey_id'], 'validated'=>false, 'data'=>$data));
        }

    }
    public function update_question(){
        $data = $this->input->post();

        if($this->survey_m->question_form_validate($data)){
            $q_id = $data['q_id'];
            $question = array(
                'survey_id'     => $data['survey_id'],
                'cat_id'        => $data['question_category'],
                'title'         => $data['question_title'],
                'description'   => $data['description'],
                'matter'        => $data['matter'],
                'text1'         => $data['question_text1'],
                'text2'         => $data['question_text2'],
                'modified_by'   => $data['user_id'],
                'modified_date' => time(),
            );

            $this->db->where('id', $q_id);
            if($this->db->update('survey_questions', $question)){

                $answers = array(
                    'question_id'   => $q_id,
                    'option_1'      => $data['option_1'],
                    'option_2'      => $data['option_2'],
                    'option_3'      => $data['option_3'],
                    'option_4'      => $data['option_4'],
                    'modified_by'   => $data['user_id'],
                    'modified_date' => time(),
                );

                $this->db->where('id', $data['option_id']);
                $this->db->update('survey_answer_options', $answers);
            }
            echo json_encode(array('survey_id'=>$data['survey_id'], 'validate'=>true));
        }else{
            echo json_encode(array('survey_id'=>$data['survey_id'], 'validated'=>false, 'data'=>$data));
        }

    }
    public function edit_question($survey_id = '', $q_id = ''){
        $survey     = $this->get_survey_by_id($survey_id, $output = 'object');
        $question   = $this->get_question_by_id($q_id, $output = 'object');
        $q_cat      = $this->survey_m->get_all_question_categories();
        $options    = get_option_by_question_id($q_id);

        $this->template
            ->title($this->module_details['name'], 'Edit question')
            ->set('survey_id', $survey_id)
            ->set('question',$question)
            ->set('options', $options)
            ->set('survey', $survey)
            ->set('q_cat', $q_cat)
            ->append_js('module::question.js')
            ->build('edit_question');
    }

    public function get_question_by_id($q_id = '', $output = 'json'){
        if($q_id){
            $query = $this->db->get_where('survey_questions', array('id' => $q_id));
            if($output == 'json'){
                echo json_encode($query->row());
            }else{
                // expected output object
                return $query->row();
            }

        }
    }
    public function delete_question($survey_id = '', $q_id = ''){

        if($q_id){
            $this->db->delete('survey_answer_options', array('question_id' => $q_id));
            $this->db->delete('survey_questions', array('id' => $q_id));
        }
        redirect('survey/questions/'.$survey_id);
    }
// ============================================= default options =======================================================

    public function default_options(){

        $options = $this->survey_m->get_all_options();

        $this->template
            ->title($this->module_details['name'], 'manage default options')
            ->set('options', $options)
            ->build('default_options');
    }

    public function update_options(){
        $data = $this->input->post();

        $option = array(
            'option_1'      => $data['option_1'],
            'option_2'      => $data['option_2'],
            'option_3'      => $data['option_3'],
            'option_4'      => $data['option_4'],
            'modified_by'   => $data['user_id'],
            'modified_date' => time(),
        );

        $this->db->where('id', 1);
        $this->db->update('survey_default_options', $option);

        redirect('survey/default_options');
    }



// ============================================= Manage peers ==========================================================
    public function peers(){
        $this->load->view('peers');
    }
}