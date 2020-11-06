<?php

$dataActual = new Data();

$utilizador = $v_userInfo;

$direitosAutor = " | Oliva de Angola © MRVIPAJI ".date('Y');

//P - Vertical, L - Horizontal
$pdf = new DocPdf('P', Method::upperGeneral('Lista geral de perfis'), $utilizador->getNome(), $dataActual->getDataActual(), $direitosAutor);

/*
  Posicionamento da coluna: L - Esquerda, R - Direita, C - Centro
  array( array(titulo_coluna1, tamanho_da_coluna1,posicionamento_coluna1),
  array(titulo_coluna2, tamanho_da_coluna2,posicionamento_coluna2),.....
*/
$cabecalho = array(
    array('#', 10, 'L'),
    array('Perfil', 35, 'L'),
    array('Descrição', 145, 'C')
);

$pdf->imprimirTabelaPerfil($cabecalho, $v_entities);
$pdf->visualizar();
