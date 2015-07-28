<?php
/**
* Essa classe é responsavel por fazer o upload de imagens e seu tratamento
* Deve ser passado o todo o $_FILES para a classe
* @deprecated Somente Imagem JPG, PNG
* @exemple UploadImagem($_FILES)
*/
class UploadImagem {
    private $type;
    private $tmp;
    private $nome;
    private $path;
    private $width;
    private $height;
    private $arquivos;
    
    function __construct( array $imagem ){
        
        if( is_array($imagem['imagem']['name']) ){
            
            $this->path = array();
            $this->nome = array();
            $this->width = array();
            $this->height = array();
            $this->tmp = array();
            
            
            $this->arquivos = count($imagem['imagem']['name']);
            for($i = 0; $i < $this->arquivos; $i++ ){
                
                $this->nome[$i] = preg_replace('/\.[^.]*$/', '', $imagem['imagem']['name'][$i]);
                $this->path[$i] = "./";
                $this->width[$i] = null;
                $this->height[$i] = null;
                $this->tmp[$i] = $imagem['imagem']['tmp_name'][$i];
                
                switch( $imagem['imagem']['type'][$i] ){
                    case 'image/jpg':
                    case 'image/jpeg':
                    case 'image/pjpeg':
                        $this->type[$i] = "image/jpg";
                        break;
                    case 'image/png':
                    case 'image/x-png':
                        $this->type[$i] = "image/png";
                        break;
                    default:
                        trigger_error("O formato dessa imagem não é valido por favor use 'JPG' ou 'PNG'", E_USER_ERROR);
                        return false;
                }
            }
            
        }else{
            $this->arquivos = 1;
            $this->nome = preg_replace('/\.[^.]*$/', '', $imagem['imagem']['name']);
            $this->path = "./";
            $this->width = null;
            $this->height = null;
            $this->tmp = $imagem['imagem']['tmp_name'];
            
            switch( $imagem['imagem']['type'] ){
                case 'image/jpg':
                case 'image/jpeg':
                case 'image/pjpeg':
                    $this->type = "image/jpg";
                    break;
                case 'image/png':
                case 'image/x-png':
                    $this->type = "image/png";
                    break;
                default:
                    trigger_error("O formato dessa imagem não é valido por favor use 'JPG' ou 'PNG'", E_USER_ERROR);
                    return false;
            }
        }
    }
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //SETERS
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
    * Esse metodo troca o nome da imagem(s), se preenchar a classe vai pegar o nome do arquivo
    * @deprecated Não coloque a estenção da imagem
    * @exemple Exemplo (string) setNome("nome_do_arquivo")
    * @exemple Exemplo (array)  setNome(array("nome01","nome02","nome3")), necessario quando voce usa mais de uma imagem
    */
    public function setNome($nome){
        if( $this->arquivos > 1 ){
            if( !is_array($nome) ){
                trigger_error("O metodo setNome() espera um array quando usa mais de 1 imagem for usada", E_USER_ERROR);
            }
            for( $i = 0; $i < $this->arquivos; $i++ ){
                if( !empty($nome[$i]) ){
                    $this->nome[$i] = (string)strip_tags(trim($nome[$i]));
                }
            }
        }else{
            if( is_array($nome) ){
                trigger_error("O metodo setNome() espera uma string quando somente 1 imagem for usada", E_USER_ERROR);
            }
            $this->nome = (string)strip_tags(trim($nome));
        }
    }
    
    /**
    * Esse metodo define o caminho da imagem(s), se não definido a imagem vai para a pasta onde script está sendo execultado
    * @exemple (string) setPath("caminho/")
    * @exemple (array) setPath(array("caminho01/", "caminho02/", "caminho03/")), necessario quando voce usa mais de uma imagem
    * @exemple (array) setPath(array("caminho01/")), necessario quando voce usa mais de uma imagem. Caso queria que todas as imagens tenho o mesmo caminho que não seja o do script
    */
    function setPath($path){       
        if( $this->arquivos > 1 ){
            if( !is_array($path) ){
                trigger_error("O metodo setPath() espera um array quando usa mais de 1 imagem for usada", E_USER_ERROR);
            }
            
            if( count($path) == 1 && !empty($path[0]) ){
                for( $i = 0; $i < $this->arquivos; $i++ ){
                    $this->path[$i] = (string)strip_tags(trim($path[0]));
                }
            
            }elseif( count($path) > 1 ){
                for( $i = 0; $i < $this->arquivos; $i++ ){
                    if( !empty($path[$i]) ){
                        $this->path[$i] = (string)strip_tags(trim($path[$i]));
                    }
                } 
            }
        }else{
            if( is_array($path) ){
                trigger_error("O metodo setPath() espera uma string quando somente 1 imagem for usada", E_USER_ERROR);
            }
            $this->path = (string)strip_tags(trim($path));
        }
    }

    /**
    * Esse metodo define o Width da imagem, se setWidth não estiver difinino e nem o setHeight a imagem vai com o seu tamanho original, se somente esse metodo estiver definido a classe vai redimencionar proporcionalmente a imagem
    * @exemple (int) setWidth(300)
    * @exemple (array) setWidth(array(300, 480, 640)), necessario quando voce usa mais de uma imagem
    * @exemple (array) setWidth(array(300)), necessario quando voce usa mais de uma imagem. Caso queria que todas as imagens tenho o mesmo Width que não seja o da imagem
    */
    public function setWidth($width) {
        if( $this->arquivos > 1 ){
            if( !is_array($width) ){
                trigger_error("O metodo setWidth() espera um array quando usa mais de 1 imagem for usada", E_USER_ERROR);
            }
            
            if( count($width) == 1 && !empty($width[0]) ){
                for( $i = 0; $i < $this->arquivos; $i++ ){
                    $this->width[$i] = (int)strip_tags(trim($width[0]));
                }
            
            }elseif( count($width) > 1 ){
                for( $i = 0; $i < $this->arquivos; $i++ ){
                    if( !empty($width[$i]) ){
                        $this->width[$i] = (int)strip_tags(trim($width[$i]));
                    }
                } 
            }
        }else{
            if( is_array($width) ){
                trigger_error("O metodo setWidth() espera um inteiro quando somente 1 imagem for usada", E_USER_ERROR);
            }
            $this->width = (int)strip_tags(trim($width));
        }
    }
    
