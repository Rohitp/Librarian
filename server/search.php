<?php

header('Content-Type: application/json');
include("dump.php");
include("db_func.php");

$q = $_REQUEST['query'];

$books_key = "";

$search_url = "https://www.googleapis.com/books/v1/volumes?q=$q&key=$books_key";

$results = callUrl($search_url);
$results_json = json_decode($results, true);

$books_array = array();
foreach($results_json['items'] as $books) {
  // echo $books["volumeInfo"]["title"]."</br>";
  // $books[] = array("title" => );
  if(!isset($books["volumeInfo"]["averageRating"])) {
    $books["volumeInfo"]["averageRating"] = "NA";
  }
  if(!isset($books["volumeInfo"]["pageCount"])) {
    $books["volumeInfo"]["pageCount"] = "NA";
  }
  $books_array[] = array("id" => $books["id"], "title" => $books["volumeInfo"]["title"], "author" => $books["volumeInfo"]["authors"][0], "description" => $books["volumeInfo"]["description"], "cover" => $books["volumeInfo"]["imageLinks"]["thumbnail"], "rating" => $books["volumeInfo"]["averageRating"], "pages" => $books["volumeInfo"]["pageCount"]);
  // $books_array[] = array("id" => $books["id"], "title" => $books["volumeInfo"]["title"], "author" => $books["volumeInfo"]["authors"][0], "description" => $books["volumeInfo"]["description"], "pages" => $books["volumeInfo"]["pageCount"], "rating" => $books["volumeInfo"]["averageRating"], "cover" => $books["volumeInfo"]["imageLinks"]["thumbnail"]);
}

// do_dump($books_array);
// do_dump($results_json);

echo json_encode($books_array);









?>
