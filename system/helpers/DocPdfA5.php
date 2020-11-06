<?php

require_once 'tcpdf/tcpdf.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DocPdfA5
 *
 * @author Administrator
 */
class DocPdfA5 extends TCPDF {

    private $titulo;
    private $direitosAutor;
    private $utilizador;
    private $dataActual;

    public function __construct($orientacao, $titulopagina, $utilizador, $dataActual, $direitosAutor, $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false, $pdfa = false) {
        $this->titulo = $titulopagina;
        $this->utilizador = $utilizador;
        $this->direitosAutor = $direitosAutor;
        $this->dataActual = $dataActual;

        $this->definicoes();
        parent::__construct($orientacao, $unit = 'mm', $format, $unicode, $encoding, $diskcache, $pdfa);
        $this->AddPage();
    }

    private function definicoes() {

        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('BPM');
        $this->SetTitle('Grupo Boavida');
        $this->SetSubject('Grupo Boavida');
        $this->SetKeywords('BPM, PDF, BPM, IT, guide');
        $this->SetAutoPageBreak(true, 80);
    }

    /**
     * I- Visualizar no browser
     * D- Download
     * @author Administrator
     */
    public function visualizar($titulo = 'gbv', $tipo = 'I') {
        $this->Output($titulo . 'pdf', $tipo);
    }

//Cabeçalho da página
    public function Header() {

        if ($this->page == 1) {
            $img_grupoboavida = K_PATH_IMAGES . 'gbv.png';
            $img_helpdesk = K_PATH_IMAGES . 'Muxima_logo_.png';
            $img_marca_agua = K_PATH_IMAGES . 'boavida_marcadaguae.png';
            if ($this->CurOrientation == 'P') {
                $this->Image($img_grupoboavida, 165, 10, 35, '', 'PNG', '', 'B', false, 300, '', false, false, 0, false, false, false);
                $this->Image($img_helpdesk, 10, 10, 45, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                $this->Image($img_marca_agua, 90, 40, 120, '', 'PNG', '', 'B', false, 300, '', false, false, 0, false, false, false);
                $this->Ln(-240);
            } else {

                $this->Image($img_grupoboavida, 240, 10, 35, '', 'PNG', '', 'B', false, 300, '', false, false, 0, false, false, false);
                $this->Image($img_helpdesk, 10, 10, 55, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                $this->Image($img_marca_agua, 217, 30, 80, '', 'PNG', '', 'B', false, 300, '', false, false, 0, false, false, false);
                $this->Ln(-155);
            }
            $this->SetFont('Montserrat', 'BU', 18);

            $this->Cell(0, 15, $this->titulo, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        } else {
            
        }
    }

    public function imprimirFichaEquipamento($entidade, $acessorios) {


        $this->Ln(25);
        $this->SetFont('Montserrat', 'BU', 14);
        $this->Cell(0, 15, $this->titulo, 0, 2, 'C', 0);

        $this->addFont('Montserrat', '', 'Montserrat.php');

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);

        $fill = 1;
        $distancia_linhas = 3;
        $distancia_separador = 2;
        $altura_campo = 6;

        $this->SetFont('Montserrat', 'B', 10);
        $this->SetFillColor(209, 209, 209);
        $this->SetTextColor(0);



        $this->SetX(5);
        if($entidade->getColaborador()!=null){
        $this->Cell(200, 8, "DADOS DO(A) COLABORADOR(A)", 0, 0, 'C', $fill);

        $this->Ln(9);
        ########### Início  da 1ª Linha ################
        $this->addFont('MontserratMedium', '', 'MontserratMedium.php');
        $this->SetFont('MontserratMedium', '', 8);
        $this->SetFillColor(242, 242, 242);
        $this->SetTextColor(0);
        $this->SetX(5);
        $nome = $entidade->getColaborador()->getNome() != null ? $entidade->getColaborador()->getNome() : "";
        $this->WriteHTMLCell(98, $altura_campo, "", "", '<b>Nome:</b> ' . $nome, 0, 0, 'L', $fill);

        //Divisória, Cell em branco
        $this->SetFillColor(255, 255, 255);
        $this->Cell(4, $altura_campo, "", 0, 0, 'L', $fill);

        $this->SetFillColor(242, 242, 242);
        $this->SetTextColor(0);
        $this->SetFont('MontserratMedium', '', 8);
        $empresa = $entidade->getColaborador()->getEmpresa()->getNome();
        $this->Cell(98, $altura_campo, "Empresa: " . $empresa, 0, 1, 'L', $fill);
        ########### Fim  da 1ª Linha ################

        $this->Ln($distancia_linhas);
        ########### Início  da 2ª Linha ################
        $this->SetFont('MontserratMedium', '', 8);
        $this->SetFillColor(242, 242, 242);
        $this->SetTextColor(0);
        $this->SetX(5);
        $departamento = $entidade->getColaborador()->getDepartamento() == null ? "" : $entidade->getColaborador()->getDepartamento()->getNome();
        $this->Cell(98, $altura_campo, "Departamento: " . $departamento, 0, 0, 'L', $fill);

        //Divisória, Cell em branco
        $this->SetFillColor(255, 255, 255);
        $this->Cell(4, $altura_campo, "", 0, 0, 'L', $fill);


        $this->SetFillColor(242, 242, 242);
        $this->SetTextColor(0);
        $this->SetFont('MontserratMedium', '', 8);
        $email = $entidade->getColaborador()->getEmail() == null ? "" : $entidade->getColaborador()->getEmail();
        $this->Cell(98, $altura_campo, "E-mail: " . $email, 0, 1, 'L', $fill);
        
        }
        ########### Fim  da 2ª Linha ################

        $codigo = $entidade->getCodigo();

        $this->SetFillColor(209, 209, 209);
        $this->SetFont('Montserrat', '', 10);
        $this->Ln($distancia_separador);
        $this->SetX(5);
        $this->Cell(200, 8, "DADOS DO EQUIPAMENTO " . $codigo, 0, 0, 'C', $fill);

        $this->Ln(9);
        ########### Início  da 4ª Linha ################
        $this->addFont('MontserratMedium', '', 'MontserratMedium.php');
        $this->SetFont('MontserratMedium', '', 8);
        $this->SetFillColor(242, 242, 242);
        $this->SetTextColor(0);
        $this->SetX(5);
        $categoria = $entidade->getCategoria() == null ? "" : Method::daNomeCategoria($entidade->getCategoria());
        $this->Cell(98, $altura_campo, "Categoria: " . $categoria, 0, 0, 'L', $fill);

        //Divisória, Cell em branco
        $this->SetFillColor(255, 255, 255);
        $this->Cell(4, $altura_campo, "", 0, 0, 'L', $fill);

        $this->SetFillColor(242, 242, 242);
        $this->SetTextColor(0);
        $this->SetFont('MontserratMedium', '', 8);
        $marca = $entidade->getMarca() == null ? "" : $entidade->getMarca()->getNome();
        $this->Cell(98, $altura_campo, "Marca: " . $marca, 0, 1, 'L', $fill);

        $this->Ln($distancia_linhas);


        $this->SetFont('MontserratMedium', '', 8);
        $this->SetFillColor(242, 242, 242);
        $this->SetTextColor(0);
        $this->SetX(5);
        $modelo = $entidade->getModelo() == null ? "" : $entidade->getModelo();
        $this->Cell(98, $altura_campo, "Modelo: " . $modelo, 0, 0, 'L', $fill);

        //Divisória, Cell em branco
        $this->SetFillColor(255, 255, 255);
        $this->Cell(4, $altura_campo, "", 0, 0, 'L', $fill);

        $this->SetFillColor(242, 242, 242);
        $this->SetTextColor(0);
        $this->SetFont('MontserratMedium', '', 8);
        $descricao = $entidade->getDescricao() == null ? "" : $entidade->getDescricao();
        $this->Cell(98, $altura_campo, "Descrição: " . $descricao, 0, 1, 'L', $fill);


        ########### Fim  da 4ª Linha ################


        $this->SetFillColor(209, 209, 209);
        $this->SetFont('Montserrat', '', 10);
        $this->Ln(2);
        $this->SetX(5);
        $this->Cell(200, 8, "ACESSÓRIO(S)", 0, 0, 'C', $fill);

        $this->Ln(9);
        ########### Início  da 5ª Linha ################

        if ($acessorios != null) {
            foreach ($acessorios as $acessorio) {

                $this->addFont('MontserratMedium', '', 'MontserratMedium.php');
                $this->SetFont('MontserratMedium', '', 8);
                $this->SetFillColor(242, 242, 242);
                $this->SetTextColor(0);
                $this->SetX(5);
                $this->Cell(98, $altura_campo, "Categoria: " . Method::daNomeCategoria($acessorio->getAcessorio()->getCategoria()), 0, 0, 'L', $fill);

                //Divisória, Cell em branco
                $this->SetFillColor(255, 255, 255);
                $this->Cell(4, $altura_campo, "", 0, 0, 'L', $fill);

                $this->SetFillColor(242, 242, 242);
                $this->SetTextColor(0);
                $this->SetFont('MontserratMedium', '', 8);
                $this->Cell(98, $altura_campo, "Marca: " . $acessorio->getAcessorio()->getMarca()->getNome(), 0, 1, 'L', $fill);
                ########### Fim  da 5ª Linha ################

                $this->Ln(1);
                ########### Início  da 6ª Linha ################
                $this->addFont('MontserratMedium', '', 'MontserratMedium.php');
                $this->SetFont('MontserratMedium', '', 8);
                $this->SetFillColor(242, 242, 242);
                $this->SetTextColor(0);
                $this->SetX(5);
                $this->Cell(98, $altura_campo, "Modelo: " . $acessorio->getAcessorio()->getModelo(), 0, 0, 'L', $fill);

                //Divisória, Cell em branco
                $this->SetFillColor(255, 255, 255);
                $this->Cell(4, $altura_campo, "", 0, 0, 'L', $fill);

                $this->SetFillColor(242, 242, 242);
                $this->SetTextColor(0);
                $this->SetFont('MontserratMedium', '', 8);
                $this->Cell(98, $altura_campo, "Descrição: " . $acessorio->getAcessorio()->getDescricao(), 0, 1, 'L', $fill);

                $this->Ln($distancia_linhas);
            }
        }

        $this->Ln(2 * $distancia_linhas);
        $this->Ln($distancia_linhas);
        $this->Ln($distancia_linhas);
        ########### Início  da 6ª Linha ################


        $this->addFont('MontserratMedium', '', 'MontserratMedium.php');
        $this->SetFont('MontserratMedium', '', 8);
        $this->SetFillColor(242, 242, 242);
        $this->SetTextColor(0);
        $this->SetX(5);
        //echo $entidade->getDataEntrega(); die;
        $data_entrega = $entidade->getDataEntrega() == null ? "" : Data::converteAMD2ptDMA($entidade->getDataEntrega());
        $this->Cell(99, $altura_campo, "Data de entrega: " . $data_entrega, 0, 0, 'C', $fill);

        $this->Ln(12);


        $this->addFont('MontserratMedium', '', 'MontserratMedium.php');
        $this->SetFont('MontserratMedium', '', 8);
        $this->SetFillColor(242, 242, 242);
        $this->SetTextColor(0);
        $this->SetX(5);
        $this->Cell(99, $altura_campo + 2, "", 0, 0, 'C', $fill);

        //Divisória, Cell em branco
        $this->SetFillColor(255, 255, 255);
        $this->Cell(2, $altura_campo, "", 0, 0, 'L', $fill);

        $this->SetFillColor(242, 242, 242);
        $this->SetTextColor(0);
        $this->SetFont('MontserratMedium', '', 8);

        $this->Cell(99, $altura_campo + 2, " ", 0, 1, 'C', $fill);

        $this->Ln(1);


        $this->addFont('MontserratMedium', '', 'MontserratMedium.php');
        $this->SetFont('MontserratMedium', '', 8);
        $this->SetFillColor(242, 242, 242);
        $this->SetTextColor(0);
        $this->SetX(5);
        $this->Cell(99, $altura_campo - 2, "Assinatura do TI", 0, 0, 'C', $fill);

        //Divisória, Cell em branco
        $this->SetFillColor(255, 255, 255);
        $this->Cell(2, $altura_campo - 2, "", 0, 0, 'L', $fill);

        $this->SetFillColor(242, 242, 242);
        $this->SetTextColor(0);
        $this->SetFont('MontserratMedium', '', 8);
        $this->Cell(99, $altura_campo - 2, "Assinatura do(a) colaborador(a) ", 0, 1, 'C', $fill);

        $this->Ln($distancia_linhas);
    }

    //Rodapé da página
    public function Footer() {


        if ($this->CurOrientation == 'L') {
            $this->SetFont('MontserratMedium', 'B', 8);
            $this->SetY(-15);
            $this->Line(10, 197, 287, 197);

            $this->Cell(0, 10, date('Y') . $this->direitosAutor, 0, false, 'L', 0, '', 0, false, 'T', 'M');
            $this->Cell(0, 10, 'Utilizador: ' . ucwords($this->utilizador) . ', ' . $this->dataActual . ' -  Processado por computador   |   Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        } else {
            $this->SetFont('MontserratMedium', 'B', 6);
            $this->SetY(-15);
            $this->Line(10, 283, 200, 283);

            $this->Cell(0, 10, date('Y') . $this->direitosAutor, 0, 0, 'L', 0, '', 0, false, 'T', 'M');
            $this->Cell(0, 10, 'Utilizador: ' . ucwords($this->utilizador) . ', ' . $this->dataActual . ' -  Processado por computador   |   Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        }
    }

}