    /**
    * Esse metodo define o Height da imagem, se setHeight não estiver difinino e nem o setWidth a imagem vai com o seu tamanho original, se somente esse metodo estiver definido a classe vai redimencionar proporcionalmente a imagem
    * @exemple (int) setHeight(180)
    * @exemple (array) setHeight(array(180, 240, 480)), necessario quando voce usa mais de uma imagem
    * @exemple (array) setHeight(array(180)), necessario quando voce usa mais de uma imagem. Caso queria que todas as imagens tenho o mesmo Height que não seja o da imagem
    */
    public function setHeight($height) {
        if( $this->arquivos > 1 ){
            if( !is_array($height) ){
                trigger_error("O metodo setHeight() espera um array quando usa mais de 1 imagem for usada", E_USER_ERROR);
            }
            
            if( count($height) == 1 && !empty($height[0]) ){
                for( $i = 0; $i < $this->arquivos; $i++ ){
                    $this->height[$i] = (int)strip_tags(trim($height[0]));
                }
            
            }elseif( count($height) > 1 ){
                for( $i = 0; $i < $this->arquivos; $i++ ){
                    if( !empty($height[$i]) ){
                        $this->height[$i] = (int)strip_tags(trim($height[$i]));
                    }
                } 
            }
        }else{
            if( is_array($height) ){
                trigger_error("O metodo setHeight() espera um inteiro quando somente 1 imagem for usada", E_USER_ERROR);
            }
            $this->height = (int)strip_tags(trim($height));
        }
    }
    
    /**
    * Depois de todos os metodos definidos, só utilizar esse metodo para realizar upload
    * @exemple upload()
    */
    public function upload(){
        if( $this->arquivos > 1 ){
            for( $i = 0; $i < $this->arquivos; $i++ ){
                switch( $this->type[$i] ){
                    case 'image/jpg':
                        $imagem = imagecreatefromjpeg($this->tmp[$i]);
                        break;
                    case 'image/png':
                        $imagem = imagecreatefrompng($this->tmp[$i]);
                        break;
                    default:
                        Alerta::inserirAlerta('erro', "Problema ao fazer upload de imagens");
                        return false;
                }
                $width = imagesx($imagem);
                $height = imagesy($imagem);
                
                if( !empty( $this->width[$i] ) && empty( $this->height[$i] ) ){
                    $this->height[$i] = ($this->width[$i] * ($height / $width));

                }elseif( empty( $this->width[$i] ) && !empty( $this->height[$i] ) ){
                    $this->width[$i] = ($this->height[$i] * ($width / $height));
                
                }elseif( empty( $this->width[$i] ) && empty( $this->height[$i] ) ){
                    $this->width[$i] = $width;
                    $this->height[$i] = $height;
                
                }
                
                $novaImagem = imagecreatetruecolor($this->width[$i], $this->height[$i]);
                imagealphablending($novaImagem, false);
                imagesavealpha($novaImagem, true);
                imagecopyresampled($novaImagem, $imagem, 0, 0, 0, 0, $this->width[$i], $this->height[$i], $width, $height);
                switch( $this->type[$i] ){
                    case 'image/jpg':
                        imagejpeg($novaImagem, $this->path[$i] . $this->nome[$i] . '.jpg');
                        break;
                    case 'image/png':
                        imagepng($novaImagem, $this->path[$i] . $this->nome[$i] . '.png');
                        break;
                }
                if( !imagedestroy($novaImagem) ){
                    return false;
                }
            }
        }else{
            switch( $this->type ){
                case 'image/jpg':
                    $imagem = imagecreatefromjpeg($this->tmp);
                    break;
                case 'image/png':
                    $imagem = imagecreatefrompng($this->tmp);
                    break;
                default:
                    Alerta::inserirAlerta('erro', "Problema ao fazer upload de imagens");
                    return false;
            }
            $width = imagesx($imagem);
            $height = imagesy($imagem);

            if( !empty( $this->width ) && empty( $this->height ) ){
                $this->height = ($this->width * ($height / $width));

            }elseif( empty( $this->width ) && !empty( $this->height ) ){
                $this->width = ($this->height * ($width / $height));

            }elseif( empty( $this->width ) && empty( $this->height ) ){
                $this->width = $width;
                $this->height = $height;

            }

            $novaImagem = imagecreatetruecolor($this->width, $this->height);
            imagealphablending($novaImagem, false);
            imagesavealpha($novaImagem, true);
            imagecopyresampled($novaImagem, $imagem, 0, 0, 0, 0, $this->width, $this->height, $width, $height);
            switch( $this->type ){
                case 'image/jpg':
                    imagejpeg($novaImagem, $this->path . $this->nome . '.jpg');
                    break;
                case 'image/png':
                    imagepng($novaImagem, $this->path . $this->nome . '.png');
                    break;
            }
            if( !imagedestroy($novaImagem) ){
                return false;
            }
        }
        return true;
    }
}
?>
