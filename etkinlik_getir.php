<?php
require_once "app.php";

global $pdo;

if (isset($_GET ["id"])){
    $sql  = $pdo->prepare("SELECT title, extra_fields FROM c2ley_k2_items WHERE catid = 3 AND published = 1 AND id = :id;");
    $sql->execute([":id" => $_GET ["id"]]);

    //execute edip içerisine id atayıp get'in içerisine atanan idleri sql injection ataklarından korumak için yaptık.
    //http://localhost/coverevi_api/haber_getir.php? -> buraya gelen idler get ile./
}
else {
    $count = 4;

    if (isset($_GET["count"]) && is_numeric($_GET["count"]))
        $count = $_GET["count"];

    $sql = $pdo->prepare("SELECT title, extra_fields FROM c2ley_k2_items WHERE catid = 3 AND published = 1 AND trash = 0 order by id DESC LIMIT :cnt;");
    $sql->bindValue(":cnt", intval($count), PDO::PARAM_INT);
    $sql->execute();
}

$data = $sql->fetchAll(PDO::FETCH_ASSOC);

$haberler = [];
//haber içindeki html taglarını sileceğiz.

foreach ($data as $haber) {
    $haberTmp = [];
    $event = json_decode($haber['extra_fields']);

    $haberTmp ["title"] = $haber["title"];
    $haberTmp ["icerik"] = strip_tags($event[0]->value);
    $haberTmp ["adres"] = strip_tags($event[1]->value);
    $haberTmp ["tarih"] = $event[2]->value;
    $haberTmp ["saat"] = $event[3]->value;

    $haberler [] = $haberTmp;
}

echo json_encode(
    array("results" => $haberler)
);
