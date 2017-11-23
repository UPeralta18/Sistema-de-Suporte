-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 23-Nov-2017 às 16:48
-- Versão do servidor: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `suporte`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `chamado`
--

CREATE TABLE `chamado` (
  `id_chamado` int(11) NOT NULL,
  `id_solicitante` int(11) NOT NULL,
  `id_atendente` int(11) DEFAULT NULL,
  `status` smallint(1) NOT NULL,
  `id_tipo_chamado` int(11) NOT NULL,
  `data_abertura` date NOT NULL,
  `data_inicio_execucao` date DEFAULT NULL,
  `data_finalizacao` date DEFAULT NULL,
  `descricao` text COLLATE utf8_bin NOT NULL,
  `titulo` text COLLATE utf8_bin NOT NULL,
  `urgente` tinyint(1) NOT NULL,
  `comentario` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `chamado`
--

INSERT INTO `chamado` (`id_chamado`, `id_solicitante`, `id_atendente`, `status`, `id_tipo_chamado`, `data_abertura`, `data_inicio_execucao`, `data_finalizacao`, `descricao`, `titulo`, `urgente`, `comentario`) VALUES
(3, 2, 1, 2, 4, '2017-11-20', '2017-11-23', '2017-11-23', 'O setor precisa de um pen drive', 'pen drive', 1, 'Jean (23/11/2017): ComentÃ¡rio  -  Jean (23/11/2017): ComentÃ¡rio  -  Jean (23/11/2017): ComentÃ¡rio 2  -  Jean (23/11/2017): ComentÃ¡rio 3  -  Ulisses (23/11/2017): Resposta'),
(4, 2, 1, 0, 3, '2017-11-20', NULL, '2017-11-23', 'Facebook nÃ£o abre', 'Facebook', 1, NULL),
(5, 2, 1, 0, 4, '2017-11-21', '2017-11-23', '2017-11-23', 'Descricao', 'Titulo', 0, NULL),
(6, 2, 1, 0, 2, '2017-11-21', '2017-11-23', '2017-11-23', 'Testando novamente', 'Teste 3', 0, NULL),
(7, 2, 1, 0, 1, '2017-11-21', NULL, NULL, 'Computador parou de ligar', 'Chamado Urgente', 0, NULL),
(8, 2, 1, 0, 2, '2017-11-21', NULL, '2017-11-23', 'Chamado nÃ£o urgente', 'Chamado NÃ£o urgente', 0, NULL),
(9, 2, 1, 0, 4, '2017-11-21', '2017-11-23', '2017-11-23', 'Outro chamado urgente', 'Outro Chamado Urgente', 1, NULL),
(10, 2, NULL, 0, 4, '2017-11-23', NULL, '2017-11-23', 'Chamado foi alterado com sucesso', 'Chamado alterado', 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `logado`
--

CREATE TABLE `logado` (
  `id_usuario` int(11) NOT NULL,
  `logado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `setor`
--

CREATE TABLE `setor` (
  `id_setor` int(11) NOT NULL,
  `nome` text COLLATE utf8_bin NOT NULL,
  `telefone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `setor`
--

INSERT INTO `setor` (`id_setor`, `nome`, `telefone`) VALUES
(1, 'T.I.', 12345678),
(2, 'R.H', 87654321),
(3, 'Diretoria', 10000000),
(4, 'Controladoria', 11111111),
(5, 'Tesouraria', 22222222);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_chamado`
--

CREATE TABLE `tipo_chamado` (
  `id_tipo_chamado` int(11) NOT NULL,
  `nome` text CHARACTER SET utf8 NOT NULL,
  `descricao` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tipo_chamado`
--

INSERT INTO `tipo_chamado` (`id_tipo_chamado`, `nome`, `descricao`) VALUES
(1, 'Equipamento', 'Problema no equipamento'),
(2, 'Rede', 'Problema de acesso a rede'),
(3, 'Internet', 'Problema para acessar algum site'),
(4, 'Solicita&ccedil;&atilde;o', 'Solicita&ccedil;&atilde;o de equipamento de inform&aacute;tica');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome` text COLLATE utf8_bin NOT NULL,
  `administrador` tinyint(1) NOT NULL,
  `senha` int(11) NOT NULL,
  `setor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `administrador`, `senha`, `setor`) VALUES
(1, 'Ulisses', 1, 123, 1),
(2, 'Jean', 0, 123, 2),
(3, 'Alvira', 1, 123, 1),
(7, 'Weslei', 0, 0, 2),
(8, 'Jessica', 0, 123, 3),
(9, 'Thais', 0, 123, 4),
(10, 'Wagner', 0, 123, 5),
(26, 'Davi', 0, 123, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chamado`
--
ALTER TABLE `chamado`
  ADD PRIMARY KEY (`id_chamado`);

--
-- Indexes for table `setor`
--
ALTER TABLE `setor`
  ADD PRIMARY KEY (`id_setor`);

--
-- Indexes for table `tipo_chamado`
--
ALTER TABLE `tipo_chamado`
  ADD PRIMARY KEY (`id_tipo_chamado`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chamado`
--
ALTER TABLE `chamado`
  MODIFY `id_chamado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `setor`
--
ALTER TABLE `setor`
  MODIFY `id_setor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tipo_chamado`
--
ALTER TABLE `tipo_chamado`
  MODIFY `id_tipo_chamado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
