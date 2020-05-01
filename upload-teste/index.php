<?php
require __DIR__ . '/../../fullstackphp/fsphp.php';
fullStackPHPClassName("03.10 - Upload de arquivos");

/*
 * [ upload ] sizes | move uploaded | url validation
 * [ upload errors ] http://php.net/manual/pt_BR/features.file-upload.errors.php
 * 1 - criamos a pasta para onde enviaremos os uploads
 * filesize (180mb) - é o tamanho maximo permitido pelo servidor php para ex uma imagem(configuravel)
 * postsize (180mb) - é o tamnho total de todos os campos preenchhidos em um form e permitidos para envio (configurável)
 * É atraves da função mimi_content_type que definimos o que podemos aceitar de upload(ex. jpeg, jpg, png, pdf)
 */
fullStackPHPClassSession("upload", __LINE__);

$folder = __DIR__ . "/uploads";
if(!file_exists($folder) || !is_dir($folder)) {
    mkdir($folder, 0755);
}

/*var_dump([
    "filesize" => ini_get("upload_max_filesize"),
    "post_size" => ini_get("post_max_size")
]);
*/

/*/var_dump([
    filetype(__DIR__ . "/index.php"),
    mime_content_type(__DIR__ . "/index.php")
]);
*/

//Se for true é porque o arquivo é valido(tipo de arquivo e o tamanho max permitido)
$getPost = filter_input(INPUT_GET, "post", FILTER_VALIDATE_BOOLEAN);
var_dump($getPost);

//2- Verificamos se existe um post de um arquivo e se é um arquivo, senao se estourar o tamanho max...senao esta em branco, selecione um arquivo 
if ($_FILES && !empty($_FILES['file']['name'])) {
    $fileUpload = $_FILES['file'];
    var_dump($fileUpload);

    $allowebTypes = [
        "image/jpg",
        "image/jpeg",
        "image/png",
        "application/pdf",
        "text/plain"        
    ];

    //renomeando o arquivo fileUpload
    $newFilename = time() . mb_strstr($fileUpload['name'], ".");

    if (in_array($fileUpload['type'], $allowebTypes)) {
        //vou mover o arquivo do local atual(tmp name) para a pasta uploads ja renomeando..se tudo ok(true)
        if(move_uploaded_file($fileUpload['tmp_name'], __DIR__ . "/uploads/{$newFilename}")) {
            echo "<p class='trigger accept'>Arquivo enviado com sucesso!</p>";
        } else {
            echo "<p class='trigger error'>Erro inesperado no servidor!</p>";
        }
    } else {
        echo "<p class='trigger error'>Formato não suportado!</p>";    
    }
} elseif ($getPost) {
    echo "<p class='trigger warning'>Woohh, parece que o arquivo é muito grande</p>";
} else {
    if($_FILES) {
        echo "<p class='trigger warning'>Selecione um arquivo antes de enviar</p>";
    }
    
}



include __DIR__ . "/form.php";
var_dump(scandir(__DIR__. "/uploads"));