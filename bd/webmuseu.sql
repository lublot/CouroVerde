-- MySQL Script generated by MySQL Workbench
-- Qui 06 Jul 2017 21:41:16 BRT
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema webMuseu
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema webMuseu
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `webMuseu` DEFAULT CHARACTER SET utf8 ;
USE `webMuseu` ;

-- -----------------------------------------------------
-- Table `webMuseu`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`Usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(20) NOT NULL,
  `sobrenome` VARCHAR(45) NOT NULL,
  `email` VARCHAR(100) NULL,
  `senha` VARCHAR(50) NULL,
  `cadastroConfirmado` TINYINT(1) NOT NULL,
  `tipoUsuario` ENUM('USUARIO', 'FUNCIONARIO', 'ADMINISTRADOR') NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`Funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`Funcionario` (
  `matricula` INT NOT NULL,
  `idUsuario` INT NOT NULL,
  `funcao` VARCHAR(45) NOT NULL,
  `cadastroObra` TINYINT(1) NOT NULL,
  `gerenciaObra` TINYINT(1) NOT NULL,
  `remocaoObra` TINYINT(1) NOT NULL,
  `cadastroNoticia` TINYINT(1) NOT NULL,
  `gerenciaNoticia` TINYINT(1) NOT NULL,
  `remocaoNoticia` TINYINT(1) NOT NULL,
  `backup` TINYINT(1) NOT NULL,
  PRIMARY KEY (`matricula`),
  INDEX `fk_Funcionario_Usuario_idx` (`idUsuario` ASC),
  CONSTRAINT `fk_Funcionario_Usuario`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `webMuseu`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`Noticia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`Noticia` (
  `idNoticia` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(50) NOT NULL,
  `subtitulo` VARCHAR(100) NULL,
  `descricao` VARCHAR(500) NULL,
  `caminhoImagem` VARCHAR(200) NULL,
  `data` DATE NOT NULL,
  PRIMARY KEY (`idNoticia`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`Classificacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`Classificacao` (
  `idClassificacao` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idClassificacao`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`Colecao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`Colecao` (
  `idColecao` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idColecao`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`Obra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`Obra` (
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
    REFERENCES `webMuseu`.`Classificacao` (`idClassificacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Obra_Colecao`
    FOREIGN KEY (`idColecao`)
    REFERENCES `webMuseu`.`Colecao` (`idColecao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`Tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`Tag` (
  `idTag` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTag`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`TagObra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`TagObra` (
  `idTag` INT NOT NULL,
  `idObra` INT NOT NULL,
  PRIMARY KEY (`idTag`, `idObra`),
  INDEX `fk_idObra_idx` (`idObra` ASC),
  CONSTRAINT `fk_TagObra_Tag`
    FOREIGN KEY (`idTag`)
    REFERENCES `webMuseu`.`Tag` (`idTag`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TagObra_Obra`
    FOREIGN KEY (`idObra`)
    REFERENCES `webMuseu`.`Obra` (`numeroInventario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`Arquivo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`Arquivo` (
  `idArquivo` INT NOT NULL AUTO_INCREMENT,
  `caminho` VARCHAR(200) NOT NULL,
  `tipo` ENUM('IMAGEM', 'MODELO 3D') NOT NULL,
  PRIMARY KEY (`idArquivo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`ArquivoObra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`ArquivoObra` (
  `idObra` INT NOT NULL,
  `idArquivo` INT NOT NULL,
  PRIMARY KEY (`idObra`, `idArquivo`),
  INDEX `fk_idArquivo_idx` (`idArquivo` ASC),
  CONSTRAINT `fk_ArquivoObra_Obra`
    FOREIGN KEY (`idObra`)
    REFERENCES `webMuseu`.`Obra` (`numeroInventario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ArquivoObra_Arquivo`
    FOREIGN KEY (`idArquivo`)
    REFERENCES `webMuseu`.`Arquivo` (`idArquivo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`Fotografia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`Fotografia` (
  `idFotografia` INT NOT NULL,
  `Fotografo` VARCHAR(50) NULL,
  `data` DATE NULL,
  `autorFotografia` VARCHAR(50) NULL,
  PRIMARY KEY (`idFotografia`),
  CONSTRAINT `fk_Fotografia_Obra`
    FOREIGN KEY (`idFotografia`)
    REFERENCES `webMuseu`.`Obra` (`numeroInventario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`Pesquisa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`Pesquisa` (
  `idPesquisa` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(45) NOT NULL,
  `estaAtiva` TINYINT(1) NOT NULL,
  PRIMARY KEY (`idPesquisa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`Pergunta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`Pergunta` (
  `idPergunta` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(45) NOT NULL,
  `opcional` TINYINT(1) NOT NULL,
  `tipo` ENUM('ABERTA', 'UNICA ESCOLHA', 'MULTIPLA ESCOLHA') NOT NULL,
  PRIMARY KEY (`idPergunta`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`PerguntaPesquisa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`PerguntaPesquisa` (
  `idPergunta` INT NOT NULL,
  `idPesquisa` INT NOT NULL,
  PRIMARY KEY (`idPergunta`, `idPesquisa`),
  INDEX `fk_PerguntaPesquisa_Pesquisa_idx` (`idPesquisa` ASC),
  CONSTRAINT `fk_PerguntaPesquisa_Pesquisa`
    FOREIGN KEY (`idPesquisa`)
    REFERENCES `webMuseu`.`Pesquisa` (`idPesquisa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PerguntaPesquisa_Pergunta`
    FOREIGN KEY (`idPergunta`)
    REFERENCES `webMuseu`.`Pergunta` (`idPergunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`UsuarioRespostaPesquisa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`UsuarioRespostaPesquisa` (
  `idUsuario` INT NOT NULL,
  `idPesquisa` INT NOT NULL,
  PRIMARY KEY (`idUsuario`, `idPesquisa`),
  INDEX `fk_UsuarioRespostaPesquisa_Pesquisa_idx` (`idPesquisa` ASC),
  CONSTRAINT `fk_UsuarioRespostaPesquisa_Usuario`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `webMuseu`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_UsuarioRespostaPesquisa_Pesquisa`
    FOREIGN KEY (`idPesquisa`)
    REFERENCES `webMuseu`.`Pesquisa` (`idPesquisa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`UsuarioGoogle`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`UsuarioGoogle` (
  `idUsuarioGoogle` VARCHAR(50) NOT NULL,
  `idUsuario` INT NOT NULL,
  PRIMARY KEY (`idUsuarioGoogle`),
  INDEX `fk_UsuarioGoogle_Usuario_idx` (`idUsuario` ASC),
  CONSTRAINT `fk_UsuarioGoogle_Usuario`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `webMuseu`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`UsuarioFacebook`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`UsuarioFacebook` (
  `idUsuarioFacebook` VARCHAR(50) NOT NULL,
  `idUsuario` INT NOT NULL,
  PRIMARY KEY (`idUsuarioFacebook`),
  INDEX `fk_UsuarioFacebook_Usuario_idx` (`idUsuario` ASC),
  CONSTRAINT `fk_UsuarioFacebook_Usuario`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `webMuseu`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`Opcao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`Opcao` (
  `idOpcao` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idOpcao`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`PerguntaOpcao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`PerguntaOpcao` (
  `idPergunta` INT NOT NULL,
  `idOpcao` INT NOT NULL,
  PRIMARY KEY (`idPergunta`, `idOpcao`),
  INDEX `fk_PerguntaOpcao_Opcao_idx` (`idOpcao` ASC),
  CONSTRAINT `fk_PerguntaOpcao_Pergunta`
    FOREIGN KEY (`idPergunta`)
    REFERENCES `webMuseu`.`Pergunta` (`idPergunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PerguntaOpcao_Opcao`
    FOREIGN KEY (`idOpcao`)
    REFERENCES `webMuseu`.`Opcao` (`idOpcao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`LogAlteracoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`LogAlteracoes` (
  `idLogAlteracoes` INT NOT NULL AUTO_INCREMENT,
  `idFuncionario` INT NOT NULL,
  `descricao` VARCHAR(1000) NOT NULL,
  `data` DATETIME NOT NULL,
  PRIMARY KEY (`idLogAlteracoes`),
  INDEX `fk_LogAlteracoes_Funcionario_idx` (`idFuncionario` ASC),
  CONSTRAINT `fk_LogAlteracoes_Funcionario`
    FOREIGN KEY (`idFuncionario`)
    REFERENCES `webMuseu`.`Funcionario` (`matricula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`LogAlteracoesObra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`LogAlteracoesObra` (
  `idLogAlteracoes` INT NOT NULL,
  `numeroInventario` INT NOT NULL,
  PRIMARY KEY (`idLogAlteracoes`),
  CONSTRAINT `fk_LogAlteracoesObra_LogAlteracoes`
    FOREIGN KEY (`idLogAlteracoes`)
    REFERENCES `webMuseu`.`LogAlteracoes` (`idLogAlteracoes`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`RelatorioAcesso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`RelatorioAcesso` (
  `data` DATE NOT NULL,
  `totalDeAcessos` DOUBLE NOT NULL,
  `numeroInventarioObraMaisVizitada` INT NOT NULL,
  `numeroInventarioObraMenosVizitada` INT NOT NULL,
  PRIMARY KEY (`data`),
  INDEX `fk_RelatorioAcesso_Obra_Mais_Vizitada_idx` (`numeroInventarioObraMaisVizitada` ASC),
  INDEX `fk_RelatorioAcesso_Obra_Menos_Vizitada_idx` (`numeroInventarioObraMenosVizitada` ASC),
  CONSTRAINT `fk_RelatorioAcesso_Obra_Mais_Vizitada`
    FOREIGN KEY (`numeroInventarioObraMaisVizitada`)
    REFERENCES `webMuseu`.`Obra` (`numeroInventario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_RelatorioAcesso_Obra_Menos_Vizitada`
    FOREIGN KEY (`numeroInventarioObraMenosVizitada`)
    REFERENCES `webMuseu`.`Obra` (`numeroInventario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
