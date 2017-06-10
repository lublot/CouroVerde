-- MySQL Script generated by MySQL Workbench
-- Sex 09 Jun 2017 21:20:49 BRT
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema webMuseo
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema webMuseo
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `webMuseo` DEFAULT CHARACTER SET utf8 ;
USE `webMuseo` ;

-- -----------------------------------------------------
-- Table `webMuseo`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseo`.`Usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(20) NOT NULL,
  `sobrenome` VARCHAR(45) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(50) NOT NULL,
  `cadastroConfirmado` TINYINT(1) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseo`.`Funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseo`.`Funcionario` (
  `matricula` INT NOT NULL,
  `funcao` VARCHAR(45) NOT NULL,
  `CadastroObra` TINYINT(1) NOT NULL,
  `gerenciaObra` TINYINT(1) NOT NULL,
  `remocaoObra` TINYINT(1) NOT NULL,
  `cadastroNoticia` TINYINT(1) NOT NULL,
  `gerenciaNoticia` TINYINT(1) NOT NULL,
  `remocaoNoticia` TINYINT(1) NOT NULL,
  `backup` TINYINT(1) NOT NULL,
  PRIMARY KEY (`matricula`),
  CONSTRAINT `fk_Funcionario_Usuario`
    FOREIGN KEY (`matricula`)
    REFERENCES `webMuseo`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseo`.`Noticia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseo`.`Noticia` (
  `idNoticia` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(50) NOT NULL,
  `subtitulo` VARCHAR(100) NULL,
  `descricao` VARCHAR(500) NULL,
  `caminhoImagem` VARCHAR(200) NULL,
  `data` DATE NOT NULL,
  PRIMARY KEY (`idNoticia`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseo`.`Classificacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseo`.`Classificacao` (
  `idClassificacao` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idClassificacao`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseo`.`Colecao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseo`.`Colecao` (
  `idColecao` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idColecao`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseo`.`Obra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseo`.`Obra` (
  `numeroInventario` INT NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `titulo` VARCHAR(100) NOT NULL,
  `funcao` VARCHAR(45) NULL,
  `origem` VARCHAR(45) NULL,
  `procedencia` VARCHAR(45) NULL,
  `descricao` VARCHAR(3000) NULL,
  `idColecao` INT NOT NULL,
  `idClassificacao` INT NOT NULL,
  `altura` FLOAT NULL,
  `largura` FLOAT NULL,
  `diametro` FLOAT NULL,
  `peso` FLOAT NULL,
  `comprimento` FLOAT NULL,
  `materiais contruidos` VARCHAR(200) NULL,
  `tecnicasFabricacao` VARCHAR(100) NULL,
  `autoria` VARCHAR(45) NULL,
  `marcasInscricoes` VARCHAR(200) NULL,
  `historicoObjeto` VARCHAR(200) NULL,
  `modoAquisicao` VARCHAR(45) NULL,
  `dataAquisicao` DATE NULL,
  `autor` VARCHAR(45) NULL,
  `observacoes` VARCHAR(100) NULL,
  `estadoConservacao` VARCHAR(45) NULL,
  PRIMARY KEY (`numeroInventario`),
  INDEX `idCategoria_idx` (`idClassificacao` ASC),
  INDEX `fk_idColecao_obra_idx` (`idColecao` ASC),
  CONSTRAINT `fk_Obra_Classificacao`
    FOREIGN KEY (`idClassificacao`)
    REFERENCES `webMuseo`.`Classificacao` (`idClassificacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Obra_Colecao`
    FOREIGN KEY (`idColecao`)
    REFERENCES `webMuseo`.`Colecao` (`idColecao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseo`.`Tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseo`.`Tag` (
  `idTag` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTag`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseo`.`TagObra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseo`.`TagObra` (
  `idTag` INT NOT NULL,
  `idObra` INT NOT NULL,
  PRIMARY KEY (`idTag`, `idObra`),
  INDEX `fk_idObra_idx` (`idObra` ASC),
  CONSTRAINT `fk_TagObra_Tag`
    FOREIGN KEY (`idTag`)
    REFERENCES `webMuseo`.`Tag` (`idTag`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TagObra_Obra`
    FOREIGN KEY (`idObra`)
    REFERENCES `webMuseo`.`Obra` (`numeroInventario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseo`.`Arquivo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseo`.`Arquivo` (
  `idArquivo` INT NOT NULL AUTO_INCREMENT,
  `caminho` VARCHAR(200) NOT NULL,
  `tipo` ENUM('IMAGEM', 'MODELO 3D') NOT NULL,
  PRIMARY KEY (`idArquivo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseo`.`ArquivoObra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseo`.`ArquivoObra` (
  `idObra` INT NOT NULL,
  `idArquivo` INT NOT NULL,
  PRIMARY KEY (`idObra`, `idArquivo`),
  INDEX `fk_idArquivo_idx` (`idArquivo` ASC),
  CONSTRAINT `fk_ArquivoObra_Obra`
    FOREIGN KEY (`idObra`)
    REFERENCES `webMuseo`.`Obra` (`numeroInventario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ArquivoObra_Arquivo`
    FOREIGN KEY (`idArquivo`)
    REFERENCES `webMuseo`.`Arquivo` (`idArquivo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseo`.`Fotografia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseo`.`Fotografia` (
  `idFotografia` INT NOT NULL,
  `Fotografo` VARCHAR(50) NULL,
  `data` VARCHAR(45) NULL,
  `autorFotografia` VARCHAR(50) NULL,
  PRIMARY KEY (`idFotografia`),
  CONSTRAINT `fk_Fotografia_Obra`
    FOREIGN KEY (`idFotografia`)
    REFERENCES `webMuseo`.`Obra` (`numeroInventario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseo`.`Pesquisa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseo`.`Pesquisa` (
  `idPesquisa` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(45) NOT NULL,
  `estaAtiva` TINYINT(1) NOT NULL,
  PRIMARY KEY (`idPesquisa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseo`.`Pergunta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseo`.`Pergunta` (
  `idPergunta` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(45) NOT NULL,
  `opcional` TINYINT(1) NOT NULL,
  `tipo` ENUM('ABERTA', 'UNICA ESCOLHA', 'MULTIPLA ESCOLHA') NOT NULL,
  PRIMARY KEY (`idPergunta`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseo`.`PerguntaPesquisa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseo`.`PerguntaPesquisa` (
  `idPergunta` INT NOT NULL,
  `idPesquisa` INT NOT NULL,
  PRIMARY KEY (`idPergunta`, `idPesquisa`),
  INDEX `fk_PerguntaPesquisa_Pesquisa_idx` (`idPesquisa` ASC),
  CONSTRAINT `fk_PerguntaPesquisa_Pesquisa`
    FOREIGN KEY (`idPesquisa`)
    REFERENCES `webMuseo`.`Pesquisa` (`idPesquisa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PerguntaPesquisa_Pergunta`
    FOREIGN KEY (`idPergunta`)
    REFERENCES `webMuseo`.`Pergunta` (`idPergunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseo`.`UsuarioRespostaPesquisa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseo`.`UsuarioRespostaPesquisa` (
  `idUsuario` INT NOT NULL,
  `idPesquisa` INT NOT NULL,
  PRIMARY KEY (`idUsuario`, `idPesquisa`),
  INDEX `fk_UsuarioRespostaPesquisa_Pesquisa_idx` (`idPesquisa` ASC),
  CONSTRAINT `fk_UsuarioRespostaPesquisa_Usuario`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `webMuseo`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_UsuarioRespostaPesquisa_Pesquisa`
    FOREIGN KEY (`idPesquisa`)
    REFERENCES `webMuseo`.`Pesquisa` (`idPesquisa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
