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

    public $allowed_evaluators  = 0;
    public $participation       = '';
    public $programme           = '';
    public $survey              = '';
    public $total_questions     = '';
    public $client              = '';
    public $attempt             = '';
    public $total_evaluators    = '';
    public $attempt_remaining   = 0;

	public function __construct()
	{
		parent::__construct();

        $this->allowed_evaluators = Settings::get('survey_setting');

		// Load the required classes
		$this->load->model('survey_m');
		$this->lang->load('survey');
        $this->load->helper('survey');
        $this->load->library('files/files');

        if(isset($this->current_user->id)){
            $this->participation   = $this->survey_m->get_current_participation($this->current_user->id);
            if($this->participation){
                $this->client          = get_client_by_id($this->participation->cid);
                $this->programme       = get_programme_by_id($this->participation->pid);
                $this->attempt_remaining = $this->participation->allowed - get_total_attempts_by_user_n_programme($this->participation->uid, $this->participation->pid);
            }



            $this->attempt         = get_current_attempt_by_user_id($this->current_user->id);
            if($this->attempt){
                $this->total_evaluators   = get_total_evaluators_by_attempt_id($this->attempt->id);
                if( ! $this->session->userdata('attempt_id')){
                    $this->session->set_userdata(array('attempt_id' => $this->attempt->id));
                }
            }
        }


        if($this->programme){
            $this->survey          = get_survey_by_programme_id($this->programme->survey);
        }

        if($this->survey){
            $this->total_questions = get_total_question_in_survey($this->survey->id);
            if( ! $this->session->userdata('survey_id')){
                $this->session->set_userdata(array('survey_id' => $this->survey->id));
            }
        }


		$this->template
			->append_css('module::survey.css')
			->append_js('module::survey.js');
	}


	public function index($offset = 0)
	{
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
        $survey = $this->survey_m->get_all_survey();

        $this->template
            ->enable_minify(true)
            ->title($this->module_details['name'], 'manage survey')
            ->set('survey', $survey)
            ->set_breadcrumb('Survey')
            ->build('index');
	}

    public function save_survey(){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }

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
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }

        $programme  = $this->survey_m->get_all_programme();
        $survey     = $this->survey_m->get_all_survey();

        $this->template
            ->title($this->module_details['name'], 'manage departments')
            ->set_breadcrumb('Programme')
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
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
        if($id){
            $this->db->delete('survey_programme', array('id' => $id));
        }
        redirect('survey/programme');
    }

    public function update_programme_status($id = '', $active = ''){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
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
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }

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
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
        $question_categories = $this->survey_m->get_all_question_categories();

        $this->template
            ->title($this->module_details['name'], 'manage question categories')
            ->set_breadcrumb('Question category')
            ->set('question_categories', $question_categories)
            ->append_js('module::question_categories.js')
            ->build('question_categories');
    }

    public function save_question_categories(){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
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

        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }

        if($id){
            $this->db->delete('survey_question_categories', array('id' => $id));

            $this->db->like('q_cat', $id);
            $query = $this->db->get('survey');
            $result = $query->result();
            foreach($result as $survey){
                $category = json_decode($survey->q_cat, true);
                $new_cat = array();
                $i = 1;
                foreach($category as $key=>$c_no){
                    if($c_no != $id){
                        $new_cat[$i] = $c_no;
                        $i++;
                    }
                }

                $this->db->where('id', $survey->id);
                $this->db->update('survey', array('q_cat' => json_encode($new_cat)));
            }


        }
        redirect('survey/question_categories');
    }
