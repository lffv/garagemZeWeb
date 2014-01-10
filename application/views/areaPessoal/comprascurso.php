	
<script type="text/javascript">

	$(document).ready(function(){
		
		$("#tabelaComprasEmCurso").flexigrid({
			url: './areapessoal/loadtabelaleiloesemcurso',
			dataType: 'json',
			colModel : [
				{display: 'ID', name : 'anu.A', resizable: false, width : 20, sortable : true, align: 'left'},
				{display: 'Titulo', name : 'anu.T', resizable: false, width : 440, sortable : true, align: 'left'},
				{display: 'Vendedor', name : 'anu.U', resizable: false, width : 60, sortable : true, align: 'left'},
				{display: 'Categoria', name : 'cat.NC', resizable: false, width : 130, sortable : true, align: 'left'}
				],
			searchitems : [
				{display: 'Titulo', name : 'anu.T', isdefault: true},
				{display: 'Vendedor', name : 'anu.U'},
				{display: 'Categoria', name : 'cat.NC'}
				],
			sortname: "anu.A",
			sortorder: "asc",
			usepager: true,
			title: 'Leilões em curso',
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
	<table id="tabelaComprasEmCurso" style="display: none;"></table>
</div>

	