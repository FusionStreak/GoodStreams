<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/search.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/genresnav.php';

     
    require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';
    $moviesAPI = new Movie;
    $actionMovies = $moviesAPI->get_by_genre("Action");
    $i=0;
    for ($row=0;$row<sizeof($actionMovies)/6;$row++) {
            if($actionMovies[$i]['img'] != NULL) {
                echo '<div class="images"><img src='.$actionMovies[$i]['img'].'/div>';
            }    
            $i++;
        }
?>