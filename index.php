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

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {

	$("#search").on("input", function(e) {
		var val = $(this).val();
		if(val === "") return;
		//Limiter à 3 caractères minimum
		if(val.length < 3) return;
		console.log(val);
		$.get("search.php", {name:val}, function(res) {
			var dataList = $("#searchresults");
			dataList.empty();
            // console.log(res);
			if(res) {
				for(var i=0, len=res.length; i<len; i++) {
					var opt = $("<option></option>").attr("value", res[i]['_id']);
					var opt = $("<option></option>").html('(' + res[i]['_id'] + ') ' + res[i]['_nom']);
                    // console.log(res[i]['_nom']);

					dataList.append(opt);
				}

			}
		},"json");
	});

    $("#submit").click(function(e){

            // alert("<div class='card'><img class='card-img-top' src='...' alt='Card image cap'><div class='card-body'>    <h5 class='card-title'>Card title</h5>    <p class='card-text'>Some quick example text to build on the card title and make up the bulk of the card's content.</p>    <a href='#' class='btn btn-primary'>Go somewhere</a></div></div>");
        $("#main").append(
            "<div class='card col-4'><div class='card-img-top' src='...' alt='Card image cap'><div class='card-body'>    <h5 class='card-title'>Card title</h5>    <p class='card-text'>Some quick example text to build on the card title and make up the bulk of the card's content.</p>    <a href='#' class='btn btn-primary'>Go somewhere</a></div></div>"
        );








    });


})
</script>	
</head>

<body class="bg-dark">
<datalist id="searchresults"></datalist>

<div class="container-fluid bg-dark ">

    <div class="row mx-auto p-2 mx-0">
        <input class="col-8 mx-auto" type="text" name="search" id="search" placeholder="Type Something" list="searchresults" autocomplete="off">
        <button id="submit" class="btn btn-primary col-4">Go!</button>
    </div>

    <div class="row mx-auto p-2 mx-0 bg-light" style="min-height: 90vh" id="main">
    </div>




</div>

</body>
</html>
