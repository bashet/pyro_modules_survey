<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a survey module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	survey Module
 */
class Admin extends Admin_Controller
{
	protected $section = 'items';

	public function __construct()
	{
		parent::__construct();

		// Load all the required classes
		$this->load->model('survey_m');
		$this->load->library('form_validation');
		$this->lang->load('survey');

		// Set the validation rules
		$this->item_validation_rules = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'trim|max_length[100]|required'
			),
			array(
				'field' => 'slug',
				'label' => 'Slug',
				'rules' => 'trim|max_length[100]|required'
			)
		);

		// We'll set the partials and metadata here since they're used everywhere
		$this->template->append_js('module::admin.js')
						->append_css('module::admin.css');
	}

	/**
	 * List all items
	 */
	public function index()
	{
		// here we use MY_Model's get_all() method to fetch everything
		$items = $this->survey_m->get_all();

		// Build the view with survey/views/admin/items.php
		$this->template
			->title($this->module_details['name'])
			->set('items', $items)
			->build('admin/items');
	}

	public function create()
	{
		// Set the validation rules from the array above
		$this->form_validation->set_rules($this->item_validation_rules);

		// check if the form validation passed
		if ($this->form_validation->run())
		{
			// See if the model can create the record
			if ($this->survey_m->create($this->input->post()))
			{
				// All good...
				$this->session->set_flashdata('success', lang('survey.success'));
				redirect('admin/survey');
			}
			// Something went wrong. Show them an error
			else
			{
				$this->session->set_flashdata('error', lang('survey.error'));
				redirect('admin/survey/create');
			}
		}
		
		$survey = new stdClass;
		foreach ($this->item_validation_rules as $rule)
		{
			$survey->{$rule['field']} = $this->input->post($rule['field']);
		}

		// Build the view using survey/views/admin/form.php
		$this->template
			->title($this->module_details['name'], lang('survey.new_item'))
			->set('survey', $survey)
			->build('admin/form');
	}
	
	public function edit($id = 0)
	{
		$survey = $this->survey_m->get($id);

		// Set the validation rules from the array above
		$this->form_validation->set_rules($this->item_validation_rules);

		// check if the form validation passed
		if ($this->form_validation->run())
		{
			// get rid of the btnAction item that tells us which button was clicked.
			// If we don't unset it MY_Model will try to insert it
			unset($_POST['btnAction']);
			
			// See if the model can create the record
			if ($this->survey_m->update($id, $this->input->post()))
			{
				// All good...
				$this->session->set_flashdata('success', lang('survey.success'));
				redirect('admin/survey');
			}
			// Something went wrong. Show them an error
			else
			{
				$this->session->set_flashdata('error', lang('survey.error'));
				redirect('admin/survey/create');
			}
		}

		// Build the view using survey/views/admin/form.php
		$this->template
			->title($this->module_details['name'], lang('survey.edit'))
			->set('survey', $survey)
			->build('admin/form');
	}
	
	public function delete($id = 0)
	{
		// make sure the button was clicked and that there is an array of ids
		if (isset($_POST['btnAction']) AND is_array($_POST['action_to']))
		{
			// pass the ids and let MY_Model delete the items
			$this->survey_m->delete_many($this->input->post('action_to'));
		}
		elseif (is_numeric($id))
		{
			// they just clicked the link so we'll delete that one
			$this->survey_m->delete($id);
		}
		redirect('admin/survey');
	}
}
