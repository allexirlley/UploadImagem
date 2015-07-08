# UploadImagem
Essa classe é responsavel por fazer o upload de imagens e seu tratamento
Deve ser passado o todo o $_FILES para a classe

Exemplo
$upload = new UploadImagem($_FILES);
$upload->setNome("quem_somos");   //NOME DA IMAGEM - OPCIONAL
$uploda->setPath("./diretorio");  //DIRETORIO PARA SALVAR A IMAGEM - OPCIONAL
$uploda->setWidth(100);           //DEFINIAR A LAGURA DA IMAGEM - OPCIONAL
$uploda->setHeight(100);          //DEFINIAR A ALTURA DA IMAGEM - OPCIONAL
$upload->upload();
