<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/search.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/genresnav.php';

     
    require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';
    $moviesAPI = new Movie;
    $scifiMovies = $moviesAPI->get_by_genre("Sci-Fi");
    $i=0;
    for ($row=0;$row<sizeof($scifiMovies);$row++) {
        if($scifiMovies[$i]['img'] != NULL) {
            echo '<div class="images"><img src='.$scifiMovies[$i]['img'].'/div>';
        }    
        $i++;
    }
?>