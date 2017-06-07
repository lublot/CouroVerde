-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2017 at 04:35 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `webmuseu`
--

-- --------------------------------------------------------

--
-- Table structure for table `arquivo`
--

CREATE TABLE IF NOT EXISTS `arquivo` (
  `idArquivo` int(11) NOT NULL AUTO_INCREMENT,
  `caminho` varchar(200) NOT NULL,
  `tipo` enum('IMAGEM','MODELO 3D') NOT NULL,
  PRIMARY KEY (`idArquivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `arquivoobra`
--

CREATE TABLE IF NOT EXISTS `arquivoobra` (
  `idObra` int(11) NOT NULL,
  `idArquivo` int(11) NOT NULL,
  PRIMARY KEY (`idObra`,`idArquivo`),
  KEY `fk_idArquivo_idx` (`idArquivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `classificacao`
--

CREATE TABLE IF NOT EXISTS `classificacao` (
  `idClassificacao` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`idClassificacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `colecao`
--

CREATE TABLE IF NOT EXISTS `colecao` (
  `idColecao` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`idColecao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fotografia`
--

CREATE TABLE IF NOT EXISTS `fotografia` (
  `idFotografia` int(11) NOT NULL,
  `Fotografo` varchar(50) DEFAULT NULL,
  `data` varchar(45) DEFAULT NULL,
  `autorFotografia` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idFotografia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `funcionario`
--

CREATE TABLE IF NOT EXISTS `funcionario` (
  `matricula` int(11) NOT NULL,
  `funcao` varchar(45) NOT NULL,
  `CadastroObra` tinyint(1) NOT NULL,
  `gerenciaObra` tinyint(1) NOT NULL,
  `remocaoObra` tinyint(1) NOT NULL,
  `cadastroNoticia` tinyint(1) NOT NULL,
  `gerenciaNoticia` tinyint(1) NOT NULL,
  `remocaoNoticia` tinyint(1) NOT NULL,
  `backup` tinyint(1) NOT NULL,
  PRIMARY KEY (`matricula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `noticia`
--

CREATE TABLE IF NOT EXISTS `noticia` (
  `idNoticia` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) NOT NULL,
  `subtitulo` varchar(100) DEFAULT NULL,
  `descricao` varchar(500) DEFAULT NULL,
  `caminhoImagem` varchar(200) DEFAULT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`idNoticia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `obra`
--

CREATE TABLE IF NOT EXISTS `obra` (
  `numeroInventario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `funcao` varchar(45) DEFAULT NULL,
  `origem` varchar(45) DEFAULT NULL,
  `procedencia` varchar(45) DEFAULT NULL,
  `descricao` varchar(3000) DEFAULT NULL,
  `idColecao` int(11) NOT NULL,
  `idClassificacao` int(11) NOT NULL,
  `altura` float DEFAULT NULL,
  `largura` float DEFAULT NULL,
  `diametro` float DEFAULT NULL,
  `peso` float DEFAULT NULL,
  `comprimento` float DEFAULT NULL,
  `materiais contruidos` varchar(200) DEFAULT NULL,
  `tecnicasFabricacao` varchar(100) DEFAULT NULL,
  `autoria` varchar(45) DEFAULT NULL,
  `marcasInscricoes` varchar(200) DEFAULT NULL,
  `historicoObjeto` varchar(200) DEFAULT NULL,
  `modoAquisicao` varchar(45) DEFAULT NULL,
  `dataAquisicao` date DEFAULT NULL,
  `autor` varchar(45) DEFAULT NULL,
  `observacoes` varchar(100) DEFAULT NULL,
  `estadoConservacao` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`numeroInventario`),
  KEY `idCategoria_idx` (`idClassificacao`),
  KEY `fk_idColecao_obra_idx` (`idColecao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pergunta`
--

CREATE TABLE IF NOT EXISTS `pergunta` (
  `idPergunta` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) NOT NULL,
  `opcional` tinyint(1) NOT NULL,
  `tipo` enum('ABERTA','UNICA ESCOLHA','MULTIPLA ESCOLHA') NOT NULL,
  PRIMARY KEY (`idPergunta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `perguntapesquisa`
--

CREATE TABLE IF NOT EXISTS `perguntapesquisa` (
  `idPergunta` int(11) NOT NULL,
  `idPesquisa` int(11) NOT NULL,
  PRIMARY KEY (`idPergunta`,`idPesquisa`),
  KEY `fk_PerguntaPesquisa_Pesquisa_idx` (`idPesquisa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pesquisa`
--

CREATE TABLE IF NOT EXISTS `pesquisa` (
  `idPesquisa` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) NOT NULL,
  `estaAtiva` tinyint(1) NOT NULL,
  PRIMARY KEY (`idPesquisa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `idTag` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`idTag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tagobra`
--

CREATE TABLE IF NOT EXISTS `tagobra` (
  `idTag` int(11) NOT NULL,
  `idObra` int(11) NOT NULL,
  PRIMARY KEY (`idTag`,`idObra`),
  KEY `fk_idObra_idx` (`idObra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL,
  `sobrenome` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `confirmouCadastro` tinyint(1) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usuariorespostapesquisa`
--

CREATE TABLE IF NOT EXISTS `usuariorespostapesquisa` (
  `idUsuario` int(11) NOT NULL,
  `idPesquisa` int(11) NOT NULL,
  PRIMARY KEY (`idUsuario`,`idPesquisa`),
  KEY `fk_UsuarioRespostaPesquisa_Pesquisa_idx` (`idPesquisa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `arquivoobra`
--
ALTER TABLE `arquivoobra`
  ADD CONSTRAINT `fk_idArquivo_arquivoObra` FOREIGN KEY (`idArquivo`) REFERENCES `arquivo` (`idArquivo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_idObra_arquivoObra` FOREIGN KEY (`idObra`) REFERENCES `obra` (`numeroInventario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `fotografia`
--
ALTER TABLE `fotografia`
  ADD CONSTRAINT `fk_idObra_fotografia` FOREIGN KEY (`idFotografia`) REFERENCES `obra` (`numeroInventario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `matricula` FOREIGN KEY (`matricula`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `obra`
--
ALTER TABLE `obra`
  ADD CONSTRAINT `fk_idClassificacao_obra` FOREIGN KEY (`idClassificacao`) REFERENCES `classificacao` (`idClassificacao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_idColecao_obra` FOREIGN KEY (`idColecao`) REFERENCES `colecao` (`idColecao`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `perguntapesquisa`
--
ALTER TABLE `perguntapesquisa`
  ADD CONSTRAINT `fk_PerguntaPesquisa_Pergunta` FOREIGN KEY (`idPergunta`) REFERENCES `pergunta` (`idPergunta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_PerguntaPesquisa_Pesquisa` FOREIGN KEY (`idPesquisa`) REFERENCES `pesquisa` (`idPesquisa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tagobra`
--
ALTER TABLE `tagobra`
  ADD CONSTRAINT `fk_idObra_tagObra` FOREIGN KEY (`idObra`) REFERENCES `obra` (`numeroInventario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_idTag_tagObra` FOREIGN KEY (`idTag`) REFERENCES `tag` (`idTag`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `usuariorespostapesquisa`
--
ALTER TABLE `usuariorespostapesquisa`
  ADD CONSTRAINT `fk_UsuarioRespostaPesquisa_Pesquisa` FOREIGN KEY (`idPesquisa`) REFERENCES `pesquisa` (`idPesquisa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_UsuarioRespostaPesquisa_Usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
