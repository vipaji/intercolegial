<?php

require_once 'tcpdf/tcpdf.php';

/**
 * Description of DocPdf
 *
 * @author pc
 */
class DocPdf extends TCPDF {

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
    }

    public function visualizar($titulo = 'gbv') {

        $this->Output($titulo . 'pdf', 'I');
    }

//Cabeçalho da página
    public function Header() {

        if ($this->page == 1) {
            $img_grupoboavida = K_PATH_IMAGES . 'gbv.png';
            $img_helpdesk = K_PATH_IMAGES . 'Muxima_logo_.png';
            $img_marca_agua = K_PATH_IMAGES . 'boavida_marcadagua1.png';
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
            $this->SetFont('helvetica', 'BU', 18);

            $this->Cell(0, 15, $this->titulo, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        } else {
            
        }
    }

    public function imprimirTopSolicitacaoTickets($cabecalho, $v_entities, $v_inicio = null, $v_fim = null) {


        $this->Ln(50);
        $this->SetFont('helvetica', 'B', 10);
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);
        if (strlen($v_inicio) > 0 && strlen($v_fim)) {
            $this->Cell(50, 6, "Período", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, "" . $v_inicio . " à " . $v_fim, 1, 1, 'L', 0);
        }

        /* if (count($v_departamentos) == 1) {
          $this->SetTextColor(255);
          $this->Cell(50, 6, "Departamento", 1, 0, 'L', 1);
          $this->SetTextColor(0);
          $this->Cell(50, 6, $v_departamentos->getNome(), 1, 1, 'L', 0);
          } */

        // echo "<pre>"; print_r(); die;

        $this->Cell(0, 6, " ", 0, 1, 'L', 0);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);


        // Header
        $this->SetFont('helvetica', 'B', 10);

        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        }
        $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        $fill = 0;

        $this->SetFont('helvetica', '', 9);
        $total = 0;

        if (count($v_entities) > 0) {

            for ($i = 0; $i < count($v_entities); $i++) {

                $this->Cell($cabecalho[0][1], 6, ($i + 1), 1, 0, 'C', $fill);
                $this->Cell($cabecalho[1][1], 6, $v_entities[$i]["nomeUtilizador"], 1, 0, 'L', $fill);
                $this->Cell($cabecalho[2][1], 6, $v_entities[$i]["nomeDepartamento"], 1, 0, 'L', $fill);
                $this->Cell($cabecalho[3][1], 6, $v_entities[$i]["totalTicket"], 1, 0, 'C', $fill);
                $this->Ln();
                $fill = !$fill;
                $total = $total + $v_entities[$i]["totalTicket"];
            }
        }if (count($v_entities) == 0) {
            $this->Cell(175, 6, "Nenhum resultado encontrado", 1, 0, 'C', $fill);
        }
        $this->Ln(2);
        $this->SetFont('helvetica', 'B', 9);
        $this->Cell(15, 6, "Total:", 1, 0, 'C', $fill);
        $this->Cell(15, 6, $total, 1, 0, 'C', $fill);
    }

    public function imprimirTopTecnicos($cabecalho, $v_entities, $v_entities_aux, $v_inicio = null, $v_fim = null) {


        $this->Ln(50);
        $this->SetFont('helvetica', 'B', 10);
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);
        if (strlen($v_inicio) > 0 && strlen($v_fim)) {
            $this->Cell(50, 6, "Período", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, "" . $v_inicio . " à " . $v_fim, 1, 1, 'L', 0);
        }



        $this->Cell(0, 6, " ", 0, 1, 'L', 0);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);


        // Header
        $this->SetFont('helvetica', 'B', 10);

        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        }
        $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        $fill = 0;
        $total = 0;

        $this->SetFont('helvetica', '', 9);

        if (count($v_entities) > 0) {

            for ($i = 0; $i < count($v_entities); $i++) {

                $this->Cell($cabecalho[0][1], 6, ($i + 1), 1, 0, 'C', $fill);
                $this->Cell($cabecalho[1][1], 6, $v_entities[$i]["nomeUtilizador"], 1, 0, 'L', $fill);
                $this->Cell($cabecalho[2][1], 6, $v_entities_aux[$i]["totalTicket"], 1, 0, 'C', $fill);
                $this->Cell($cabecalho[3][1], 6, $v_entities[$i]["totalTicket"], 1, 0, 'C', $fill);

                $percent = $v_entities_aux[$i]["totalTicket"] == 0 ? "0 %" : round((($v_entities[$i]["totalTicket"] / $v_entities_aux[$i]["totalTicket"]) * 100), 2) . " %";
                $this->Cell($cabecalho[4][1], 6, $percent, 1, 0, 'C', $fill);
                $this->Ln();
                $fill = !$fill;
                $total = $total + $v_entities[$i]["totalTicket"];
            }
        }if (count($v_entities) == 0) {
            $this->Cell(275, 6, "Nenhum resultado encontrado", 1, 0, 'C', $fill);
        }
        $this->Ln(2);
        $this->SetFont('helvetica', 'B', 9);
        $this->Cell(15, 6, "Total:", 1, 0, 'C', $fill);
        $this->Cell(15, 6, $total, 1, 0, 'C', $fill);
    }

    public function imprimirTotalTicketDepartamento($cabecalho, $abertos, $resolucao, $tratados, $fechados, $v_departamentos, $cabecalho2 = null, $v_inicio = null, $v_fim = null) {


        $this->Ln(50);
        $this->SetFont('helvetica', 'B', 10);
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);
        if (strlen($v_inicio) > 0 && strlen($v_fim)) {
            $this->Cell(50, 6, "Período", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, "" . Data::converteAMD2ptDMA($v_inicio) . " à " . Data::converteAMD2ptDMA($v_fim), 1, 1, 'L', 0);
        }

        if (count($v_departamentos) == 1) {
            $this->SetTextColor(255);
            $this->Cell(50, 6, "Departamento", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, $v_departamentos->getNome(), 1, 1, 'L', 0);
        }


        $this->Cell(0, 6, " ", 0, 1, 'L', 0);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);


        // Header
        $this->SetFont('helvetica', 'B', 10);
        if (count($v_departamentos) == 1) {
            $num_headers = count($cabecalho);
            for ($i = 0; $i < $num_headers; ++$i) {
                $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
            }
        } else {
            $num_headers = count($cabecalho2);
            for ($i = 0; $i < $num_headers; ++$i) {
                $this->Cell($cabecalho2[$i][1], 7, $cabecalho2[$i][0], 1, 0, $cabecalho2[$i][2], 1);
            }
        }
        $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        $fill = 0;

        $this->SetFont('helvetica', '', 9);

        if (count($v_departamentos) == 1) {

            $total = $abertos[0] + $resolucao[0] + $tratados[0] + $fechados[0];
            $this->Cell($cabecalho[0][1], 6, $total, 1, 0, 'C', $fill);
            $this->Cell($cabecalho[1][1], 6, $abertos[0], 1, 0, 'C', $fill);
            $this->Cell($cabecalho[2][1], 6, $resolucao[0], 1, 0, 'C', $fill);
            $this->Cell($cabecalho[3][1], 6, $tratados[0], 1, 0, 'C', $fill);
            $this->Cell($cabecalho[4][1], 6, $fechados[0], 1, 0, 'C', $fill);

            $this->Ln();
            $fill = !$fill;
        }if (count($v_departamentos) > 1) {
            for ($i = 0; $i < count($abertos); $i++) {

                $total = $abertos[$i] + $resolucao[$i] + $tratados[$i] + $fechados[$i];
                $this->Cell($cabecalho2[0][1], 6, $v_departamentos[$i]->getNome(), 1, 0, 'C', $fill);
                $this->Cell($cabecalho2[1][1], 6, $total, 1, 0, 'C', $fill);
                $this->Cell($cabecalho2[2][1], 6, $abertos[$i], 1, 0, 'C', $fill);
                $this->Cell($cabecalho2[3][1], 6, $resolucao[$i], 1, 0, 'C', $fill);
                $this->Cell($cabecalho2[4][1], 6, $tratados[$i], 1, 0, 'C', $fill);
                $this->Cell($cabecalho2[5][1], 6, $fechados[$i], 1, 0, 'C', $fill);

                $this->Ln();
                $fill = !$fill;
            }
        } if (count($v_departamentos) == 0) {
            $this->Cell(275, 6, "Nenhum resultado encontrado", 1, 0, 'C', $fill);
        }
    }

    public function imprimirMapaControleInventario($v_artigos, $v_departamento) {


        $this->Ln(45);
        $this->SetFont('helvetica', 'B', 10);
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);


        $this->SetTextColor(255);
        $this->Cell(50, 6, "Data", 1, 0, 'L', 1);
        $this->SetTextColor(0);
        $this->Cell(50, 6, date("d/m/Y"), 1, 1, 'L', 0);

        if (strlen($v_departamento) > 0) {
            $this->SetTextColor(255);
            $this->Cell(50, 6, "Departamento", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, $v_departamento, 1, 1, 'L', 0);
        }

        $totali = 0;
        for ($i = 0; $i < count($v_artigos); $i++) {
            $totali = $v_artigos[$i]->getCategoria() == 0 || $v_artigos[$i]->getCategoria() == 1 ? $totali + 1 : $totali + 0;
        }

        $this->SetTextColor(255);
        $this->Cell(50, 6, "Total de computadores", 1, 0, 'L', 1);
        $this->SetTextColor(0);
        $this->Cell(50, 6, $totali, 1, 1, 'L', 0);




        $this->Cell(0, 6, " ", 0, 1, 'L', 0);


        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);


        // Header


        $this->SetFont('helvetica', '', 9);
        $cont = 0;
        $anterior = 0;
        $proximo = 0;
        $actual = 0;

        //echo "<pre>";
        //print_r($v_artigos); die;

        $total = count($v_artigos);


        $this->SetFont('helvetica', 'B', 10);
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        $fill = 1;
        $this->Cell(50, 6, "Colaborador", 1, 0, 'L', $fill);
        $this->Cell(30, 6, "Código", 1, 0, 'C', $fill);
        $this->Cell(30, 6, "Equipamento", 1, 0, 'L', $fill);
        $this->Cell(30, 6, "Marca", 1, 0, 'C', $fill);
        $this->Cell(45, 6, "Modelo", 1, 0, 'C', $fill);
        $this->Cell(50, 6, "Localização", 1, 0, 'L', $fill);
        $this->Cell(30, 6, "Validar", 1, 1, 'C', $fill);


        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        $fill = 0;

        $this->SetFont('helvetica', '', 9);
        $this->Ln();


        if (count($v_artigos) > 0) {
            for ($i = 0; $i < count($v_artigos); $i++) {
                $cont++;
                if ($cont == 1) {
                    $actual = $anterior;
                } else {
                    $actual = $v_artigos[$i]->getColaborador()->getId();
                    $anterior = $v_artigos[$i - 1]->getColaborador()->getId();
                    if (($i + 1) < $total) {
                        $proximo = $v_artigos[$i + 1]->getColaborador()->getId();
                    }
                }

                if ($actual == $anterior) {

                    $this->Cell(50, 6, Method::abreviaTexto($v_artigos[$i]->getColaborador()->getNome(), 35, true), 1, 0, 'L', $fill);
                    $this->Cell(30, 6, $v_artigos[$i]->getCodigo(), 1, 0, 'L', $fill);
                    $this->Cell(30, 6, Method::daNomeCategoria($v_artigos[$i]->getCategoria()), 1, 0, 'L', $fill);
                    $this->Cell(30, 6, $v_artigos[$i]->getMarca()->getNome(), 1, 0, 'C', $fill);
                    $this->Cell(45, 6, $v_artigos[$i]->getModelo(), 1, 0, 'C', $fill);
                    $this->Cell(50, 6, $v_artigos[$i]->getLocalizacao(), 1, 0, 'L', $fill);
                    $this->Cell(30, 6, "", 1, 0, 'C', $fill);

                    $this->Ln();
                    $fill = !$fill;
                } else {
                    $this->Ln();

                    $this->Cell(50, 6, Method::abreviaTexto($v_artigos[$i]->getColaborador()->getNome(), 35, true), 1, 0, 'L', $fill);
                    $this->Cell(30, 6, $v_artigos[$i]->getCodigo(), 1, 0, 'L', $fill);
                    $this->Cell(30, 6, Method::daNomeCategoria($v_artigos[$i]->getCategoria()), 1, 0, 'L', $fill);
                    $this->Cell(30, 6, $v_artigos[$i]->getMarca()->getNome(), 1, 0, 'C', $fill);
                    $this->Cell(45, 6, $v_artigos[$i]->getModelo(), 1, 0, 'C', $fill);
                    $this->Cell(50, 6, $v_artigos[$i]->getLocalizacao(), 1, 0, 'L', $fill);
                    $this->Cell(30, 6, "", 1, 0, 'C', $fill);

                    $this->Ln();
                    $fill = !$fill;
                }
            }

            $this->Ln();
            $this->Ln();

            $fill = 1;

            $this->SetFont('helvetica', 'B', 10);
            $this->SetFillColor(242, 242, 242);
            $this->SetTextColor(0);
            $this->SetX(10);
            $this->Cell(89, 8, "", 0, 0, 'C', $fill);

            //Divisória, Cell em branco
            $this->SetFillColor(255, 255, 255);
            $this->Cell(87, 8, "", 0, 0, 'L', $fill);

            $this->SetFillColor(242, 242, 242);
            $this->SetTextColor(0);
            $this->SetFont('helvetica', 'B', 10);
            $this->Cell(89, 8, " ", 0, 1, 'C', $fill);

            $this->Ln(1);

            $this->SetFont('helvetica', 'B', 10);
            $this->SetFillColor(242, 242, 242);
            $this->SetTextColor(0);
            $this->SetX(10);
            $this->Cell(89, 4, "Assinatura do TI", 0, 0, 'C', $fill);

            //Divisória, Cell em branco
            $this->SetFillColor(255, 255, 255);
            $this->Cell(87, 4, "", 0, 0, 'L', $fill);

            $this->SetFillColor(242, 242, 242);
            $this->SetTextColor(0);
            $this->SetFont('helvetica', 'B', 10);
            $this->Cell(89, 4, "Assinatura do(a) gestor(a) da área ", 0, 1, 'C', $fill);
        } else {
            $this->Cell(275, 6, "Nenhum resultado encontrado", 1, 0, 'C', $fill);
        }
    }

    public function imprimirTabelaTicketTotalServicoArea($cabecalho, $v_tickets, $v_areas = null, $v_area = null, $v_servico = null, $v_inicio = null, $v_fim = null, $v_nomeArea = null, $v_nomeServico = null) {


        $this->Ln(45);
        $this->SetFont('helvetica', 'B', 10);
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);
        if (strlen($v_inicio) > 0 || 0 && strlen($v_fim) > 0) {
            $this->Cell(50, 6, "Período", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, $v_inicio . " até " . $v_fim, 1, 1, 'L', 0);
        }
        if (strlen($v_area) > 0) {
            $this->SetTextColor(255);
            $this->Cell(50, 6, "Área", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, $v_nomeArea, 1, 1, 'L', 0);
        }

        if (strlen($v_servico) > 0) {
            $this->SetTextColor(255);
            $this->Cell(50, 6, "Serviço", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, $v_nomeServico, 1, 1, 'L', 0);
        }

        $this->Cell(0, 6, " ", 0, 1, 'L', 0);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', 'B', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        }
        $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        $fill = 0;
        $this->SetFont('helvetica', '', 9);
        $total = count($v_tickets);

        $resumo_total_geral = 0;
        $resumo_total_bpm = 0;
        $resumo_total_ti = 0;
        $resumo_abertos = 0;
        $resumo_abertos_bpm = 0;
        $resumo_abertos_ti = 0;
        $resumo_resolvidos = 0;
        $resumo_resolvidos_bpm = 0;
        $resumo_resolvidos_ti = 0;
        $resumo_tratados = 0;
        $resumo_tratados_bpm = 0;
        $resumo_tratados_ti = 0;
        $resumo_fechados = 0;
        $resumo_fechados_bpm = 0;
        $resumo_fechados_ti = 0;

        $resumo_percent = 0;
        $resumo_percent_bpm = 0;
        $resumo_percent_ti = 0;
        $total_naonulos = 0;
        $total_naonulos_bpm = 0;
        $total_naonulos_ti = 0;
        $j = 0;
        $k = 0;
        $sum = 0;

        //echo "<pre>"; print_r($v_tickets); die;

        if (count($v_areas) == 2) {
            for ($t = 0; $t <= $total - 1; $t++) {
                if ($v_tickets[$t]["area"] == 1) {
                    $rows_ti[$j]["nome"] = $v_tickets[$t]["nome"];
                    $rows_ti[$j]["total"] = $v_tickets[$t]["total"];
                    $rows_ti[$j]["totalA"] = $v_tickets[$t]["totalA"];
                    $rows_ti[$j]["totalE"] = $v_tickets[$t]["totalE"];
                    $rows_ti[$j]["totalT"] = $v_tickets[$t]["totalT"];
                    $rows_ti[$j]["totalF"] = $v_tickets[$t]["totalF"];
                    $j++;
                }if ($v_tickets[$t]["area"] == 2) {
                    $rows_bpm[$k]["nome"] = $v_tickets[$t]["nome"];
                    $rows_bpm[$k]["total"] = $v_tickets[$t]["total"];
                    $rows_bpm[$k]["totalA"] = $v_tickets[$t]["totalA"];
                    $rows_bpm[$k]["totalE"] = $v_tickets[$t]["totalE"];
                    $rows_bpm[$k]["totalT"] = $v_tickets[$t]["totalT"];
                    $rows_bpm[$k]["totalF"] = $v_tickets[$t]["totalF"];
                    $k++;
                }
            }
        }
        if (count($v_areas) == 1) {
            for ($t = 0; $t <= $total - 1; $t++) {
                $rows_geral[$j]["nome"] = $v_tickets[$t]["nome"];
                $rows_geral[$j]["total"] = $v_tickets[$t]["total"];
                $rows_geral[$j]["totalA"] = $v_tickets[$t]["totalA"];
                $rows_geral[$j]["totalE"] = $v_tickets[$t]["totalE"];
                $rows_geral[$j]["totalT"] = $v_tickets[$t]["totalT"];
                $rows_geral[$j]["totalF"] = $v_tickets[$t]["totalF"];
                $j++;
            }
        }


        if ($total == 0) {
            $this->Cell(275, 6, "Nenhum resultado encontrado", 1, 0, 'C', $fill);
        } else {
            if (count($v_areas) > 0 || $v_areas !== null) {

                if (count($v_areas) == 2) {
                    for ($t = 0; $t < count($rows_ti); $t++) {

                        $resumo_total_ti = $resumo_total_ti + $rows_ti[$t]["total"];
                        $resumo_abertos = $resumo_abertos_ti + $rows_ti[$t]["totalA"];
                        $resumo_resolvidos_ti = $resumo_resolvidos + $rows_ti[$t]["totalE"];
                        $resumo_tratados_ti = $resumo_tratados_ti + $rows_ti[$t]["totalT"];
                        $resumo_fechados_ti = $resumo_fechados_ti + $rows_ti[$t]["totalF"];
                        $percentual = ($rows_ti[$t]["total"] == 0 || ($rows_ti[$t]["totalT"] == 0 && $rows_ti[$t]["totalF"] == 0)) ? 0 : (($rows_ti[$t]["totalT"] + $rows_ti[$t]["totalF"]) / $rows_ti[$t]["total"]) * 100;
                        $resumo_percent_ti = $resumo_percent_ti + $percentual;

                        if ($percentual !== 0) {
                            $total_naonulos_ti++;
                        }
                        $this->SetFont('helvetica', 'B', 9);
                        $this->Cell($cabecalho[0][1], 6, ucfirst(strtoupper($rows_ti[$t]["nome"])), 1, 0, 'L', $fill);
                        $this->SetFont('helvetica', '', 9);
                        $this->Cell($cabecalho[1][1], 6, $rows_ti[$t]["total"], 1, 0, 'C', $fill);
                        $this->Cell($cabecalho[2][1], 6, $rows_ti[$t]["totalA"], 1, 0, 'C', $fill);
                        $this->Cell($cabecalho[3][1], 6, $rows_ti[$t]["totalE"], 1, 0, 'C', $fill);
                        $this->Cell($cabecalho[4][1], 6, $rows_ti[$t]["totalT"], 1, 0, 'C', $fill);
                        $this->Cell($cabecalho[5][1], 6, $rows_ti[$t]["totalF"], 1, 0, 'C', $fill);
                        $this->Cell($cabecalho[6][1], 6, round($percentual, 2) . " %", 1, 0, 'C', $fill);

                        $this->Ln();
                        $fill = !$fill;
                    }
                    $this->Ln();
                    $this->SetFont('helvetica', 'B', 10);
                    $this->Cell($cabecalho[0][1], 5, "RESUMO TI", 1, 0, 'L', $fill);
                    $this->SetFont('helvetica', '', 9);
                    $this->Cell($cabecalho[1][1], 5, "$resumo_total_ti", 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[2][1], 5, "$resumo_abertos_ti", 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[3][1], 5, "$resumo_resolvidos_ti", 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[4][1], 5, "$resumo_tratados_ti", 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[5][1], 5, "$resumo_fechados_ti", 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[6][1], 5, $resumo_percent_ti == 0 ? "0 %" : round(100 * (($resumo_tratados_ti + $resumo_fechados_ti) / $resumo_total_ti), 2) . " %", 1, 0, 'C', $fill);


                    $this->Ln();
                    $this->Ln();
                    for ($t = 0; $t < count($rows_bpm); $t++) {

                        $resumo_total_bpm = $resumo_total_bpm + $rows_bpm[$t]["total"];
                        $resumo_abertos_bpm = $resumo_abertos_bpm + $rows_bpm[$t]["totalA"];
                        $resumo_resolvidos_bpm = $resumo_resolvidos_bpm + $rows_bpm[$t]["totalE"];
                        $resumo_tratados_bpm = $resumo_tratados_bpm + $rows_bpm[$t]["totalT"];
                        $resumo_fechados_bpm = $resumo_fechados_bpm + $rows_bpm[$t]["totalF"];
                        $percentual = ($rows_bpm[$t]["total"] == 0 || ($rows_bpm[$t]["totalT"] == 0 && $rows_bpm[$t]["totalF"] == 0)) ? 0 : (($rows_bpm[$t]["totalT"] + $rows_bpm[$t]["totalF"]) / $rows_bpm[$t]["total"]) * 100;
                        $resumo_percent_bpm = $resumo_percent_bpm + $percentual;


                        if ($percentual !== 0) {
                            $total_naonulos_bpm++;
                        }
                        $this->SetFont('helvetica', 'B', 9);
                        $this->Cell($cabecalho[0][1], 6, ucfirst(strtoupper($rows_bpm[$t]["nome"])), 1, 0, 'L', $fill);
                        $this->SetFont('helvetica', '', 9);
                        $this->Cell($cabecalho[1][1], 6, $rows_bpm[$t]["total"], 1, 0, 'C', $fill);
                        $this->Cell($cabecalho[2][1], 6, $rows_bpm[$t]["totalA"], 1, 0, 'C', $fill);
                        $this->Cell($cabecalho[3][1], 6, $rows_bpm[$t]["totalE"], 1, 0, 'C', $fill);
                        $this->Cell($cabecalho[4][1], 6, $rows_bpm[$t]["totalT"], 1, 0, 'C', $fill);
                        $this->Cell($cabecalho[5][1], 6, $rows_bpm[$t]["totalF"], 1, 0, 'C', $fill);
                        $this->Cell($cabecalho[6][1], 6, round($percentual, 2) . " %", 1, 0, 'C', $fill);
                        $this->Ln();
                        $fill = !$fill;
                    }
                    $this->Ln();
                    $this->SetFont('helvetica', 'B', 10);
                    $this->Cell($cabecalho[0][1], 5, "RESUMO BPM", 1, 0, 'L', $fill);
                    $this->SetFont('helvetica', '', 9);
                    $this->Cell($cabecalho[1][1], 5, "$resumo_total_bpm", 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[2][1], 5, "$resumo_abertos_bpm", 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[3][1], 5, "$resumo_resolvidos_bpm", 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[4][1], 5, "$resumo_tratados_bpm", 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[5][1], 5, "$resumo_fechados_bpm", 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[6][1], 5, $resumo_percent_bpm == 0 ? "0 %" : round(100 * (($resumo_tratados_bpm + $resumo_fechados_bpm) / $resumo_total_bpm), 2) . " %", 1, 1, 'C', $fill);

                    $this->Ln();
                    $this->SetFont('helvetica', 'B', 10);
                    $this->Cell($cabecalho[0][1], 5, "RESUMO GERAL", 1, 0, 'L', $fill);
                    $this->SetFont('helvetica', '', 9);
                    $this->Cell($cabecalho[1][1], 5, ($resumo_total_bpm + $resumo_total_ti), 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[2][1], 5, ($resumo_abertos_bpm + $resumo_abertos_ti), 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[3][1], 5, ($resumo_resolvidos_bpm + $resumo_resolvidos_ti), 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[4][1], 5, ($resumo_tratados_bpm + $resumo_tratados_ti), 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[5][1], 5, ($resumo_fechados_bpm + $resumo_fechados_ti), 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[6][1], 5, ($resumo_percent_bpm + $resumo_percent_ti) == 0 ? "0 %" : round(100 * (($resumo_tratados_bpm + $resumo_fechados_bpm + $resumo_fechados_ti + $resumo_tratados_ti) / ($resumo_total_bpm + $resumo_total_ti)), 2) . " %", 1, 0, 'C', $fill);
                } if (count($v_areas) == 1) {

                    for ($t = 0; $t < count($rows_geral); $t++) {

                        $resumo_total_geral = $resumo_total_geral + $rows_geral[$t]["total"];
                        $resumo_abertos = $resumo_abertos + $rows_geral[$t]["totalA"];
                        $resumo_resolvidos = $resumo_resolvidos + $rows_geral[$t]["totalE"];
                        $resumo_tratados = $resumo_tratados + $rows_geral[$t]["totalT"];
                        $resumo_fechados = $resumo_fechados + $rows_geral[$t]["totalF"];
                        $percentual = ($rows_geral[$t]["total"] == 0 || ($rows_geral[$t]["totalT"] == 0 && $rows_geral[$t]["totalF"] == 0)) ? 0 : (($rows_geral[$t]["totalT"] + $rows_geral[$t]["totalF"]) / $rows_geral[$t]["total"]) * 100;
                        $resumo_percent = $resumo_percent + $percentual;


                        if ($percentual !== 0) {
                            $total_naonulos++;
                        }
                        $this->SetFont('helvetica', 'B', 9);
                        $this->Cell($cabecalho[0][1], 6, ucfirst(strtoupper($rows_geral[$t]["nome"])), 1, 0, 'L', $fill);
                        $this->SetFont('helvetica', '', 9);
                        $this->Cell($cabecalho[1][1], 6, $rows_geral[$t]["total"], 1, 0, 'C', $fill);
                        $this->Cell($cabecalho[2][1], 6, $rows_geral[$t]["totalA"], 1, 0, 'C', $fill);
                        $this->Cell($cabecalho[3][1], 6, $rows_geral[$t]["totalE"], 1, 0, 'C', $fill);
                        $this->Cell($cabecalho[4][1], 6, $rows_geral[$t]["totalT"], 1, 0, 'C', $fill);
                        $this->Cell($cabecalho[5][1], 6, $rows_geral[$t]["totalF"], 1, 0, 'C', $fill);
                        $this->Cell($cabecalho[6][1], 6, round($percentual, 2) . " %", 1, 0, 'C', $fill);

                        $this->Ln();
                        $fill = !$fill;
                    }
                    $this->Ln();
                    $this->SetFont('helvetica', 'B', 10);
                    $this->Cell($cabecalho[0][1], 5, "RESUMO", 1, 0, 'L', $fill);
                    $this->SetFont('helvetica', '', 9);
                    $this->Cell($cabecalho[1][1], 5, "$resumo_total_geral", 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[2][1], 5, "$resumo_abertos", 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[3][1], 5, "$resumo_resolvidos", 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[4][1], 5, "$resumo_tratados", 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[5][1], 5, "$resumo_fechados", 1, 0, 'C', $fill);
                    $this->Cell($cabecalho[6][1], 5, $resumo_percent == 0 ? "0 %" : round(100 * (($resumo_tratados + $resumo_fechados) / $resumo_total_geral), 2) . " %", 1, 0, 'C', $fill);
                }
            }
        }
    }

    public function imprimirFichaEntregaEquipamento($entidade, $acessorios) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);


        $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        $fill = 1;

        $this->SetFont('helvetica', 'B', 10);
        //Fundo azul escuro
        $this->SetFillColor(209, 209, 209);
        $this->SetTextColor(0);
        $this->SetX(40);

        $this->Cell(140, 6, "Dados do equipamento ", 1, 0, 'C', $fill);

        $this->Ln(7);

        $this->SetFont('helvetica', 'B', 9);
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->Cell(30, 6, "Código: ", 1, 0, 'L', $fill);


        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(160, 6, $entidade->getCodigo(), 1, 1, 'L', $fill);

        $this->SetFont('helvetica', 'B', 9);
        //Fundo azul escuro
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->Cell(30, 6, "Modelo: ", 1, 0, 'L', $fill);


        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(160, 6, $entidade->getModelo(), 1, 1, 'L', $fill);

        $this->SetFont('helvetica', 'B', 9);
        //Fundo azul escuro
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->Cell(30, 6, "Categoria: ", 1, 0, 'L', $fill);


        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(160, 6, Method::daNomeCategoria($entidade->getCategoria()), 1, 1, 'L', $fill);

        $this->SetFont('helvetica', 'B', 9);
        //Fundo azul escuro
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->Cell(30, 6, "Marca: ", 1, 0, 'L', $fill);


        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(160, 6, $entidade->getMarca()->getNome(), 1, 1, 'L', $fill);
        $this->Ln();

        $this->Ln(5);

