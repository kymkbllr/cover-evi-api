<?php
require_once "app.php";

global $pdo;

if (isset($_GET ["id"])){
    $sql  = $pdo->prepare("SELECT title, extra_fields_search FROM c2ley_k2_items WHERE catid = 3 AND published = 1 AND id = :id;");
    $sql->execute([":id" => $_GET ["id"]]);

    //execute edip içerisine id atayıp get'in içerisine atanan idleri sql injection ataklarından korumak için yaptık.
    //http://localhost/coverevi_api/haber_getir.php? -> buraya gelen idler get ile./
}
else {
    $sql = $pdo->prepare("SELECT title, extra_fields_search FROM c2ley_k2_items WHERE catid = 3 AND published = 1 order by id DESC LIMIT 4;");
    $sql->execute();
}

$data = $sql->fetchAll(PDO::FETCH_ASSOC);

$haberler = [];
//haber içindeki html taglarını sileceğiz.

foreach ($data as $haber) {
    $haber ["introtext"]=strip_tags($haber ["extra_fields_search"]);
    $haberler [] = $haber;
}

echo json_encode($haberler);
