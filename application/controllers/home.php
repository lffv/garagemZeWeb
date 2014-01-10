<?php

class Home extends CI_Controller{
	
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

	public function index(){
		
		$this->dados["categorias"] = $this->recebeCategorias();
		$this->dados["destaques"] = $this->Bd->getRandomDestaques();
		$this->load->view('home',$this->dados);

	}
	
	public function autenticaruser(){
		
		$up=$this->input->post('nuser');
		
		if(!$up) die();
		
		$user = $this->Bd->getUtilizador($up);
		
		$p["res"]=0;
		$p["nome"]="";
		
		if(count($user)==1){

			$z = $user[0];
			
			if(md5($this->input->post('puser')) == $z->P){
			
				$this->session->set_userdata('u', $z->U);
				$this->session->set_userdata('nu', $z->NU);
				$this->session->set_userdata('dn', $z->DN);
				$this->session->set_userdata('m', $z->M);
				$this->session->set_userdata('f', $z->F);
				$this->session->set_userdata('cp', $z->CP);
				$this->session->set_userdata('e', $z->E);
				
				$p["res"]=1;
				$p["nome"]=$z->NU;
				$p["feedback"]=$this->Bd->getFeedbackUtilizador($z->U);
			
			}
		
		}
		
		echo json_encode($p);

	}
	
	public function janelaregisto(){
		
		$p["distritos"]=$this->Bd->getDistritos();
		$this->load->view('janelaregisto',$p);

	}

	public function janeladetutilizador($u){
		
		$uti = $this->Bd->getDetalhesUtilizador($u);
		
		if(empty($uti))
			echo 'Erro: Utilizador não encontrado';
		else{
			$p["uti"] = $uti[0];
			$this->load->view('janelaDetUtilizador',$p);
		}

	}
	
	public function janelaaddanuncio(){
		
		$passar["categorias"] = $this->recebeCategorias();
		
		$this->load->view('janelaAddAnuncio', $passar);
				
	}
	
	/*
		-1: Sucesso
		-2: Erro de entrada na função
		 1: Erro do Oracle, duplicate key: Username já existe
		 x: Erro do Trigger, email já existe
	*/
	public function insereuser(){
		
		if(!$this->input->post("usern")){ $p["res"] = -2; echo json_encode($p); }
		else {
			
			$dados = array(
				"uname" => $this->input->post("usern"),
				"nome" => $this->input->post("unuser"),
				"euser" => $this->input->post("euser"),
				"passu" => $this->input->post("puser1"),
				"dnuser" => $this->input->post("dnuser"),
				"muser" => $this->input->post("muser"),
				"fruser" => $this->input->post("fruser"),
				"cpuser" => $this->input->post("cpuser")
			);
			
			$p["res"] = $this->Bd->insereUtilizador($dados);
			
			echo json_encode($p);
		
		}
		
	}
	
	public function jsonconcelhos(){
		echo json_encode($this->Bd->getConcelhos($this->input->get('d')));		
	} 
	
	public function jsonfreguesias(){
		echo json_encode($this->Bd->getFreguesias($this->input->get('c')));		
	}
	
	public function loadtabelacategorias($cat=""){
		
		$page = 1;
		$rp = 15;
		$sortname = $sortorder = $qtype = $query = "";

		// Recebe os parametros da tabela
		if ($this->input->post('page')) $page = $this->input->post('page');
		if ($this->input->post('sortname')) $sortname = $this->input->post('sortname');
		if ($this->input->post('sortorder')) $sortorder = $this->input->post('sortorder');
		if ($this->input->post('qtype')) $qtype = $this->input->post('qtype');
		if ($this->input->post('query')) $query = $this->input->post('query');
		if ($this->input->post('rp')) $rp = $this->input->post('rp');

		$dados = array();
		$dados['page'] = $page; // O numero da página

		$tmp = $this->Bd->getAnunciosByCategoria(
				$cat,
				$sortname,
				$sortorder,
				$qtype,
				$query,
				(($page-1)*$rp)+1, // Inicio
				(($page-1)*$rp)+$rp // Fim
			);

		$dados['total'] = isset($tmp["conta"]) ? $tmp["conta"] : 0;
		$anuncios = isset($tmp["dados"]) ? $tmp["dados"] : array();		

		$dados['rows'] = array(); 

		foreach($anuncios as $a){
			
			if($a->E==2) $estado = 'Terminado';
			else{
				$exp = strtotime(str_replace(".", "-", $a->DF)) < strtotime(date("y-m-d"));
				if($exp) $estado = "Expirado";
				else{
					if($a->E==0) $estado = 'Em curso';
					elseif($a->E==1) $estado = 'Em leilão';
					else $estado = "";
				}
			}

			$tit = '<a href="'.base_url().'detailsanuncio/index/'.$a->A.'">'.$a->T.'</a>';

			$dados['rows'][] = array(
				'id' => $a->A,
				'cell' => array($a->A,$tit,$a->NU, $a->P, $estado)
			);

		}
		
		echo json_encode($dados);
		
	}
	
	public function logout(){
		
		$this->session->unset_userdata('u', $z->U);
		$this->session->unset_userdata('nu', $z->NU);
		$this->session->unset_userdata('dn', $z->DN);
		$this->session->unset_userdata('m', $z->M);
		$this->session->unset_userdata('f', $z->F);
		$this->session->unset_userdata('cp', $z->CP);
		$this->session->unset_userdata('e', $z->E);
		
		redirect("./home");
		
	}
	
	public function fazinteresse(){

		if(!$this->dados["temLogin"]) die("-1");
		/*
		 * -1: Sem login feito
		 * -2: Não estava interessado e passou a estar
		 * -3: Estava e deixou de estar
		 * > 0 Erro do oracle que disparou
		 */
		echo $this->Bd->interesse($this->dados["dadosUser"]["u"],$this->input->post('an'));

	}

	public function compraranuncio(){

		if(!$this->dados["temLogin"]) die("-1");

		echo $this->Bd->comprarAnuncio($this->dados["dadosUser"]["u"],
					$this->input->post('an'),
					$this->input->post('mp')
			  );
	}
	
	public function licitaranuncio(){

		if(!$this->dados["temLogin"]) die("-1");

		echo $this->Bd->licitarAnuncio($this->dados["dadosUser"]["u"],
					$this->input->post('pr'),
					$this->input->post('an'),
					$this->input->post('mp')
			  );
	}

}

?>
