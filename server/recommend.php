<?php
header('Content-Type: application/json');

include("dump.php");
include("db_func.php");

// mO-62VxpLe0C

$id = $_REQUEST['id'];

$books_key = "AIzaSyChxGhtcxfvxuWh36cGy5B4tTkAqU2yNyk";

$search_url = "https://www.googleapis.com/books/v1/volumes/$id/associated?key=$books_key";

$results = callUrl($search_url);
$results_json = json_decode($results, true);
$books_array = array();
foreach($results_json['items'] as $books) {
  // echo $books["id"];
  if(!isset($books["volumeInfo"]["averageRating"])) {
    $books["volumeInfo"]["averageRating"] = "NA";
  }
  if(!isset($books["volumeInfo"]["pageCount"])) {
    $books["volumeInfo"]["pageCount"] = "NA";
  }
  $books_array[] = array("id" => $books["id"], "title" => $books["volumeInfo"]["title"], "author" => $books["volumeInfo"]["authors"][0], "description" => $books["volumeInfo"]["description"], "cover" => $books["volumeInfo"]["imageLinks"]["thumbnail"], "rating" => $books["volumeInfo"]["averageRating"], "pages" => $books["volumeInfo"]["pageCount"]);
}
// do_dump($results_json);

echo json_encode(array("books" => $books_array));










?>