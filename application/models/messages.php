<?PHP

class Messages extends CI_Model {

	function get($id, $first_entry = FALSE, $last_entry = FALSE)
	{
		//Get the list of messages entries for a user
		$sql = "SELECT " . $this->db->messages_table . ".*, " . $this->db->user_table . ".name";
		$sql .= " FROM " . $this->db->messages_table;
		$sql .= " LEFT JOIN " . $this->db->user_table . " ON " . $this->db->messages_table . ".writer_id = " . $this->db->user_table . ".id";
		$sql .= " WHERE user_id = '" . $id . "'";
		$sql .= " GROUP BY " . $this->db->messages_table . ".id";
		$sql .= " ORDER BY time DESC";
		$sql .= " LIMIT " . $first_entry . "," . $last_entry;
		
		$messages_result = $this->db->query($sql);
		$messages = $messages_result->result_array();
		$messages['num_rows'] = $messages_result->num_rows();

		return $messages;
	}

	function create($entry)
	{
		$this->db->insert($this->db->messages_table, $entry);
		
		$sql = "SELECT " . $this->db->messages_table . ".*, " . $this->db->user_table . ".name";
		$sql .= " FROM " . $this->db->messages_table;
		$sql .= " LEFT JOIN " . $this->db->user_table . " ON " . $this->db->messages_table . ".writer_id = " . $this->db->user_table . ".id";
		$sql .= " ORDER BY id DESC";
		$sql .= " LIMIT 1";
		
		$new_entry = $this->db->query($sql)->row_array();
		
		return $new_entry;
	}

	function erase($id, $user_id)
	{
		$this->db->select('id, user_id, writer_id');
		$this->db->where('id', $id);
		$messages = $this->db->get($this->db->messages_table);
		$entry = $messages->row_array();

		if ($messages->num_rows() > 0 && ($user_id === $entry['user_id'] || $user_id === $entry['writer_id']))
		{
			$deletes = array('id' => $id);
			$this->db->delete($this->db->messages_table, $deletes);
		}
		else
		{
			return FALSE;
		}
	}
	
}

/* End of file messages.php */
/* Location: ./application/models/messages.php */