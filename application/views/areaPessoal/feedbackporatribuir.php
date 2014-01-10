	
<script type="text/javascript">

	$(document).ready(function(){
		
		function atribuirFeed(com, grid) {

			$('.trSelected', grid).each(function() {
				
				var tab = $(this);
				
				var ur = $('td:eq(3) > div',this).html();
				
				var id = tab.attr('id');
				
				id = id.substring(id.lastIndexOf('row')+3);
				
				var p = prompt("Insira a pontuacao para o anuncio com o ID: "+id);
				
				if(p==null){ return false; }
				if(!(pa=parseInt(p))){ alert("Valor inválido"); return false; }
				if(pa<0 || pa>5){ alert("Valor inválido"); return false; }
				
				var c = prompt("Insira c comentário para o anuncio com o ID: "+id);
				
				if(c==null){ return false; }
				
				// Se chegar aqui, atribui o feedback
				
				$.ajax({

					  type: "POST",
					  url: "./areapessoal/atribuirfeed",
					  data: {a:id, ur:ur, c:c, p:pa },
					  dataType: 'json'
					}).done(function(msg) {
						
						if(msg=="-1"){
							
							alert("Feedback atribuido com sucesso");
							$('#tabelaFeedAtribuido').flexReload();
							
						}else{
							alert("Ocorreu um erro: "+msg);
						}	

				});
				
				return false;
				
			});
			
		}
		
		$("#tabelaFeedAtribuido").flexigrid({
			url: './areapessoal/loadtabelafeedbackporatribuir',
			dataType: 'json',
			colModel : [
				{display: 'ID', name : 'anu.A', resizable: false, width : 30, sortable : true, align: 'left'},
				{display: 'Anuncio', name : 'anu.T', resizable: false, width : 450, sortable : true, align: 'left'},
				{display: 'Tipo', name : 'tipo', resizable: false, width : 80, sortable : false, align: 'left'},
				{display: 'Atribuir a', name : 'uti', resizable: false, width : 90, sortable : false, align: 'left'},
				],
			searchitems : [
				{display: 'Titulo', name : 'anu.T', isdefault: true}
				],
			buttons : [
				{name: 'Atribuir', bclass:'add', onpress: atribuirFeed }
			],
			sortname: "anu.A",
			sortorder: "asc",
			usepager: true,
			title: 'Feedback por Atribuir',
			useRp: true,
			rp: 15,
			showTableToggleBtn: false,
			width: 700,
			height: 245,
			resizable: false,
			singleSelect: true
		}); 
		
	});
			
</script>

<div class="janelaFlexi">
	<table id="tabelaFeedAtribuido" style="display: none;"></table>
</div>

	