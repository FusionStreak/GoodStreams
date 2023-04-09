<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/search.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/genresnav.php';

     
    require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';
    $moviesAPI = new Movie;
    $mysteryMovies = $moviesAPI->get_by_genre("Mystery");
    $i=0;
    for ($row=0;$row<sizeof($mysteryMovies);$row++) {
        if($mysteryMovies[$i]['img'] != NULL) {
            echo '<div class="images"><img src='.$mysteryMovies[$i]['img'].'/div>';
        }    
        $i++;
    }
?>