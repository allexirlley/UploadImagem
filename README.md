# UploadImagem
Essa classe é responsavel por fazer o upload de imagens e seu redimencionamento.<br>
Deve ser passado o todo o $_FILES para a classe

## Exemplo
```php
<?php
require_once "UploadImagem.class.php";

//EXEMPLO COM UMA IMAGEM
$upload = new UploadImagem($_FILES);
$upload->setNome("nome_imagem");   //NOME DA IMAGEM - OPCIONAL
$uploda->setPath("diretorio/");  //DIRETORIO PARA SALVAR A IMAGEM - OPCIONAL
$uploda->setWidth(100);           //DEFINIAR A LAGURA DA IMAGEM - OPCIONAL
$uploda->setHeight(100);          //DEFINIAR A ALTURA DA IMAGEM - OPCIONAL
$upload->upload();

//EXEMPLO COM VARIAS IMAGEM
$upload = new UploadImagem($_FILES);
$upload->setNome(array("nome_imagem01","nome_imagem02")); //NOME DA IMAGEM - OPCIONAL
$uploda->setPath(array("diretorio01/","diretorio02/"));   //DIRETORIO PARA SALVAR A IMAGEM - OPCIONAL
$uploda->setWidth(array(100, 160));                       //DEFINIAR A LAGURA DA IMAGEM - OPCIONAL
$uploda->setHeight(array(100, 160));                      //DEFINIAR A ALTURA DA IMAGEM - OPCIONAL
$upload->upload();

?>
```
