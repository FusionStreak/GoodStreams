<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/search.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/genresnav.php';

     
    require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';
    $moviesAPI = new Movie;
    $documentMovies = $moviesAPI->get_by_genre("Documentary");
    $i=0;
    for ($row=0;$row<sizeof($documentMovies);$row++) {
        if($documentMovies[$i]['img'] != NULL) {
            echo '<div class="images"><img src='.$documentMovies[$i]['img'].'/div>';
        }    
        $i++;
    }
?>