// ============================================= Manage questions ======================================================

    public function questions_in_category($cat_id = ''){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
        $category   = '';
        $questions  = '';
        if($cat_id){
            $category   = get_category_by_id($cat_id);
            $questions  = get_questions_by_category($cat_id);
        }else{
            redirect($this->config->base_url());
        }


        $this->template
            ->title($this->module_details['name'], 'manage questions')
            ->set('cat', $category)
            ->set('questions', $questions)
            ->set_breadcrumb('Category', '/survey/question_categories/')
            ->set_breadcrumb('Questions')
            ->append_css('module::question.css')
            ->append_js('module::question.js')
            ->build('questions_in_category');
    }

    public function organise_questions($cat_id = ''){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
        $category   = '';
        $questions  = '';
        if($cat_id){
            $category   = get_category_by_id($cat_id);
            $questions  = get_questions_by_category($cat_id);
        }else{
            redirect($this->config->base_url());
        }


        $this->template
            ->title($this->module_details['name'], 'manage questions')
            ->set('cat', $category)
            ->set('questions', $questions)
            ->set_breadcrumb('Question category', '/survey/questions_in_category/'.$cat_id)
            ->set_breadcrumb('Organise questions')
            ->append_css('module::question.css')
            ->append_js('module::question.js')
            ->append_js('module::organise_questions.js')
            ->build('organise_questions');
    }

    public function questions($survey_id = ''){

        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }

        if(! $survey_id){
            redirect($this->config->base_url());
        }

        $categories = $this->survey_m->get_all_question_categories();
        $survey     = get_survey_by_id($survey_id);

        $this->template
            ->title($this->module_details['name'], 'manage questions')
            ->set('categories', $categories)
            ->set('survey', $survey)
            ->set('survey_id', $survey_id)
            ->set_breadcrumb('Survey', '/survey')
            ->set_breadcrumb('Question')
            ->append_css('module::question.css')
            ->append_js('module::question.js')
            ->build('questions');
    }

    public function add_qCat_to_survey(){
        if($data = $this->input->post()){
            $survey = get_survey_by_id($data['survey_id']);
            $cat    = re_build_cat($survey, $data);
            $this->db->where('id', $survey->id);
            if($this->db->update('survey', array('q_cat' => $cat))){
                redirect('survey/questions/'. $survey->id);
            }
        }
    }

    public function add_new_question($cat_id = ''){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
        if( ! $cat_id){
            redirect($this->config->base_url());
        }
        $category = get_category_by_id($cat_id);

        $this->template
            ->title($this->module_details['name'], 'manage questions')
            ->set('category', $category)
            ->set('cat_id', $cat_id)
            ->append_js('module::question.js')
            ->set_breadcrumb('Question category', '/survey/questions_in_category/'.$cat_id)
            ->set_breadcrumb('Add new question')
            ->build('add_new_question');
    }

    public function organise($survey_id = ''){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }

        if($survey_id){
            // we will go ahead to do the next job
            $questions = $this->survey_m->get_all_questions($survey_id);
        }else{
            // wrong entry kick to ass
            $questions = '';
        }
        $categories = $this->survey_m->get_all_question_categories();
        $survey     = get_survey_by_id($survey_id);

        $this->template
            ->title($this->module_details['name'], 'manage questions')
            ->set('questions', $questions)
            ->set('categories', $categories)
            ->set('survey', $survey)
            ->set('survey_id', $survey_id)
            ->set_breadcrumb('Survey', '/survey')
            ->set_breadcrumb('Questions', '/survey/questions/'.$survey_id)
            ->set_breadcrumb('Organise')
            ->append_js('module::organise.js')
            ->build('organise');
    }

    public function update_position_in_category(){
        $data       = json_decode(json_encode($this->input->post()));
        $results    = $data->results;
        $i          = 1;
        $questions = array();
        foreach($results as $q){
            $questions[$i] = $q->id;
            $i++;
        }
        $this->db->where('id', $data->cat_id);
        $this->db->update('survey_question_categories', array('questions' =>json_encode($questions)));

        echo json_encode($results);
    }

    public function update_position(){
        $data       = json_decode(json_encode($this->input->post()));
        $results    = $data->results;
        $survey     = $data->survey;
        $get_id     = explode('-',$survey);
        $survey_id  = $get_id[1];
        $new_cat    = array();
        $i          = 1;

        $temp = array();
        foreach($results as $category){
            $new_cat[$i]    = $category->id;
            $children       = $category->children;
            $questions      = array();
            $j              = 1;
            foreach($children as $child){
                $q_id = explode('-', $child->id);
                $questions[$j] = $q_id[1];
                $j++;
            }
            $this->db->where('id', $category->id);
            $this->db->update('survey_question_categories', array('questions' =>json_encode($questions)));
            $i++;
        }

        $this->db->where('id', $survey_id);
        $this->db->update('survey', array('q_cat' =>json_encode($new_cat)));

        echo json_encode($temp);
    }

    public function save_question(){

        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
        $data = $this->input->post();
        $cat_id = $data['cat_id'];
        if($this->survey_m->question_form_validate($data)){
            $question = array(
                'cat_id'        => $cat_id,
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

                $cat_info   = get_category_by_id($cat_id);
                $new_cat_info = re_build_question_serial($cat_info,$q_id);
                $this->db->where('id', $cat_id);
                $this->db->update('survey_question_categories', array('questions' => $new_cat_info));

                $answers = array(
                    'question_id'   => $q_id,
                    'option_1_label'=> $data['option_1_label'],
                    'option_2_label'=> $data['option_2_label'],
                    'option_3_label'=> $data['option_3_label'],
                    'option_4_label'=> $data['option_4_label'],
                    'option_1'      => $data['option_1'],
                    'option_2'      => $data['option_2'],
                    'option_3'      => $data['option_3'],
                    'option_4'      => $data['option_4'],
                    'created_by'    => $data['user_id'],
                    'create_date'   => time(),
                );

                $this->db->insert('survey_answer_options', $answers);
            }
            echo json_encode(array('cat_id'=>$cat_id, 'validate'=>true));
        }else{
            echo json_encode(array('cat_id'=>$cat_id, 'validated'=>false, 'data'=>$data));
        }

    }
    public function update_question(){

        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
        $data = $this->input->post();

        if($this->survey_m->question_form_validate($data)){
            $q_id = $data['q_id'];
            $question = array(
                'cat_id'        => $data['cat_id'],
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
                    'option_1_label'=> $data['option_1_label'],
                    'option_2_label'=> $data['option_2_label'],
                    'option_3_label'=> $data['option_3_label'],
                    'option_4_label'=> $data['option_4_label'],
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
            echo json_encode(array('cat_id'=>$data['cat_id'], 'validate'=>true));
        }else{
            echo json_encode(array('cat_id'=>$data['cat_id'], 'validated'=>false, 'data'=>$data));
        }

    }
    public function edit_question($cat_id = '', $q_id = ''){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }

        $question   = $this->get_question_by_id($q_id, $output = 'object');
        $category   = get_category_by_id($cat_id);
        $options    = get_option_by_question_id($q_id);

        $this->template
            ->title($this->module_details['name'], 'Edit question')
            ->set('question',$question)
            ->set('options', $options)
            ->set('category', $category)
            ->append_js('module::question.js')
            ->set_breadcrumb('Question category', '/survey/questions_in_category/'.$cat_id)
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
    public function delete_question($cat_id = '', $q_id = ''){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
        if($q_id){
            $this->db->delete('survey_answer_options', array('question_id' => $q_id));
            $this->db->delete('survey_questions', array('id' => $q_id));
            $category = get_category_by_id($cat_id);

            $questions = json_decode($category->questions, true);
            $new_questions = array();
            $i = 1;
            foreach($questions as $key=>$q_no){
                if($q_no != $q_id){
                    $new_questions[$i] = $q_no;
                    $i++;
                }
            }

            $this->db->where('id', $cat_id);
            $this->db->update('survey_question_categories', array('questions' => json_encode($new_questions)));

        }
        redirect('survey/questions_in_category/'.$cat_id);
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
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
        $this->load->model('files/file_folders_m');

        //get files folders
        $file_folders = $this->file_folders_m->get_folders();
        $folders_tree = array();
        foreach($file_folders as $folder)
        {
            $indent = repeater('&raquo; ', $folder->depth);
            $folders_tree[$folder->id] = $indent.$folder->name;
        }

        $clients = $this->survey_m->get_all_clients();

        $this->template
            ->title($this->module_details['name'], 'manage clients')
            ->set_breadcrumb('Organisations')
            ->set('clients', $clients)
            ->set('file_folders', $file_folders)
            ->set('folders_tree', $folders_tree)
            ->append_js('module::clients.js')
            ->build('clients');
    }

    public function get_images_in_folder($id, $options = array()) {

        if (isset($options['offset'])){
            $this->db->limit($options['offset']);
        }

        if (isset($options['limit'])){
            $this->db->limit($options['limit']);
        }

        return $this->db
            ->select('files.*')
            ->where('folder_id', $id)
            ->where('files.type', 'i')
            ->get('files')
            ->result();

    }

    public function ajax_select_folder($folder_id){
        //load files model
        $this->load->model('files/file_folders_m');

        $folder = $this->file_folders_m->get($folder_id);

        if (isset($folder->id)){
            $folder->images = $this->get_images_in_folder($folder->id);

            return $this->template->build_json($folder);
        }

        echo FALSE;
    }

    public function save_clients(){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }

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
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }

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
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
        $data = $this->input->post();

        $client = array('manager_uid'=>$data['manager_id']);
        $this->db->where('id', $data['client_id']);
        $this->db->update('survey_clients', $client);
        redirect('survey/clients');
    }

    public function programme_request(){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }

        $client = $this->survey_m->get_client_by_manager_id($this->current_user->id);

        if($this->current_user->group_id == 1){
            $active_request     = get_all_active_requests_for_admin();
            $approved_request   = get_all_approved_requests_for_admin();
        }else{
            $active_request     = get_all_active_requests_for_client($client->id);
            $approved_request   = get_all_approved_requests_for_client($client->id);
        }

        $this->template
            ->title($this->module_details['name'], 'manage users')
            ->set_breadcrumb('Manage Users')
            ->set('active_request', $active_request)
            ->set('approved_request', $approved_request)
            ->set('client', $client)
            ->append_js('module::manage_users.js')
            ->build('programme_request');
    }

    public function approve_new_programme($request_id = ''){
        if($request_id){
            $request = get_programme_request_by_id($request_id);

            $current_participation = get_current_participation_by_user($request->uid);

            $this->db->where('id', $current_participation->id);
            if($this->db->update('survey_participant', array('active' => 0))){
                $new_participation = array(
                    'uid'   => $request->uid,
                    'cid'   => $request->cid,
                    'pid'   => $request->pid
                );

                if($this->db->insert('survey_participant', $new_participation)){

                    $user   = get_user_by_id($request->uid);
                    $client = get_client_by_id($request->cid);
                    $manager = get_manager_by_uni($request->cid);
                    $user_email = array();

                    $user_email['subject']			= Settings::get('site_name') . ' - New Programme Participation Approved'; // No translation needed as this is merely a fallback to Email Template subject
                    $user_email['slug'] 		    = 'new-programme-approved';
                    $user_email['to'] 				= $user->email;
                    $user_email['user_name']        = get_user_full_name($request->uid);
                    $user_email['client_name']      = $client->name;
                    $user_email['manager_name']     = $manager['name'];
                    $user_email['from'] 			= Settings::get('server_email');
                    $user_email['name']				= Settings::get('site_name');
                    $user_email['reply-to']			= Settings::get('contact_email');

                    Events::trigger('email', $user_email, 'array');

                    $this->db->where('id', $request_id);
                    $this->db->update('survey_new_application', array('status' => 0, 'approval_date' => time()));
                }
            }
        }
        redirect('survey/programme_request');
    }

    public function manage_users(){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
        $client = $this->survey_m->get_client_by_manager_id($this->current_user->id);

        $this->template
            ->title($this->module_details['name'], 'manage users')
            ->set('client', $client)
            ->set_breadcrumb('Manage Users')
            ->append_js('module::manage_users.js')
            ->build('manage_users');

    }

    public function get_all_users_ajax(){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
        $client = $this->survey_m->get_client_by_manager_id($this->current_user->id);
        if($this->current_user->group_id == 1){
            $users = $this->survey_m->get_all_users_for_admin();
        }else{
            $users = $this->survey_m->get_all_users_by_client($client->id);
        }

        echo json_encode(array('aaData'=>$users));
        //print_r(array('aaData'=>$users));
    }

    public function activate_user($user_id = '', $active = 0){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
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
        echo $active;
        //redirect('survey/manage_users');
    }

    public function user_survey(){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
        if( $this->session->userdata('all_answered')){
            // redirect to review all page
        }

        $questions      = get_questions_by_survey_id($this->survey->id);

        $answer_data = new stdClass();
        $answer_data->user_id    = $this->current_user->id;
        if($this->attempt){
            $answer_data->attempt_id = $this->attempt->id;
        }else{
            $answer_data->attempt_id = '';
        }

        $answer_data->survey_id  = $this->survey->id;

        $ex_ans = get_existing_answer($answer_data);

        if($this->attempt){
            if( ! $this->attempt->report_ready){
                if($ex_ans){
                    $my_answer = json_decode($ex_ans->answers);
                    if(count((array)$my_answer) == $this->total_questions){
                        $this->db->where('id', $ex_ans->id);
                        $this->db->update('survey_user_answer', array('finished' => 1));
                        redirect('survey/user_review_all');
                    }
                }else{
                    $my_answer = '';
                }
            }else{
                $my_answer = '';
            }
        }else{
            $my_answer = '';
        }





        if( ! $this->session->userdata('question_no')){
            $this->session->set_userdata(array('question_no' => 1));
        }

        $q_no = $this->session->userdata('question_no');



        $this->template
            ->title($this->module_details['name'], 'manage users')
            ->set_breadcrumb('User survey')
            ->set('survey', $this->survey)
            ->set('total_evaluators', $this->total_evaluators)
            ->set('attempt', $this->attempt)
            ->set('total_questions', $this->total_questions)
            ->set('q_no', $q_no)
            ->set('my_answer', $my_answer)
            ->append_css('module::user_survey.css')
            ->append_js('module::user_survey.js')
            ->build('user_survey');
    }

    public function evaluators(){

        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }

        $attempt = get_current_active_attempt_by_user_id($this->current_user->id);
        if($attempt){
            $evaluators     = get_evaluators_by_attempt_id($attempt->id);
        }else{
            $evaluators     = '';
        }

        $this->template
            ->title($this->module_details['name'], 'manage evaluators')
            ->set_breadcrumb('Manage evaluators')
            ->set('evaluators', $evaluators)
            ->set('programme', $this->programme)
            ->set('attempt', $this->attempt)
            ->set('total_evaluators', $this->total_evaluators)
            ->set('allowed_evaluators', $this->allowed_evaluators)
            ->set('attempt_remaining',$this->attempt_remaining)
            ->append_js('module::save_evaluators.js');

        if($this->attempt){
            if($this->attempt->report_ready){
                $this->template->build('no_evaluators');
            }else{
                if($evaluators){
                    $this->template->build('evaluators');
                }else{
                    $this->template->build('no_evaluators');
                }
            }
        }else{
            $this->template->build('no_evaluators');
        }


    }

    public function save_evaluators(){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }

        $data    = json_decode(json_encode($this->input->post()));

        $all_empty      = true;
        $success        = false;
        $total_empty    = 0;
        $missing_fields = false;
        $duplicate_entry= '';
        $data_exist     = '';
        $error          = array();
        $total_entered  = 4;
        $entry          = 0;
        $attempt = get_current_active_attempt_by_user_id($this->current_user->id);
        if($attempt){
            $evaluators = get_evaluators_by_attempt_id($attempt->id);
        }else{
            $evaluators = '';
        }



        foreach($data as $field=>$value){
            if($value){
                $all_empty = false;
                $entry++;

                $field_name = substr($field,0,5);
                if($field_name == 'email'){

                    /*
                    if($evaluators){
                        foreach($evaluators as $ev){
                            if($ev->email == $value){
                                $data_exist = 'Duplicate email address found in existing entry';
                            }
                        }
                    }
                    */

                    if($duplicate_entry == ''){
                        $duplicate_entry = duplicate_entry($field, $value, $data);
                    }

                    if($value){
                        if ( ! filter_var($value, FILTER_VALIDATE_EMAIL)){
                            $error[] = substr($field,6);
                        }

                    }

                }
            }else{
                if($field != 'submit_evaluators'){
                    $total_empty = $total_empty + 1;
                }
            }


        }

        if( ! $evaluators){
            if( ($entry / 3) < 3){
                $total_entered = 2;
            }
        }

        if(($total_empty % 3)!=0){
            $missing_fields = true;
        }

        if(( ! $missing_fields) && ( ! $all_empty) && ($duplicate_entry == '') && ($data_exist == '') && ($total_entered >= 3) && ( ! $error)){
            $attempt = array(
                'user_id'       => $this->current_user->id,
                'programme_id'  => $this->programme->id,
                'survey_id'     => $this->session->userdata('survey_id'),
                'client_id'     => $this->client->id,
                'create_date'   => time(),
            );

            if($this->db->insert('survey_attempt', $attempt)){
                $attempt_id = $this->db->insert_id();

                $this->attempt         = get_current_attempt_by_user_id($this->current_user->id);
                if($this->attempt){
                    $this->total_evaluators   = get_total_evaluators_by_attempt_id($this->attempt->id);
                    $this->session->set_userdata(array('attempt_id' => $this->attempt->id));
                }

                for($i = 1; $i <= $this->allowed_evaluators; $i++){
                    $name   = 'name_'.$i;
                    $email  = 'email_'.$i;
                    $rel    = 'relation_'.$i;
                    if(($data->$name) && ($data->$email) && ($data->$rel)){
                        $evaluator = array(
                            'attempt_id'    => $attempt_id,
                            'name'          => $data->$name,
                            'email'         => $data->$email,
                            'relation'      => $data->$rel,
                            'link_md5'      => md5($attempt_id.$data->$email)
                        );
                        if($this->db->insert('survey_evaluators', $evaluator)){
                            $success = true;
                        }else{
                            $success = false;
                        }
                    }

                }
            }

        }


        echo json_encode(
            array(
                'success'           =>$success,
                'all_empty'         => $all_empty,
                'evaluators'        => $total_entered,
                'missing_fields'    => $missing_fields,
                'duplicate_entry'   => $duplicate_entry,
                'data_exist'        => $data_exist,
                'error'             =>$error
            )
        );
    }

    public function update_evaluators(){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }

        $data    = json_decode(json_encode($this->input->post()));

        $all_empty      = true;
        $success        = false;
        $total_empty    = 0;
        $missing_fields = false;
        $duplicate_entry= '';
        $data_exist     = '';
        $error          = array();
        $total_entered  = 4;
        $evaluators = get_evaluators_by_attempt_id($this->attempt->id);



        foreach($data as $field=>$value){
            if($value){
                $all_empty = false;

                $field_name = substr($field,0,5);
                if($field_name == 'email'){

                    if($evaluators){
                        foreach($evaluators as $ev){
                            if($ev->email == $value){
                                $data_exist = 'Duplicate email address found in existing entry';
                            }
                        }
                    }

                    if($duplicate_entry == ''){
                        $duplicate_entry = duplicate_entry($field, $value, $data);
                    }

                    if($value){
                        if ( ! filter_var($value, FILTER_VALIDATE_EMAIL)){
                            $error[] = substr($field,6);
                        }

                    }

                }
            }else{
                if($field != 'submit_evaluators'){
                    $total_empty = $total_empty + 1;
                }
            }


        }


        if(($total_empty % 3)!=0){
            $missing_fields = true;
        }

        if(( ! $missing_fields) && ( ! $all_empty) && ($duplicate_entry == '') && ($data_exist == '') && ($total_entered >= 3) && ( ! $error)){
            $start = $this->total_evaluators + 1;
            for($i = $start; $i <= $this->allowed_evaluators; $i++){
                $name   = 'name_'.$i;
                $email  = 'email_'.$i;
                $rel    = 'relation_'.$i;
                if(($data->$name) && ($data->$email) && ($data->$rel)){
                    $evaluator = array(
                        'attempt_id'    => $this->attempt->id,
                        'name'          => $data->$name,
                        'email'         => $data->$email,
                        'relation'      => $data->$rel,
                        'link_md5'      => md5($this->attempt->id.$data->$email)
                    );
                    if($this->db->insert('survey_evaluators', $evaluator)){
                        $success = true;
                    }else{
                        $success = false;
                    }
                }

            }

        }

        echo json_encode(
                        array(
                            'success'           =>$success,
                            'all_empty'         => $all_empty,
                            'evaluators'        => $total_entered,
                            'missing_fields'    => $missing_fields,
                            'duplicate_entry'   => $duplicate_entry,
                            'data_exist'        => $data_exist,
                            'error'             =>$error
                        )
                    );
    }

    public function delete_evaluator($id = ''){

        if($id){
            $this->db->delete('survey_evaluators', array('id' => $id));
        }
        redirect('survey/evaluators');
    }

    public function send_email_to_single_evaluator($link = ''){
        if($link){
            if(! $this->current_user->id){
                redirect($this->config->base_url());
                exit();
            }

            $this->attempt = get_current_attempt_by_user_id($this->current_user->id); // reset the attempt
            $evaluator = get_evaluator_by_link($link);

            if($data = $this->input->post()){

                if(generate_email_template_for_evaluator($data,$evaluator)){
                    $mail = array();
                    $mail['slug'] 				= 'email-to-evaluators';
                    $mail['to'] 				= $evaluator->email;
                    $mail['from'] 				= Settings::get('server_email');
                    $mail['name']				= Settings::get('site_name');
                    $mail['reply-to']			= Settings::get('contact_email');

                    Events::trigger('email', $mail, 'array');

                    $this->db->where('id', $evaluator->id);
                    $this->db->update('survey_evaluators', array('re_email_sent' => 1));
                }

                //var_dump($data);
                redirect('survey/send_email_to_evaluators_successful');
            }

            $this->template
                ->title($this->module_details['name'], 'send email to evaluators')
                ->set_breadcrumb('Manage evaluators', '/survey/evaluators' )
                ->set_breadcrumb('Send email')
                ->append_js('module::user_survey.js')
                ->build('send_email_to_evaluators');

        }else{
            redirect($this->config->base_url());
        }
    }

    public function send_email_to_evaluators(){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }

        $this->attempt = get_current_attempt_by_user_id($this->current_user->id); // reset the attempt
        if($this->attempt){
            $this->total_evaluators   = get_total_evaluators_by_attempt_id($this->attempt->id);
            $this->session->set_userdata(array('attempt_id' => $this->attempt->id));
        }

        if($data = $this->input->post()){
            $evaluators =  get_evaluators_by_attempt_id($this->attempt->id);

            foreach($evaluators as $evaluator){
                if(! $evaluator->email_sent){
                    if(generate_email_template_for_evaluator($data,$evaluator)){
                        $mail = array();
                        $mail['slug'] 				= 'email-to-evaluators';
                        $mail['to'] 				= $evaluator->email;
                        $mail['from'] 				= Settings::get('server_email');
                        $mail['name']				= Settings::get('site_name');
                        $mail['reply-to']			= Settings::get('contact_email');

                        Events::trigger('email', $mail, 'array');

                        $this->db->where('id', $evaluator->id);
                        $this->db->update('survey_evaluators', array('email_sent' => 1));
                    }
                }

            }
            //var_dump($data);
            redirect('survey/send_email_to_evaluators_successful');
        }

        $this->template
            ->title($this->module_details['name'], 'send email to evaluators')
            ->set_breadcrumb('Manage evaluators', '/survey/evaluators' )
            ->set_breadcrumb('Send email')
            ->append_js('module::user_survey.js')
            ->build('send_email_to_evaluators');
    }

    public function reports(){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }

        $all_submitted  = true;
        $self_submit    = true;

        if($this->attempt){
            $answer = new stdClass();
            $answer->user_id    = $this->current_user->id;
            $answer->attempt_id = $this->attempt->id;
            $answer->survey_id  = $this->survey->id;

            $my_ans = get_existing_answer($answer);



            if($my_ans){
                if( ! $my_ans->submitted){
                    $all_submitted = false;
                    $self_submit    = false;
                }
            }else{
                $all_submitted  = false;
                $self_submit    = false;
            }


            $evaluators     = get_evaluators_by_attempt_id($this->attempt->id);
            if($evaluators){
                foreach($evaluators as $ev){
                    if( ! $ev->submitted){
                        $all_submitted = false;
                    }
                }
            }else{
                $all_submitted = false;
            }


            if($all_submitted){
                $attempt = array();
                if( ! $this->attempt->finished_date){
                    $attempt['finished_date'] = time();
                }
                if( ! $this->attempt->report_ready){
                    $attempt['report_ready'] = 1;
                }
                if($attempt){
                    $this->db->where('id', $this->attempt->id);
                    $this->db->update('survey_attempt', $attempt);
                }
            }
        }else{
            $all_submitted = false;
        }

        $this->template
            ->title($this->module_details['name'], 'report')
            ->set_breadcrumb('Report')
            ->set('attempt', $this->attempt)
            ->set('all_submitted', $all_submitted)
            ->set('self_submit', $self_submit)
            ->build('report');
    }

    public function report_viewer($attempt_id = ''){

        $base_url = $this->config->base_url();

        $file = $base_url.'reports/'.$attempt_id.'.pdf';
        $found = 1;

        if( ! file_exists('./reports/'.$attempt_id.'.pdf')){
            $found = 0;
        }


        $this->template
            ->title($this->module_details['name'], 'Report')
            ->set_layout('report')
            ->set('attempt_id', $attempt_id)
            ->set('base_url', $this->config->base_url())
            ->set('file', $file)
            ->set('found', $found)
            ->append_css('module::loader.css')
            ->append_js('module::pace.min.js')
            ->build('report_viewer');
    }

    public function view_report($attempt_id = ''){

        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
        $this->load->helper('pdf');
        $this->load->helper('report');
        $this->load->library('session');

        $data = array();

        $data['base_url']   = $this->config->base_url();
        $attempt            = get_current_attempt_by_id($attempt_id);
        $data['attempt']    = $attempt;
        $programme          = get_programme_by_id($attempt->programme_id);
        $data['programme']  = $programme;
        $survey             = get_survey_by_id($attempt->survey_id);
        $data['survey']     = $survey;

        $attempt_update = array();
        if( ! $attempt->finished_date){
            $attempt_update['finished_date'] = time();
        }
        if( ! $attempt->report_ready){
            $attempt_update['report_ready'] = 1;
        }
        if($attempt_update){
            $this->db->where('id', $attempt->id);
            $this->db->update('survey_attempt', $attempt_update);
        }

        $client             = get_client_by_id($attempt->client_id);
        //var_dump($client);
        if($client->logo){
            $logo           = $this->config->base_url().'index.php/files/large/'.$client->logo;
            $this->session->set_userdata(array('logo' => $logo));
        }else{
            $logo           = "";
            $this->session->unset_userdata(array('logo' => $logo ));
        }




        if($this->current_user->group == 'user'){
            $user_id = $this->current_user->id;
        }else{
            $user_id = $attempt->user_id;
        }

        $data['all_attempt']= get_all_attempts_by_user_n_programme($user_id, $programme->id);
        $data['questions']  = get_questions_by_survey_id($survey->id);
        $data['categories'] = json_decode($survey->q_cat);
        $data['user_id']    = $user_id;
        $data['evaluators'] = get_evaluators_by_attempt_id($attempt_id);
        $data['programme']  = get_programme_by_id($attempt->programme_id);

        $answer = new stdClass();
        $answer->user_id = $user_id;
        $answer->attempt_id = $attempt_id;
        $answer->survey_id = $survey->id;
        $answers = get_existing_answer($answer);
        $data['user_answer'] = $answers;
        $data['total_evaluators'] = get_total_evaluators_by_attempt_id($attempt_id);
        $data['total_questions']  = get_total_question_in_survey($survey->id);
        $data['file']             = './reports/'.$attempt_id.'.pdf';
        $data['submitted_evaluators'] = get_submitted_evaluators($attempt_id);

        $this->load->view('pdf', $data);
    }

    public function generate_report($attempt_id = ''){

        $attempt            = get_current_attempt_by_id($attempt_id);
        $data['attempt']    = $attempt;
        $programme          = get_programme_by_id($attempt->programme_id);
        $data['programme']  = $programme;
        $data['survey']     = get_survey_by_id($attempt->survey_id);
        $data['all_attempt']= get_all_attempts_by_user_n_programme($this->current_user->id, $programme->id);

        $this->template
            ->title($this->module_details['name'], 'history')
            ->build('another_report');
    }

    public function history($user_id = ''){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }

        if($this->current_user->group != 'user'){
            if($user_id){
                $user_history   = get_user_answer_history($user_id);
                $user           = get_profile_by_user_id($user_id);
            }
        }else{
            $user_history   = get_user_answer_history($this->current_user->id);
            $user           = get_profile_by_user_id($this->current_user->id);
        }

        $participation      = get_current_participation_by_user($user->user_id);
        $attempt_remaining  = $participation->allowed - get_total_attempts_by_user_n_programme($participation->uid, $participation->pid);

        $this->template
            ->title($this->module_details['name'], 'history')
            ->set_breadcrumb('History')
            ->set('user_history', $user_history)
            ->set('attempt_remaining', $attempt_remaining)
            ->set('user', $user)
            ->build('history');
    }

    public function register_q_no_session(){
        $data = $this->input->post();

        $this->session->set_userdata(array('question_no' => $data['q_no']));

        echo 'session updated!';
    }

    public function user_review_all(){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
        if( ! $this->session->userdata('all_answered')){
            $this->session->set_userdata(array('all_answered' => 1));
        }

        $questions      = get_questions_by_survey_id($this->survey->id);

        $answer_data = new stdClass();
        $answer_data->user_id    = $this->current_user->id;
        $answer_data->attempt_id = $this->attempt->id;
        $answer_data->survey_id  = $this->survey->id;

        $ex_ans = get_existing_answer($answer_data);
        if($this->attempt){
            if( ! $this->attempt->report_ready){
                if($ex_ans){
                    $my_answer = json_decode($ex_ans->answers);
                    if(count((array)$my_answer) == $this->total_questions){
                        $this->db->where('id', $ex_ans->id);
                        $this->db->update('survey_user_answer', array('finished' => 1));
                    }
                }
            }
        }

        $ex_ans = get_existing_answer($answer_data);// re initialisation

        $my_answer = json_decode($ex_ans->answers);

        $this->template
            ->title($this->module_details['name'], 'review answer')
            ->set_breadcrumb('Review')
            ->set('survey', $this->survey)
            ->set('ex_ans', $ex_ans)
            ->set('my_answer', $my_answer)
            ->set('total_questions', $this->total_questions)
            ->append_js('module::user_survey.js')
            ->build('user_review_all');
    }

    public function user_review_single($q_no = '', $q_id = ''){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
        if(($q_no) && ($q_id)){
            $question      = get_question_by_id($q_id);

            $answer_data = new stdClass();
            $answer_data->user_id    = $this->current_user->id;
            $answer_data->attempt_id = $this->attempt->id;
            $answer_data->survey_id  = $this->survey->id;

            $ex_ans = get_existing_answer($answer_data);

            $my_answer = json_decode($ex_ans->answers);

            $this->template
                ->title($this->module_details['name'], 'manage users')
                ->set_breadcrumb('Review single question')
                ->set('q', $question)
                ->set('total_evaluators', $this->total_evaluators)
                ->set('attempt', $this->attempt)
                ->set('total_questions', $this->total_questions)
                ->set('q_no', $q_no)
                ->set('my_answer', $my_answer)
                ->append_css('module::user_survey.css')
                ->append_js('module::user_survey.js')
                ->build('user_survey_single_question');
        }else{
            redirect($this->config->base_url());
        }
    }

    public function user_survey_submit(){
        if(! $this->current_user->id){
            redirect($this->config->base_url());
            exit();
        }
        $data = $this->input->post();
        $answer = new stdClass();
        $answer->user_id    = $data['user_id'];
        $answer->attempt_id = $data['attempt_id'];
        $answer->survey_id  = $data['survey_id'];

        $ex_ans = get_existing_answer($answer);

        $result = array();

        if($ex_ans->finished){
            $result['finished'] = true;
            $this->db->where('id', $ex_ans->id);
            if($this->db->update('survey_user_answer', array('submitted' => 1, 'submit_date' =>time()))){
                $result['updated'] = true;
            }else{
                $result['updated'] = false;
            }
        }else{
            $result['finished'] = false;
        }

        echo json_encode($result);
    }

    public function successful(){
        $this->template
            ->set_layout('user_survey')
            ->title($this->module_details['name'], 'confirmation')
            ->build('user_survey_submit');
    }
    public function send_email_to_evaluators_successful(){
        $this->template
            ->set_layout('user_survey')
            ->title($this->module_details['name'], 'confirmation')
            ->build('user_survey_submit');
    }
    public function successful_submitted_by_evaluator(){
        $this->template
            ->set_layout('user_survey')
            ->title($this->module_details['name'], 'confirmation')
            ->build('evaluator_submit');
    }

    public function update_user_answer(){
        $data = $this->input->post();
        $answer = new stdClass();
        $answer->user_id    = $data['user_id'];
        $answer->attempt_id = $data['attempt_id'];
        $answer->survey_id  = $data['survey_id'];

        $ex_ans = get_existing_answer($answer);

        if($ex_ans){
            // need to update with new answer to existing answer
            $answer->answers    = rebuild_answer($data, $ex_ans->answers);
            $this->db->where('id', $ex_ans->id);
            if($this->db->update('survey_user_answer', $answer)){
                echo 'updated success';
            }else{
                echo json_encode(array('data' => $answer, 'msg'=> $this->db->_error_message()));
            }
        }else{
            // insert new answer
            $answer->start_date = time();
            $answer->answers    = json_encode(array($data['q_id'] => $data['value']));

            if($this->db->insert('survey_user_answer', $answer)){
                echo 'insert success!';
            }else{
                echo $this->db->_error_message();
            }
        }

    }

    public function evaluator_response($link = ''){

        $evaluator = '';
        if($link){
            $this->session->set_userdata(array('link' => $link));
            $evaluator = get_evaluator_by_link($link);
            $this->session->set_userdata(array('evaluator_id' => $evaluator->id));

            $this->attempt  = get_current_attempt_by_id($evaluator->attempt_id);
            $this->survey   = get_survey_by_id($this->attempt->survey_id);

            $this->session->set_userdata(array('attempt_id' => $this->attempt->id));
            $this->session->set_userdata(array('survey_id' => $this->survey->id));
        }


        $this->template
            ->set_layout('evaluator_response')
            ->title($this->module_details['name'], 'evaluator response')
            ->set('evaluator', $evaluator)
            ->build('evaluator_response');
    }
    public function evaluator_survey(){
        $this->attempt  = get_current_attempt_by_id($this->session->userdata('attempt_id'));
        $this->survey   = get_survey_by_id($this->session->userdata('survey_id'));
        $this->total_questions = get_total_question_in_survey($this->survey->id);

        //$questions      = get_questions_by_survey_id($this->survey->id);

        $evaluator = get_evaluator_by_link($this->session->userdata('link'));

        $my_answer = json_decode($evaluator->answers);
        if($my_answer){
            if(count((array)$my_answer) == $this->total_questions){
                $this->db->where('id', $evaluator->id);
                $this->db->update('survey_evaluators', array('finished' => 1));
                redirect('survey/evaluator_review_all');
            }
        }else{
            $this->session->set_userdata(array('question_no' => 1));
        }

        if( ! $this->session->userdata('question_no')){
            $this->session->set_userdata(array('question_no' => 1));
        }

        $q_no = $this->session->userdata('question_no');



        $this->template
            ->set_layout('evaluator_response')
            ->title($this->module_details['name'], 'evaluator response')
            ->set('survey', $this->survey)
            ->set('attempt', $this->attempt)
            ->set('total_questions', $this->total_questions)
            ->set('q_no', $q_no)
            ->set('my_answer', $my_answer)
            ->append_css('module::user_survey.css')
            ->append_js('module::evaluator_survey.js')
            ->build('evaluator_survey');
    }

    public function update_evaluator_answer(){
        if($data = $this->input->post()){
            $evaluator = get_evaluator_by_link($this->session->userdata('link'));
            $ex_ans = $evaluator->answers;

            if($ex_ans){
                // need to update with new answer to existing answer
                $answers    = rebuild_answer($data, $ex_ans);
                $this->db->where('id', $evaluator->id);
                if($this->db->update('survey_evaluators', array('answers' => $answers))){
                    echo 'updated success';
                }else{
                    echo json_encode(array('data' => $answers, 'msg'=> $this->db->_error_message()));
                }
            }else{
                // insert new answer
                $start_date = time();
                $answers    = json_encode(array($data['q_id'] => $data['value']));
                $this->db->where('id', $evaluator->id);
                if($this->db->update('survey_evaluators', array('start_date' => $start_date,'answers' => $answers))){
                    echo 'insert success!';
                }else{
                    echo $this->db->_error_message();
                }
            }
        }
    }

    public function evaluator_review_all(){
        $link   = $this->session->userdata('link');
        $evaluator = get_evaluator_by_link($link);
        $this->attempt  = get_current_attempt_by_id($evaluator->attempt_id);
        $this->survey   = get_survey_by_id($this->attempt->survey_id);
        $this->total_questions = get_total_question_in_survey($this->survey->id);

        $my_answer = json_decode($evaluator->answers);
        if(count((array)$my_answer) == $this->total_questions){
            $this->db->where('id', $evaluator->id);
            $this->db->update('survey_evaluators', array('finished' => 1));
            $evaluator = get_evaluator_by_id($evaluator->id); // reset evaluator
        }

        if( ! $this->session->userdata('all_answered')){
            $this->session->set_userdata(array('all_answered' => 1));
        }

        //$questions      = get_questions_by_survey_id($this->survey->id);

        $this->template
            ->set_layout('evaluator_response')
            ->title($this->module_details['name'], 'review answer')
            ->set_breadcrumb('Review')
            ->set('evaluator', $evaluator)
            ->set('survey', $this->survey)
            ->set('my_answer', $my_answer)
            ->set('total_questions', $this->total_questions)
            ->append_js('module::evaluator_survey.js')
            ->build('evaluator_review_all');
    }

    public function evaluator_review_single($q_no = '', $q_id = ''){
        if(($q_no) && ($q_id)){
            $question      = get_question_by_id($q_id);

            $link   = $this->session->userdata('link');
            $evaluator = get_evaluator_by_link($link);

            $this->attempt  = get_current_attempt_by_id($evaluator->attempt_id);
            $this->survey   = get_survey_by_id($this->attempt->survey_id);

            $my_answer = json_decode($evaluator->answers);
            $this->total_questions = get_total_question_in_survey($this->survey->id);

            $this->template
                ->set_layout('evaluator_response')
                ->title($this->module_details['name'], 'manage users')
                ->set_breadcrumb('Review single question')
                ->set('q', $question)
                ->set('attempt', $this->attempt)
                ->set('total_questions', $this->total_questions)
                ->set('q_no', $q_no)
                ->set('my_answer', $my_answer)
                ->append_css('module::user_survey.css')
                ->append_js('module::evaluator_survey.js')
                ->build('evaluator_survey_single_question');
        }else{
            redirect($this->config->base_url());
        }
    }

    public function evaluator_survey_submit(){

        $link   = $this->session->userdata('link');
        $evaluator = get_evaluator_by_link($link);

        $this->attempt  = get_current_attempt_by_id($evaluator->attempt_id);
        $this->survey   = get_survey_by_id($this->attempt->survey_id);

        $result = array();

        if($evaluator->finished){
            $result['finished'] = true;
            $this->db->where('id', $evaluator->id);
            if($this->db->update('survey_evaluators', array('submitted' => 1, 'submit_date' =>time()))){
                $result['updated'] = true;
            }else{
                $result['updated'] = false;
            }
        }else{
            $result['finished'] = false;
        }

        echo json_encode($result);
    }

    public function get_total_evaluators(){
        echo get_total_evaluators_by_attempt_id($this->attempt->id);
    }

    public function get_category_by_id($id = ''){
        if($id){
            echo json_encode(get_category_by_id($id));
        }
    }

    public function remove_category($survey_id, $cat_id){
        $query  = $this->db->get_where('survey', array('id' =>$survey_id));
        $survey = $query->row();

        $category = json_decode($survey->q_cat, true);
        $new_cat = array();
        $i = 1;
        foreach($category as $key=>$c_no){
            if($c_no != $cat_id){
                $new_cat[$i] = $c_no;
                $i++;
            }
        }

        $this->db->where('id', $survey_id);
        $this->db->update('survey', array('q_cat' => json_encode($new_cat)));
        redirect('survey/questions/'. $survey_id);
    }

    public function new_application(){
        $programmes     = get_all_programme();
        $participation  = get_all_participation($this->current_user->id);
        $application    = get_active_application($this->current_user->id);

        $this->template
            ->title($this->module_details['name'], 'apply for new programme')
            ->set_breadcrumb('Apply for new programme')
            ->set('programmes', $programmes)
            ->set('participation', $participation)
            ->set('client', $this->client)
            ->set('application', $application)
            ->build('new_application');
    }

    public function new_programme_application(){
        if($data = json_decode(json_encode($this->input->post()))){
            $new_programme_id = $data->programme_id;

            $participant = array(
                'uid'   => $this->current_user->id,
                'cid'   => $data->client_id,
                'pid'   => $new_programme_id,
                'create_date' => time()
            );

            if($this->db->insert('survey_new_application', $participant)){

                $manager = get_manager_by_uni($data->client_id);

                $mail = array();
                $mail['subject']			= Settings::get('site_name') . ' - New Programme Application'; // No translation needed as this is merely a fallback to Email Template subject
                $mail['slug'] 				= 'new_programme_approval';
                $mail['to'] 				= $manager['email'];
                $mail['manager_name']       = $manager['name'];
                $mail['from'] 				= Settings::get('server_email');
                $mail['name']				= Settings::get('site_name');
                $mail['reply-to']			= Settings::get('contact_email');

                Events::trigger('email', $mail, 'array');

                redirect('survey/new_application_success_msg');
            }
        }
    }

    public function new_application_success_msg(){
        $this->template
            ->title($this->module_details['name'], 'apply for new programme')
            ->set_breadcrumb('Apply for new programme')
            ->build('new_application_success_msg');
    }

    public function update_attempt_allowed(){
        if($data = json_decode(json_encode($this->input->post()))){
            $user_data = explode('-', $data->user_data);
            $user_id = $user_data[1];

            $participation      = get_current_participation_by_user($user_id);
            $remaining_attempts = $participation->allowed - get_total_attempts_by_user_n_programme($participation->uid, $participation->pid);
            $new_allocation     = $participation->allowed + ($data->value - $remaining_attempts);

            $this->db->where('id', $participation->id);
            if($this->db->update('survey_participant', array('allowed' => $new_allocation))){
                echo '1';
            }else{
                echo '0';
            }

        }
    }

    public function set_logo(){
        if($data = json_decode(json_encode($this->input->post()))){
            $this->db->where('id', $data->client_id );
            if($data->image == 'default'){
                if($this->db->update('survey_clients', array('logo' => ''))){
                    redirect('survey/clients');
                }
            }else{
                if($this->db->update('survey_clients', array('logo' => $data->image))){
                    redirect('survey/clients');
                }
            }

        }
    }

    public function export_user($client_id){
        $this->load->dbutil();
        $this->load->helper('download');
        $sql = "SELECT
                      distinct sp.uid as user_id,
                      pro.first_name as first_name,
                      pro.last_name as last_name,
                      u.email as email,
                      org.name as organisation,
                      pro.cohort as cohort,
                      ifnull(attempt.programme,prog.name) as programme,
                      ifnull(attempt.total_attempt,0) as total_attempt,
                      DATE_FORMAT(pro.created, '%d-%m-%Y') as registration_date
                FROM default_survey_participant  sp
                join default_users u
                on u.id = sp.uid
                join default_profiles pro
                on sp.uid = pro.user_id
                join default_survey_clients org
                on org.id = sp.cid
                join default_survey_programme prog
	            on prog.id = sp.pid
                left join (select attempt.user_id as user_id, attempt.programme_id as prog_id, prog.name as programme, count(attempt.id) as total_attempt
                        from default_survey_programme prog
                    join default_survey_attempt attempt
                    on attempt.programme_id = prog.id
                    group by attempt.user_id, attempt.programme_id) attempt
                on attempt.user_id = sp.uid
                where sp.cid=$client_id";
        $query = $this->db->query($sql);
        $data = $this->dbutil->csv_from_result($query, ',');
        force_download('CSV_Report.csv', $data);
    }
    public function export_all_user(){
        $this->load->dbutil();
        $this->load->helper('download');
        $sql = "SELECT
                      distinct sp.uid as user_id,
                      pro.first_name as first_name,
                      pro.last_name as last_name,
                      u.email as email,
                      org.name as organisation,
                      pro.cohort as cohort,
                      ifnull(attempt.programme,prog.name) as programme,
                      ifnull(attempt.total_attempt,0) as total_attempt,
                      DATE_FORMAT(pro.created, '%d-%m-%Y') as registration_date
                FROM default_survey_participant  sp
                join default_users u
                on u.id = sp.uid
                join default_profiles pro
                on sp.uid = pro.user_id
                join default_survey_clients org
                on org.id = sp.cid
                join default_survey_programme prog
	            on prog.id = sp.pid
                left join (select attempt.user_id as user_id, attempt.programme_id as prog_id, prog.name as programme, count(attempt.id) as total_attempt
                        from default_survey_programme prog
                    join default_survey_attempt attempt
                    on attempt.programme_id = prog.id
                    group by attempt.user_id, attempt.programme_id) attempt
                on attempt.user_id = sp.uid
                ";
        $query = $this->db->query($sql);
        $data = $this->dbutil->csv_from_result($query, ',');
        force_download('CSV_Report.csv', $data);
    }
}