<?php

global $post, $current_user; //for this example only :)

$comment_data = array(
    'comment_post_ID'      => 85, // to which post the comment will show up
    'comment_author'       => 'Another Someone', //fixed value - can be dynamic
    'comment_author_email' => 'someone@example.com', //fixed value - can be dynamic
    'comment_author_url'   => 'http://example.com', //fixed value - can be dynamic
    'comment_content'      => 'Comment messsage...', //fixed value - can be dynamic
    'comment_type'         => '',// empty for regular comments, 'pingback' for pingbacks, 'trackback' for trackbacks
    'comment_parent'       => 0, // 0 if it's not a reply to another comment; if it's a reply, mention the parent comment ID here
    'user_id'              => 0, //passing current user ID or any predefined as per the demand
);

//Insert new comment and get the comment ID
$comment_id = wp_new_comment( $comment_data );



?>