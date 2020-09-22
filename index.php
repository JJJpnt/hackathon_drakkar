<?php

// use Repository\PersonneRepository;

include('include/connexion.php');
require_once 'Entity/Personne.php';
require_once 'Repository/PersonneRepository.php';

// $b = new Personne();

$pr = new PersonneRepository($bdd);

// var_dump($pr->findAll());

?>

<!doctype html>
<html>
<head>
<title>Test</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>
$(document).ready(function() {

	$("#search").on("input", function(e) {
		var val = $(this).val();
		if(val === "") return;
		//You could use this to limit results
		//if(val.length < 3) return;
		console.log(val);
		$.get("artservice.cfc?method=getart&returnformat=json", {term:val}, function(res) {
			var dataList = $("#searchresults");
			dataList.empty();
			if(res.DATA.length) {
				for(var i=0, len=res.DATA.length; i<len; i++) {
					var opt = $("<option></option>").attr("value", res.DATA[i][0]);
					dataList.append(opt);
				}

			}
		},"json");
	});

})
</script>	
</head>

<body>

<p>
	<input type="text" name="search" id="search" placeholder="Type Something" list="searchresults" autocomplete="off">
	<datalist id="searchresults"></datalist>
</p>

</body>
</html>