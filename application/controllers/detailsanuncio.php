<?php
class DetailsAnuncio extends CI_Controller{

	var $dados;
	
	/*
	 * Estado do Anuncio:
	 * 
	 * 0 -> a decorrer
	 * 1 -> com pelo menos uma licitação (entrou em leilão)
	 * 2 -> vendido
	 */
	 
	/*
	 * Métodos de Pagamento:
	 * 
	 * 1 -> Carteira
	 * 2 -> Outros
	 * 
	 */

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
			
		$anuncio = $this->Bd->getAnuncio($d);

		if(empty($anuncio)){
			echo 'O Anuncio não foi encontrado!<br />Será redirecionado para a página principal';
			$this->output->set_header('refresh:3; url="'.base_url().'"');
		}else{
			
			if(!$this->dados["temLogin"]){
				$this->dados["temInteresse"] = false;
			}else{
				$this->dados["temInteresse"] = $this->Bd->temInteresse($this->dados["dadosUser"]["u"],$d);
			}
			
			$this->dados["an"] = $anuncio[0];

			// Se estiver em leilão, vai buscar a ultima licitação
			if($anuncio[0]->E==1)
				$this->dados["lic"] = $this->Bd->getUltimaLicitacao($d);
			else
				$this->dados["lic"] = "0.00";
			
			$this->dados["categorias"] = $this->recebeCategorias();
			$this->load->view('detailsAnuncio', $this->dados);
		
		}

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
