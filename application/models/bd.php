
<?php

class Bd extends CI_Model{

	function getDistritos(){

		$sql = "SELECT * FROM DISTRICONCELHOS WHERE DC = '0'";

		$query = $this->db->query($sql);

		return $query->result();

	}
	
	function getConcelhos($d){
		
		$sql = "SELECT * FROM DISTRICONCELHOS WHERE DC = ? OR C = ?";

		$query = $this->db->query($sql,array($d,$d));

		return $query->result();

	}
	
	// Por concelho:
	function getFreguesias($c){
		
		$sql = "SELECT * FROM FREGUESIAS WHERE C=?";

		$query = $this->db->query($sql,array($c));

		return $query->result();

	}
	
	// Por id da freguesia:
	function getFreguesiasByID($f){
		
		$sql = "SELECT * FROM FREGUESIAS WHERE F=?";

		$query = $this->db->query($sql,array($f));

		return $query->result();

	}
	
	function getUtilizador($u){
		
		$sql = "SELECT * FROM UTILIZADORES WHERE U = ?";
		
		$query = $this->db->query($sql,array($u));

		return $query->result();
		
	}
	
	function getDetalhesUtilizador($u){
		
		/* UTILIZA A VIEW detalhesutilizadores */
		$sql = "select * from detalhesutilizadores WHERE U = ?";

		$query = $this->db->query($sql,array($u));

		return $query->result();
		
	}
	
	function getFeedbackUtilizador($u){
		
		$sql = "select round(coalesce(avg(P),0),2) as feed from feedback where ur = ?";
		
		$query = $this->db->query($sql,array($u));

		$res = $query->result();
		
		return $res[0]->FEED; 
		
	}
	
	function getCategorias(){
		
		$sql = "SELECT * FROM CATEGORIAS";
		
		$query = $this->db->query($sql);

		return $query->result();
		
	}

	function insereUtilizador($dados){
	
		$sql = "INSERT INTO UTILIZADORES VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		
		$query = $this->db->query($sql, array(
			$dados["uname"],
			$dados["nome"],
			$dados["dnuser"],
			$dados["muser"],
			$dados["fruser"],
			$dados["cpuser"],
			$dados["euser"],
			md5($dados["passu"])
		));

		if(!$query){
			
			$erros = $this->db->retornaErro();
			
			if($erros["code"]==1){
				
				$const = $this->getConstrainName($erros["message"]);
				
				if($const=="GARAGEMZE.USERNAMEUNICO") return -2;
				if($const=="GARAGEMZE.EMAILUNICO") return -3;
				
			}

			else return $erros["code"];
			
		} else return -1; // SUCESSO

	}
	
	function insereAnuncio($dados){
		
		$sql = "INSERT INTO ANUNCIOS (u,c,p,t,d,img) VALUES (?,?,?,?,?,?)";

		$query = $this->db->query($sql, array(
			$dados["uti"],
			$dados["cat"],
			floatval($dados["pre"]),
			$dados["tit"],
			$dados["desc"],
			$dados["img"]
		));

		if(!$query){

			$res = $this->db->retornaErro();

		} else{
			
			$res = array("code"=> -1);
			
			/* Vai directamente buscar o id do anuncio que foi inserido ao sequence do oracle,
			mas funciona mal, pois é preciso gerar o proximo valor com o nextval antes do currval:
			
			 $sql = "select id_anuncios.nextval from dual";
			 $query = $this->db->query($sql);
			 $sql = "select id_anuncios.currval as A from dual";
			 * 
			 * 
			 */
			  
			 // ou vai ao maior:
			 $sql = "select max(A) as A from ANUNCIOS";

			 $query = $this->db->query($sql);
			 $tmp = $query->result();
			 $res["message"] = $tmp[0]->A;
						
		}
		return $res;
		
	}
	
	function getAnuncio($id){
		
		$sql = "SELECT * FROM ANUNCIOS WHERE A = ?";

		$query = $this->db->query($sql,array($id));

		return $query->result();
		
	}

	function getRandomDestaques(){
		
		/* Utiliza a view anunciosaleatorios */
		
		$sql = "SELECT * FROM anunciosaleatorios";

		$query = $this->db->query($sql);

		return $query->result();

	}

	function interesse($user, $anuncio){

		$sql = "INSERT INTO INTERESSES VALUES (?,?)";

		$query = $this->db->query($sql,array($user,$anuncio));
		
		if(!$query){
			
			$res = $this->db->retornaErro();
			
			// Se estava interessado, deixa de estar
			if($res["code"]==1){
						
				$sql = "DELETE FROM INTERESSES WHERE U = ? AND A = ?";
				
				$query = $this->db->query($sql,array($user,$anuncio)); 
				
				if($query) return -3;
				else{
					$res = $this->db->retornaErro();
					return $res["code"];
				}
								
			}else return $res["code"];
			
		}else return -2;
		
	}

