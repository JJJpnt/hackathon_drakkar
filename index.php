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
<style>
.card {
    max-width: 13rem !important;
}
.card-title {
    padding-left: 1rem;
}
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {

    var minGen = 0;
    var maxGen = 0

    function search() {

        console.log("searching...");

        var val = $("#search").val();

        $.get("search.php", {name:val}, function(res) {
                var dataList = $("#searchresults");
                dataList.empty();
                // console.log(res);
                if(res) {
                    for(var i=0, len=res.length; i<len; i++) {
                        var opt = $("<option></option>");
                        var span = $("<span></span>");
                        $(opt).append(span);
                        $(span).attr("value", res[i]['_id']);
                        $(span).attr("id", "anOption");
                        // console.log(span);
                        // var opt = $("<option><span></span></option>").attr("value", res[i]['_id']);
                        $(span).data("id", res[i]['_id']);
                        $(span).html('(' + res[i]['_id'] + ') ' + res[i]['_nom']);
                        // console.log(res[i]['_nom']);

                        dataList.append(opt);
                    }

                }
            },"json");

    }



	$("#search").keyup(function(e) {
        // console.log("fdp+3000");
        var val = $(this).val();
		if(val === "") return;
		//Limiter à 3 caractères minimum
		if(val.length < 3) return;
        clearTimeout($(this).data('timer'));
        var wait = setTimeout(search, 250);
        $(this).data('timer', wait);

  	});




    // function getAllEvents(element) {
    //     var result = [];
    //     for (var key in element) {
    //         if (key.indexOf('on') === 0) {
    //             result.push(key.slice(2));
    //         }
    //     }
    //     return result.join(' ');
    // }
    // var el = $('#anOption');
    // el.bind(getAllEvents(el[0]), function(e) {
    //     console.log(e);
    // });
    // $("span").click(function(e){
    //     console.log(e);
    // });

    function getEnfants(personneId){
                        // var personneId = $("#data").data("id");
                        // generation=0;

                        // alert("getenfants"+personneId);
                        // console.log(this);
                        // var generation = $(this).parent().parent().parent().data('generation');
                        // console.log($("#wrap").last());
                        // var generation = $("#wrap").last().data('generation');
                        var generation = maxGen;
                        // var generation = 0;
                        console.log("generation : "+generation)
                        // var generation = $("#data").data('generation');
                        // alert("Génération : " + generation);
                        $.get("getChildren.php", {idPersonne:personneId}, function(res){console.log(res);addEnfant(res, generation);},"json");

                        
                    }

    function getParents(personneId){
                        // var personneId = $("#data").data("id");
                        // generation=0;

                        // alert("getparents"+personneId);
                        // console.log(this);
                        // var generation = $(this).parent().parent().parent().data('generation');
                        // console.log($("#wrap").last());
                        // var generation = $("#wrap").last().data('generation');
                        var generation = minGen;
                        // var generation = 0;
                        console.log("generation : "+generation)
                        // var generation = $("#data").data('generation');
                        // alert("Génération : " + generation);
                        $.get("getParents.php", {idPersonne:personneId}, function(res){console.log(res);addParent(res, generation);},"json");

                        
                    }



    function addParent(ress, generation) {
        // alert("addenfants");
                            console.log("ress : "+ress.length);
                            console.log(ress);
                            if(ress.length>0) {

                            // var generation = $("#wrap").last().data('generation');
                            // console.log("generation"+generation)
                            // console.log(ress);
                            var g1 = generation-1;

                            $("#wrap").prepend(
                                '<div class="container-fluid d-flex justify-content-center mx-auto p-2 mx-0 bg-light w-100" id="main" data-generation="'+(g1)+'"></div>'
                            );
                            
                            ress.forEach(function(pers){
                                // $("div[data-generation='0']").clear();
                                $("div[data-generation='"+g1+"']").append(
                                    "<div data-id='"+ pers['_id'] +"' class='card col-4 m-0 p-1'style='width: 20rem'>\
                                    <div class='card-body d-flex flex-column justify-content-around align-items-center w-100 p-0'>\
                                        <a data-id='"+ pers['_id'] +"' href='#' class='parents btn btn-primary m-4 w-50 rounded mx-auto'>Parents</a>\
                                        <h5 class='card-title'>"+pers['_nom']+"</h5>\
                                        <a data-id='"+ pers['_id'] +"' href='#' class='enfants btn btn-primary m-4 w-50 rounded mx-auto'>Enfants</a>\
                                    </div>\
                                    </div>"
                                );

                                $("a.enfants[data-id='"+pers['_id']+"']").click(function(){ 
                                        getEnfants(pers['_id']);
                                    }
                                );
                                $("a.parents[data-id='"+pers['_id']+"']").click(function(){ 
                                        getParents(pers['_id']);
                                    }
                                );


                            //     $("a[data-id='"+pers['_id']+"']").click(function(){ 
                            //     //      $("#data").data('generation', 0);
                            //     //   $("#data").data('id', personneId);

                            //         getEnfants(pers['_id']);
                            //         }
                            // );

                            });

                            minGen--;
                        } else { alert("Pas de parents")}
                        // $("#data").data('generation', (generation+1))
    }

    function addEnfant(ress, generation) {
        // alert("addenfants");
                            console.log("ress : "+ress.length);
                            console.log(ress);
                            if(ress.length>0) {

                            // var generation = $("#wrap").last().data('generation');
                            // console.log("generation"+generation)
                            // console.log(ress);
                            var g1 = generation+1;

                            $("#wrap").append(
                                '<div class="container-fluid d-flex justify-content-center mx-auto p-2 mx-0 bg-light w-100" id="main" data-generation="'+(generation+1)+'"></div>'
                            );
                            
                            ress.forEach(function(pers){
                                // $("div[data-generation='0']").clear();
                                $("div[data-generation='"+g1+"']").append(
                                    "<div data-id='"+ pers['_id'] +"' class='card col-4 m-0 p-1'style='width: 20rem'>\
                                    <div class='card-body d-flex flex-column justify-content-around align-items-center w-100 p-0'>\
                                        <a data-id='"+ pers['_id'] +"' href='#' class='parents btn btn-primary m-4 w-50 rounded mx-auto'>Parents</a>\
                                        <h5 class='card-title'>"+pers['_nom']+"</h5>\
                                        <a data-id='"+ pers['_id'] +"' href='#' class='enfants btn btn-primary m-4 w-50 rounded mx-auto'>Enfants</a>\
                                    </div>\
                                    </div>"
                                );
                                $("a.enfants[data-id='"+pers['_id']+"']").click(function(){ 
                                        getEnfants(pers['_id']);
                                    }
                                );
                                $("a.parents[data-id='"+pers['_id']+"']").click(function(){ 
                                        getParents(pers['_id']);
                                    }
                                );






                            //     $("a[data-id='"+pers['_id']+"']").click(function(){ 
                            //     //      $("#data").data('generation', 0);
                            //     //   $("#data").data('id', personneId);

                            //         getEnfants(pers['_id']);
                            //         }
                            // );

                            });

                            maxGen++;
                        } else { alert("Pas d'enfants")}
                        // $("#data").data('generation', (generation+1))
    }


    $("#submit").click(function(e){

        var personneName = $("#search").val();
        var idRegex = /\((.*?)\)/;
        var match = idRegex.exec(personneName);
        var personneId = match[1];
        console.log(personneName);
        console.log(personneId);

                            // <p class='d-block align-self-start mt-0 mx-0 ml-1'>Sexe : "+res['_sexe']+"</p>\
                            // <p class='d-block align-self-start mt-0 mx-0 ml-1'>Quartier : "+res['_quartier']+"</p>\
                            // <p class='d-block align-self-start mt-0 mx-0 ml-1'>Fonction ménage : "+res['_fonction_menage']+"</p>\
                            // <p class='d-block align-self-start mt-0 mx-0 ml-1'>Profession : "+res['_profession']+"</p>\
                            // <p class='d-block align-self-start mt-0 mx-0 ml-1'>Né.e à : "+res['_lieu_naissance']+"</p>\
        // if(personneId) alert(personneId);
        if(personneId) {

            $.get("getOnePerson.php", {idPersonne:personneId}, function(res) {
                // dataList.empty();
                // console.log(res);
                if(res) {

                    console.log(res);
                        // <div class='card-img-top' src='...' alt='Card image cap'>\
                        // </div>\
                        // style='max-height: 30rem'
                    // $("div[data-generation='0']").empty();
                    minGen = 0;
                    $("#wrap").empty();
                    $("#wrap").append('<div class="container-fluid d-flex justify-content-center mx-auto p-2 mx-0 bg-light w-100" id="main" data-generation="0"></div>');
                    $("div[data-generation='0']").append(
                        "<div data-id='"+ personneId +"' class='card col-4 m-0 p-1'style='width: 20rem'>\
                        <div class='card-body d-flex flex-column justify-content-around align-items-center w-100 p-0'>\
                            <a data-id='"+ personneId +"' href='#' class='parents btn btn-primary m-4 w-50 rounded mx-auto'>Parents</a>\
                            <h5 class='card-title'>"+res['_nom']+"</h5>\
                            <a data-id='"+ personneId +"' href='#' class='enfants btn btn-primary m-4 w-50 rounded mx-auto'>Enfants</a>\
                        </div>\
                        </div>"
                    );

                    $("a.enfants[data-id='"+personneId+"']").click(function(){ 
                             getEnfants(personneId);
                            }
                    );
                    $("a.parents[data-id='"+personneId+"']").click(function(){ 
                             getParents(personneId);
                            }
                    );




                    // for(var i=0, len=res.length; i<len; i++) {
                    //     var opt = $("<option></option>");
                    //     var span = $("<span></span>");
                    //     $(opt).append(span);
                    //     $(span).attr("value", res[i]['_id']);
                    //     $(span).attr("id", "anOption");
                    //     // console.log(span);
                    //     // var opt = $("<option><span></span></option>").attr("value", res[i]['_id']);
                    //     $(span).data("id", res[i]['_id']);
                    //     $(span).html('(' + res[i]['_id'] + ') ' + res[i]['_nom']);
                    //     // console.log(res[i]['_nom']);

                    //     dataList.append(opt);
                    }

                }
            ,"json");






        }

    });


})
</script>	
</head>

<body class="bg-dark">
<datalist id="searchresults"></datalist>

<!-- <input id="data" type="hidden" data-id="null" data-generation="0"> -->


<div class="container-fluid bg-dark ">

    <div class="row mx-auto p-2 mx-0">
        <input class="col-8 mx-auto" type="search" name="search" id="search" placeholder="Type Something" list="searchresults" autocomplete="off"  value="(32277)">
        <button id="submit" class="btn btn-primary col-4">Go!</button>
    </div>
    <div id="wrap">
        
    </div>




</div>

</body>
</html>
