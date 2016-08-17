<?php

header('Content-Type: application/json');
include("dump.php");
include("db_func.php");
include("../keys.php");

// mO-62VxpLe0C

$id = $_REQUEST['id'];

// $books_key = "";

$search_url = "https://www.googleapis.com/books/v1/volumes/$id?key=$books_key";

$results = callUrl($search_url);
$book = json_decode($results, true);
// $books_array = array();
if(!isset($book["volumeInfo"]["averageRating"])) {
  $book["volumeInfo"]["averageRating"] = "NA";
}
if(!isset($book["volumeInfo"]["pageCount"])) {
  $book["volumeInfo"]["pageCount"] = "NA";
}

if(!isset($book["volumeInfo"]["authors"][0])) {
  $book["volumeInfo"]["authors"][0] = "NA";
}



$books_array = array("id" => $book["id"], "title" => $book["volumeInfo"]["title"], "author" => $book["volumeInfo"]["authors"][0], "description" => $book["volumeInfo"]["description"], "cover" => $book["volumeInfo"]["imageLinks"]["thumbnail"], "rating" => $book["volumeInfo"]["averageRating"], "pages" => $book["volumeInfo"]["pageCount"]);
// foreach ($results_json as $key => $value) {
//
// }

// do_dump($books_array);

echo json_encode($books_array);









?>
