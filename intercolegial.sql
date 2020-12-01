-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01-Dez-2020 às 11:33
-- Versão do servidor: 10.4.16-MariaDB
-- versão do PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `intercolegial`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `titulo` varchar(250) NOT NULL,
  `texto` text NOT NULL,
  `data` date NOT NULL,
  `foto` varchar(250) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL COMMENT 'Quando 0 = Não publicado; Quando 1 = Publicado;',
  `utilizador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `blog`
--

INSERT INTO `blog` (`id`, `titulo`, `texto`, `data`, `foto`, `estado`, `utilizador`) VALUES
(1, 'Amigo', 'Teste para ver se conseguimos carregar esse site no ar o mais breve possível. Mas para isso, precisamos escrever no mínimo 100 caracteres.\r\n\r\nTeste para ver se conseguimos carregar esse site no ar o mais breve possível. Mas para isso, precisamos escrever no mínimo 100 caracteres.', '2020-10-13', 'ec89418753146eb4f6c2552b40ce05ea.jpg', 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `documento`
--

CREATE TABLE `documento` (
  `id` int(11) NOT NULL,
  `ficheiro` varchar(250) DEFAULT NULL,
  `tipo` varchar(10) DEFAULT NULL,
  `descricao` varchar(300) NOT NULL,
  `data` date NOT NULL,
  `utilizador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `escola`
--

CREATE TABLE `escola` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `descricao` varchar(350) NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `escola`
--

