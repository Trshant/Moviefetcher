<?php
class Api extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('dbcache');
        $this->load->model('omdb');
    }

    public function movie($id)
    {
    	$data = $this->dbcache->get_movie_data( $id );
    	if( count($data) != 0){ 
			echo $data[0]->response;
			exit;
		}
    	if( count($data) == 0){
    		$data = $this->omdb->get_movie_data( $id ) ;
    		$this->dbcache->save_movie_data( $id , $data ) ;
    		echo $data;
    	}
    }

    public function search($term)
    {    	
        $data = $this->dbcache->get_search( $term ) ;
        if( count($data) != 0){ 
			echo $data[0]->response;
			exit;
		}
    	if( count($data) == 0){
    		$data = $this->omdb->get_search( $term ) ;
       		$this->dbcache->save_search( $term , $data ) ;
       		echo $data ;
    	}
        //echo json_encode( $data ) ;
        
    }


}
?> 
