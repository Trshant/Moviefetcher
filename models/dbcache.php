<?PHP

class Dbcache extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_search( $term )
    {
    	/* get the api content here */
    	$query = $this->db->get_where('search', array('term' => $term) );
    	return $query->result();
 		
	}

	function save_search( $term , $response ){
		/* save the data to the database */
		$data = array();
		$data["term"] = $term ;
		$data["response"] = $response ;
		$this->db->insert('search', $data);

	}

	function get_movie_data( $imdbid )
    {
    	/* get the api content here */
    	$query = $this->db->get_where('movie', array('imdbid' => $imdbid) );
    	return $query->result();
 		
	}

	function save_movie_data( $imdbid , $response ){
		/* save the data to the database */
		$data = array();
		$data["imdbid"] = $imdbid ;
		$data["response"] = $response ;
		$this->db->insert('movie', $data);
	}

}

?>
