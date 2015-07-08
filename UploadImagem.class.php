<?php
/**
* Essa classe é responsavel por fazer o upload de imagens e seu tratamento
 * Deve ser passado o todo o $_FILES para a classe
*/
class UploadImagem {
    private $imagem;
    private $nome;
    private $path = "./";
    private $width;
    private $height;
    
    function __construct( array $imagem ){
        $this->nome = $imagem['imagem']['name'];
        switch( $imagem['imagem']['type'] ){
            case 'image/jpg':
            case 'image/jpeg':
            case 'image/pjpeg':
                 $this->imagem = $imagem['imagem'];
                break;
            case 'image/png':
            case 'image/x-png':
                $this->imagem = $imagem['imagem'];
                break;
            default:
                return "O formato dessa imagem não é valido por favor use 'JPG' ou 'PNG'";
        }
    }
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //SETERS
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
    * Esse metodo troca o nome da imagem, não coloque a estenção
    */
    public function setNome($nome) {
        $this->nome = (string)strip_tags(trim($nome));
    }
    
    function setPath($path) {
        $this->path = (string)strip_tags(trim($path));
    }
    
    public function setWidth($width) {
        $this->width = (int)strip_tags(trim($width));
    }

    public function setHeight($height) {
        $this->height = (int)strip_tags(trim($height));
    }

    public function upload(){
        switch( $this->imagem['type'] ){
            case 'image/jpg':
            case 'image/jpeg':
            case 'image/pjpeg':
                $imagem = imagecreatefromjpeg($this->imagem['tmp_name']);
                break;
            case 'image/png':
            case 'image/x-png':
                $imagem = imagecreatefrompng($this->imagem['tmp_name']);
                break;
            default:
                return "Problema ao fazer upload de imagens";
        }
        $width = imagesx($imagem);
        $height = imagesy($imagem);
        
        if( !empty( $this->width ) ){
            $this->height = ($this->width * ($height / $width));
           
        }elseif( !empty( $this->height ) ){
            $this->width = ($this->height * ($width / $height));
        
        }elseif( empty( $this->width ) || empty( $this->height ) ){
            $this->width = $width;
            $this->height = $height;
        }
        
        $novaImagem = imagecreatetruecolor($this->width, $this->height);
        imagealphablending($novaImagem, false);
        imagesavealpha($novaImagem, true);
        imagecopyresampled($novaImagem, $imagem, 0, 0, 0, 0, $this->width, $this->height, $width, $height);
        switch( $this->imagem['type'] ){
            case 'image/jpg':
            case 'image/jpeg':
            case 'image/pjpeg':
                imagejpeg($novaImagem, $this->path . $this->nome . '.jpg');
                break;
            case 'image/png':
            case 'image/x-png':
                imagepng($novaImagem, $this->path . $this->nome . '.png');
                break;
        }
        imagedestroy($novaImagem);
    }
}
?>
