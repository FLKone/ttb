<?php

class HomeController extends Controller {

	public function index()
    {
        $CRs = new CR($this->db);
        $Actus = new Actu($this->db);
        $Streams = new Stream($this->db);

        $this->f3->set('actus',$Actus->all(10));
        $this->f3->set('streams',$Streams->find());
        $this->f3->set('crs',$CRs->all());

        $this->f3->set('page_head','Le premier site d\'information des tartuffes :o');
        $this->f3->set('view','home.htm');
	}

}
