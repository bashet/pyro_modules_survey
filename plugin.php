<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a survey module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	survey Module
 */
class Plugin_survey extends Plugin
{
	/**
	 * Item List
	 * Usage:
	 * 
	 * {{ survey:items limit="5" order="asc" }}
	 *      {{ id }} {{ name }} {{ slug }}
	 * {{ /survey:items }}
	 *
	 * @return	array
	 */
	function items()
	{
		$limit = $this->attribute('limit');
		$order = $this->attribute('order');
		
		return $this->db->order_by('name', $order)
						->limit($limit)
						->get('survey_items')
						->result_array();
	}

    function clients(){
        $query = $this->db->get_where('survey_clients', array('active'=>1));

        return $query->result();
    }

    function get_programme_info(){
        return 'This programme information';
    }

    /*function get_survey_name_by_id($id){
        $query = $this->db->get_where('survey', array('id' => $id));
        $row = $query->row();
        if($row){
            return $row->name;
        }else{
            return '';
        }
    }*/
}

/* End of file plugin.php */