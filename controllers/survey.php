<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a survey module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	survey Module
 */
class Survey extends Public_Controller {

    public $allowed_evaluators = 0;

	public function __construct()
	{
		parent::__construct();

        $this->allowed_evaluators = Settings::get('survey_setting');

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
            ->set_breadcrumb('Survey')
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
    public function programme(){

        $programme  = $this->survey_m->get_all_programme();
        $survey     = $this->survey_m->get_all_survey();

        $this->template
            ->title($this->module_details['name'], 'manage departments')
            ->set('programme', $programme)
            ->set('survey', $survey)
            ->append_js('module::programme.js')
            ->build('programme');
    }

    public function save_programme(){
        $posted_data = $this->input->post();

        if($posted_data['programme_id']){
            // we are here to edit the data.
            $data = $this->survey_m->update_programme($posted_data);
        }else{
            // we here to ad new data
            $data = $this->survey_m->insert_programme($posted_data);
        }

        echo json_encode($data);
    }

    public function get_programme_by_id($id = ''){
        if($id){
            $query = $this->db->get_where('survey_programme', array('id' => $id));
            echo json_encode($query->row());
        }
    }

    public function delete_programme($id = ''){

        if($id){
            $this->db->delete('survey_programme', array('id' => $id));
        }
        redirect('survey/programme');
    }

    public function update_programme_status($id = '', $active = ''){
        $programme = '';
        if($id){
            if($active){
                // need to de-activate
                $programme = array('active'=>0);
            }else{
                // need to activate
                $programme = array('active'=>1);
            }
        }

        $this->db->where('id', $id);
        $this->db->update('survey_programme', $programme);
        redirect('survey/programme');
    }

    public function link_programme(){
        $data = $this->input->post();

        $new_data = array(
            'survey'    => $data['survey_id']
        );

        $this->db->where('id', $data['programme_id']);
        $this->db->update('survey_programme', $new_data);
        redirect('survey/programme');
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
            ->set_breadcrumb('Survey', '/survey')
            ->set_breadcrumb('Question')
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
            ->set_breadcrumb('Survey', '/survey/'.$survey_id)
            ->set_breadcrumb('Add new question')
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
            ->set_breadcrumb('Survey', '/survey/'.$survey_id)
            ->set_breadcrumb('Edit question')
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

// ============================================= Clients ===============================================================
    public function clients(){
        $clients = $this->survey_m->get_all_clients();

        $this->template
            ->title($this->module_details['name'], 'manage clients')
            ->set('clients', $clients)
            ->set_breadcrumb('Clients')
            ->append_js('module::clients.js')
            ->build('clients');
    }

    public function save_clients(){
        $posted_data = $this->input->post();

        if($posted_data['client_id']){
            // we are here to edit the data.
            $data = $this->survey_m->update_client($posted_data);
        }else{
            // we here to ad new data
            $data = $this->survey_m->insert_client($posted_data);
        }

        echo json_encode($data);
    }

    public function get_client_by_id($id = '', $output = 'json'){
        if($id){
            $query = $this->db->get_where('survey_clients', array('id' => $id));
            if($output == 'json'){
                echo json_encode($query->row());
            }else{
                // expected output object
                return $query->row();
            }

        }
    }

    public function update_client_status($client_id = ''){
        $client = $this->get_client_by_id($client_id, 'object');
        if($client->active){
            // need to de-activate
            $new_client = array('active'=>0);
        }else{
            // need to activate
            $new_client = array('active'=>1);
        }
        $this->db->where('id', $client_id);
        $this->db->update('survey_clients', $new_client);
        redirect('survey/clients');
    }
    public function update_manager(){
        $data = $this->input->post();

        $client = array('manager_uid'=>$data['manager_id']);
        $this->db->where('id', $data['client_id']);
        $this->db->update('survey_clients', $client);
        redirect('survey/clients');
    }

    public function manage_users(){
        $client = $this->survey_m->get_client_by_manager_id($this->current_user->id);
        if($this->current_user->group_id == 1){
            $users = $this->survey_m->get_all_users_for_admin();
        }else{
            $users = $this->survey_m->get_all_users_by_client($client->id);
        }

        $this->template
            ->title($this->module_details['name'], 'manage users')
            ->set('users', $users)
            ->set('client', $client)
            ->set_breadcrumb('Manage Users')
            ->append_js('module::manage_users.js')
            ->build('manage_users');

    }

    public function activate_user($user_id = '', $active = 0){
        $data = array();
        if($user_id){
            $user       = get_user_by_id($user_id);
            $profile    = get_profile_by_user_id($user_id);
            $client     = $this->survey_m->get_client_by_manager_id($this->current_user->id);

            if($active){
                // need to de-activate
                $new_user = array('active'=>1);
                $slug = 'user-activate';
            }else{
                // need to activate
                $new_user = array('active'=>0);
                $slug = 'user-de-activate';
            }

            $this->db->where('id', $user_id);
            if($this->db->update('users', $new_user)){
                // send email notification to the user about the status changes

                $data['subject']			= Settings::get('site_name') . ' - User Activation'; // No translation needed as this is merely a fallback to Email Template subject
                $data['slug'] 				= $slug;
                $data['to'] 				= $user->email;
                $data['user_name']          = $profile->first_name . ' ' . $profile->last_name;
                $data['client']             = $client->name;
                $data['from'] 				= Settings::get('server_email');
                $data['name']				= Settings::get('site_name');
                $data['reply-to']			= Settings::get('contact_email');

                Events::trigger('email', $data, 'array');
            }

        }
        redirect('survey/manage_users');
    }

    public function user_survey($q_id = ''){
        $participation  = $this->survey_m->get_current_participation($this->current_user->id);
        //$client         = get_client_by_id($participation->cid);
        $programme      = get_programme_by_id($participation->pid);
        $survey         = get_survey_by_programme_id($programme->survey);
        $total_questions    = get_total_question_in_survey($survey->id);

        $q_no           = '';
        if($q_id){
            $question   = get_question_by_id($q_id);
        }else{
            $question   = get_first_question($survey->id);
            $q_no       = 1;
        }
        //$questions      = get_questions_by_survey_id($survey->id);

        $attempt        = get_current_attempt_by_user_id($this->current_user->id);
        if($attempt){
            //$evaluators     = get_evaluators_by_attempt_id($attempt->id);
            $total_evaluators   = get_total_evaluators_by_attempt_id($attempt->id);
        }else{
            $total_evaluators   = '';
        }



        $this->template
            ->title($this->module_details['name'], 'manage users')
            ->set_breadcrumb('User survey')
            ->set('total_evaluators', $total_evaluators)
            ->set('question', $question)
            ->set('q_no', $q_no)
            ->set('attempt', $attempt)
            ->set('survey', $survey)
            ->set('total_questions', $total_questions)
            ->append_css('module::user_survey.css')
            ->build('user_survey');
    }

    public function evaluators(){
        $participation  = $this->survey_m->get_current_participation($this->current_user->id);
        $programme      = get_programme_by_id($participation->pid);

        $attempt        = get_current_attempt_by_user_id($this->current_user->id);
        if($attempt){
            $evaluators     = get_evaluators_by_attempt_id($attempt->id);
            $total_evaluators   = get_total_evaluators_by_attempt_id($attempt->id);
        }else{
            $evaluators     = '';
            $total_evaluators   = '';
        }

        $this->template
            ->title($this->module_details['name'], 'manage evaluators')
            ->set_breadcrumb('Manage evaluators')
            ->set('evaluators', $evaluators)
            ->set('programme', $programme)
            ->set('attempt', $attempt)
            ->set('total_evaluators', $total_evaluators)
            ->set('allowed_evaluators', $this->allowed_evaluators)
            ->append_js('module::save_evaluators.js');

        if($evaluators){
            $this->template->build('evaluators');
        }else{
            $this->template->build('no_evaluators');
        }

    }

    public function save_evaluators(){
        $data = $this->input->post();
        $given = 0;
        $error = array();
        for($i = 1; $i <= $this->allowed_evaluators; $i++){
            if(($data['evaluators_name-'.$i]) && ($data['evaluators_email-'.$i]) && ($data['relationship'.$i])){
                $given++;
            }
            if($data['evaluators_email-'.$i]){
                if ( ! filter_var($data['evaluators_email-'.$i], FILTER_VALIDATE_EMAIL)){
                    $error[] = $i;
                }
            }
        }

        if(($given >= 3) && (empty($error))){
            // we can proceed to save data
            $attempt = array(
                'user_id'       => $data['user_id'],
                'survey_id'     => $data['survey_id'],
                'create_date'   => time(),
            );
            if($this->db->insert('survey_attempt', $attempt)){
                $attempt_id = $this->db->insert_id();

                for($i = 1; $i <= $this->allowed_evaluators; $i++){
                    if(($data['evaluators_name-'.$i]) && ($data['evaluators_email-'.$i]) && ($data['relationship'.$i])){
                        $evaluators = array(
                            'attempt_id'    => $attempt_id,
                            'name'          => $data['evaluators_name-'.$i],
                            'email'         => $data['evaluators_email-'.$i],
                            'relation'      => $data['relationship'.$i]
                        );
                        $this->db->insert('survey_evaluators', $evaluators);
                    }
                }

            }

            echo json_encode(array('success' => true));

        }else{
            echo json_encode(array('evaluators' => $given, 'error' =>$error));
        }

    }

    public function update_evaluators(){
        $data = $this->input->post();
        $error = array();
        for($i = 1; $i <= $this->allowed_evaluators; $i++){
            if(isset($data['evaluators_email-'.$i])){
                if($data['evaluators_email-'.$i]){
                    if ( ! filter_var($data['evaluators_email-'.$i], FILTER_VALIDATE_EMAIL)){
                        $error[] = $i;
                    }
                }
            }
        }

        if(empty($error)){

            $attempt_id = $data['attempt_id'];

            for($i = 1; $i <= $this->allowed_evaluators; $i++){
                if(isset($data['evaluators_name-'.$i]) && isset($data['evaluators_email-'.$i]) && isset($data['relationship'.$i])){
                    if(($data['evaluators_name-'.$i]) && ($data['evaluators_email-'.$i]) && ($data['relationship'.$i])){
                        $evaluators = array(
                            'attempt_id'    => $attempt_id,
                            'name'          => $data['evaluators_name-'.$i],
                            'email'         => $data['evaluators_email-'.$i],
                            'relation'      => $data['relationship'.$i]
                        );
                        $this->db->insert('survey_evaluators', $evaluators);
                    }
                }
            }

            echo json_encode(array('success' => true));

        }else{
            echo json_encode(array('error' =>$error));
        }

    }

    public function send_email_to_evaluators(){
        $this->template
            ->title($this->module_details['name'], 'send email to evaluators')
            ->set_breadcrumb('Manage evaluators', '/survey/evaluators' )
            ->set_breadcrumb('Send email')
            ->build('send_email_to_evaluators');
    }

    public function reports(){
        $this->template
            ->title($this->module_details['name'], 'report')
            ->set_breadcrumb('Report')
            ->build('report');
    }

    public function history(){
        $this->template
            ->title($this->module_details['name'], 'history')
            ->set_breadcrumb('History')
            ->build('history');
    }
}