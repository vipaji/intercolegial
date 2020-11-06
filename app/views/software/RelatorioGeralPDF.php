<?php

$dataActual = new Data();

$utilizador = $v_userInfo;

$direitosAutor = " | Grupo Boa Vida © BPM & TI - Criação e Inovação";

//P - Vertical, L - Horizontal
$pdf = new DocPdf('P', Method::upperGeneral('Lista geral de cargos'), $utilizador->getNome(), $dataActual->getDataActual(), $direitosAutor);

/* Posicionamento da coluna: L - Esquerda, R - Direita, C - Centro
  array( array(titulo_coluna1, tamanho_da_coluna1,posicionamento_coluna1),
  array(titulo_coluna2, tamanho_da_coluna2,posicionamento_coluna2),.....
 */
$cabecalho = array(
    array('#', 10, 'L'),
    array('Nome', 80, 'C'),
    array('Descrição', 100, 'C'));

$pdf->imprimirTabelaCargos($cabecalho, $v_entities);
$pdf->visualizar();
