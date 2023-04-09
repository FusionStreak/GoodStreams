<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/search.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/genresnav.php';

     
    require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';
    $moviesAPI = new Movie;
    $historyMovies = $moviesAPI->get_by_genre("History");
    $i=0;
    for ($row=0;$row<sizeof($historyMovies);$row++) {
        if($historyMovies[$i]['img'] != NULL) {
            echo '<div class="images"><img src='.$historyMovies[$i]['img'].'/div>';
        }    
        $i++;
    }
?>