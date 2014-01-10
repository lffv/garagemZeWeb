	
<script type="text/javascript">

	$(document).ready(function(){
		
		$("#tabelaVendasEmCurso").flexigrid({
			url: './areapessoal/loadtabelavendas/0',
			dataType: 'json',
			colModel : [
				{display: 'ID', name : 'anu.A', resizable: false, width : 20, sortable : true, align: 'left'},
				{display: 'Titulo', name : 'anu.T', resizable: false, width : 440, sortable : true, align: 'left'},
				{display: 'Preço', name : 'anu.P', resizable: false, width : 60, sortable : true, align: 'left'},
				{display: 'Categoria', name : 'cat.NC', resizable: false, width : 130, sortable : true, align: 'left'}
				],
			searchitems : [
				{display: 'Titulo', name : 'anu.T', isdefault: true},
				{display: 'Categoria', name : 'cat.NC'}
				],
			sortname: "anu.A",
			sortorder: "asc",
			usepager: true,
			title: 'Vendas em curso',
			useRp: true,
			rp: 15,
			showTableToggleBtn: false,
			width: 700,
			height: 270,
			resizable: false,
			singleSelect: true
		}); 
		
	});
			
</script>

<div class="janelaFlexi">
	<table id="tabelaVendasEmCurso" style="display: none;"></table>
</div>

	