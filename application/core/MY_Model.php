<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Base Model
 * 
 * @package CI-Beam
 * @category Model
 * @author Ardi Soebrata
 * 
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 * @property CI_Input $input
 * 
 */
class MY_Model extends CI_Model
{
	protected $table;
	protected $id_field = 'id';
	protected $default_sort_field = '';
	protected $default_sort_order = '';
	
	protected $filter_fields = array();
	
	protected $ci;
	
	function __construct()
	{
		parent::__construct();
		$this->ci =& get_instance();
	}
	
	/**
	 * Insert data to table
	 * 
	 * @param array $data
	 * @return boolean
	 */
	function insert($data)
	{
		unset($data[$this->id_field]);
		return $this->db->insert($this->table, $data);
	}
	
	/**
	 * Update data to table
	 * 
	 * @param mixed $id
	 * @param array $data
	 * @return boolean
	 */
	function update($id, $data)
	{
		return $this->db->update($this->table, $data, array($this->id_field => $id));
	}
	
	/**
	 * Delete data from table
	 * 
	 * @param mixed $id
	 * @return boolean
	 */
	function delete($id)
	{
		return $this->db->delete($this->table, array($this->id_field => $id));
	}
	
	/**
	 * Get data by id
	 * 
	 * @param mixed $id
	 * @return object/boolean
	 */
	function get_by_id($id)
	{
		//$this->prep_query();
		$query = $this->db->get_where($this->table, array($this->table . '.' . $this->id_field => $id));
		if ($query->num_rows() > 0)
			return $query->row();
		else
			return FALSE;
	}
	
	/**
	 * Get data by id
	 * 
	 * @param mixed $id
	 * @return object/boolean
	 */
	function get_all($limit = 0, $offset = 0)
	{
		$this->prep_query();
		if ($this->default_sort_field != "") {
			$sort = $this->default_sort_order;
			if ($this->default_sort_order == "") {
				$sort = "ASC";
			}
			$this->db->order_by($this->default_sort_field,$sort);
		}
		if ($limit != 0) {
			$query = $this->db->get($this->table, $limit, $offset);
		}
		else {
			$query = $this->db->get($this->table);
		}
		if ($query->num_rows() > 0)
			return $query->result();
		else
			return FALSE;
	}
	
	/**
	 * Get list of data from table
	 * Automatically create Pagination Class if base_url is not empty.
	 * 
	 * @return array
	 */
	function get_list($base_url = '', $limit = 0, $offset = 0)
	{
		// If base_url is empty, list all data.
		if (empty($base_url))
			return $this->db->get($this->table)->result();
		else
		{
			$this->load->library('pagination');
			
			// Set pagination limit
			if (empty($limit) && $limit != 0)
			{
				if ($this->input->get('page_limit'))
					$limit = (int) $this->input->get('page_limit');
				else
					$limit = $this->config->item('rows_limit');
			}
			
			// Set pagination offset
			if (empty($offset))
			{
				if ($this->pagination->page_query_string)
					$offset = (int) $this->input->get($this->pagination->query_string_segment);
				else
					$offset = $this->uri->segment(4);
			}
			if ($this->pagination->use_page_numbers && ($offset > 0))
				$offset = ($offset - 1) * $limit;
			
			// Set base_url, 
			if ($this->pagination->page_query_string)
			{
				if (strpos($base_url, '?') === FALSE)
					$base_url .= '?';
			}
			
			// Get number of rows
			$row_counts = $this->get_row_count();

			// Create pagination
			$expl = explode("#",$base_url);

			$base_url = $expl[0];
			if ($expl[1] != "") {
				$config["suffix"] = "#".$expl[1];
			}

			$config['base_url']		= $base_url;
			$config['total_rows']	= $row_counts;
			$config['per_page']		= $limit;
			$this->pagination->initialize($config);
			
			// Execute query
			$this->prep_query();
			$this->prep_filters();
			$this->prep_sorters();
			if ($limit != 0) {
				$query = $this->db->get($this->table, $limit, $offset);
			}
			else {
				$query = $this->db->get($this->table);
			}
			return $query->result();
		}
	}
	
	function prep_query()
	{
		
	}
	
	/**
	 * Get all filter fields.
	 * @return array();
	 */
	function get_filter_fields()
	{
		return $this->filter_fields;
	}
	
	/**
	 * Set all filter fields.
	 * @param array Array of field names. 
	 */
	function set_filter_fields($fields)
	{
		$this->filter_fields = $fields;
	}
	
	/**
	 * Add a filter field to filter fields list.
	 * @param array Field name to add. 
	 */
	function add_filter_field($filter)
	{
		if (! is_array($filter)) return FALSE;
		$this->filter_fields = array_merge($this->filter_fields, $filter);
	}
	
	/**
	 * Remove a field name from filter fields.
	 * @param string Field name to remove.
	 */
	function remove_fitler_field($field_name)
	{
		$key = array_search($field_name, $this->filter_fields);
		if ($key)
			unset($this->filter_fields[$key]);
	}

	/**
	 * Prepare sql for filters, by getting the filter list from GET or using $filters param if specified.
	 * 
	 * @param string Array of filter fields and it's values.
	 */
	function prep_filters($filters = array())
	{
		// If $filters param is not specified, use input GET.
		if (!is_array($filters) || count($filters) == 0)
		{
			foreach($this->filter_fields as $field => $operator)
			{
				$value = $this->input->get($field);
				if (!$value)
					$value = $this->input->get(str_replace ('.', '_', $field));
				if ($value)
					$filters[$field] = $value;
			}
		}
		
		// Add filter to db.
		foreach ($this->filter_fields as $field => $operator)
		{
			if (isset($filters[$field]))
				if ($operator == 'LIKE')
					$this->db->like($field, $filters[$field]);
				else
					$this->db->where($field, $filters[$field]);
		}
	}
	
	/**
	 * Get row count.
	 * 
	 * Please set additional where and grouping statements before calling this function.
	 * 
	 * @param array $filters Array of filters.
	 * @return int Number of row.
	 */
	function get_row_count($filters = array(), $table_name = NULL)
	{
		$this->prep_query();
		$this->prep_filters($filters);
		
		if (is_string($table_name))
			$this->db->from($table_name);
		else
			$this->db->from($this->table);
		
		return $this->db->count_all_results();
	}
	
	/**
	 * Prepare sql for sorter, by getting the sorter from GET or using $sort_string param if GET is not specified.
	 * 
	 * @param string SQL order statement.
	 */
	function prep_sorters($sort_string = '')
	{
		$sort_by = $this->input->get($this->config->item('sort_by_query_string'));
		$sort_order = $this->input->get($this->config->item('sort_order_query_string'));

		// If input GET is not specified, use $sort_string param.
		if ($sort_by)
		{
			if (! $sort_order) $sort_order = 'asc';
			$this->db->order_by($sort_by, $sort_order);
		}
		elseif (!empty($sort_string))
			$this->db->order_by($sort_string);
		elseif (!empty($this->default_sort_field))
		{
			if (!empty($this->default_sort_order))
				$this->db->order_by($this->default_sort_field, $this->default_sort_order);
			else
				$this->db->order_by($this->default_sort_field);
		}
	}

	function find_row($url, $filters, $limit, $offset){
		$this->filters = $filters;

		return $this->get_list($url, $limit, $offset);
	}
}