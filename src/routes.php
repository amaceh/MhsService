<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
// defaul function
$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get("/matkul/", function (Request $request, Response $response){
    $sql = "SELECT * FROM kuliah";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

$app->get("/matkul/get/{id}/", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $sql = "SELECT * FROM kuliah WHERE kode_mk=:id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([":id" => $id]);
    $result = $stmt->fetch();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

$app->get("/matkul/search/", function (Request $request, Response $response, $args){
    $keyword = $request->getQueryParam("keyword");
    $sql = "SELECT * FROM kuliah WHERE kode_mk LIKE '%$keyword%' OR nama_mk LIKE '%$keyword%' OR nama_dosen LIKE '%$keyword%' OR sks LIKE '%$keyword%'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
    //var_dump($sql);
});

$app->post("/matkul/", function (Request $request, Response $response){

    $new_mk = $request->getParsedBody();

    $sql = "INSERT INTO kuliah (nama_mk, nama_dosen, sks) VALUE (:nama_mk, :nama_dosen, :sks)";
    $stmt = $this->db->prepare($sql);

    $data = [
        ":nama_mk" => $new_mk["nama_mk"],
        ":nama_dosen" => $new_mk["nama_dosen"],
        ":sks" => $new_mk["sks"]
    ];

    if($stmt->execute($data))
       return $response->withJson(["status" => "success", "data" => "1"], 200);
    
    return $response->withJson(["status" => "failed", "data" => "0"], 200);
});


$app->put("/matkul/{id}/", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $new_mk = $request->getParsedBody();
    $sql = "UPDATE kuliah SET nama_mk=:nama_mk, nama_dosen=:nama_dosen, sks=:sks WHERE kode_mk=:id";
    $stmt = $this->db->prepare($sql);
    
    $data = [
        ":id" => $id,
        ":nama_mk" => $new_mk["nama_mk"],
        ":nama_dosen" => $new_mk["nama_dosen"],
        ":sks" => $new_mk["sks"]
    ];

    if($stmt->execute($data))
       return $response->withJson(["status" => "success", "data" => "1"], 200);
    
    return $response->withJson(["status" => "failed", "data" => "0"], 200);
});


$app->delete("/matkul/{id}/", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $sql = "DELETE FROM kuliah WHERE kode_mk=:id";
    $stmt = $this->db->prepare($sql);
    
    $data = [
        ":id" => $id
    ];

    if($stmt->execute($data))
       return $response->withJson(["status" => "success", "data" => "1"], 200);
    
    return $response->withJson(["status" => "failed", "data" => "0"], 200);
});
