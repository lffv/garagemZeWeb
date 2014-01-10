<?php
class DetailsCategoria extends CI_Controller{

	var $dados;
	
	public function __construct(){
        parent::__construct();
		
		$this->dados = array();
		
		$this->dados["temLogin"] = $this->session->userdata('u') ? 1 : 0;
		
		if($this->dados["temLogin"]){
			$this->dados["dadosUser"] = array(
				"u" => $this->session->userdata('u'),
				"nu" => $this->session->userdata('nu'),
				"dn" => $this->session->userdata('dn'),
				"m" => $this->session->userdata('m'),
				"f" => $this->session->userdata('f'),
				"cp" => $this->session->userdata('cp'),
				"e" => $this->session->userdata('e'),
				"feedback" => $this->Bd->getFeedbackUtilizador($this->session->userdata('u'))
			);
		}

	}

	public function index($d=0){
		
		$this->dados["categorias"] = $this->recebeCategorias();
		$this->load->view('detailsCategoria', $this->dados);

	}
	
	private function recebeCategorias(){
		
		$cat = $this->Bd->getCategorias();
		$cat2 = $cat;
		
		$catorg = array();
		
		foreach($cat as $c){		
			
			$catorg[$c->C]["nome"] = $c->NC;
			$catorg[$c->C]["filhos"] = array();

			foreach($cat2 as $c2){
				if($c2->PC == $c->C){
					$catorg[$c->C]["filhos"][$c2->C] = $c2->NC;
				}
			}
			
			if(empty($catorg[$c->C]["filhos"])) unset($catorg[$c->C]);
			
		}
		
		return $catorg;
		
	}

}

?>