	function temInteresse($user,$anuncio){
		
		$sql = "SELECT * FROM INTERESSES WHERE U = ? AND A = ?";
		
		$query = $this->db->query($sql,array($user,$anuncio));
		
		$res = $query->result();
		
		return (count($res)==1);
		
	}
	
	function getUltimaLicitacao($a){

		$sql = "SELECT COALESCE(MAX(V),0) as maiorl FROM LEILOES WHERE A = ?";

		$query = $this->db->query($sql,array($a));

		$res = $query->result();

		return $res[0]->MAIORL;
	}
	
	function comprarAnuncio($user, $anuncio, $mp){

		$sql = "INSERT INTO VENDAS (UC,MP,A) VALUES (?,?,?)";

		$query = $this->db->query($sql,array($user,$mp,$anuncio));
		
		if($query) return -2;
		else{
			$res = $this->db->retornaErro();
			return $res["code"];
		}

	}
	
	function licitarAnuncio($user, $valor, $anuncio, $mp){

		$sql = "INSERT INTO LEILOES (UL,V,MP,A) VALUES (?,?,?,?)";

		$query = $this->db->query($sql,array($user,floatval($valor),$mp,$anuncio));
		
		if($query) return -2;
		else{
			$res = $this->db->retornaErro();
			return $res["code"];
		}

	}
	
