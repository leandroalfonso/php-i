<?php
header("Access-Control-Allow-Origin: *");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["imagem"])) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["imagem"]["name"]);

    // Verifica se o arquivo é uma imagem válida
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedTypes = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedTypes)) {
        http_response_code(400);
        echo json_encode(array("message" => "Apenas imagens JPG, JPEG, PNG e GIF são permitidas."));
        exit();
    }

    // Move o arquivo para o diretório de uploads
    if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $targetFile)) {
        $dados = array(
            "nome" => $_POST["nome"],
            "idade" => $_POST["idade"],
            "cidade" => $_POST["cidade"],
            "imagem" => $targetFile
        );

        echo json_encode($dados);
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Ocorreu um erro ao fazer upload do arquivo."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Requisição inválida. Certifique-se de que está fazendo uma requisição POST com uma imagem."));
}
?>
