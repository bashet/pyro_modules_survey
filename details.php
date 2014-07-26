<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_survey extends Module {

	public $version = '1.0.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'survey'
			),
			'description' => array(
				'en' => 'This module is built for IOE only.'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'content', // You can also place modules in their top level menu. For example try: 'menu' => 'survey',
			'sections' => array(
				'items' => array(
					'name' 	=> 'survey:items', // These are translated from your language file
					'uri' 	=> 'admin/survey',
						'shortcuts' => array(
							'create' => array(
								'name' 	=> 'survey:create',
								'uri' 	=> 'admin/survey/create',
								'class' => 'add'
								)
							)
						)
				)
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('survey');
		$this->db->delete('settings', array('module' => 'survey'));

		$survey = array(
                        'id' => array(
									  'type' => 'INT',
									  'constraint' => '11',
									  'auto_increment' => TRUE
									  ),
						'name' => array(
										'type' => 'VARCHAR',
										'constraint' => '100'
										),
						'slug' => array(
										'type' => 'VARCHAR',
										'constraint' => '100'
										)
						);

		$survey_setting = array(
			'slug' => 'survey_setting',
			'title' => 'Allowed Evaluators',
			'description' => 'Please specify the allowed max number of evaluators',
			'`default`' => '1',
			'`value`' => '1',
			'type' => 'select',
			'`options`' => '1=Yes|0=No',
			'is_required' => 1,
			'is_gui' => 1,
			'module' => 'survey'
		);

		$this->dbforge->add_field($survey);
		$this->dbforge->add_key('id', TRUE);

		if($this->dbforge->create_table('survey') AND
		   $this->db->insert('settings', $survey_setting) AND
		   is_dir($this->upload_path.'survey') OR @mkdir($this->upload_path.'survey',0777,TRUE))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('survey');
		$this->db->delete('settings', array('module' => 'survey'));
		{
			return TRUE;
		}
	}


	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}
}
/* End of file details.php */