INSERT INTO `escola` (`id`, `nome`, `descricao`, `tipo`) VALUES
(1, 'IMEL', 'Luanda', 3),
(2, 'COMERCIAL', 'Luanda', 3),
(3, 'COLÉGIO EMIRAIS', 'NOVA VIDA', 1),
(4, 'COLÉGIO PITABEL', 'NOVA VIDA, BELAS,BENFICA', 1),
(5, 'Colégio São Francisco de Assis', 'LUANDA SUL', 1),
(6, 'COLÉGIO ATLÂNTICO - LUANDA', 'Rua Comandante Nzaji nº 137', 1),
(7, 'COLÉGIO Nª Sª DA ANUNCIAÇÃO', 'VIANA', 1),
(8, 'COLÉGIO CARMENF', 'VIANA', 1),
(9, 'COMPLEXO POLITÉCNICO\r\nELSAMINA', 'VIANA', 2),
(10, 'COLÉGIO Nª Sª DA ANUNCIAÇÃO', 'SEQUELE', 1),
(11, 'CAT COLÉGIO ANGOLANO DE\r\nTALATONA', 'BELAS', 1),
(12, 'COLÉGIO ÁbêCê', 'MARTAL', 1),
(13, 'COLÉGIO ELISANGELA FILOMENA', '1ª DE MAIO', 1),
(14, 'COLÉGIO PATRICIA ROSSANA', 'TALATONA', 1),
(15, 'COLÉGIO CAJU', 'CONDOMÍNIO CAJU', 1),
(16, 'COLÉGIO SANTA CATARINA', 'Luanda', 1),
(17, 'COLÉGIO SAN PIETRO CAMAMA', 'Camama', 1),
(18, 'COLÉGIO AMOR E PAZ', 'ESTRADA CAMAMA-VIANA', 1),
(19, 'ALPEGA', 'VILA ALICE', 1),
(20, 'COLÉGIO BOAVENTURA', 'MORRO BENTO,R. DA TOTAL', 1),
(21, 'COLÉGIO SANTA ANA & NOÉSEA', 'VILA ALICE', 1),
(22, 'ESCOLA 28 DE AGOSTO', 'EDIFÍCIO FUTUNGO', 1),
(23, 'COLÉGIO MUNDIAL', 'BELAS', 1),
(24, 'COLÉGIO NEVAL', 'BELAS', 1),
(25, 'COLÉGIO MESSIAS', 'GAMEK A DIREITA', 1),
(26, 'COLÉGIO COLINA DO\r\nSOL(BENFICA)', 'BELAS', 1),
(27, 'COLÉGIO NOVOS HORIZONTES', 'BELAS', 1),
(28, 'INSTITUTO MÉDIO DE ECONOMIA\r\nGIAVISSAMA 2', 'VIANA', 2),
(29, 'COLÉGIO OS BRILHANTES', 'QUIFICA', 1),
(30, 'COLÉGIO JÚLIO VERNE', 'QUIFICA', 1),
(31, 'COLÉGIO COMPLEXO ESCOLAR\r\nGIRASSOL', 'BELAS', 1),
(32, 'COLÉGIO LONGUESSA ||', 'BELAS', 1),
(33, 'COLÉGIO LETRAS E CORES', 'QUIFICA', 1),
(34, 'COLÉGIO VEREDA DAS FLORES', 'VIANA', 1),
(35, 'COLÉGIO MARIA LUÍSA', 'VIANA', 1),
(36, 'COLÉGIO LEONARDO DA VINCI', 'AV. HO CHIN MINH', 1),
(37, 'COLÉGIO HENRIQUES', 'CACUACO', 1),
(38, 'COLÉGIO ELISANGELA FILOMENA', 'BELAS', 1),
(39, 'COLÉGIO GILIPA', 'CACUACO', 1),
(40, 'COLÉGIO AMIZADE', 'ESTRADA CAMAMA-TALATONA', 1),
(41, 'COLÉGIO PETALAS DO SABER', 'VIANA', 1),
(42, 'COLÉGIO COMPLEXO ESCOLAR\r\nGIRASSOL', 'BELAS', 1),
(43, 'COLÉGIO ATLÂNTICO SUL', 'VIANA', 1),
(44, 'COLÉGIO QUINANGOLA', 'VIANA', 1),
(45, 'COLÉGIO MAGOS', 'VIANA', 1),
(46, 'COMPLEXO ESCOLAR ELIADA', 'VIANA', 1),
(47, 'COLÉGIO NARFIVE', 'ZANGO 3', 1),
(48, 'COLÉGIO MAGNÓLIA', 'ZANGO 2', 1),
(49, 'COLÉGIO MEGA SABER', 'ZANGO 3', 1),
(50, 'COLÉGIO CARVAJÚ', '', 1),
(51, 'COLÉGIO IMEG', '', 1),
(52, 'COLÉGIO IMAG', 'ZANGO 3', 1),
(53, 'COLÉGIO ESPÍRITO SANTO', '', 1),
(54, 'COLÉGIO TARIMBA', '', 1),
(55, 'INSTITUTO TÉCNICO LUCRÉCIO\r\nDOS SANTOS', 'ZANGO 3', 2),
(56, 'COLÉGIO SACRINOR', 'CACUACO', 1),
(57, 'PUNIV DE CACUACO', 'CACUACO', 3),
(58, 'COLÉGIO MADRUGADA', 'CAZENGA', 1),
(59, 'COLÉGIO FRUTOS DO CAJUEIRO', 'CONDOMÍNIO ACÁCIAS', 1),
(60, 'COLÉGIO ERIEV', 'DISTRITO URBANO DA SAPÚ', 1),
(61, 'COLÉGIO REJOMINAR', '', 1),
(62, 'COLÉGIO ALDANUEL', 'PALANCA', 1),
(63, 'COLÉGIO SAN CARLOS', 'PALANCA', 1),
(64, 'COLÉGIO ANDALA', 'PALANCA', 1),
(65, 'COLÉGIO MUNDO AZAUL', 'MUNDO AZUL', 1),
(66, 'COLÉGIO ALBINO', 'SAMBA', 1),
(67, 'COLÉGIO ESPERANÇA RENOVADA', 'BENFICA', 1),
(68, 'COLÉGIO INOVADOR', 'BENFICA', 1),
(69, 'COLÉGIO TINONI', 'QUIFICA', 1),
(70, 'COLÉGIO PRIMAZIA DO KILAMBA', 'KILAMBA', 1),
(71, 'ESCOLA SAGRADA ESPERANÇA\r\n2003', 'KILAMBA', 3),
(72, 'INSTITUTO DE GESTÃO DO\r\nKILAMBA', 'QUARTEIRÃO HUNGU,X', 3),
(73, 'I.M.A.G. 2012', 'KILAMBA', 3),
(74, 'COLÉGIO MUKWETO', 'BELAS', 1),
(75, 'COLÉGIO QUINANGOLA', 'VIANA', 1),
(76, 'IMPAL', 'IMGOBOTA', 3),
(77, 'MULTU – YA- KEVELA', 'IMGOBOTA', 3),
(78, 'NGOLA KILUANGE', '1ª DE MAIO', 3),
(79, 'COLÉGIO PATRICIA ROSSANA', '', 1),
(80, 'COLÉGIO SÃO BENEDITO', 'RANGEL', 1),
(81, 'ITEL', 'RANGEL', 3),
(82, 'NGOLA MBANDE', 'RANGEL', 3),
(83, 'COMPLEXO ESCOLAR BETÂNIA', 'IMGOBOTA', 1),
(84, 'IMS', 'MAIANGA', 3),
(85, 'IMTSK', 'CAZENGA', 3),
(86, 'SÃO JOSÉ DO CLUNI', 'IMGOMBOTA', 1),
(87, 'ESCOLA PORTUGUESA', '1ª DE MAIO', 1),
(88, 'COLÉGIO EPISAQUE', '', 1),
(89, 'COLÉGIO Nª Sª DA ANUNCIAÇÃO', 'ZANGO', 1),
(90, 'COLÉGIO MONA TOWER', 'TALATONA', 1),
(91, 'COLÉGIO HENRIQUES', 'KINAXIXI', 1),
(92, 'COLÉGIO ANUARATE', 'CASSENDA', 1),
(93, 'COLÉGIO VALOR REAL DO SABER', 'ZANGO 4', 1),
(94, 'COLÉGIO Nª Sª DO GUARDALUPE', 'VIANA', 1),
(95, 'COLÉGIO Nª Sª DA ANUNCIAÇÃO', 'KILAMBA', 1),
(96, 'COLÉGIO GREGÓRIO SEMEDO', 'MAIANGA', 1),
(97, 'COLÉGIO AFRILAURE', 'VIANA', 1),
(98, 'Instituto Médio Politécnico Smartbits -\r\nISMP.S', 'VIANA', 3),
(99, 'CZANGO', 'ZANGO 3', 3),
(100, 'INSTITUTO DE SAÚDE KIETTO', 'CAMAMA', 1),
(101, 'COMPLEXO ESCOLAR TONHA', 'CAMAMA', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento`
--

CREATE TABLE `evento` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `data` date NOT NULL,
  `descricao` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `evento`
--

INSERT INTO `evento` (`id`, `nome`, `data`, `descricao`) VALUES
(1, 'Evento 112324', '2020-10-24', 'Descrição para Evento 11342'),
(2, 'Ruca Fest Intercolégial By T´Leva', '2020-11-28', 'Nota explicativa sobre o Festival Drive In (Ruca Fest Intercolégial By T’Leva):\r\n\r\n1. O festival será realizado no parque de estacionamento do Talatona Shopping nos dias 28 e 29 de novembro em duas sessões por dia; \r\n\r\n2. Os assentos normais serão subititudos pelas viaturas para evitar ajuntamento d');

-- --------------------------------------------------------

--
-- Estrutura da tabela `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `utilizador` int(11) NOT NULL,
  `operacao` varchar(50) NOT NULL,
  `registo` varchar(50) DEFAULT NULL,
  `tabela` varchar(50) DEFAULT NULL,
  `data_hora` datetime NOT NULL,
  `descricao` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `log`
--

INSERT INTO `log` (`id`, `utilizador`, `operacao`, `registo`, `tabela`, `data_hora`, `descricao`) VALUES
(1, 1, 'Adição', NULL, NULL, '2020-10-01 17:01:38', 'Adicionou novo Tipo de Escola: <b>Privado</b>'),
(2, 1, 'Adição', NULL, NULL, '2020-10-01 17:03:43', 'Adicionou novo Tipo de Escola: <b>Comparticipada</b>'),
(3, 1, 'Adição', NULL, NULL, '2020-10-02 16:27:18', 'Adicionou nova Escola: <b>Colégio Famon</b>'),
(4, 1, 'Adição', NULL, NULL, '2020-10-02 16:55:44', 'Adicionou nova escola: <b>Colégio Famon</b>'),
(5, 1, 'Adição', NULL, NULL, '2020-10-02 18:29:40', 'Adicionou nova escola: <b>Colégio Famon</b>'),
(6, 1, 'Adição', NULL, NULL, '2020-10-09 18:04:21', 'Adicionou nova escola: <b>Colégio Famon</b>'),
(7, 1, 'Adição', NULL, NULL, '2020-10-09 18:13:35', 'Adicionou nova escola: <b>Colégio Famon</b>'),
(8, 1, 'Adição', NULL, NULL, '2020-10-09 18:13:51', 'Adicionou novo Tipo de Escola: <b>Comparticipada</b>'),
(9, 1, 'Adição', NULL, NULL, '2020-10-09 18:42:07', 'Adicionou nova Escola: <b>Colégio Famon</b>'),
(10, 1, 'Adição', NULL, NULL, '2020-10-12 13:14:05', 'Adicionou novo Estudante: <b>Julio Manuel</b>'),
(11, 1, 'Adição', NULL, NULL, '2020-10-13 12:29:36', 'Adicionou novo Evento: <b>Evento 1</b>'),
(12, 1, 'Adição', NULL, NULL, '2020-10-13 13:42:59', 'Adicionou novo Evento: <b>Evefafafafaf</b>'),
(13, 1, 'Adição', NULL, NULL, '2020-10-13 14:50:49', 'Adicionou novo artigo no Blog: <b>Amigo Oculto</b>'),
(14, 1, 'Adição', NULL, NULL, '2020-10-13 14:51:46', 'Adicionou novo artigo no Blog: <b>Amigo Oculto 2</b>'),
(15, 1, 'Adição', NULL, NULL, '2020-10-13 15:26:26', 'Adicionou novo artigo no Blog: <b>Amigo Oculto 3</b>'),
(16, 1, 'Adição', NULL, NULL, '2020-10-13 15:29:09', 'Adicionou novo artigo no Blog: <b>Amigo Oculto 4</b>'),
(17, 1, 'Actualização', NULL, NULL, '2020-10-13 17:48:52', 'Adicionou foto ao artigo <b>Amigo</b>'),
(18, 1, 'Actualização', NULL, NULL, '2020-10-13 17:51:28', 'Adicionou foto ao artigo <b>Amigo</b>'),
(19, 1, 'Visualizar', NULL, NULL, '2020-10-16 13:46:14', 'Visualizou informações do utilizador: <b>Júlio Manuel</b>'),
(20, 1, 'Actualizar', NULL, NULL, '2020-10-16 13:53:24', 'Actualizou                                                                                                                                                                                                                                                                                                  '),
(21, 1, 'Visualizar', NULL, NULL, '2020-10-16 13:53:24', 'Visualizou informações do utilizador: <b>Júlio Manuel</b>'),
(23, 1, 'Visualizar', NULL, NULL, '2020-11-12 14:27:10', 'Visualizou informações do utilizador: <b>Jacinto Cardoso</b>'),
(24, 1, 'Actualização', NULL, NULL, '2020-11-12 21:21:03', 'Actualizou a sua foto de perfil'),
(25, 1, 'Actualização', NULL, NULL, '2020-11-12 21:47:17', 'Actualizou a sua foto de perfil'),
(26, 1, 'Actualização', NULL, NULL, '2020-11-12 21:54:31', 'Actualizou a sua foto de perfil'),
(27, 2, 'Adição', NULL, NULL, '2020-11-13 14:34:21', 'Adicionou novo Evento: <b>Ruca Fest Intercolégial By T´Leva</b>'),
(28, 1, 'Actualização', NULL, NULL, '2020-11-26 15:02:28', 'Actualizou a sua foto de perfil');

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil`
--

CREATE TABLE `perfil` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `perfil`
--

INSERT INTO `perfil` (`id`, `nome`, `descricao`) VALUES
(1, 'Administrador', 'Administrador da aplicação.'),
(2, 'Aluno', 'Perfil para Alunos'),
(3, 'Tinatune', 'Perfil para Tinatune'),
(4, 'Gestor', 'Gestor da aplicação');

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil_permissao`
--

CREATE TABLE `perfil_permissao` (
  `perfil` int(11) NOT NULL,
  `permissao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `perfil_permissao`
--

INSERT INTO `perfil_permissao` (`perfil`, `permissao`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(4, 2),
(4, 6),
(4, 5),
(2, 5),
(2, 4),
(2, 5),
(3, 4),
(3, 5),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11);

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissao`
--

CREATE TABLE `permissao` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `descricao` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `permissao`
--

INSERT INTO `permissao` (`id`, `nome`, `descricao`) VALUES
(1, 'criarUtilizador', 'Permitir ao utilizador criar nova conta para outro utilizador.'),
(2, 'verUtilizador', 'Permitir ao utilizador ver utilizadores.'),
(3, 'eliminarUtilizador', 'Permitir ao utilizador eliminar outros utilizadores.'),
(4, 'NovaFotoutilizador', 'Permitir ao utilizador actualizar a foto.'),
(5, 'uploadMultimediaDocumento', 'Permitir ao utilizador carregar documento na aplicação.'),
(6, 'verDetalhesUtilizador', 'Permitir ao utilizador informações detalhada de utilizadores.'),
(7, 'verLog', 'Permitir ao utilizador ver registo de actividades'),
(8, 'verPerfil', 'Permitir ao utilizador ver Perfil'),
(9, 'editarPerfil', 'Permitir ao utilizador editar perfil.'),
(10, 'eliminarPerfil', 'Permitir ao utilizador eliminar Perfil'),
(11, 'eliminarPermissao', 'Permitir ao utilizador eliminar Permissão');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_escola`
--

CREATE TABLE `tipo_escola` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tipo_escola`
--

INSERT INTO `tipo_escola` (`id`, `nome`, `descricao`) VALUES
(1, 'Privado', 'Escola Privada'),
(2, 'Comparticipada', 'Escola Comparticipada'),
(3, 'Estatal', 'Escola Estatal');

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizador`
--

CREATE TABLE `utilizador` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(150) NOT NULL,
  `perfil` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `foto` varchar(250) DEFAULT NULL,
  `telefone` varchar(100) DEFAULT NULL,
  `escola` int(11) DEFAULT NULL,
  `data_inscricao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `utilizador`
--

INSERT INTO `utilizador` (`id`, `nome`, `email`, `password`, `perfil`, `estado`, `foto`, `telefone`, `escola`, `data_inscricao`) VALUES
(1, 'Júlio Manuel', 'mrvipaji@mrvipaji.ao', '81dc9bdb52d04dc20036dbd8313ed055', 1, 1, 'fe29fe6de7aedbc40201cf1a4e3e5394.jpg', '921766797', NULL, NULL),
(2, 'Jacinto Cardoso', 'jacinto.cardoso@jam.co.ao', '81dc9bdb52d04dc20036dbd8313ed055', 1, 1, NULL, '', NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilizador` (`utilizador`);

--
-- Índices para tabela `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilizador` (`utilizador`);

--
-- Índices para tabela `escola`
--
ALTER TABLE `escola`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilizador` (`utilizador`);

--
-- Índices para tabela `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `perfil_permissao`
--
ALTER TABLE `perfil_permissao`
  ADD KEY `perfil` (`perfil`),
  ADD KEY `permissao` (`permissao`);

--
-- Índices para tabela `permissao`
--
ALTER TABLE `permissao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tipo_escola`
--
ALTER TABLE `tipo_escola`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `utilizador`
--
ALTER TABLE `utilizador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perfil` (`perfil`),
  ADD KEY `escola` (`escola`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `documento`
--
ALTER TABLE `documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `escola`
--
ALTER TABLE `escola`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de tabela `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `permissao`
--
ALTER TABLE `permissao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `tipo_escola`
--
ALTER TABLE `tipo_escola`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `utilizador`
--
ALTER TABLE `utilizador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`utilizador`) REFERENCES `utilizador` (`id`);

--
-- Limitadores para a tabela `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`utilizador`) REFERENCES `utilizador` (`id`);

--
-- Limitadores para a tabela `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`utilizador`) REFERENCES `utilizador` (`id`);

--
-- Limitadores para a tabela `perfil_permissao`
--
ALTER TABLE `perfil_permissao`
  ADD CONSTRAINT `perfil_permissao_ibfk_1` FOREIGN KEY (`perfil`) REFERENCES `perfil` (`id`),
  ADD CONSTRAINT `perfil_permissao_ibfk_2` FOREIGN KEY (`permissao`) REFERENCES `permissao` (`id`);

--
-- Limitadores para a tabela `utilizador`
--
ALTER TABLE `utilizador`
  ADD CONSTRAINT `utilizador_ibfk_1` FOREIGN KEY (`perfil`) REFERENCES `perfil` (`id`),
  ADD CONSTRAINT `utilizador_ibfk_2` FOREIGN KEY (`escola`) REFERENCES `escola` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
