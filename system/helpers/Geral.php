<?php
Class Geral {

    const CONS_PARAMETRO_TEMPO_ANOS = "ANOS";
    const CONS_PARAMETRO_TEMPO_MESES = "MESES";
    const CONS_PARAMETRO_TEMPO_DIAS = "DIAS";
    const CONS_PARAMETRO_TEMPO_HORAS = "HORAS";
    const CONS_PARAMETRO_TEMPO_MINUTOS = "MINUTOS";
    const CONS_PARAMETRO_TEMPO_SEGUNDOS = "SEGUNDOS";
    
    const CONS_GENERO_MASCULINO = "M";
    const CONS_GENERO_FEMININO = "F";
    
    const CONS_PESSOA_SINGULAR = "S";
    const CONS_PESSOA_COLECTIVA = "C";
    
    const CONS_MOEDA_BASE = "AOA";
    const CONS_MOEDA_REFERENCIA = "USD";
    const CONS_MOEDA_ALTERNATIVA = "EUR";
    
    const CONS_UTILIZADOR_ACTIVADO = 1;
    const CONS_UTILIZADOR_DESACTIVADO = 0;
    
    const DIR_IMG_UTILIZADORES = 'https://www.intercolegialtinatune.co.ao/web-files/uploads/utilizadores/';
    const DIR_IMG_PRODUTOS = 'https://www.intercolegialtinatune.co.ao/web-files/uploads/produtos/';
    const DIR_IMG_BLOG = 'https://www.intercolegialtinatune.co.ao/web-files/uploads/blog/';
    const DIR_IMG_DOCUMENTOS = "https://www.intercolegialtinatune.co.ao/web-files/uploads/documentos/";
    
    const CONS_PERFIL_GESTOR = "gestor";
    const CONS_PERFIL_ADMINISTRADOR = "administrador";
    const CONS_PERFIL_ALUNO = "aluno";
    const CONS_PERFIL_OPERADOR = "operador";
    const CONS_PERFIL_PROFESSOR = "professor";
    const CONS_PERFIL_TINA_TUNE = "tinatune";
    
    const CONS_MESSAGE_ERRO_PAGAMENTO_IMOVEL_SEM_CLIENTE = "Impossível efectuar pagamento!!! Cliente sem imóvel e sem extra(s).";
    const CONS_MESSAGE_ERRO_CLIENTE_NAO_ENCONTRADO = "O cliente não foi encontrado.";
    const CONS_MESSAGE_ERRO_EQUIPAMENTO_NAO_ENCONTRADO = "O equipamento não foi encontrado.";
    const CONS_MESSAGE_ERRO_ACESSORIO_NAO_ENCONTRADO = "O acessório não foi encontrado.";
    const CONS_MESSAGE_ERRO_IMOVEL_SEM_NEGOCIACAO = "Impossível efectuar pagamento, imóvel sem negociação!!!";
    const CONS_MESSAGE_ERRO_ENTIDADE_NAO_ENCONTRADO = " %s não foi encontrado(a).";
    const CONS_MESSAGE_ERRO_PERFIL_SEM_PERMISSOES = "Operação não permitida. O seu perfil não lhe permite realizar esta operação.";

    const CONS_ENTIDADE_PRODUTO = "P";
    
    const CONS_MULTIMEDIA_TIPO_IMAGEM = "I";
    const CONS_MULTIMEDIA_TIPO_VIDEO = "V";
    const CONS_MULTIMEDIA_TIPO_DOCUMENTO = "D";
    const CONS_MULTIMEDIA_TIPO_OUTRO = "O";
    const CONS_MULTIMEDIA_TIPO_AUDIO = "A";
    
    const EMAIL_MUXIMA_NOTIFICACAO= "muximacentral@grupoboavida.co.ao";
    const EMAIL_BPM_SUPORTE= "bpm.suporte@grupoboavida.co.ao";
    const EMAIL_TI_SUPORTE= "it.suporte@grupoboavida.co.ao";
    const PASSWORD_MUXIMA_NOTIFICACAO="GBVida05mc";
    const SMTP_PORT=465;
    
    const CONS_METODO_POST = "POST";
    const CONS_METODO_GET = "GET";
    
    const CONS_ESTADO_NOTIFICACAO_NAO_LIDA=0;
    const CONS_ESTADO_NOTIFICACAO_LIDA=1;

    const CONS_PRODUTO_ESTADO_INACTIVO = 0;
    const CONS_PRODUTO_ESTADO_ACTIVO = 1;

    const CONS_ENCOMENDA_ESTADO_PENDENTE = "P";
    const CONS_ENCOMENDA_ESTADO_ENTREGUE = "E";
    const CONS_ENCOMENDA_ESTADO_CANCELADO = "C";

    const CONS_N_PUBLICADO = 0;
    const CONS_PUBLICADO = 1;
}