<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a survey module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	survey Module
 */
class survey extends Public_Controller
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
        $dpt = $this->survey_m->get_all_dtp();

        $this->load->view('survey',array('dpt'=>$dpt));
	}

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

    public function delete_dpt($id = ''){

        $this->db->delete('survey_dpt', array('id' => $id));
        redirect('survey/dpt');
    }

    public function peers(){
        $this->load->view('peers');
    }
}