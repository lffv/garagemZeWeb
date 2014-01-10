<?php
class AreaPessoal extends CI_Controller{

	var $dados;

	public function __construct(){
        parent::__construct();
		
		$this->dados= array();
		
		$this->dados["temLogin"] = $this->session->userdata('u') ? 1 : 0;
		
		if($this->dados["temLogin"]){
			
			$nomef = $this->Bd->getFreguesiasByID($this->session->userdata('f'));
			
			$this->dados["dadosUser"] = array(				
				
				"u" => $this->session->userdata('u'),
				"nu" => $this->session->userdata('nu'),
				"dn" => $this->session->userdata('dn'),
				"m" => $this->session->userdata('m'),
				"f" => $this->session->userdata('f'),
				"nomef" => (count($nomef)==1) ? $nomef[0]->NF : "",
				"cp" => $this->session->userdata('cp'),
				"e" => $this->session->userdata('e'),
				"feedback" => $this->Bd->getFeedbackUtilizador($this->session->userdata('u'))
			);
			
		}else redirect("./home");
		
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
		$this->dados["saldo"] = $this->Bd->getSaldoUtilizador($this->dados["dadosUser"]["u"]);
		$this->load->view('areaPessoal/areaPessoal', $this->dados);

	}
	
	public function levantasaldo(){
		
		if(!$this->input->post("saldo"));
		else {
			echo $this->Bd->levantaSaldo($this->dados["dadosUser"]["u"],$this->input->post("saldo"));
		}
		
	}
	
	public function carregasaldo(){
		
		if(!$this->input->post("saldo"));
		else {
			echo $this->Bd->carregaSaldo($this->dados["dadosUser"]["u"],$this->input->post("saldo"));
		}
		
	}
	
	public function atribuirfeed(){
		
		if(!$this->input->post("ur")) echo "Sem dados";
		else{
			
			$ud = $this->dados["dadosUser"]["u"];
			$ur = $this->input->post("ur");
			$c = $this->input->post("c");
			$p = $this->input->post("p");
			$a = $this->input->post("a");
			
			echo $this->Bd->inserirFeedback($ud,$ur,$a,$c,$p);
			
			
		}
		
		
	}
	
	public function interesses(){
		$this->load->view('areaPessoal/interesses');
	}
	
	public function feedbackatribuir(){
		
		$this->load->view('areaPessoal/feedbackAtribuir');

	}
	public function feedbackporatribuir(){
		
		$this->load->view('areaPessoal/feedbackPorAtribuir');

	}
	public function feedbackrecebido(){
		
		$this->load->view('areaPessoal/feedbackRecebido');

	}
	public function comprascurso(){
		
		$this->load->view('areaPessoal/comprasCurso');

	}
	public function comprasefectuadas(){
		
		$this->load->view('areaPessoal/comprasEfectuadas');

	}
	public function vendasterminadas(){
		
		$this->load->view('areaPessoal/vendasTerminadas');

	}
	public function vendasdecorrer(){
		
		$this->load->view('areaPessoal/vendasDecorrer');

	}
	public function carteira(){
		
		$this->load->view('areaPessoal/carteira');

	}

	public function loaddadosgrid(){
		/*
			$result=$this->Bd->$modelname;
		 	$data['total']=count($result);
			$data['page']=1;
		 
			foreach($result as $ d){
					
			} 
		*/
		$data['total']=20;
		$data['page']=1;
		for($i=0;$i<20;$i++){
				$data['rows'][] = array(
                                  'id' => "id".$i,
                                  'cell' => array(
                                               "id".$i, 
                                               "cliente".$i, 
                                               "preco".$i,
                                               "titulo".$i,
                                               "data".$i
									  		 )
									);

		}

		echo json_encode($data);

	}

