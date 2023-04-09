<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/search.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/genresnav.php';

     
    require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';
    $moviesAPI = new Movie;
    $romanceMovies = $moviesAPI->get_by_genre("Romance");
    $i=0;
    for ($row=0;$row<sizeof($romanceMovies);$row++) {
        if($romanceMovies[$i]['img'] != NULL) {
            echo '<div class="images"><img src='.$romanceMovies[$i]['img'].'/div>';
        }    
        $i++;
    }
?>