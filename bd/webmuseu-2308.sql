CREATE DATABASE  IF NOT EXISTS `webmuseu` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `webmuseu`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: webmuseu
-- ------------------------------------------------------
-- Server version	5.7.14

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `backup`
--

DROP TABLE IF EXISTS `backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup` (
  `idBackup` int(11) NOT NULL AUTO_INCREMENT,
  `caminho` text NOT NULL,
  `dataHora` datetime NOT NULL,
  PRIMARY KEY (`idBackup`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup`
--

LOCK TABLES `backup` WRITE;
/*!40000 ALTER TABLE `backup` DISABLE KEYS */;
INSERT INTO `backup` VALUES (2,'backups/backup_2017-08-2310-51-54.zip','2017-08-23 10:51:54'),(3,'backups/backup_2017-08-2310-52-29.zip','2017-08-23 10:52:29'),(4,'backups/backup_2017-08-2311-29-06.zip','2017-08-23 11:29:06'),(5,'backups/backup_2017-08-2311-29-25.zip','2017-08-23 11:29:25'),(6,'backups/backup_2017-08-2314-21-17.zip','2017-08-23 14:21:17');
/*!40000 ALTER TABLE `backup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classificacao`
--

DROP TABLE IF EXISTS `classificacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classificacao` (
  `idClassificacao` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`idClassificacao`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classificacao`
--

LOCK TABLES `classificacao` WRITE;
/*!40000 ALTER TABLE `classificacao` DISABLE KEYS */;
INSERT INTO `classificacao` VALUES (2,'Acervo Madeira'),(3,'Objetos'),(49,'Objetos de Casa'),(6,'Objetos Pessoais'),(1,'Periodo Escravocrata');
/*!40000 ALTER TABLE `classificacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colecao`
--

DROP TABLE IF EXISTS `colecao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colecao` (
  `idColecao` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`idColecao`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colecao`
--

LOCK TABLES `colecao` WRITE;
/*!40000 ALTER TABLE `colecao` DISABLE KEYS */;
INSERT INTO `colecao` VALUES (3,'Caricaturas'),(6,'Chapéus'),(5,'Ferros'),(67,'Lucas da Feira'),(66,'Luminárias'),(1,'Pote');
/*!40000 ALTER TABLE `colecao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fotografia`
--

DROP TABLE IF EXISTS `fotografia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fotografia` (
  `idFotografia` int(11) NOT NULL,
  `Fotografo` varchar(50) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `autorFotografia` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idFotografia`),
  CONSTRAINT `fk_Fotografia_Obra` FOREIGN KEY (`idFotografia`) REFERENCES `obra` (`numeroInventario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fotografia`
--

LOCK TABLES `fotografia` WRITE;
/*!40000 ALTER TABLE `fotografia` DISABLE KEYS */;
/*!40000 ALTER TABLE `fotografia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `funcionario`
--

DROP TABLE IF EXISTS `funcionario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `funcionario` (
  `matricula` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `funcao` varchar(45) NOT NULL,
  `cadastroObra` tinyint(1) NOT NULL,
  `gerenciaObra` tinyint(1) NOT NULL,
  `remocaoObra` tinyint(1) NOT NULL,
  `cadastroNoticia` tinyint(1) NOT NULL,
  `gerenciaNoticia` tinyint(1) NOT NULL,
  `remocaoNoticia` tinyint(1) NOT NULL,
  `backup` tinyint(1) NOT NULL,
  PRIMARY KEY (`matricula`),
  UNIQUE KEY `idUsuario_UNIQUE` (`idUsuario`),
  KEY `fk_Funcionario_Usuario_idx` (`idUsuario`),
  CONSTRAINT `fk_Funcionario_Usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funcionario`
--

LOCK TABLES `funcionario` WRITE;
/*!40000 ALTER TABLE `funcionario` DISABLE KEYS */;
INSERT INTO `funcionario` VALUES (3,6,'gerente back end',1,1,1,1,1,1,1),(4,4,'gerente geral',1,1,1,1,1,1,1),(5,5,'gerente front end',1,1,1,1,1,1,1),(112233,1,'Dona',1,1,1,1,1,1,1),(445566,3,'Funcionário',1,1,1,0,0,0,1),(889911,47,'ADMINISTRADOR',1,1,1,1,1,1,1);
/*!40000 ALTER TABLE `funcionario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logalteracoes`
--

DROP TABLE IF EXISTS `logalteracoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logalteracoes` (
  `idLogAlteracoes` int(11) NOT NULL AUTO_INCREMENT,
  `matriculaFuncionario` int(11) NOT NULL,
  `idItemAlterado` int(11) NOT NULL,
  `tipoItemAlterado` enum('NOTICIA','OBRA','BACKUP','FUNCIONARIO') NOT NULL,
  `descricao` text NOT NULL,
  `dataHora` datetime NOT NULL,
  PRIMARY KEY (`idLogAlteracoes`),
  KEY `fk_LogAlteracoes_Funcionario_idx` (`matriculaFuncionario`),
  CONSTRAINT `fk_LogAlteracoes_Funcionario` FOREIGN KEY (`matriculaFuncionario`) REFERENCES `funcionario` (`matricula`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logalteracoes`
--

LOCK TABLES `logalteracoes` WRITE;
/*!40000 ALTER TABLE `logalteracoes` DISABLE KEYS */;
INSERT INTO `logalteracoes` VALUES (1,5,6,'OBRA','Uma obra foi alterada','2017-08-22 22:45:32'),(2,5,6,'OBRA','Uma obra foi alterada','2017-08-22 22:46:52'),(3,5,8,'OBRA','Uma obra foi cadastrada','2017-08-22 22:50:54'),(4,4,8,'OBRA','Uma obra foi removida','2017-08-22 22:56:54'),(5,4,7,'OBRA','Uma obra foi cadastrada','2017-08-22 22:59:58'),(6,112233,8888,'OBRA','Uma obra foi cadastrada','2017-08-23 09:21:37'),(7,112233,8888,'OBRA','Uma obra foi cadastrada','2017-08-23 09:23:51'),(8,112233,8888,'OBRA','Uma obra foi cadastrada','2017-08-23 09:24:07'),(9,112233,8888,'OBRA','Uma obra foi cadastrada','2017-08-23 09:24:22'),(10,112233,8888,'OBRA','Uma obra foi cadastrada','2017-08-23 09:24:31'),(11,112233,8888,'OBRA','Uma obra foi cadastrada','2017-08-23 09:24:36'),(12,112233,8888,'OBRA','Uma obra foi cadastrada','2017-08-23 09:25:01'),(13,112233,8888,'OBRA','Uma obra foi cadastrada','2017-08-23 09:25:07'),(14,112233,8888,'OBRA','Uma obra foi cadastrada','2017-08-23 09:25:38'),(15,112233,8888,'OBRA','Uma obra foi cadastrada','2017-08-23 09:25:44'),(16,112233,8888,'OBRA','Uma obra foi cadastrada','2017-08-23 09:25:46'),(17,112233,4535,'OBRA','Uma obra foi cadastrada','2017-08-23 09:26:09'),(18,112233,34455,'OBRA','Uma obra foi cadastrada','2017-08-23 09:28:34'),(19,112233,77347,'OBRA','Uma obra foi cadastrada','2017-08-23 09:29:51'),(20,112233,89894,'OBRA','Uma obra foi cadastrada','2017-08-23 09:32:49'),(21,112233,5564,'OBRA','Uma obra foi cadastrada','2017-08-23 09:38:07'),(22,112233,4656,'OBRA','Uma obra foi cadastrada','2017-08-23 09:43:28'),(23,112233,4656,'OBRA','Uma obra foi cadastrada','2017-08-23 09:44:06'),(24,112233,4656,'OBRA','Uma obra foi cadastrada','2017-08-23 09:44:23'),(25,112233,4656,'OBRA','Uma obra foi cadastrada','2017-08-23 09:44:40'),(26,112233,4656,'OBRA','Uma obra foi cadastrada','2017-08-23 09:44:51'),(27,112233,4656,'OBRA','Uma obra foi cadastrada','2017-08-23 09:45:25'),(28,112233,4656,'OBRA','Uma obra foi cadastrada','2017-08-23 09:45:59'),(29,112233,4656,'OBRA','Uma obra foi cadastrada','2017-08-23 09:46:38'),(30,112233,4656,'OBRA','Uma obra foi cadastrada','2017-08-23 09:46:56'),(31,112233,4656,'OBRA','Uma obra foi cadastrada','2017-08-23 09:47:10'),(32,112233,44523,'OBRA','Uma obra foi cadastrada','2017-08-23 09:55:32'),(33,112233,8898,'OBRA','Uma obra foi cadastrada','2017-08-23 10:03:01'),(34,112233,8898,'OBRA','Uma obra foi cadastrada','2017-08-23 10:03:01'),(35,112233,4535,'OBRA','Uma obra foi alterada','2017-08-23 10:06:11'),(36,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 10:06:26'),(37,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 10:15:11'),(38,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 10:15:26'),(39,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 10:15:40'),(40,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 10:15:51'),(41,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 10:17:59'),(42,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 10:19:18'),(43,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 10:19:52'),(44,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 10:23:16'),(45,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 10:35:54'),(46,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 10:36:08'),(47,112233,1,'BACKUP','Um backup foi criado','2017-08-23 10:51:47'),(48,112233,2,'BACKUP','Um backup foi criado','2017-08-23 10:52:06'),(49,112233,3,'BACKUP','Um backup foi criado','2017-08-23 10:52:44'),(50,112233,4,'BACKUP','Um backup foi criado','2017-08-23 11:29:22'),(51,112233,5,'BACKUP','Um backup foi criado','2017-08-23 11:29:40'),(52,112233,4535,'OBRA','Uma obra foi removida','2017-08-23 11:40:57'),(53,112233,8898,'OBRA','Uma obra foi removida','2017-08-23 11:41:01'),(54,112233,34455,'OBRA','Uma obra foi removida','2017-08-23 11:41:04'),(55,112233,44523,'OBRA','Uma obra foi removida','2017-08-23 11:41:07'),(56,112233,6787,'OBRA','Uma obra foi cadastrada','2017-08-23 11:47:07'),(57,112233,6787,'OBRA','Uma obra foi removida','2017-08-23 11:47:22'),(58,112233,454,'OBRA','Uma obra foi cadastrada','2017-08-23 11:49:21'),(59,112233,454,'OBRA','Uma obra foi removida','2017-08-23 11:49:31'),(60,112233,1,'OBRA','Uma obra foi alterada','2017-08-23 13:17:12'),(61,112233,1,'OBRA','Uma obra foi alterada','2017-08-23 13:21:09'),(62,112233,1,'OBRA','Uma obra foi alterada','2017-08-23 13:23:34'),(63,112233,1,'OBRA','Uma obra foi alterada','2017-08-23 13:23:44'),(64,112233,1,'OBRA','Uma obra foi alterada','2017-08-23 13:23:52'),(65,112233,1,'OBRA','Uma obra foi alterada','2017-08-23 13:24:54'),(66,112233,1,'OBRA','Uma obra foi alterada','2017-08-23 13:26:06'),(67,112233,1,'OBRA','Uma obra foi alterada','2017-08-23 13:27:22'),(68,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 13:28:14'),(69,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 13:28:36'),(70,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 13:30:07'),(71,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 13:32:04'),(72,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 13:33:02'),(73,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 13:34:09'),(74,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 13:34:18'),(75,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 13:34:41'),(76,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 13:35:41'),(77,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 13:36:07'),(78,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 13:36:52'),(79,112233,1,'OBRA','Uma obra foi alterada','2017-08-23 13:37:13'),(80,112233,2,'OBRA','Uma obra foi alterada','2017-08-23 13:37:24'),(81,112233,889911,'FUNCIONARIO','Um funcionÃ¡rio foi cadastrado','2017-08-23 14:18:41'),(82,889911,6,'BACKUP','Um backup foi criado','2017-08-23 14:21:28');
/*!40000 ALTER TABLE `logalteracoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `noticia`
--

DROP TABLE IF EXISTS `noticia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `noticia` (
  `idNoticia` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `subtitulo` varchar(150) DEFAULT NULL,
  `descricao` text,
  `caminhoImagem` text,
  `data` date NOT NULL,
  PRIMARY KEY (`idNoticia`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `noticia`
--

LOCK TABLES `noticia` WRITE;
/*!40000 ALTER TABLE `noticia` DISABLE KEYS */;
INSERT INTO `noticia` VALUES (1,'Inauguração Web Museu Casa do Sertão','','O web museu casa do sertão foi inaugurado no dia 23/08/2017, desenvolvido pela MITHOLOGIC Software. O nome escolhido foi SERTOUR.','media/noticias/imagens/20170821172133museo_casa_certao_1.jpg','2017-08-22'),(2,'Nova coleção no Museu Casa do Sertão','','O web museu casa do sertão inaugurou uma nova coleção no dia 22/08/2017, nessa nova coleção estão expostos diversos tipos de máquinas.','media/noticias/imagens/20170821172456museo_casa_certao_2.jpg','2017-08-22');
/*!40000 ALTER TABLE `noticia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `obra`
--

DROP TABLE IF EXISTS `obra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `obra` (
  `numeroInventario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `funcao` varchar(45) DEFAULT NULL,
  `origem` varchar(45) DEFAULT NULL,
  `procedencia` varchar(45) DEFAULT NULL,
  `descricao` text,
  `idColecao` int(11) NOT NULL,
  `idClassificacao` int(11) NOT NULL,
  `altura` float DEFAULT NULL,
  `largura` float DEFAULT NULL,
  `diametro` float DEFAULT NULL,
  `peso` float DEFAULT NULL,
  `comprimento` float DEFAULT NULL,
  `materiaisContruidos` varchar(200) DEFAULT NULL,
  `tecnicasFabricacao` varchar(100) DEFAULT NULL,
  `autoria` varchar(45) DEFAULT NULL,
  `marcasInscricoes` varchar(200) DEFAULT NULL,
  `historicoObjeto` varchar(200) DEFAULT NULL,
  `modoAquisicao` varchar(45) DEFAULT NULL,
  `dataAquisicao` date DEFAULT NULL,
  `autor` varchar(45) DEFAULT NULL,
  `observacoes` varchar(100) DEFAULT NULL,
  `estadoConservacao` varchar(45) DEFAULT NULL,
  `caminhoImagem1` text,
  `caminhoImagem2` text,
  `caminhoImagem3` text,
  `caminhoImagem4` text,
  `caminhoImagem5` text,
  `caminhoModelo3D` text,
  PRIMARY KEY (`numeroInventario`),
  KEY `idCategoria_idx` (`idClassificacao`),
  KEY `fk_idColecao_obra_idx` (`idColecao`),
  CONSTRAINT `fk_Obra_Classificacao` FOREIGN KEY (`idClassificacao`) REFERENCES `classificacao` (`idClassificacao`) ON UPDATE CASCADE,
  CONSTRAINT `fk_Obra_Colecao` FOREIGN KEY (`idColecao`) REFERENCES `colecao` (`idColecao`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `obra`
--

LOCK TABLES `obra` WRITE;
/*!40000 ALTER TABLE `obra` DISABLE KEYS */;
INSERT INTO `obra` VALUES (1,'Lumin&aacute;ria','Lumin&aacute;ria t&iacute;pica sertaneja.','','Sertão da Bahia','','Uma luminária típica do sertão da bahia.',66,49,1.5,2,3,4,10,'Plástico e couro','Várias','Desconhecido','Alguns arranhões','','',NULL,'','','','../media/obras/imagens/1/lu-potes.jpg','../media/obras/imagens/1/luminaria-rustica-de-juta-e-resina-chacaras.jpg','','','','../media/obras/modelo3d/1/lamp.obj'),(2,'Pote','Pote t&iacute;pico sertanejo.','','Feira de Santana','','Um pote típico do sertão da bahia.',1,6,1.5,2,3,4,10,'Cerâmica','Várias','Desconhecido','Alguns arranhões','','',NULL,'','','','../media/obras/imagens/2/pote.jpg','','','','','../media/obras/modelo3d/2/pote.obj'),(3,'Rosto Asssustado','Rosto Asssustado do Sertão','','Sertão da Bahia','','Uma caricatura típica do sertão da bahia.',3,3,1.5,2,3,4,10,'Cerâmica','Várias','Desconhecido','Alguns arranhões','','',NULL,'','','','../media/obras/imagens/3/caricatura.jpg','','','','',''),(4,'Chapéu Típico','Chapéu Típico de Sertanejo','','Sertão da Bahia','','Um chapéu típico do sertão da bahia.',6,6,1.5,2,3,4,10,'Couro','Várias','Desconhecido','Alguns arranhões','','',NULL,'','','','../media/obras/imagens/4/chapeu.jpg','','','','',''),(5,'Ferro de Passar Roupa','Ferro de Passar Roupa Carvão','','Sertão da Bahia','','Um ferro de passar típico do sertão da bahia.',5,49,1.5,2,3,4,10,'Ferro e carvão','Várias','Desconhecido','Alguns arranhões','','',NULL,'','','','../media/obras/imagens/5/f1.jpg','../media/obras/imagens/5/f2.jpg','','','',''),(6,'Carro de boi','Carro de boi','','','','',1,1,NULL,NULL,NULL,NULL,NULL,'','','','','','',NULL,'','','','../media/obras/imagens/6/IMG-20170822-WA0008.jpg','../media/obras/imagens/6/carro de boi.jpg','','','','../media/obras/modelo3d/6/carroca.obj'),(7,'Tear','Tear','','','','',67,49,NULL,NULL,NULL,NULL,NULL,'','','','','','',NULL,'','','','../media/obras/imagens/7/Tear.jpg','','','','','');
/*!40000 ALTER TABLE `obra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opcao`
--

DROP TABLE IF EXISTS `opcao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opcao` (
  `idOpcao` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` text NOT NULL,
  PRIMARY KEY (`idOpcao`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opcao`
--

LOCK TABLES `opcao` WRITE;
/*!40000 ALTER TABLE `opcao` DISABLE KEYS */;
INSERT INTO `opcao` VALUES (1,'Não'),(2,'Sim'),(3,'Muito'),(4,'Página Inicial'),(5,'Galeria'),(6,'Sobre'),(7,'Filtro'),(8,'Notícias');
/*!40000 ALTER TABLE `opcao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pergunta`
--

DROP TABLE IF EXISTS `pergunta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pergunta` (
  `idPergunta` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` text NOT NULL,
  `opcional` tinyint(1) NOT NULL,
  `tipo` enum('ABERTA','UNICA ESCOLHA','MULTIPLA ESCOLHA') NOT NULL,
  PRIMARY KEY (`idPergunta`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pergunta`
--

LOCK TABLES `pergunta` WRITE;
/*!40000 ALTER TABLE `pergunta` DISABLE KEYS */;
INSERT INTO `pergunta` VALUES (1,'Está satisfeito(a) com o sistema?',0,'UNICA ESCOLHA'),(2,'O que gostou?',0,'MULTIPLA ESCOLHA'),(3,'Escreva aqui uma sugestão',1,'ABERTA');
/*!40000 ALTER TABLE `pergunta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perguntaopcao`
--

DROP TABLE IF EXISTS `perguntaopcao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perguntaopcao` (
  `idPergunta` int(11) NOT NULL,
  `idOpcao` int(11) NOT NULL,
  PRIMARY KEY (`idPergunta`,`idOpcao`),
  KEY `fk_PerguntaOpcao_Opcao_idx` (`idOpcao`),
  CONSTRAINT `fk_PerguntaOpcao_Opcao` FOREIGN KEY (`idOpcao`) REFERENCES `opcao` (`idOpcao`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_PerguntaOpcao_Pergunta` FOREIGN KEY (`idPergunta`) REFERENCES `pergunta` (`idPergunta`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perguntaopcao`
--

LOCK TABLES `perguntaopcao` WRITE;
/*!40000 ALTER TABLE `perguntaopcao` DISABLE KEYS */;
INSERT INTO `perguntaopcao` VALUES (1,1),(1,2),(1,3),(2,4),(2,5),(2,6),(2,7),(2,8);
/*!40000 ALTER TABLE `perguntaopcao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perguntapesquisa`
--

DROP TABLE IF EXISTS `perguntapesquisa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perguntapesquisa` (
  `idPergunta` int(11) NOT NULL,
  `idPesquisa` int(11) NOT NULL,
  PRIMARY KEY (`idPergunta`,`idPesquisa`),
  KEY `fk_PerguntaPesquisa_Pesquisa_idx` (`idPesquisa`),
  CONSTRAINT `fk_PerguntaPesquisa_Pergunta` FOREIGN KEY (`idPergunta`) REFERENCES `pergunta` (`idPergunta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_PerguntaPesquisa_Pesquisa` FOREIGN KEY (`idPesquisa`) REFERENCES `pesquisa` (`idPesquisa`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perguntapesquisa`
--

LOCK TABLES `perguntapesquisa` WRITE;
/*!40000 ALTER TABLE `perguntapesquisa` DISABLE KEYS */;
INSERT INTO `perguntapesquisa` VALUES (1,1),(2,1),(3,1);
/*!40000 ALTER TABLE `perguntapesquisa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pesquisa`
--

DROP TABLE IF EXISTS `pesquisa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pesquisa` (
  `idPesquisa` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `descricao` text,
  `estaAtiva` tinyint(1) NOT NULL,
  PRIMARY KEY (`idPesquisa`),
  UNIQUE KEY `titulo_UNIQUE` (`titulo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pesquisa`
--

LOCK TABLES `pesquisa` WRITE;
/*!40000 ALTER TABLE `pesquisa` DISABLE KEYS */;
INSERT INTO `pesquisa` VALUES (1,'Pesquisa de satisfação do sistema','Essa pesquisa visa buscar estatísticas em relação ao uso do sistema.',1);
/*!40000 ALTER TABLE `pesquisa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `respostaaberta`
--

DROP TABLE IF EXISTS `respostaaberta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `respostaaberta` (
  `idUsuario` int(11) NOT NULL,
  `idPesquisa` int(11) NOT NULL,
  `idPergunta` int(11) NOT NULL,
  `descricao` text NOT NULL,
  PRIMARY KEY (`idUsuario`,`idPesquisa`,`idPergunta`),
  KEY `fk_RespostaAberta_Pergunta_idx` (`idPergunta`),
  KEY `fk_RespostaAberta_Pesquisa_idx` (`idPesquisa`),
  CONSTRAINT `fk_RespostaAberta_Pergunta` FOREIGN KEY (`idPergunta`) REFERENCES `pergunta` (`idPergunta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_RespostaAberta_Pesquisa` FOREIGN KEY (`idPesquisa`) REFERENCES `pesquisa` (`idPesquisa`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_RespostaAberta_Usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `respostaaberta`
--

LOCK TABLES `respostaaberta` WRITE;
/*!40000 ALTER TABLE `respostaaberta` DISABLE KEYS */;
INSERT INTO `respostaaberta` VALUES (1,1,3,''),(4,1,3,'Muito bom o sistema!'),(45,1,3,'Legal o sistema!');
/*!40000 ALTER TABLE `respostaaberta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `respostafechada`
--

DROP TABLE IF EXISTS `respostafechada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `respostafechada` (
  `idUsuario` int(11) NOT NULL,
  `idPesquisa` int(11) NOT NULL,
  `idPergunta` int(11) NOT NULL,
  `idOpcao` int(11) NOT NULL,
  PRIMARY KEY (`idUsuario`,`idPesquisa`,`idPergunta`,`idOpcao`),
  KEY `fk_RespostaSelecionada_Opcao_idx` (`idOpcao`),
  KEY `fk_RespostaFechada_Pergunta_idx` (`idPergunta`),
  KEY `fk_RespostaFechada_Pesquisa_idx` (`idPesquisa`),
  CONSTRAINT `fk_RespostaFechada_Opcao` FOREIGN KEY (`idOpcao`) REFERENCES `opcao` (`idOpcao`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_RespostaFechada_Pergunta` FOREIGN KEY (`idPergunta`) REFERENCES `pergunta` (`idPergunta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_RespostaFechada_Pesquisa` FOREIGN KEY (`idPesquisa`) REFERENCES `pesquisa` (`idPesquisa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_RespostaFechada_Usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `respostafechada`
--

LOCK TABLES `respostafechada` WRITE;
/*!40000 ALTER TABLE `respostafechada` DISABLE KEYS */;
INSERT INTO `respostafechada` VALUES (1,1,1,2),(4,1,1,2),(45,1,1,2),(1,1,2,4),(1,1,2,5);
/*!40000 ALTER TABLE `respostafechada` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `idTag` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`idTag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tagobra`
--

DROP TABLE IF EXISTS `tagobra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tagobra` (
  `idTag` int(11) NOT NULL,
  `idObra` int(11) NOT NULL,
  PRIMARY KEY (`idTag`,`idObra`),
  KEY `fk_idObra_idx` (`idObra`),
  CONSTRAINT `fk_TagObra_Obra` FOREIGN KEY (`idObra`) REFERENCES `obra` (`numeroInventario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_TagObra_Tag` FOREIGN KEY (`idTag`) REFERENCES `tag` (`idTag`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tagobra`
--

LOCK TABLES `tagobra` WRITE;
/*!40000 ALTER TABLE `tagobra` DISABLE KEYS */;
/*!40000 ALTER TABLE `tagobra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL,
  `sobrenome` varchar(45) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  `cadastroConfirmado` tinyint(1) NOT NULL,
  `tipoUsuario` enum('USUARIO','FUNCIONARIO','ADMINISTRADOR') DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Jamylle','Santana','jamyllesf@gmail.com','25d55ad283aa400af464c76d713c07ad',1,'ADMINISTRADOR'),(2,'Usuário','Comum','usuariocomum@gmail.com','2e9ec317e197819358fbc43afca7d837',1,'USUARIO'),(3,'Funcionário','Museu','funcionariomuseu@gmail.com','551b50cd77c369891fa02b5dc73c03a7',1,'FUNCIONARIO'),(4,'valmir','vinicius','vvalmeida96@gmail.com','e7d80ffeefa212b7c5c55700e4f7193e',1,'ADMINISTRADOR'),(5,'sarah','pereira','sarahecomp@gmail.com','e7d80ffeefa212b7c5c55700e4f7193e',1,'FUNCIONARIO'),(6,'emerson','souza','ebssoueu@gmail.com','e7d80ffeefa212b7c5c55700e4f7193e',1,'FUNCIONARIO'),(7,'emerson','santos','emersonsl1605@gmail.com','e7d80ffeefa212b7c5c55700e4f7193e',1,'USUARIO'),(8,'Aloísio','Júnior','kleyner2@hotmail.com','e7d80ffeefa212b7c5c55700e4f7193e',1,'USUARIO'),(9,'Bruno','Menezes','brunomenezes253@gmail.com','e7d80ffeefa212b7c5c55700e4f7193e',1,'USUARIO'),(10,'iago','macedo','iagomcd.almeida@gmail.com ','e7d80ffeefa212b7c5c55700e4f7193e',1,'USUARIO'),(11,'marcus','aldrey','marcusaldrey@gmail.com','e7d80ffeefa212b7c5c55700e4f7193e',1,'USUARIO'),(12,'Matheus','Texeira','mteixeira.1998@gmail.com','e7d80ffeefa212b7c5c55700e4f7193e',1,'USUARIO'),(13,'victor','munduruca','victormunduruca@gmail.com','e7d80ffeefa212b7c5c55700e4f7193e',1,'USUARIO'),(14,'diego','lourenço','diegossl94@gmail.com','e7d80ffeefa212b7c5c55700e4f7193e',1,'USUARIO'),(15,'joao','silva','joao@silva.com','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(16,'Ryder','Maddox','vestibulum@erat.ca','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(17,'Sawyer','Munoz','dictum@ipsumdolorsit.edu','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(18,'Neville','Rollins','sed.dolor@estNunc.co.uk','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(19,'Connor','Sparks','Nam.interdum@risus.co.uk','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(20,'Garth','Yang','dolor.sit.amet@amet.com','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(21,'Harper','Fernandez','dolor.sit@Loremipsum.edu','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(22,'Lev','Serrano','mauris@ac.ca','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(23,'Gage','Stein','urna@Aliquamfringilla.edu','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(24,'Jacob','Weber','iaculis.enim@sapienmolestieorci.co.uk','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(25,'Christopher','Cannon','vitae.mauris.sit@auctor.co.uk','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(26,'Hakeem','May','Nulla.facilisi.Sed@ligula.com','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(27,'Damon','Mcpherson','ornare.lectus@hymenaeosMauris.edu','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(28,'Erasmus','David','libero.mauris@dictum.edu','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(29,'Akeem','Tyler','neque@posuereenim.net','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(30,'Burton','Walters','erat.vitae@Morbiaccumsanlaoreet.com','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(31,'Kasper','Le','pharetra.sed@sagittisaugue.ca','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(32,'Edan','Collins','nunc@euismod.org','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(33,'Rogan','Terrell','sit@idrisus.co.uk','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(34,'Blaze','Shelton','augue@vitaemaurissit.ca','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(35,'Forrest','Avila','hendrerit.a@Maecenas.net','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(36,'Paki','Pennington','mauris.sit@arcuNunc.ca','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(37,'Arthur','Moss','Curabitur.dictum.Phasellus@nibhsit.ca','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(38,'Grant','Crawford','vulputate@Cras.net','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(39,'Reuben','Potts','Maecenas.mi.felis@actellusSuspendisse.edu','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(40,'David','Lloyd','lobortis.quis.pede@hendrerit.co.uk','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(41,'Merrill','Wong','facilisis.eget.ipsum@sodalesnisi.org','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(42,'Raphael','Finch','elit.pretium@turpisvitae.ca','732002cec7aeb7987bde842b9e00ee3b',1,'USUARIO'),(43,'Vinicius','Almeida','naughtynaughtyweliketoparty@live.com','',1,'USUARIO'),(45,'Sertour','Museu','websertour@gmail.com','',1,'USUARIO'),(46,'Ionara','de Almeida','','',1,'USUARIO'),(47,'Administrador','Sertour','sertouradm@email.com','e8c962b048d755b2344fcfd66207b45b',1,'ADMINISTRADOR');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarioacessoobra`
--

DROP TABLE IF EXISTS `usuarioacessoobra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarioacessoobra` (
  `numeroInventario` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`idUsuario`,`numeroInventario`),
  KEY `fk_UsuarioAcesso_Usuario_idx` (`idUsuario`),
  KEY `fk_UsuarioAcesso_AcessoObra_idx` (`numeroInventario`),
  CONSTRAINT `fk_UsuarioAcesso_AcessoObra` FOREIGN KEY (`numeroInventario`) REFERENCES `obra` (`numeroInventario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_UsuarioAcesso_Usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarioacessoobra`
--

LOCK TABLES `usuarioacessoobra` WRITE;
/*!40000 ALTER TABLE `usuarioacessoobra` DISABLE KEYS */;
INSERT INTO `usuarioacessoobra` VALUES (1,1),(2,1),(3,1),(5,1),(6,1),(7,1),(1,5),(2,5),(6,5);
/*!40000 ALTER TABLE `usuarioacessoobra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuariofacebook`
--

DROP TABLE IF EXISTS `usuariofacebook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuariofacebook` (
  `idUsuarioFacebook` varchar(50) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`idUsuarioFacebook`),
  KEY `fk_UsuarioFacebook_Usuario_idx` (`idUsuario`),
  CONSTRAINT `fk_UsuarioFacebook_Usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuariofacebook`
--

LOCK TABLES `usuariofacebook` WRITE;
/*!40000 ALTER TABLE `usuariofacebook` DISABLE KEYS */;
INSERT INTO `usuariofacebook` VALUES ('1432272156886551',43),('132926473988857',45),('1742030152480823',46);
/*!40000 ALTER TABLE `usuariofacebook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuariogoogle`
--

DROP TABLE IF EXISTS `usuariogoogle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuariogoogle` (
  `idUsuarioGoogle` varchar(50) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`idUsuarioGoogle`),
  KEY `fk_UsuarioGoogle_Usuario_idx` (`idUsuario`),
  CONSTRAINT `fk_UsuarioGoogle_Usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuariogoogle`
--

LOCK TABLES `usuariogoogle` WRITE;
/*!40000 ALTER TABLE `usuariogoogle` DISABLE KEYS */;
INSERT INTO `usuariogoogle` VALUES ('114439588359162871504',4);
/*!40000 ALTER TABLE `usuariogoogle` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-23 14:34:49
