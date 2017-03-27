
<?php
require_once "app.php";

global $pdo;

$sql = $pdo->prepare("SELECT title, video FROM c2ley_k2_items WHERE catid IN (30,31,4,25,24,23,26,14,22,21,13,12) AND publish_up <= CURDATE( ) AND published = 1 ORDER BY id DESC LIMIT 10;");
$sql->execute();

$data = $sql->fetchAll(PDO::FETCH_ASSOC);

// linklerin içi boş

$linkler = [];
//haber içindeki html taglarını sileceğiz.

// bu foreach ile $data içinde gelen title'ı linklerin içine koyuyoruz. daha sonra
// video içinde gelen iframe içerisinden youtube video idsini çekiyoruz.

foreach ($data as $link) {
    // regular expression
    preg_match('/embed\/([A-Za-z0-9_-]+)/', $link ['video'], $youtube_id);

    $linkler [] = array(
        "title" => $link ["title"],
        "youtube_id" => $youtube_id[1],
        "thumbnail" => 'https://img.youtube.com/vi/'.$youtube_id[1].'/0.jpg'
        );
    //thumbnail öz izleme satırını göstermek için
}

echo json_encode(
    array("results" => $linkler)
);
