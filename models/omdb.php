<?PHP

class Omdb extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get_search( $term )
    {
    	/* get the api content here */
    	return file_get_contents('http://www.omdbapi.com/?s='.$term);
 		
	}

	function get_movie_data( $imdbid )
    {
    	/* get the api content here */
 		return file_get_contents('http://www.omdbapi.com/?plot=full&i='.$imdbid);
 		/* lets see how everything goes :) */
	}

}

?>