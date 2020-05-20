<?PHP

class News extends CI_Model {

	function get($id = FALSE, $first_entry = FALSE, $last_entry = FALSE)
	{
		if (! isset($id) || $id == 'list')
		{
			//Get a list of news
			$news_query = 'SELECT *, UNIX_TIMESTAMP(time) AS unix_time FROM `' . $this->db->news_table . '` ORDER BY unix_time DESC LIMIT ' . $first_entry . ', ' . $last_entry;
			$news = $this->db->query($news_query);
			$news = $news->result_array();
			
			for ($x = 0; $x < count($news); $x++)
			{
				$news[$x]['entry'] = explode("\n\n", $news[$x]['entry']);
			}
			
			$news['num_rows'] = $this->db->count_all($this->db->news_table);
		}
		elseif ($id == 'rss')
		{
			//Get a list of news for RSS
			$news_query = 'SELECT *, UNIX_TIMESTAMP(time) AS unix_time FROM `' . $this->db->news_table . '` ORDER BY unix_time DESC LIMIT 10';
			$news = $this->db->query($news_query);
			$news = $news->result_array();
		}
		else
		{
			//Get a single news entry
			$news_query = 'SELECT *, UNIX_TIMESTAMP(time) AS unix_time FROM `' . $this->db->news_table . '` WHERE id = ' . $id;
			$news = $this->db->query($news_query);
			$news = $news->row_array();
		}
		
		return $news;
	}

	function create($news)
	{
		//Write the new news entry
		$this->db->insert($this->db->news_table, $news);
		
		//Get all info about this new entry from the DB to help the AJAX render it
		$this->db->select('*, UNIX_TIMESTAMP(time) as unix_time');
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$new_entry = $this->db->get($this->db->news_table);
		
		$new_entry = $new_entry->row_array();
		$new_entry['time'] = date('jS F, Y', $new_entry['unix_time']);
		$new_entry['entries'] = explode("\n\n", $new_entry['entry']);
		
		$output = '
			<section id="entry-' . $new_entry['id'] . '">
				<h3>' . $new_entry['time'] . '</h3>
				<ul>
		';
				
		foreach ($new_entry['entries'] as $this_entry)
		{
			$output .= '<li>' . $this_entry . '</li>';
		}

		$output .= '
				</ul>
				
				<p style="padding-left: 1em;">
					<a class="ajaxJSON" href="' . base_url('about/edit_news/' . $new_entry['id']) . '"><img src="' . base_url('assets/images/icons/edit.png') . '" width="16"></a>
					<a class="ajaxJSON" rel="Are you sure you want to delete this?" href="' . base_url('about/erase_news/' . $new_entry['id']) . '"><img src="' . base_url('assets/images/icons/erase.png') . '" width="16"></a>
				</p>
			</section>
		';
		
		return $output;
	}
	
	function update($id, $changes)
	{
		$this->db->where('id', $id);
		$this->db->update($this->db->news_table, $changes);
	}
	
	function erase($id)
	{
		$erase_id = array('id' => $id);
		$this->db->delete($this->db->news_table, $erase_id);
	}
	
}

/* End of file news.php */
/* Location: ./application/models/news.php */