	function getInteresses($user, $campoOrdenar="", $sentidoOrdenar="ASC", $campoPesquisa="", $valorPesquisa="", $ini=1, $fim=9999999){

		$sql = "SELECT * FROM
				(SELECT inte.A, anu.T, anu.P, uti.NU, cat.NC, ROW_NUMBER() OVER (ORDER BY $campoOrdenar $sentidoOrdenar) Ro 
					FROM interesses inte, anuncios anu, utilizadores uti, categorias cat 
					WHERE uti.u = anu.u and cat.c = anu.c and inte.A = anu.A and inte.u=?";

		$sqlConta = "SELECT COUNT(*) as total FROM (SELECT inte.A, anu.T, anu.P, uti.NU, cat.NC from interesses inte, anuncios anu, utilizadores uti, categorias cat 
  where uti.u = anu.u and cat.c = anu.c and inte.A = anu.A and inte.u=?";

		if($campoPesquisa != "" && $valorPesquisa != ""){
			$valorPesquisa = strtoupper($valorPesquisa);
			$sql .= " AND UPPER($campoPesquisa) LIKE '%$valorPesquisa%' ";
			$sqlConta .= " AND UPPER($campoPesquisa) LIKE '%$valorPesquisa%' )";
		}else $sqlConta .= ")";

		$sql .= " ) WHERE Ro BETWEEN " . intval($ini,10) ." and ".intval($fim,10);

		$query = $this->db->query($sql,array($user));
		$query2 = $this->db->query($sqlConta,array($user));

		if(!$query || !$query2) {
			return array();
		} 
		
		$p["dados"] = $query->result();
		$ax = $query2->result();
		$p["conta"] = $ax[0]->TOTAL;
		
		return $p;

	}
	
	function getAnunciosByCategoria($categoria, $campoOrdenar="", $sentidoOrdenar="ASC", $campoPesquisa="", $valorPesquisa="", $ini=1, $fim=9999999){

		$sql = "SELECT * FROM
				(SELECT anu.A, anu.T, anu.P, uti.NU, anu.E, anu.DF, ROW_NUMBER() OVER (ORDER BY $campoOrdenar $sentidoOrdenar) Ro 
					FROM anuncios anu, utilizadores uti, categorias cat 
					WHERE uti.u = anu.u and cat.c = anu.c and (cat.c=? OR cat.pc=?)";

		$sqlConta = "SELECT COUNT(*) as total FROM (SELECT anu.A, anu.T, anu.P, uti.NU, anu.E, anu.DF from anuncios anu, utilizadores uti, categorias cat 
  where uti.u = anu.u and cat.c = anu.c and (cat.c=? or cat.pc=?)";

		if($campoPesquisa != "" && $valorPesquisa != ""){
			$valorPesquisa = strtoupper($valorPesquisa);
			$sql .= " AND UPPER($campoPesquisa) LIKE '%$valorPesquisa%' ";
			$sqlConta .= " AND UPPER($campoPesquisa) LIKE '%$valorPesquisa%' )";
		}else $sqlConta .= ")";

		$sql .= " ) WHERE Ro BETWEEN " . intval($ini,10) ." and ".intval($fim,10);

		$query = $this->db->query($sql,array($categoria,$categoria));
		$query2 = $this->db->query($sqlConta,array($categoria,$categoria));

		if(!$query || !$query2) {
			return array();
		} 
		
		$p["dados"] = $query->result();
		$ax = $query2->result();
		$p["conta"] = $ax[0]->TOTAL;
		
		return $p;

	}

	function getVendasByEstado($user, $estado, $campoOrdenar="", $sentidoOrdenar="ASC", $campoPesquisa="", $valorPesquisa="", $ini=1, $fim=9999999){

		$sql = "SELECT * FROM
				(SELECT anu.A, anu.T, anu.P, cat.NC, ROW_NUMBER() OVER (ORDER BY $campoOrdenar $sentidoOrdenar) Ro 
					FROM anuncios anu, categorias cat 
					WHERE anu.u = ? and anu.e = ? and anu.c=cat.c";

		$sqlConta = "SELECT COUNT(*) as total FROM (SELECT anu.A, anu.T, anu.P, cat.NC from anuncios anu, categorias cat 
  WHERE anu.u = ? and anu.e = ? and cat.c = anu.c";

		if($campoPesquisa != "" && $valorPesquisa != ""){
			$valorPesquisa = strtoupper($valorPesquisa);
			$sql .= " AND UPPER($campoPesquisa) LIKE '%$valorPesquisa%' ";
			$sqlConta .= " AND UPPER($campoPesquisa) LIKE '%$valorPesquisa%' )";
		}else $sqlConta .= ")";

		$sql .= " ) WHERE Ro BETWEEN " . intval($ini,10) ." and ".intval($fim,10);

		$query = $this->db->query($sql,array($user,$estado));
		$query2 = $this->db->query($sqlConta,array($user,$estado));

		if(!$query || !$query2) {
			return array();
		} 
		
		$p["dados"] = $query->result();
		$ax = $query2->result();
		$p["conta"] = $ax[0]->TOTAL;
		
		return $p;

	}
	
	function getComprasEfectuadas($user, $campoOrdenar="", $sentidoOrdenar="ASC", $campoPesquisa="", $valorPesquisa="", $ini=1, $fim=9999999){

		$sql = "SELECT * FROM
				(SELECT anu.A, anu.T, anu.P, cat.NC, anu.U, ROW_NUMBER() OVER (ORDER BY $campoOrdenar $sentidoOrdenar) Ro 
					FROM anuncios anu, categorias cat 
					WHERE anu.u <> ? and anu.c=cat.c and exists (select * from vendas ve where ve.A=anu.a and ve.UC= ? )";

		$sqlConta = "SELECT COUNT(*) as total FROM (SELECT anu.A, anu.T, anu.P, cat.NC, anu.U from anuncios anu, categorias cat 
  WHERE anu.u <> ? and cat.c = anu.c and exists (select * from vendas ve where ve.A=anu.a and ve.UC= ? )";

		if($campoPesquisa != "" && $valorPesquisa != ""){
			$valorPesquisa = strtoupper($valorPesquisa);
			$sql .= " AND UPPER($campoPesquisa) LIKE '%$valorPesquisa%' ";
			$sqlConta .= " AND UPPER($campoPesquisa) LIKE '%$valorPesquisa%' )";
		}else $sqlConta .= ")";

		$sql .= " ) WHERE Ro BETWEEN " . intval($ini,10) ." and ".intval($fim,10);

		$query = $this->db->query($sql,array($user,$user));
		$query2 = $this->db->query($sqlConta,array($user,$user));

		if(!$query || !$query2) {
			return array();
		} 
		
		$p["dados"] = $query->result();
		$ax = $query2->result();
		$p["conta"] = $ax[0]->TOTAL;
		
		return $p;

	}
	
	function getLeiloesEnvolvidos($user, $campoOrdenar="", $sentidoOrdenar="ASC", $campoPesquisa="", $valorPesquisa="", $ini=1, $fim=9999999){

		$sql = "SELECT * FROM
				(SELECT anu.A, anu.T, anu.P, cat.NC, anu.U, ROW_NUMBER() OVER (ORDER BY $campoOrdenar $sentidoOrdenar) Ro 
					FROM anuncios anu, categorias cat 
					WHERE anu.u <> ? and anu.e=1 and anu.c=cat.c and exists (select * from leiloes lei where lei.A=anu.a and lei.UL= ? )";

		$sqlConta = "SELECT COUNT(*) as total FROM (SELECT anu.A, anu.T, anu.P, cat.NC, anu.U from anuncios anu, categorias cat 
  WHERE anu.u <> ? and cat.c = anu.c and anu.e=1 and exists (select * from leiloes lei where lei.A=anu.a and lei.UL= ? )";

		if($campoPesquisa != "" && $valorPesquisa != ""){
			$valorPesquisa = strtoupper($valorPesquisa);
			$sql .= " AND UPPER($campoPesquisa) LIKE '%$valorPesquisa%' ";
			$sqlConta .= " AND UPPER($campoPesquisa) LIKE '%$valorPesquisa%' )";
		}else $sqlConta .= ")";

		$sql .= " ) WHERE Ro BETWEEN " . intval($ini,10) ." and ".intval($fim,10);

		$query = $this->db->query($sql,array($user,$user));
		$query2 = $this->db->query($sqlConta,array($user,$user));

		if(!$query || !$query2) {
			return array();
		} 
		
		$p["dados"] = $query->result();
		$ax = $query2->result();
		$p["conta"] = $ax[0]->TOTAL;
		
		return $p;

	}
	
	function getMovimentos($user, $campoOrdenar="", $sentidoOrdenar="ASC", $campoPesquisa="", $valorPesquisa="", $ini=1, $fim=9999999){

		$sql = "SELECT * FROM
				(SELECT mov.M, mov.DM, mov.V, mov.A, ROW_NUMBER() OVER (ORDER BY $campoOrdenar $sentidoOrdenar) Ro 
					FROM movimentos mov 
					WHERE mov.um = ?";

		$sqlConta = "SELECT COUNT(*) as total FROM (SELECT mov.M, mov.DM, mov.V, mov.A from movimentos mov WHERE mov.um = ?";

		if($campoPesquisa != "" && $valorPesquisa != ""){
			$valorPesquisa = strtoupper($valorPesquisa);
			$sql .= " AND UPPER($campoPesquisa) LIKE '%$valorPesquisa%' ";
			$sqlConta .= " AND UPPER($campoPesquisa) LIKE '%$valorPesquisa%' )";
		}else $sqlConta .= ")";

		$sql .= " ) WHERE Ro BETWEEN " . intval($ini,10) ." and ".intval($fim,10);

		$query = $this->db->query($sql,array($user,$user));
		$query2 = $this->db->query($sqlConta,array($user,$user));

		if(!$query || !$query2) {
			return array();
		} 
		
		$p["dados"] = $query->result();
		$ax = $query2->result();
		$p["conta"] = $ax[0]->TOTAL;
		
		return $p;

	}
	
	function getFeedbackAtribuido($user, $campoOrdenar="", $sentidoOrdenar="ASC", $campoPesquisa="", $valorPesquisa="", $ini=1, $fim=9999999){
		
		$sql = "SELECT * FROM
				(SELECT anu.A, anu.T, fe.UR, fe.P, fe.C, ROW_NUMBER() OVER (ORDER BY $campoOrdenar $sentidoOrdenar) Ro 
					FROM feedback fe, anuncios anu 
					WHERE fe.ud = ? and anu.a=fe.a";

		$sqlConta = "SELECT COUNT(*) as total FROM (SELECT anu.A, anu.T, fe.UR, fe.P, fe.C from feedback fe, anuncios anu WHERE fe.ud = ? and anu.a=fe.a";

		if($campoPesquisa != "" && $valorPesquisa != ""){
			$valorPesquisa = strtoupper($valorPesquisa);
			$sql .= " AND UPPER($campoPesquisa) LIKE '%$valorPesquisa%' ";
			$sqlConta .= " AND UPPER($campoPesquisa) LIKE '%$valorPesquisa%' )";
		}else $sqlConta .= ")";

		$sql .= " ) WHERE Ro BETWEEN " . intval($ini,10) ." and ".intval($fim,10);

		$query = $this->db->query($sql,array($user,$user));
		$query2 = $this->db->query($sqlConta,array($user,$user));

		if(!$query || !$query2) {
			return array();
		} 
		
		$p["dados"] = $query->result();
		$ax = $query2->result();
		$p["conta"] = $ax[0]->TOTAL;
		
		return $p;

	}
	
	function getFeedbackRecebido($user, $campoOrdenar="", $sentidoOrdenar="ASC", $campoPesquisa="", $valorPesquisa="", $ini=1, $fim=9999999){
		
		$sql = "SELECT * FROM
				(SELECT anu.A, anu.T, fe.UD, fe.P, fe.C, ROW_NUMBER() OVER (ORDER BY $campoOrdenar $sentidoOrdenar) Ro 
					FROM feedback fe, anuncios anu 
					WHERE fe.ur = ? and anu.a=fe.a";

		$sqlConta = "SELECT COUNT(*) as total FROM (SELECT anu.A, anu.T, fe.UD, fe.P, fe.C from feedback fe, anuncios anu WHERE fe.ur = ? and anu.a=fe.a";

		if($campoPesquisa != "" && $valorPesquisa != ""){
			$valorPesquisa = strtoupper($valorPesquisa);
			$sql .= " AND UPPER($campoPesquisa) LIKE '%$valorPesquisa%' ";
			$sqlConta .= " AND UPPER($campoPesquisa) LIKE '%$valorPesquisa%' )";
		}else $sqlConta .= ")";

		$sql .= " ) WHERE Ro BETWEEN " . intval($ini,10) ." and ".intval($fim,10);

		$query = $this->db->query($sql,array($user,$user));
		$query2 = $this->db->query($sqlConta,array($user,$user));

		if(!$query || !$query2) {
			return array();
		} 
		
		$p["dados"] = $query->result();
		$ax = $query2->result();
		$p["conta"] = $ax[0]->TOTAL;
		
		return $p;

	}
	
	function getFeedbackPorAtribuir($user, $campoOrdenar="", $sentidoOrdenar="ASC", $campoPesquisa="", $valorPesquisa="", $ini=1, $fim=9999999){
		
		$sql = "SELECT * FROM
				(SELECT anu.A, anu.T, anu.U, ve.UC, ROW_NUMBER() OVER (ORDER BY $campoOrdenar $sentidoOrdenar) Ro 
					FROM anuncios anu, vendas ve 
					WHERE anu.a=ve.a and not exists(select * from feedback fe where fe.a=anu.a and fe.ud=?)";

		$sqlConta = "SELECT COUNT(*) as total FROM (SELECT anu.A, anu.T, anu.U, ve.UC FROM anuncios anu, vendas ve WHERE anu.a=ve.a and not exists(select * from feedback fe where fe.a=anu.a and fe.ud=?)";

		if($campoPesquisa != "" && $valorPesquisa != ""){
			$valorPesquisa = strtoupper($valorPesquisa);
			$sql .= " AND UPPER($campoPesquisa) LIKE '%$valorPesquisa%' ";
			$sqlConta .= " AND UPPER($campoPesquisa) LIKE '%$valorPesquisa%' )";
		}else $sqlConta .= ")";

		$sql .= " ) WHERE Ro BETWEEN " . intval($ini,10) ." and ".intval($fim,10);

		$query = $this->db->query($sql,array($user,$user));
		$query2 = $this->db->query($sqlConta,array($user,$user));

		if(!$query || !$query2) {
			return array();
		} 
		
		$p["dados"] = $query->result();
		$ax = $query2->result();
		$p["conta"] = $ax[0]->TOTAL;
		
		return $p;

	}
	
	function getSaldoUtilizador($u){

		$sql = "select round(coalesce(sum(v),0),2) as saldo from movimentos where um = ?";
		
		$query = $this->db->query($sql,array($u));

		$res = $query->result();
		
		return $res[0]->SALDO; 
		
	}
	
	function levantaSaldo($u,$valor){
			
		$sql = "INSERT INTO MOVIMENTOS(UM,DM,V,A) VALUES(?,sysdate,?,0)";

		$query = $this->db->query($sql,array($u,$valor*(-1)));

		if($query) return -1;
		else{
			$res = $this->db->retornaErro();
			return $res["code"];
		}

	}
	
	function carregaSaldo($u,$valor){
			
		$sql = "INSERT INTO MOVIMENTOS(UM,DM,V,A) VALUES(?,sysdate,?,0)";

		$query = $this->db->query($sql,array($u,$valor));

		if($query) return -1;
		else{
			$res = $this->db->retornaErro();
			return $res["code"];
		}

	}
	
	function inserirFeedback($ud,$ur,$a,$c,$p){
		
		$sql = "INSERT INTO FEEDBACK VALUES(?,?,?,?,?)";

		$query = $this->db->query($sql,array($ud,$ur,$a,$c,$p));

		if($query) return -1;
		else{
			$res = $this->db->retornaErro();
			return $res["code"];
		}
		
	}
	
	private function getConstrainName($m){

		if(substr($m,0,strpos($m,":"))!="ORA-00001") return NULL;
		
		$const = substr($m, strpos($m, '(')+1);
		$const = substr($const, 0, strpos($const, ')'));

		return $const;
		
	}
}

?>
