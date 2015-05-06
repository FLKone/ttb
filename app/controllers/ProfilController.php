<?php

class ProfilController extends Controller {

  public function view()
    {
        $CR = new CR($this->db);
        $myCr = $CR->byUserName($this->f3->get('PARAMS.name'));

        foreach ($myCr as $subKey  => $subArray) {
            if ($subArray["username"] != htmlentities("Profil supprimé")) {
                unset($myCr[$subKey ]);
            }
        }

        $this->f3->set('list_cr', $myCr);

        $Stream = new Stream($this->db);
        $this->f3->set('list_stream', $myStream = $Stream->byUserName($this->f3->get('PARAMS.name')));

        if (!count($myCr) && !count($myStream) ) {
          $this->f3->error(404);
          //$this->f3->reroute('@home');
        }

        $this->f3->set('site_title','Les CRs, Streams, Actus de '.$this->f3->get('PARAMS.name').' | thetartuffebay.org');
        $this->f3->set('view','profil/view.htm');

  }

}
