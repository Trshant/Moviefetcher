<?php
class Products extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('dbcache');
        $this->load->model('omdb');
    }

    public function shoes($sandals, $id)
    {
        echo $sandals;
        echo $id;
    }

    public function movie($id)
    {
    	$data = $this->dbcache->get_movie_data( $id );
    	echo '<br/>in db'; var_dump( $data ); echo count($data) ;
    	if( count($data) == 0){
    		$data = $this->omdb->get_movie_data( $id ) ;
    		echo '<br/>in online'; var_dump( $data );
    		$this->dbcache->save_movie_data( $id , $data ) ;
    	}
        var_dump($data);
    }

    public function show($id)
    {	
    	echo $id ;
        var_dump( $data = $this->omdb->get_search( $id ) ) ;
    }
}
?> 