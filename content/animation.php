<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/search.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/genresnav.php';

     
    require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';
    $moviesAPI = new Movie;
    $animationMovies = $moviesAPI->get_by_genre("Animation");
    $i=0;
    for ($row=0;$row<sizeof($animationMovies);$row++) {
            if($animationMovies[$i]['img'] != NULL) {
                echo '<div class="images"><img src='.$animationMovies[$i]['img'].'/div>';
            }    
            $i++;
        }
?>