<?php

$title = $_GET['entry'] ?? null;
$entry = get_entries(null, null, $title);
$entry = $entry[0];

include 'inc/templates/parts/post.php';