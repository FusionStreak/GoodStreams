<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/search.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/genresnav.php';

     
    require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';
    $moviesAPI = new Movie;
    $horrorMovies = $moviesAPI->get_by_genre("Horror");
    $i=0;
    for ($row=0;$row<sizeof($horrorMovies);$row++) {
        if($horrorMovies[$i]['img'] != NULL) {
            echo '<div class="images"><img src='.$horrorMovies[$i]['img'].'/div>';
        }    
        $i++;
    }
?>