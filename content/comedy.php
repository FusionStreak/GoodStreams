<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/search.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/genresnav.php';

     
    require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';
    $moviesAPI = new Movie;
    $comedyMovies = $moviesAPI->get_by_genre("Comedy");
    $i=0;
    for ($row=0;$row<sizeof($comedyMovies);$row++) {
            if($comedyMovies[$i]['img'] != NULL) {
                echo '<div class="images"><img src='.$comedyMovies[$i]['img'].'/div>';
            }    
            $i++;
        }
?>