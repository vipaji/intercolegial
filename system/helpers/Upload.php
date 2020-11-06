<?php

class Upload {

//Atributo com as configurações  do ficheiro (Tamanho, altura, largura em pixels)
    private $config;
//Atributo para os erros de upload 
    private $erros;
// Atributo para o arquivo
    private $arquivo;
//diretorio 
    private $directorio;
    private $ficheiro_nome;
    private $ficheiro_desc;
    private $ficheiro_dir;
    private $ficheiro_ext;
    private $ficheiro_type;

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

    public function getAllowedMimeTypes() {
        return array(
            // Image formats
            "imagem" => array(
                'jpg|jpeg|jpe' => 'image/jpeg',
                'gif' => 'image/gif',
                'png' => 'image/png',
                'bmp' => 'image/bmp',
                'tif|tiff' => 'image/tiff',
                'ico' => 'image/x-icon'),
            // Video formats
            "video" => array(
                'asf|asx' => 'video/x-ms-asf',
                'wmv' => 'video/x-ms-wmv',
                'wmx' => 'video/x-ms-wmx',
                'wm' => 'video/x-ms-wm',
                'avi' => 'video/avi',
                'divx' => 'video/divx',
                'flv' => 'video/x-flv',
                'mov|qt' => 'video/quicktime',
                'mpeg|mpg|mpe' => 'video/mpeg',
                'mp4|m4v' => 'video/mp4',
                'ogv' => 'video/ogg',
                'webm' => 'video/webm',
                'mkv' => 'video/x-matroska'),
            // Audio formats
            "audio" => array(
                'mp3|m4a|m4b' => 'audio/mpeg',
                'ra|ram' => 'audio/x-realaudio',
                'wav' => 'audio/wav',
                'ogg|oga' => 'audio/ogg',
                'mid|midi' => 'audio/midi',
                'wma' => 'audio/x-ms-wma',
                'wax' => 'audio/x-ms-wax',
                'mka' => 'audio/x-matroska'),
            // Misc application formats
            "outro" => array(
                //'js' => 'application/javascript',
                //'swf' => 'application/x-shockwave-flash',
                //'class' => 'application/java',
                'tar' => 'application/x-tar',
                'zip' => 'application/zip',
                'gz|gzip' => 'application/x-gzip',
                'rar' => 'application/rar',
                '7z' => 'application/x-7z-compressed',
            //'exe' => 'application/x-msdownload'
            ),
            // Text formats
            "documento" => array(
                'pdf' => 'application/pdf',
                'rtf' => 'application/rtf',
                'txt|asc|c|cc|h' => 'text/plain',
                'csv' => 'text/csv',
                'tsv' => 'text/tab-separated-values',
                'ics' => 'text/calendar',
                'rtx' => 'text/richtext',
                //'css' => 'text/css',
                //'htm|html' => 'text/html',
                // MS Office formats
                'doc' => 'application/msword',
                'pot|pps|ppt' => 'application/vnd.ms-powerpoint',
                'wri' => 'application/vnd.ms-write',
                'xla|xls|xlt|xlw' => 'application/vnd.ms-excel',
                'mdb' => 'application/vnd.ms-access',
                'mpp' => 'application/vnd.ms-project',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'docm' => 'application/vnd.ms-word.document.macroEnabled.12',
                'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
                'dotm' => 'application/vnd.ms-word.template.macroEnabled.12',
                'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
                'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
                'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
                'xltm' => 'application/vnd.ms-excel.template.macroEnabled.12',
                'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
                'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'pptm' => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
                'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
                'ppsm' => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
                'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
                'potm' => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
                'ppam' => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
                'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
                'sldm' => 'application/vnd.ms-powerpoint.slide.macroEnabled.12',
                'onetoc|onetoc2|onetmp|onepkg' => 'application/onenote',
                // OpenOffice formats
                'odt' => 'application/vnd.oasis.opendocument.text',
                'odp' => 'application/vnd.oasis.opendocument.presentation',
                'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
                'odg' => 'application/vnd.oasis.opendocument.graphics',
                'odc' => 'application/vnd.oasis.opendocument.chart',
                'odb' => 'application/vnd.oasis.opendocument.database',
                'odf' => 'application/vnd.oasis.opendocument.formula',
                // WordPerfect formats
                'wp|wpd' => 'application/wordperfect',
                // iWork formats
                'key' => 'application/vnd.apple.keynote',
                'numbers' => 'application/vnd.apple.numbers',
                'pages' => 'application/vnd.apple.pages'),
        );
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

    public function getFicheiroDir() {
        return $this->ficheiro_dir;
    }

    public function getFicheiroNome() {
        return $this->ficheiro_nome;
    }

    public function getFicheiroDescricao() {
        return $this->ficheiro_desc;
    }

    public function getFicheiroExt() {
        return $this->ficheiro_ext;
    }

    public function getFicheiroType() {

        foreach ($this->getAllowedMimeTypes() as $key => $value) {
            if (in_array((string) $this->arquivo["type"], array_values($value))) {
                return $key;
            }
        }

        return null;
    }

    public function verificarFicheiro() {

        if ($this->arquivo) {

            // Verifica se o mime-type do arquivo é de ficheiro


            if ($this->getFicheiroType() == null) {
                $this->erros[] = "Ficheiro em formato inválido!  Envie outro Ficheiro";
            } else {

                // Verifica tamanho do arquivo
                if ($this->arquivo["size"] > $this->config["tamanho"]) {
                    $this->erros[] = "Arquivo em tamanho muito grande! A ficheiro deve ser de no máximo " . $this->config["tamanho"] . " bytes. Envie outro arquivo";
                }

                //No caso de uma imagem verificar a altura e largura 
                if ($this->getFicheiroType() == "imagem") {
                    $tamanhos = getimagesize($this->arquivo["tmp_name"]);

                    // Verifica largura
                    if ($tamanhos[0] > $this->config["largura"]) {
                        $this->erros[] = "Largura da ficheiro não deve ultrapassar " . $this->config["largura"] . " pixels";
                    }

                    // Verifica altura
                    if ($tamanhos[1] > $this->config["altura"]) {
                        $this->erros[] = "Altura da ficheiro não deve ultrapassar " . $this->config["altura"] . " pixels";
                    }
                }
            }
        }
    }

    public function upload() {

        // $this->verificarFicheiro();

        if (sizeof($this->erros)) {
            return FALSE;
        } else {

            // Pega extensão do arquivo 
            //preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $this->arquivo["name"], $this->ficheiro_ext);
            $this->ficheiro_ext = str_replace(' ', '-', strtolower($this->arquivo["name"]));
            $this->ficheiro_ext = substr($this->ficheiro_ext, strrpos($this->ficheiro_ext, '.'));
            $this->ficheiro_ext = str_replace('.', '', $this->ficheiro_ext);

            //Pega a descricao do ficheiro 
            $this->ficheiro_desc = $this->arquivo["name"];

            // Gera um nome único para a ficheiro 
            $this->ficheiro_nome = md5(uniqid(time())) . "." . $this->ficheiro_ext;

            // Caminho de onde a ficheiro ficará 
            $this->ficheiro_dir = $this->directorio . $this->ficheiro_nome;

            // Faz o upload da ficheiro
            if (move_uploaded_file($this->arquivo["tmp_name"], $this->ficheiro_dir)) {

                return TRUE;
            } else {
                $this->erros[] = "Problemas no upload !! ";
                return FALSE;
            }
        }
    }

    /**
     * @name reArrayFiles
     * @description método de reordena a Variavel de Upload do POST  
     * @param array $file_post
     * @return array()
     */
    public static function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }

}
