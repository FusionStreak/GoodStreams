<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/search.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/genresnav.php';

     
    require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';
    $moviesAPI = new Movie;
    $musicalMovies = $moviesAPI->get_by_genre("Musical");
    $i=0;
    for ($row=0;$row<sizeof($musicalMovies);$row++) {
        if($musicalMovies[$i]['img'] != NULL) {
            echo '<div class="images"><img src='.$musicalMovies[$i]['img'].'/div>';
        }    
        $i++;
    }
?>