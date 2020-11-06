<?php

$dataActual = new Data();

$utilizador = $v_userInfo;

$direitosAutor = " | Grupo Boa Vida © BPM & TI - Criação e Inovação";

//P - Vertical, L - Horizontal
$pdf = new DocPdf('L', Method::upperGeneral('Lista geral de utilizadores'), $utilizador->getNome(), $dataActual->getDataActual(), $direitosAutor);

/* Posicionamento da coluna: L - Esquerda, R - Direita, C - Centro
  array( array(titulo_coluna1, tamanho_da_coluna1,posicionamento_coluna1),
  array(titulo_coluna2, tamanho_da_coluna2,posicionamento_coluna2),.....
 */
$cabecalho = array(
    array('#', 10, 'L'),
    array('Nome', 60, 'C'),
    array('E-mail', 70, 'C'),
    array('Empresa', 30, 'C'),
    array('Departamento', 30, 'C'),
    array('Cargo', 25, 'C'),
    array('Perfil', 30, 'C'),
    array('Estado', 20, 'C')
);

$pdf->imprimirTabelaUtilizadores($cabecalho, $v_entities);
$pdf->visualizar();