	public function insereanuncio(){

		if(!$this->input->post("tanuncio")){ $p["res"] = -2; echo json_encode($p); }
		else {

			$p = array();

			if($this->input->post('tmpnomeimg')!=""){

				$config['upload_path'] = './imganuncios/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '10000';
				$config['max_width']  = '1024';
				$config['max_height']  = '768';

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('ianuncio')){
					$p["erro"] = $this->upload->display_errors('','');
					$p["res"] = -2;
				}else{
					$data = $this->upload->data();
					$nome=$data["file_name"];
					$p["res"] = 1;
				}

			}else{
				$nome = "";
			}

			$dados = array(
				"uti" => $this->dados["dadosUser"]["u"],
				"tit" => $this->input->post("tanuncio"),
				"cat" => $this->input->post("canuncio"),
				"pre" => $this->input->post("tmppreco"),
				"desc" => $this->input->post("danuncio"),
				"img" => $nome
			);

			$res = $this->Bd->insereAnuncio($dados);

			echo json_encode($res);

		}

	}

	public function loadtabelainteresses(){

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

		$tmp = $this->Bd->getInteresses(
				$this->dados["dadosUser"]["u"],
				$sortname,
				$sortorder,
				$qtype,
				$query,
				(($page-1)*$rp)+1, // Inicio
				(($page-1)*$rp)+$rp // Fim
			);

		$dados['total'] = isset($tmp["conta"]) ? $tmp["conta"] : 0;
		$interesses = isset($tmp["dados"]) ? $tmp["dados"] : array();		

		$dados['rows'] = array(); 

		foreach($interesses as $i){
			
			$tit = '<a href="'.base_url().'detailsanuncio/index/'.$i->A.'">'.$i->T.'</a>';
			
			$dados['rows'][] = array(
				'id' => $i->A,
				'cell' => array($i->A,$tit,$i->NU, $i->P, $i->NC)
			);

		}
		
		echo json_encode($dados);
		
	}

	/* $d = 0 -> Em curso
	 * $d = 2 -> Terminadas
	 */
	public function loadtabelavendas($d){

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

		$tmp = $this->Bd->getVendasByEstado(
				$this->dados["dadosUser"]["u"],
				$d,
				$sortname,
				$sortorder,
				$qtype,
				$query,
				(($page-1)*$rp)+1, // Inicio
				(($page-1)*$rp)+$rp // Fim
			);

		$dados['total'] = isset($tmp["conta"]) ? $tmp["conta"] : 0;
		$pesq = isset($tmp["dados"]) ? $tmp["dados"] : array();		

		$dados['rows'] = array(); 

		foreach($pesq as $i){

			$tit = '<a href="'.base_url().'detailsanuncio/index/'.$i->A.'">'.$i->T.'</a>';
			
			$dados['rows'][] = array(
				'id' => $i->A,
				'cell' => array($i->A,$tit,$i->P, $i->NC)
			);

		}
		
		echo json_encode($dados);
		
	}

	public function loadtabelacompras(){

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

		$tmp = $this->Bd->getComprasEfectuadas(
				$this->dados["dadosUser"]["u"],
				$sortname,
				$sortorder,
				$qtype,
				$query,
				(($page-1)*$rp)+1, // Inicio
				(($page-1)*$rp)+$rp // Fim
			);

		$dados['total'] = isset($tmp["conta"]) ? $tmp["conta"] : 0;
		$pesq = isset($tmp["dados"]) ? $tmp["dados"] : array();		

		$dados['rows'] = array(); 

		foreach($pesq as $i){

			$tit = '<a href="'.base_url().'detailsanuncio/index/'.$i->A.'">'.$i->T.'</a>';
			
			$dados['rows'][] = array(
				'id' => $i->A,
				'cell' => array($i->A,$tit,$i->P, $i->U, $i->NC)
			);

		}
		
		echo json_encode($dados);
		
	}

	public function loadtabelaleiloesemcurso(){

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

		$tmp = $this->Bd->getLeiloesEnvolvidos(
				$this->dados["dadosUser"]["u"],
				$sortname,
				$sortorder,
				$qtype,
				$query,
				(($page-1)*$rp)+1, // Inicio
				(($page-1)*$rp)+$rp // Fim
			);

		$dados['total'] = isset($tmp["conta"]) ? $tmp["conta"] : 0;
		$pesq = isset($tmp["dados"]) ? $tmp["dados"] : array();		

		$dados['rows'] = array(); 

		foreach($pesq as $i){

			$tit = '<a href="'.base_url().'detailsanuncio/index/'.$i->A.'">'.$i->T.'</a>';
			
			$dados['rows'][] = array(
				'id' => $i->A,
				'cell' => array($i->A,$tit, $i->U, $i->NC)
			);

		}
		
		echo json_encode($dados);
		
	}

	public function loadtabelamovimentos(){

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

		$tmp = $this->Bd->getMovimentos(
				$this->dados["dadosUser"]["u"],
				$sortname,
				$sortorder,
				$qtype,
				$query,
				(($page-1)*$rp)+1, // Inicio
				(($page-1)*$rp)+$rp // Fim
			);

		$dados['total'] = isset($tmp["conta"]) ? $tmp["conta"] : 0;
		$pesq = isset($tmp["dados"]) ? $tmp["dados"] : array();		

		$dados['rows'] = array(); 

		foreach($pesq as $i){

			$tipo="";

			if($i->A==0){
				if($i->V>0){
					$tipo="Carregamento";
				}else{
					$tipo="Levantamento";
				}
			}else{
				if($i->V>0){
					$tipo='<a href="'.base_url().'detailsanuncio/index/'.$i->A.'">'."Venda - Anuncio ID: ".$i->A.'</a>';
				}else{
					$tipo='<a href="'.base_url().'detailsanuncio/index/'.$i->A.'">'."Compra - Anuncio ID: ".$i->A.'</a>';
				}
			}
			
			$dados['rows'][] = array(
				'id' => $i->A,
				'cell' => array($i->M,$tipo, $i->V.' €', $i->DM)
			);

		}
		
		echo json_encode($dados);
		
	}

	public function loadtabelafeedbackAtribuido(){

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

		$tmp = $this->Bd->getFeedbackAtribuido(
				$this->dados["dadosUser"]["u"],
				$sortname,
				$sortorder,
				$qtype,
				$query,
				(($page-1)*$rp)+1, // Inicio
				(($page-1)*$rp)+$rp // Fim
			);

		$dados['total'] = isset($tmp["conta"]) ? $tmp["conta"] : 0;
		$pesq = isset($tmp["dados"]) ? $tmp["dados"] : array();		

		$dados['rows'] = array(); 

		foreach($pesq as $i){

			$tit = '<a href="'.base_url().'detailsanuncio/index/'.$i->A.'">'.$i->T.'</a>';
			
			$dados['rows'][] = array(
				'id' => $i->A,
				'cell' => array($tit,$i->UR, $i->P, $i->C)
			);

		}
		
		echo json_encode($dados);
		
	}

	public function loadtabelafeedbackRecebido(){

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

		$tmp = $this->Bd->getFeedbackRecebido(
				$this->dados["dadosUser"]["u"],
				$sortname,
				$sortorder,
				$qtype,
				$query,
				(($page-1)*$rp)+1, // Inicio
				(($page-1)*$rp)+$rp // Fim
			);

		$dados['total'] = isset($tmp["conta"]) ? $tmp["conta"] : 0;
		$pesq = isset($tmp["dados"]) ? $tmp["dados"] : array();		

		$dados['rows'] = array(); 

		foreach($pesq as $i){

			$tit = '<a href="'.base_url().'detailsanuncio/index/'.$i->A.'">'.$i->T.'</a>';
			
			$dados['rows'][] = array(
				'id' => $i->A,
				'cell' => array($tit,$i->UD, $i->P, $i->C)
			);

		}
		
		echo json_encode($dados);
		
	}
	
	public function loadtabelafeedbackporatribuir(){

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

		$tmp = $this->Bd->getFeedbackPorAtribuir(
				$this->dados["dadosUser"]["u"],
				$sortname,
				$sortorder,
				$qtype,
				$query,
				(($page-1)*$rp)+1, // Inicio
				(($page-1)*$rp)+$rp // Fim
			);

		$dados['total'] = isset($tmp["conta"]) ? $tmp["conta"] : 0;
		$pesq = isset($tmp["dados"]) ? $tmp["dados"] : array();		

		$dados['rows'] = array(); 

		foreach($pesq as $i){

			$tit = '<a href="'.base_url().'detailsanuncio/index/'.$i->A.'">'.$i->T.'</a>';
			$tipo="";
			
			
			if($this->dados["dadosUser"]["u"]==$i->UC){
				$tipo="Compra";
				$uut=$i->U;
			}else{
				$tipo="Venda";
				$uut=$i->UC;
			}

			$dados['rows'][] = array(
				'id' => $i->A,
				'cell' => array($i->A, $tit, $tipo,$uut)
			);

		}
		
		echo json_encode($dados);
		
	}

}

?>
