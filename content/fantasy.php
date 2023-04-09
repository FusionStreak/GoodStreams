<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/search.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/genresnav.php';

     
    require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';
    $moviesAPI = new Movie;
    $fantasyMovies = $moviesAPI->get_by_genre("Fantasy");
    $i=0;
    for ($row=0;$row<sizeof($fantasyMovies);$row++) {
        if($fantasyMovies[$i]['img'] != NULL) {
            echo '<div class="images"><img src='.$fantasyMovies[$i]['img'].'/div>';
        }    
        $i++;
    }
?>