###############################   Dados do colaborador ############################### 
        $this->SetFont('helvetica', 'B', 10);
        $this->SetFillColor(209, 209, 209);
        $this->SetTextColor(0);
        $this->SetX(40);
        $this->Cell(140, 6, "Dados do colaborador ", 1, 0, 'C', $fill);

        $this->Ln(7);


        $this->SetFont('helvetica', 'B', 9);
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->Cell(30, 6, "Nome ", 1, 0, 'L', $fill);


        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(160, 6, $entidade->getColaborador()->getNome(), 1, 1, 'L', $fill);

        $this->SetFont('helvetica', 'B', 9);
        //Fundo azul escuro
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->Cell(30, 6, "Empresa ", 1, 0, 'L', $fill);


        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(160, 6, $entidade->getColaborador()->getEmpresa()->getNome(), 1, 1, 'L', $fill);

        $this->SetFont('helvetica', 'B', 9);
        //Fundo azul escuro
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->Cell(30, 6, "Departamento ", 1, 0, 'L', $fill);


        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(160, 6, $entidade->getColaborador()->getDepartamento()->getNome(), 1, 1, 'L', $fill);

        $this->SetFont('helvetica', 'B', 9);
        //Fundo azul escuro
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->Cell(30, 6, "E-mail ", 1, 0, 'L', $fill);


        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(160, 6, $entidade->getColaborador()->getEmail(), 1, 1, 'L', $fill);
        $this->Ln();

        $this->Ln(5);


        ###############################   Dados do colaborador #############################
        ###############################   Dados do acessório ############################### 

        $this->SetFont('helvetica', 'B', 10);


        $this->SetFillColor(209, 209, 209);
        $this->SetTextColor(0);
        $this->SetX(40);
        $this->Cell(140, 6, "Dado(s) dos acessório(s) ", 1, 0, 'C', $fill);

        $this->Ln(7);
        $this->SetFont('helvetica', 'B', 9);

        foreach ($acessorios as $acessorio) {
            //Fundo azul escuro
            $this->SetFillColor(34, 49, 97);
            $this->SetTextColor(255);
            $this->Cell(30, 6, "Código: ", 1, 0, 'L', $fill);


            $this->SetFont('helvetica', '', 9);
            $this->SetTextColor(0);
            $this->SetFillColor(255, 255, 255);
            $this->Cell(160, 6, $acessorio->getAcessorio()->getCodigo(), 1, 1, 'L', $fill);

            $this->SetFont('helvetica', 'B', 9);
            //Fundo azul escuro
            $this->SetFillColor(34, 49, 97);
            $this->SetTextColor(255);
            $this->Cell(30, 6, "Modelo: ", 1, 0, 'L', $fill);


            $this->SetFont('helvetica', '', 9);
            $this->SetTextColor(0);
            $this->SetFillColor(255, 255, 255);
            $this->Cell(160, 6, $acessorio->getAcessorio()->getModelo(), 1, 1, 'L', $fill);

            $this->SetFont('helvetica', 'B', 9);
            //Fundo azul escuro
            $this->SetFillColor(34, 49, 97);
            $this->SetTextColor(255);
            $this->Cell(30, 6, "Categoria: ", 1, 0, 'L', $fill);


            $this->SetFont('helvetica', '', 9);
            $this->SetTextColor(0);
            $this->SetFillColor(255, 255, 255);
            $this->Cell(160, 6, Method::daNomeCategoria($acessorio->getAcessorio()->getCategoria()), 1, 1, 'L', $fill);

            $this->SetFont('helvetica', 'B', 9);
            //Fundo azul escuro
            $this->SetFillColor(34, 49, 97);
            $this->SetTextColor(255);
            $this->Cell(30, 6, "Marca: ", 1, 0, 'L', $fill);


            $this->SetFont('helvetica', '', 9);
            $this->SetTextColor(0);
            $this->SetFillColor(255, 255, 255);
            $this->Cell(160, 6, $acessorio->getAcessorio()->getMarca()->getNome(), 1, 1, 'L', $fill);
            $this->Ln();
        }

        ###############################   Dados do cônjuge ############################### 
    }

    //$cabecalho, $v_areas, $v_tickets, $v_servico, $v_inicio, $v_fim

    public function imprimirIndicadoresTecnico($cabecalho, $v_tickets, $v_tecnico = null, $v_inicio = null, $v_fim = null) {


        $this->Ln(50);
        $this->SetFont('helvetica', 'B', 10);
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);
        if (strlen($v_inicio) > 0 || 0 && strlen($v_fim) > 0) {
            $this->Cell(55, 6, "Período", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(55, 6, $v_inicio . " até " . $v_fim, 1, 1, 'L', 0);
        }

        if (strlen($v_tecnico) > 0) {
            $this->SetTextColor(255);
            $this->Cell(55, 6, "Técnico", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(55, 6, $v_tecnico, 1, 1, 'L', 0);
        }

        $this->Cell(0, 6, " ", 0, 1, 'L', 0);


        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);


        // Header
        $this->SetFont('helvetica', 'B', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        }
        $this->Ln();


        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        $fill = 0;
        $this->SetFont('helvetica', '', 9);
        $total = count($v_tickets);

        $resumo_total = 0;
        $resumo_abertos = 0;
        $resumo_resolvidos = 0;
        $resumo_tratados = 0;
        $resumo_fechados = 0;
        $resumo_atrasados = 0;
        $resumo_percent = 0;
        $total_naonulos = 0;


        if ($total == 0) {
            $this->Cell(275, 6, "Nenhum resultado encontrado", 1, 0, 'C', $fill);
        } else {
            for ($t = 0; $t <= $total - 1; ++$t) {

                $resumo_total = $resumo_total + $v_tickets[$t]["total"];
                $resumo_abertos = $resumo_abertos + $v_tickets[$t]["totalA"];
                $resumo_resolvidos = $resumo_resolvidos + $v_tickets[$t]["totalE"];
                $resumo_tratados = $resumo_tratados + $v_tickets[$t]["totalT"];
                $resumo_fechados = $resumo_fechados + $v_tickets[$t]["totalF"];
                $resumo_atrasados = $resumo_atrasados + $v_tickets[$t]["totalAt"];
                $percentual = $v_tickets[$t]["total"] == 0 ? 0 : (($v_tickets[$t]["totalT"] + $v_tickets[$t]["totalF"]) / $v_tickets[$t]["total"]) * 100;
                $resumo_percent = $resumo_percent + $percentual;


                if ($percentual !== 0) {
                    $total_naonulos++;
                }
                $this->SetFont('helvetica', 'B', 9);
                $this->Cell($cabecalho[0][1], 6, $v_tickets[$t]["nome"], 1, 0, 'L', $fill);
                $this->SetFont('helvetica', '', 9);
                $this->Cell($cabecalho[1][1], 6, $v_tickets[$t]["total"], 1, 0, 'C', $fill);
                $this->Cell($cabecalho[2][1], 6, $v_tickets[$t]["totalA"], 1, 0, 'C', $fill);
                $this->Cell($cabecalho[3][1], 6, $v_tickets[$t]["totalE"], 1, 0, 'C', $fill);
                $this->Cell($cabecalho[4][1], 6, $v_tickets[$t]["totalT"], 1, 0, 'C', $fill);
                $this->Cell($cabecalho[5][1], 6, $v_tickets[$t]["totalF"], 1, 0, 'C', $fill);
                //$this->Cell($cabecalho[6][1], 6, $v_tickets[$t]["totalAt"], 1, 0, 'C', $fill);

                $this->Cell($cabecalho[6][1], 6, round($percentual, 2) . " %", 1, 0, 'C', $fill);

                $this->Ln();
                $fill = !$fill;
            }
            $this->Ln();
            $this->SetFont('helvetica', 'B', 10);
            $this->Cell($cabecalho[0][1], 6, "Resumo", 1, 0, 'L', $fill);
            $this->SetFont('helvetica', '', 9);
            $this->Cell($cabecalho[1][1], 6, "$resumo_total", 1, 0, 'C', $fill);
            $this->Cell($cabecalho[2][1], 6, "$resumo_abertos", 1, 0, 'C', $fill);
            $this->Cell($cabecalho[3][1], 6, "$resumo_resolvidos", 1, 0, 'C', $fill);
            $this->Cell($cabecalho[4][1], 6, "$resumo_tratados", 1, 0, 'C', $fill);
            $this->Cell($cabecalho[5][1], 6, "$resumo_fechados", 1, 0, 'C', $fill);
            //$this->Cell($cabecalho[6][1], 6, $resumo_atrasados, 1, 0, 'C', $fill);
            $this->Cell($cabecalho[6][1], 6, round(($resumo_percent / $total_naonulos), 2) . " %", 1, 0, 'C', $fill);
        }
    }

    //$cabecalho, $v_areas, $v_tickets, $v_servico, $v_inicio, $v_fim

    public function imprimirTabelaTicketsAjax($cabecalho, $v_tickets, $v_servico = null, $v_inicio = null, $v_fim = null) {


        $this->Ln(50);
        $this->SetFont('helvetica', 'B', 10);
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);
        if (strlen($v_inicio) > 0 || 0 && strlen($v_fim) > 0) {
            $this->Cell(50, 6, "Período", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, $v_inicio . " até " . $v_fim, 1, 1, 'L', 0);
        }

        if (strlen($v_servico) > 0) {
            $this->SetTextColor(255);
            $this->Cell(50, 6, "Serviço", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, $v_servico, 1, 1, 'L', 0);
        }

        $this->Cell(0, 6, " ", 0, 1, 'L', 0);


        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);


        // Header
        $this->SetFont('helvetica', 'B', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        }
        $this->Ln();


        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        $fill = 0;
        $this->SetFont('helvetica', '', 9);
        $total = count($v_tickets);

        $resumo_total = 0;
        $resumo_abertos = 0;
        $resumo_resolvidos = 0;
        $resumo_tratados = 0;
        $resumo_fechados = 0;
        $resumo_atrasados = 0;
        $resumo_percent = 0;
        $total_naonulos = 0;


        if ($total == 0) {
            $this->Cell(275, 6, "Nenhum resultado encontrado", 1, 0, 'C', $fill);
        } else {
            for ($t = 0; $t <= $total - 1; ++$t) {

                $resumo_total = $resumo_total + $v_tickets[$t]["total"];
                $resumo_abertos = $resumo_abertos + $v_tickets[$t]["totalA"];
                $resumo_resolvidos = $resumo_resolvidos + $v_tickets[$t]["totalE"];
                $resumo_tratados = $resumo_tratados + $v_tickets[$t]["totalT"];
                $resumo_fechados = $resumo_fechados + $v_tickets[$t]["totalF"];
                $resumo_atrasados = $resumo_atrasados + $v_tickets[$t]["totalAt"];
                $percentual = ($v_tickets[$t]["total"] == 0 || $v_tickets[$t]["totalT"] == 0) ? 0 : ($v_tickets[$t]["totalT"] / $v_tickets[$t]["total"]) * 100;
                $resumo_percent = $resumo_percent + $percentual;


                if ($percentual !== 0) {
                    $total_naonulos++;
                }
                $this->SetFont('helvetica', 'B', 9);
                $this->Cell($cabecalho[0][1], 6, $v_tickets[$t]["nome"], 1, 0, 'L', $fill);
                $this->SetFont('helvetica', '', 9);
                $this->Cell($cabecalho[1][1], 6, $v_tickets[$t]["total"], 1, 0, 'C', $fill);
                $this->Cell($cabecalho[2][1], 6, $v_tickets[$t]["totalA"], 1, 0, 'C', $fill);
                $this->Cell($cabecalho[3][1], 6, $v_tickets[$t]["totalE"], 1, 0, 'C', $fill);
                $this->Cell($cabecalho[4][1], 6, $v_tickets[$t]["totalT"], 1, 0, 'C', $fill);
                $this->Cell($cabecalho[5][1], 6, $v_tickets[$t]["totalF"], 1, 0, 'C', $fill);
                $this->Cell($cabecalho[6][1], 6, $v_tickets[$t]["totalAt"], 1, 0, 'C', $fill);

                $this->Cell($cabecalho[7][1], 6, round($percentual, 2) . " %", 1, 0, 'C', $fill);

                $this->Ln();
                $fill = !$fill;
            }
            $this->Ln();
            $this->SetFont('helvetica', 'B', 10);
            $this->Cell($cabecalho[0][1], 6, "Resumo", 1, 0, 'L', $fill);
            $this->SetFont('helvetica', '', 9);
            $this->Cell($cabecalho[1][1], 6, "$resumo_total", 1, 0, 'C', $fill);
            $this->Cell($cabecalho[2][1], 6, "$resumo_abertos", 1, 0, 'C', $fill);
            $this->Cell($cabecalho[3][1], 6, "$resumo_resolvidos", 1, 0, 'C', $fill);
            $this->Cell($cabecalho[4][1], 6, "$resumo_tratados", 1, 0, 'C', $fill);
            $this->Cell($cabecalho[5][1], 6, "$resumo_fechados", 1, 0, 'C', $fill);
            $this->Cell($cabecalho[6][1], 6, $resumo_atrasados, 1, 0, 'C', $fill);
            $this->Cell($cabecalho[7][1], 6, round(($resumo_percent / $total_naonulos), 2) . " %", 1, 0, 'C', $fill);
        }
    }

    public function imprimirTabelaTicketsExploracao($cabecalho, $dados, $v_empresa = null, $v_departamento = null, $v_solicitante = null, $v_area = null, $v_servico = null, $v_prioridade = null, $v_estado = null, $v_inicio = null, $v_fim = null) {


        $this->Ln(50);
        $this->SetFont('helvetica', 'B', 10);
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);
        if (strlen($v_inicio) > 0 && strlen($v_fim)) {
            $this->Cell(50, 6, "Período", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, "" . Data::converteAMD2ptDMA($v_inicio) . " à " . Data::converteAMD2ptDMA($v_fim), 1, 1, 'L', 0);
        }

        if (strlen($v_empresa) > 0) {
            $this->SetTextColor(255);
            $this->Cell(50, 6, "Empresa", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, $v_empresa, 1, 1, 'L', 0);
        }
        if (strlen($v_departamento) > 0) {
            $this->SetTextColor(255);
            $this->Cell(50, 6, "Departamento", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, $v_departamento, 1, 1, 'L', 0);
        }
        if (strlen($v_solicitante) > 0) {
            $this->SetTextColor(255);
            $this->Cell(50, 6, "Solicitante", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, $v_solicitante, 1, 1, 'L', 0);
        }
        if (strlen($v_area) > 0) {
            $this->SetTextColor(255);
            $this->Cell(50, 6, "Área", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, $v_area, 1, 1, 'L', 0);
        }
        if (strlen($v_servico) > 0) {
            $this->SetTextColor(255);
            $this->Cell(50, 6, "Serviço", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, $v_servico, 1, 1, 'L', 0);
        }
        if (strlen($v_prioridade) > 0) {
            $this->SetTextColor(255);
            $this->Cell(50, 6, "Grau de prioridade", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, $v_prioridade, 1, 1, 'L', 0);
        }
        if (strlen($v_estado) > 0) {
            $this->SetTextColor(255);
            $this->Cell(50, 6, "Estado", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, $v_estado, 1, 1, 'L', 0);
        }


        $this->Cell(0, 6, " ", 0, 1, 'L', 0);


        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);


        // Header
        $this->SetFont('helvetica', 'B', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        }
        $this->Ln();


        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        $fill = 0;

        $this->SetFont('helvetica', '', 9);
        $cont = 0;
        if (count($dados) > 0) {
            foreach ($dados as $obj) {
                $cont++;

                $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
                $this->Cell($cabecalho[1][1], 6, Method::abreviaTexto($obj->getSolicitante()->getNome(), 35, true), 1, 0, 'L', $fill);
                $empresa_departamento = $obj->getSolicitante()->getEmpresa()->getNome() . "/" . $obj->getSolicitante()->getDepartamento()->getNome();
                $this->Cell($cabecalho[2][1], 6, $empresa_departamento, 1, 0, 'L', $fill);
                $this->Cell($cabecalho[3][1], 6, $obj->getNumero(), 1, 0, 'C', $fill);
                $this->Cell($cabecalho[4][1], 6, $obj->getServico()->getNome(), 1, 0, 'C', $fill);
                $this->Cell($cabecalho[5][1], 6, Method::daNomeGrauUrgenciaTicket($obj->getGrauUrgencia()), 1, 0, 'L', $fill);

                //print_r($obj->getEstado()); die;
                $this->Cell($cabecalho[6][1], 6, Method::daNomeEstadoTicket($obj->getEstado()), 1, 0, 'C', $fill);

                $data_abertura = $obj->getDataAbertura();
                $this->Cell($cabecalho[7][1], 6, Data::converteAMD2DMA($data_abertura), 1, 0, 'C', $fill);

                $this->Ln();
                $fill = !$fill;
            }
        } else {
            $this->Cell(275, 6, "Nenhum resultado encontrado", 1, 0, 'C', $fill);
        }
    }

    public function imprimirTabelaDepartamentos($cabecalho, $dados) {
        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        }
        $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        $fill = 0;

        $this->SetFont('helvetica', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;

            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[3][1], 6, $obj->getEmpresa()->getNome(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaAgendaDiariaTicket($cabecalho, $dados, $tecnico) {


        $this->Ln(50);
        $this->SetFont('helvetica', 'B', 10);
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);


        if (strlen($tecnico) > 0) {
            $this->SetTextColor(255);
            $this->Cell(50, 6, "Técnico", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, $tecnico, 1, 1, 'L', 0);
        }
        if (strlen($tecnico) > 0) {
            $this->SetTextColor(255);
            $this->Cell(50, 6, "Data", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(50, 6, date("d/m/Y"), 1, 1, 'L', 0);
        }

        $this->Cell(0, 6, " ", 0, 1, 'L', 0);


        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);


        // Header
        $this->SetFont('helvetica', 'B', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        }
        $this->Ln();


        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helvetica', '', 9);
        $cont = 0;
        if (count($dados) > 0) {
            foreach ($dados as $obj) {
                $cont++;

                $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
                $referencia = strlen($obj->getNumero()) === 0 ? "" : $obj->getNumero();
                $this->Cell($cabecalho[1][1], 6, $referencia, 1, 0, 'C', $fill);
                $this->Cell($cabecalho[2][1], 6, $obj->getServico()->getNome(), 1, 0, 'C', $fill);
                $this->Cell($cabecalho[3][1], 6, Method::abreviaTexto($obj->getSolicitante()->getNome(), 35, true), 1, 0, 'L', $fill);
                $empresa_departamento = $obj->getSolicitante()->getEmpresa()->getNome() . "/" . $obj->getSolicitante()->getDepartamento()->getNome();
                $this->Cell($cabecalho[4][1], 6, $empresa_departamento, 1, 0, 'L', $fill);
                $this->Cell($cabecalho[5][1], 6, Method::daNomeGrauUrgenciaTicket($obj->getGrauUrgencia()), 1, 0, 'L', $fill);
                $this->Cell($cabecalho[6][1], 6, $obj->getDataAbertura(), 1, 0, 'C', $fill);

                $estado = date("Y-m-d") > $obj->getDataPrevistaResolucao() && $obj->getEstado() == "E" ? "Atrasado" : Method::daNomeEstadoTicket($obj->getEstado());
                $this->Cell($cabecalho[7][1], 6, $estado, 1, 0, 'C', $fill);
                $this->Ln();
                $fill = !$fill;
            }
        } else {
            $this->Cell(275, 6, "Nenhum resultado encontrado", 1, 0, 'C', $fill);
        }
    }

    public function imprimirTabelaExploracaoTicketsAjax($cabecalho, $dados, $v_area = null, $v_servico = null, $v_estado = null, $v_inicio = null, $v_fim = null, $v_prioridade = null) {

        $this->Ln(50);

        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        $this->SetFont('helvetica', 'B', 9);

        if (strlen($v_inicio) > 0 || 0 && strlen($v_fim) > 0) {
            $this->Cell(40, 6, "Período", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(80, 6, $v_inicio . " até " . $v_fim, 1, 1, 'L', 0);
        }
        if (strlen($v_area) > 0) {
            $this->SetTextColor(255);
            $this->Cell(40, 6, "Área", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(80, 6, $v_area, 1, 1, 'L', 0);
        }

        if (strlen($v_servico) > 0) {
            $this->SetTextColor(255);
            $this->Cell(40, 6, "Serviço", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(80, 6, $v_servico, 1, 1, 'L', 0);
        }

        if (strlen($v_estado) > 0) {
            $this->SetTextColor(255);
            $this->Cell(40, 6, "Estado", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(80, 6, $v_estado, 1, 1, 'L', 0);
        }

        if (strlen($v_prioridade) > 0) {
            $this->SetTextColor(255);
            $this->Cell(40, 6, "Prioridade", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(80, 6, $v_prioridade, 1, 1, 'L', 0);
        }
        $this->Ln();

        $total = count($dados);
        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);

        $cont = 0;

        if ($total > 0) {
            $txt = <<<EOD
          <table cellspacing="0" cellpadding="1" border="1">
              <tr style="color: white; background-color:#223161; font-size:10px; text-align:center;">
                <td>#</td>
                <td>Solicitante</td>
                <td>Empresa/Departamento</td>
                <td>Nº. ticket</td>
                <td>Área/Serviço</td>
                <td>Descrição</td>
                <td>Estado</td>
             </tr>
EOD;
            for ($i = 0; $i < $total; $i++) {
                $cont++;
                $txt .= <<<EOD
    <tr>
      <td>{$cont}</td>
      <td>{$dados[$i]['nomeSolicitante']}</td>
      <td>{$dados[$i]['nomeEmpresa']}/{$dados[$i]['nomeDepartamento']}</td>
      <td style="text-align:center;">{$dados[$i]['numTicket']}</td>
      <td>{$dados[$i]['nomeAreaTicket']}/{$dados[$i]['nomeServico']}</td>
      <td>{$dados[$i]['descTicket']}</td>
      <td style="text-align:center;">{$dados[$i]['estadoTicket']}</td>
    </tr>
EOD;
            }
            $txt .= <<<EOD
                </table>
EOD;

            $this->writeHTML($txt, true, false, false, false, '');
        } else {
            $this->SetFont('helvetica', 'B', 11);
            $txt = "Nenhum resultado encontrado!";
            $this->Cell(275, 6, $txt, 1, 1, 'C', 0);
        }
    }

    public function relatorioProdutividadeMensal($cabecalho, $dados, $v_nome = null, $v_departamento = null, $v_inicio = null, $v_fim = null) {

        $this->Ln(50);

        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        $this->SetFont('helvetica', 'B', 9);

        if (strlen($v_inicio) > 0 || 0 && strlen($v_fim) > 0) {
            $this->Cell(40, 6, "Período", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(80, 6, $v_inicio . " até " . $v_fim, 1, 1, 'L', 0);
        }
        if (strlen($v_nome) > 0) {
            $this->SetTextColor(255);
            $this->Cell(40, 6, "Técnico", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(80, 6, $v_nome, 1, 1, 'L', 0);
        }

        if (strlen($v_departamento) > 0) {
            $this->SetTextColor(255);
            $this->Cell(40, 6, "Departamento", 1, 0, 'L', 1);
            $this->SetTextColor(0);
            $this->Cell(80, 6, $v_departamento, 1, 1, 'L', 0);
        }

        $this->Ln();

        $total = count($dados);
        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);

        $cont = 0;
        $totalResolvidos = 0;

        if ($total > 0) {
            $txt = <<<EOD
          <table cellspacing="0" cellpadding="1" border="1">
              <tr style="color: white; background-color:#223161; font-size:10px; text-align:center;">
                <td>#</td>
                <td>Solicitante</td>
                <td>Empresa/Departamento</td>
                <td>Nº. ticket</td>
                <td>Área/Serviço</td>
                <td>Descrição</td>
                <td>Estado</td>
             </tr>
EOD;
            for ($i = 0; $i < $total; $i++) {
                
                if($dados[$i]['estadoTicket']=='Tratado' || $dados[$i]['estadoTicket']=='Fechado' ){
                    $totalResolvidos++;  
                }
                $cont++;
                $txt .= <<<EOD
    <tr>
      <td>{$cont}</td>
      <td style="text-align:center;">{$dados[$i]['nomeSolicitante']}</td>
      <td>{$dados[$i]['nomeEmpresa']}/{$dados[$i]['nomeDepartamento']}</td>
      <td style="text-align:center;">{$dados[$i]['numTicket']}</td>
      <td>{$dados[$i]['nomeAreaTicket']}/{$dados[$i]['nomeServico']}</td>
      <td>{$dados[$i]['descTicket']}</td>
      <td style="text-align:center;">{$dados[$i]['estadoTicket']}</td>
    </tr>
EOD;
            }
            $txt .= <<<EOD
                </table>
EOD;

            $this->writeHTML($txt, true, false, false, false, '');
        } else {
            $this->SetFont('helvetica', 'B', 11);
            $txt = "Nenhum resultado encontrado!";
            $this->Cell(275, 6, $txt, 1, 1, 'C', 0);
        }

        $totalTickets = $cont;
        $percentual = $totalTickets == 0 ? 0 : round(($totalResolvidos / $totalTickets) * 100,2);
        $this->SetFont('helvetica', 'B', 9);
        $this->Ln();
        $this->SetTextColor(255);
        $this->Cell(40, 6, "Total", 1, 0, 'L', 1);
        $this->SetTextColor(0);
        $this->Cell(80, 6, "$totalTickets", 1, 1, 'L', 0);
        $this->SetTextColor(255);
        $this->Cell(40, 6, "Resolvidos", 1, 0, 'L', 1);
        $this->SetTextColor(0);
        $this->Cell(80, 6, $totalResolvidos, 1, 1, 'L', 0);
        $this->SetTextColor(255);
        $this->Cell(40, 6, "Percent. de tratamento", 1, 0, 'L', 1);
        $this->SetTextColor(0);
        $this->Cell(80, 6, $percentual . " %", 1, 1, 'L', 0);
    }

    public function imprimirTabelaTickets($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, Method :: abreviaTexto($obj->getSolicitante()->getNome(), 35, true), 1, 0, 'L', $fill);
            $empresa_departamento = $obj->getSolicitante()->getEmpresa()->getNome() . "/" . $obj->getSolicitante()->getDepartamento()->getNome();
            $this->Cell($cabecalho[2][1], 6, $empresa_departamento, 1, 0, 'L', $fill);

            $referencia = strlen($obj->getNumero()) === 0 ? "" : $obj->getNumero();
            $this->Cell($cabecalho[3][1], 6, $referencia, 1, 0, 'C', $fill);
            $this->Cell($cabecalho[4][1], 6, $obj->getServico()->getNome(), 1, 0, 'C', $fill);
            $this->Cell($cabecalho[5][1], 6, Method:: daNomeGrauUrgenciaTicket($obj->getGrauUrgencia()), 1, 0, 'L', $fill);
            $this->Cell($cabecalho [6] [1], 6, Method::daNomeEstadoTicket($obj->getEstado()), 1, 0, 'C', $fill);


            $estado = $obj->getDataAbertura();
            $this->Cell($cabecalho[7][1], 6, $estado, 1, 0, 'C', $fill);



            $this->Ln();
            $fill = !$fill;
        }
    }

    /*
     * @param $cabecalho
     * @param $dimensoesColunas
     * @param $dados
     */

    public function imprimirTabelaPagamentos($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, Method::abreviaTexto($obj->getImovel()->getCliente()->getUtilizador()->getNome(), 35, true), 1, 0, 'L', $fill);

            $referencia = strlen($obj->getImovel()->getReferencia()) === 0 ? "" : $obj->getImovel()->getReferencia() . " - ";
            $imovel = $referencia . $obj->getImovel()->getTipoImovel()->getNome() . " - " . $obj->getImovel()->getTipologia()->getNome() . " - " . $obj->getImovel()->getProjecto()->getNome();
            $this->Cell($cabecalho[2][1], 6, $imovel, 1, 0, 'C', $fill);

            $this->Cell($cabecalho[3][1], 6, number_format($obj->getValor(), 2, ",", "."), 1, 0, 'L', $fill);

            $this->Cell($cabecalho[4][1], 6, Data:: converteAMD2DMA($obj->getPagamento()->getData()), 1, 0, 'C', $fill);


            $estado = $obj->getImovel()->getEntregue() === 0 ? "Não entregue" : "Entregue";
            $this->Cell($cabecalho[5][1], 6, $estado, 1, 0, 'C', $fill);

            $this->Cell($cabecalho[6][1], 6, $obj->getPagamento()->getMoeda()->getMoeda(), 1, 0, 'C', $fill);
            $this->Cell($cabecalho [7][1], 6, $obj->getPagamento()->getReferencia(), 1, 0, 'C', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    /**
     * @param $cabecalho
     * @param $dimensoesColunas
     * @param $dados
     */
    public function imprimirTabelaImovel($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont ++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getProjecto()->getNome(), 1, 0, 'L', $fill);
            $arr_localizacao = $obj->getLocalizacao() == null ? ";;;;" : explode(';', $obj->getLocalizacao()->getNome(), 5);
            $v1 = "Quadra:" . $arr_localizacao[0];
            $v2 = $v1 . " |Lote:" . $arr_localizacao [1];
            $v3 = $v2 . " |Tipo Lote: " . $arr_localizacao[2];
            $v4 = $v3 . " |Lote m2:" . $arr_localizacao [3];
            $localizacao = $v4 . " |Modelo:" . $obj->getModelo();
            if ($obj->getLocalizacao() == null) {
                $localizacao = "";
            } $this->Cell($cabecalho[2][1], 6, $localizacao, 1, 0, 'L', $fill);

            $this->Cell($cabecalho[3][1], 6, $obj->getTipologia()->getNome(), 1, 0, 'L', $fill);

            $nomeCliente = empty($obj->getCliente()) ? "" : $obj->getCliente()->getUtilizador()->getNome();
            $this->Cell($cabecalho[4][1], 6, $nomeCliente, 1, 0, 'L', $fill);


            $estado = $obj->getEstado() === "O" ? "Em obra" : "Concluído";
            $this->Cell($cabecalho[5][1], 6, $estado, 1, 0, 'C', $fill);

            $this->Cell($cabecalho [6] [1], 6, number_format($obj->getValor(), 2, ",", ".") . " " . $obj->getMoeda()->getMoeda(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaCargos($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaOrgaos($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaPaises($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getCodigo(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getFone(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[3][1], 6, $obj->getIso(), 1, 0, 'C', $fill);
            $this->Cell($cabecalho[4][1], 6, $obj->getIso3(), 1, 0, 'C', $fill);
            $this->Cell($cabecalho[5][1], 6, $obj->getNome(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaIdiomasPaises($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getPais()->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getIdioma()->getDescricao(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaIdiomas($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getIdioma(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getCodigoErp(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[3][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaStatusClientes($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getStatus(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getCodigoErp(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[3][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaMoedas($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getMoeda(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho [3] [1], 6, number_format($obj->getCompra(), 2, ",", "."), 1, 0, 'C', $fill);
            $this->Cell($cabecalho[3][1], 6, number_format($obj->getVenda(), 2, ",", "."), 1, 0, 'C', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaUtilizadores($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;

            $empresa = $obj->getEmpresa() == null ? "" : $obj->getEmpresa()->getNome();
            $departamento = $obj->getDepartamento() == null ? "" : $obj->getDepartamento()->getNome();
            $cargo = $obj->getCargo() == null ? "" : $obj->getCargo()->getNome();
            $perfil = $obj->getFuncao() == null ? "" : $obj->getFuncao()->getNome();
            $estado = $obj->getEstado() === 1 ? "Activo" : "Inactivo";
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getEmail(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[3][1], 6, $empresa, 1, 0, 'C', $fill);
            $this->Cell($cabecalho[4][1], 6, $departamento, 1, 0, 'C', $fill);
            $this->Cell($cabecalho[5][1], 6, $cargo, 1, 0, 'C', $fill);
            $this->Cell($cabecalho[6][1], 6, $perfil, 1, 0, 'C', $fill);
            $this->Cell($cabecalho[7][1], 6, $estado, 1, 0, 'C', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaTipoProjecto($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaTipoImovel($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaTipologia($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaCondominio($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getProjecto()->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaTipoExtra($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaNivelLocalizacao($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getNivel(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[3][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaTipoContacto($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaTipoActividade($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaMunicipio($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; $i++) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getProvincia()->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[3][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaProvincia($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirFichaEntidadeExterna($entidade, $conjuge) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);
        $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 1;

        $this->SetFont('helvetica', 'B', 10);
        //Fundo azul escuro
        $this->SetFillColor(209, 209, 209);
        $this->SetTextColor(0);
        $this->SetX(40);

        $this->Cell(140, 6, "Dados gerais ", 1, 0, 'C', $fill);
        $this->Ln(7);

        $this->SetFont('helvetica', 'B', 9);
        //Fundo azul escuro
        $this->SetFillColor(242, 242, 242);
        $this->SetTextColor(0);
        $this->Cell(30, 10, "Nome completo: ", 1, 0, 'L', $fill);

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('helvetica', '', 9);
        $this->Cell(160, 10, $entidade->getNome(), 1, 1, 'L', $fill);

        $this->SetFont('helvetica', 'B', 9);
        //Fundo azul escuro
        $this->SetFillColorArray(34, 49, 97);
        $this->SetTextColor(0);
        $this->Cell(30, 6, "BI: ", 1, 0, 'L', $fill);


        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);
        $this->SetFillColorArray(255, 255, 255);
        $this->Cell(160, 6, $entidade->getBI(), 1, 1, 'L', $fill);

        $this->SetFont('helvetica', 'B', 9);
        //Fundo azul escuro
        $this->SetFillColorArray(34, 49, 97);
        $this->SetTextColor(255);
        $this->Cell(30, 6, "Empresa: ", 1, 0, 'L', $fill);


        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);
        $this->SetFillColorArray(255, 255, 255);
        $this->Cell(160, 6, $entidade->getEmpresa(), 1, 1, 'L', $fill);

        $this->SetFont('helvetica', 'B', 9);
        //Fundo azul escuro
        $this->SetFillColorArray(34, 49, 97);
        $this->SetTextColor(255);
        $this->Cell(30, 6, "Endereço: ", 1, 0, 'L', $fill);


        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);
        $this->SetFillColorArray(255, 255, 255);
        $this->Cell(160, 6, $entidade->getEndereco(), 1, 1, 'L', $fill);

        $this->SetFont('helvetica', 'B', 9);
        //Fundo azul escuro
        $this->SetFillColorArray(34, 49, 97);
        $this->SetTextColor(255);
        $this->Cell(30, 6, "Telemóvel: ", 1, 0, 'L', $fill);


        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);
        $this->SetFillColorArray(255, 255, 255);
        $this->Cell(160, 6, $entidade->getTelemovel(), 1, 1, 'L', $fill);

        $this->SetFont('helvetica', 'B', 9);
        //Fundo azul escuro
        $this->SetFillColorArray(34, 49, 97);
        $this->SetTextColor(255);
        $this->Cell(30, 6, "E-mail: ", 1, 0, 'L', $fill);

        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);
        $this->SetFillColorArray(255, 255, 255);
        $this->Cell(160, 6, $entidade->getEmail(), 1, 1, 'L', $fill);

        $this->Ln(5);

        ###############################   Dados do cônjuge ############################### 

        $this->SetFont('helvetica', 'B', 9);
        //Fundo azul escuro
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->Cell(30, 6, "Nome: ", 1, 0, 'L', $fill);


        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(160, 6, $conjuge->getNome(), 1, 1, 'L', $fill);

        $this->SetFont('helvetica', 'B', 9);
        //Fundo azul escuro
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->Cell(30, 6, "BI: ", 1, 0, 'L', $fill);


        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(160, 6, $conjuge->getBI(), 1, 1, 'L', $fill);

        $this->SetFont('helvetica', 'B', 9);
        //Fundo azul escuro
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->Cell(30, 6, "Empresa: ", 1, 0, 'L', $fill);


        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(160, 6, $conjuge->getEmpresa(), 1, 1, 'L', $fill);

        $this->SetFont('helvetica', 'B', 9);
        //Fundo azul escuro
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->Cell(30, 6, "E-mail: ", 1, 0, 'L', $fill);


        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(0);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(160, 6, $conjuge->getEmail(), 1, 1, 'L', $fill);

        ###############################   Dados do cônjuge ############################### 
    }

    public function imprimirTabelaConsultores($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getEmail(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[3][1], 6, $obj->getTelefone(), 1, 0, 'C', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaBancos($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getSigla(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[3][1], 6, $obj->getDescricao(), 1, 0, 'C', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaContasBancarias($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getBanco()->getSigla(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getConta(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[3][1], 6, $obj->getIban(), 1, 0, 'C', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaPerfil($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaClientes($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getCodigoCliente(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getUtilizador()->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[3][1], 6, $obj->getTelefone(), 1, 0, 'C', $fill);
            $this->Cell($cabecalho[4][1], 6, $obj->getUtilizador()->getEmail(), 1, 0, 'C', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaExtras($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[3][1], 6, $obj->getTipoExtra()->getNome(), 1, 0, 'C', $fill);

            //$estadoUtilizador = $obj->getEstado() === 1 ? "Activo" : "Inactivo";
            //$this->Cell($cabecalho[4][1], 6, $estadoUtilizador, 1, 0, 'C', $fill);

            $this
                    ->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaProjectos($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getDescricao(), 1, 0, 'L', $fill);
            $endereco = $obj->getEndereco() === null ? "" : $obj->getEndereco()->getDescricao();
            $this->Cell($cabecalho[3][1], 6, $obj->getEndereco()->getDescricao(), 1, 0, 'C', $fill);
            $this->Cell($cabecalho[4][1], 6, $obj->getTipoProjecto()->getNome(), 1, 0, 'C', $fill);

            $this->Ln();
            $fill = !$fill;
        }
    }

    public function imprimirTabelaEvolucaoObra($cabecalho, $dados) {

        $this->Ln(50);

        // Colors, line width and bold font
        $this->SetFillColor(34, 49, 97);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);

        // Header
        $this->SetFont('helvetica', '', 10);
        $num_headers = count($cabecalho);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($cabecalho[$i][1], 7, $cabecalho[$i][0], 1, 0, $cabecalho[$i][2], 1);
        } $this->Ln();

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = 0;

        $this->SetFont('helveti ca', '', 9);
        $cont = 0;
        foreach ($dados as $obj) {
            $cont++;
            $this->Cell($cabecalho[0][1], 6, $cont, 1, 0, 'L', $fill);
            $this->Cell($cabecalho[1][1], 6, $obj->getReferencia(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[2][1], 6, $obj->getProjecto()->getNome(), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[3][1], 6, $obj->getLocalizacao() == null ? "" : Method :: abreviaTexto($obj->getLocalizacao()->getNome(), 35, true), 1, 0, 'L', $fill);
            $this->Cell($cabecalho[4][1], 6, $obj->getTipologia()->getNome(), 1, 0, 'L', $fill);

            $nomeCliente = empty($obj->getCliente()) ? "" : $obj->getCliente()->getUtilizador()->getNome();
            $this->Cell($cabecalho[5][1], 6, $nomeCliente, 1, 0, 'L', $fill);


            $estado = $obj->getEstado() === "O" ? "Em obra" : "Concluído";
            $this->Cell($cabecalho[6][1], 6, $estado, 1, 0, 'C', $fill);

            $this->Cell($cabecalho [7] [1], 6, number_format($obj->getValor(), 2, ",", ".") . " " . $obj->getMoeda()->getMoeda(), 1, 0, 'R', $fill);

            $this->Ln();

            $fill = !$fill;
        }
    }

//Rodapé da página
    public function Footer() {

        if ($this->CurOrientation == 'L') {
            $this->SetFont('helvetica', 'B', 8);
            $this->SetY(-15);
            $this->Line(10, 197, 287, 197);
            $this->Cell(0, 10, date('Y') . $this->direitosAutor, 0, false, 'L', 0, '', 0, false, 'T', 'M');
            $this->Cell(0, 10, 'Utilizador: ' . ucwords($this->utilizador) . ', ' . $this->dataActual . ' -  Processado por computador   |   Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        } else {
            $this->SetFont('helvetica', 'B', 6);
            $this->SetY(-15);
            $this->Line(10, 283, 200, 283);
            $this->Cell(0, 10, date('Y') . $this->direitosAutor, 0, 0, 'L', 0, '', 0, false, 'T', 'M');
            $this->Cell(0, 10, 'Utilizador: ' . ucwords($this->utilizador) . ', ' . $this->dataActual . ' -  Processado por computador   |   Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        }
    }

}
