<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/search.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/genresnav.php';

     
    require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';
    $moviesAPI = new Movie;
    $movies = $moviesAPI->get_by_genre($_GET['genre']);
    $i=0;
    for ($row=0;$row<sizeof($movies);$row++) {
            if($movies[$i]['img'] != NULL) {
                echo '<div class="images"><img src='.$movies[$i]['img'].'><button id="wantto">Want to watch</button><button id="watched">Watched</button><button id="info">Info</button></div>';
            }    
            $i++;
    }
