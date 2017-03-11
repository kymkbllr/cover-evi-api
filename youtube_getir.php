
<?php
require_once "app.php";

global $pdo;

$sql = $pdo->prepare("SELECT title, video FROM c2ley_k2_items WHERE catid = 4 AND published = 1 order by id DESC LIMIT 4;");
$sql->execute();

$data = $sql->fetchAll(PDO::FETCH_ASSOC);

// linklerin içi boş

$linkler = [];
//haber içindeki html taglarını sileceğiz.

// bu foreach ile $data içinde gelen title'ı linklerin içine koyuyoruz. daha sonra
// video içinde gelen iframe içerisinden youtube video idsini çekiyoruz.

foreach ($data as $link) {
    preg_match('/embed\/([A-Za-z0-9_-]+)/', $link ['video'], $youtube_id);

    $linkler [] = array(
        "title" => $link ["title"],
        "youtube_id" => $youtube_id[1],
        "thumbnail" => 'https://img.youtube.com/vi/'.$youtube_id[1].'/0.jpg'
        );
    //thumbnail öz izleme satırını göstermek için
}

echo json_encode($linkler);
