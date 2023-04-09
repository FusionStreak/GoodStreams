<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/search.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/genresnav.php';

     
    require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';
    $moviesAPI = new Movie;
    $thrillerMovies = $moviesAPI->get_by_genre("Thriller");
    $i=0;
    for ($row=0;$row<sizeof($thrillerMovies);$row++) {
        if($thrillerMovies[$i]['img'] != NULL) {
            echo '<div class="images"><img src='.$thrillerMovies[$i]['img'].'/div>';
        }    
        $i++;
    }
?>