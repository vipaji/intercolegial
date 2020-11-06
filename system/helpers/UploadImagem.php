<?php

class UploadImagem {

//Atributo com as configurações  da imagem (Tamanho, altura, largura em pixels)
    private $config;
//Atributo para os erros de upload 
    private $erros;
// Atributo para o arquivo
    private $arquivo;
//diretorio 
    private $directorio;
    private $imagem_nome;
    private $imagem_dir;
    private $imagem_ext;

    public function __construct($arquivo, $directorio, $config = null) {
        $this->config = ( (isset($config) && $config != null && !empty($config)) ? $config : array('tamanho' => 3000000000006883, 'altura' => 1000000000, 'largura' => 12000000000));
        $this->arquivo = ( isset($arquivo) ? $arquivo : FALSE);

        if (!file_exists($directorio)) {

            if (!mkdir($directorio, 0777, true)) {
                $this->erros[] = 'Falha na criação do directório';
            }
        }

        $this->directorio = $directorio;
        $this->erros = array();
    }

    public function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
        return $this;
    }

    public function setConfig($config) {
        $this->config = $config;
        return $this;
    }

    public function setDirectorio($directorio) {
        $this->directorio = $directorio;
        return $this;
    }

    public function getErrors() {
        return $this->erros;
    }

    public function getConfig() {
        return $this->config;
    }

    public function getArquivo() {
        return $this->arquivo;
    }

    public function getDirectorio() {
        return $this->directorio;
    }

    public function getImagemDir() {
        return $this->imagem_dir;
    }

    public function getImagemNome() {
        return $this->imagem_nome;
    }

    public function getImagemExt() {
        return $this->imagem_ext;
    }

    public function verificarImagem() {

        if ($this->arquivo) {

// Verifica se o mime-type do arquivo é de imagem
            if (!preg_match("/^image\/(pjpeg|PJPEG|jpeg|JPEG|png|PNG|gif|GIF|bmp|BMP|jpg|JPG)$/i", $this->arquivo["type"])) {
                $this->erros[] = "Arquivo em formato inválido! A imagem deve ser jpg, jpeg, bmp, gif ou png. Envie outro arquivo";
            } else {
// Verifica tamanho do arquivo
                if ($this->arquivo["size"] > $this->config["tamanho"]) {
                    $this->erros[] = "Arquivo em tamanho muito grande! A imagem deve ser de no máximo " . $this->config["tamanho"] . " bytes. Envie outro arquivo";
                }
                $tamanhos = getimagesize($this->arquivo["tmp_name"]);
// Verifica largura
                if ($tamanhos[0] > $this->config["largura"]) {
                    $this->erros[] = "Largura da imagem não deve ultrapassar " . $this->config["largura"] . " pixels";
                }
// Verifica altura
                if ($tamanhos[1] > $this->config["altura"]) {
                    $this->erros[] = "Altura da imagem não deve ultrapassar " . $this->config["altura"] . " pixels";
                }
            }
        }
    }

    public function upload() {

        $this->verificarImagem();

        if (sizeof($this->erros)) {
            return FALSE;
        } else {

            // Pega extensão do arquivo 
            preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $this->arquivo["name"], $this->imagem_ext);

            // Gera um nome único para a imagem 
            $this->imagem_nome = md5(uniqid(time())) . "." . $this->imagem_ext[1];

            // Caminho de onde a imagem ficará 
            $this->imagem_dir = $this->directorio . $this->imagem_nome;

            // Faz o upload da imagem
            if (move_uploaded_file($this->arquivo["tmp_name"], $this->imagem_dir)) {

                return TRUE;
            } else {
                $this->erros[] = "Problemas no upload !! ";
                return FALSE;
            }
        }
    }

    public static function eliminaImagem($imagem) {
        try {
            unlink($imagem);
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

}
