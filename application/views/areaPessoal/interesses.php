	
<script type="text/javascript">

	$(document).ready(function(){
		
		$("#tabelaInteresses").flexigrid({
			url: './areapessoal/loadtabelainteresses',
			dataType: 'json',
			colModel : [
				{display: 'ID', name : 'inte.A', resizable: false, width : 20, sortable : true, align: 'left'},
				{display: 'Titulo', name : 'anu.T', resizable: false, width : 243, sortable : true, align: 'left'},
				{display: 'Vendedor', name : 'uti.NU', resizable: false, width : 180, sortable : true, align: 'left'},
				{display: 'Preço', name : 'anu.P', resizable: false, width : 50, sortable : true, align: 'left'},
				{display: 'Categoria', name : 'cat.NC', resizable: false, width : 130, sortable : true, align: 'left'}
				],
			searchitems : [
				{display: 'Titulo', name : 'anu.T', isdefault: true},
				{display: 'Categoria', name : 'cat.NC'}
				],
			sortname: "inte.A",
			sortorder: "asc",
			usepager: true,
			title: 'Anúncios Interessantes',
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
	<table id="tabelaInteresses" style="display: none;"></table>
</div>

	