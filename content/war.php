<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/search.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/genresnav.php';

     
    require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';
    $moviesAPI = new Movie;
    $warMovies = $moviesAPI->get_by_genre("War");
    $i=0;
    for ($row=0;$row<sizeof($warMovies);$row++) {
        if($warMovies[$i]['img'] != NULL) {
            echo '<div class="images"><img src='.$warMovies[$i]['img'].'/div>';
        }    
        $i++;
    }
?>