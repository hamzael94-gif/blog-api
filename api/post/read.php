<?php 
// Header

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instruction blog post object
$database = new Database();
$db = $database->connect();

$post = new Post($db);

//Blog post Query

$results = $post->read();

//Get row query

$num = $results->rowCount();

// check if any posts 

if($num > 0)
{
    $posts_arr = array();

    $posts_arr['data'] = array();

    while($row = $results->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body'=> html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        );
        //Push to "data"
        array_push($posts_arr['data'],$post_item);
    }

    //Turn to json & output

    echo json_encode($posts_arr);
}else{
    //No posts
    echo json_encode(
        array('message'=> 'No Posts Found')
    );
}