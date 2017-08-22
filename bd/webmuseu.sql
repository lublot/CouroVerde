-- MySQL Script generated by MySQL Workbench
-- Sáb 12 Ago 2017 09:32:06 BRT
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
  UNIQUE INDEX `idUsuario_UNIQUE` (`idUsuario` ASC),
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
  `titulo` VARCHAR(150) NOT NULL,
  `subtitulo` VARCHAR(150) NULL,
  `descricao` TEXT NULL,
  `caminhoImagem` TEXT NULL,
  `data` DATE NOT NULL,
  PRIMARY KEY (`idNoticia`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`Classificacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`Classificacao` (
  `idClassificacao` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idClassificacao`),
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`Colecao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`Colecao` (
  `idColecao` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idColecao`),
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC))
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
  `descricao` TEXT NULL,
  `idColecao` INT NOT NULL,
  `idClassificacao` INT NOT NULL,
  `altura` FLOAT NULL,
  `largura` FLOAT NULL,
  `diametro` FLOAT NULL,
  `peso` FLOAT NULL,
  `comprimento` FLOAT NULL,
  `materiaisContruidos` VARCHAR(200) NULL,
  `tecnicasFabricacao` VARCHAR(100) NULL,
  `autoria` VARCHAR(45) NULL,
  `marcasInscricoes` VARCHAR(200) NULL,
  `historicoObjeto` VARCHAR(200) NULL,
  `modoAquisicao` VARCHAR(45) NULL,
  `dataAquisicao` DATE NULL,
  `autor` VARCHAR(45) NULL,
  `observacoes` VARCHAR(100) NULL,
  `estadoConservacao` VARCHAR(45) NULL,
  `caminhoImagem1` TEXT NULL,
  `caminhoImagem2` TEXT NULL,
  `caminhoImagem3` TEXT NULL,
  `caminhoImagem4` TEXT NULL,
  `caminhoImagem5` TEXT NULL,
  `caminhoModelo3D` TEXT NULL,
  PRIMARY KEY (`numeroInventario`),
  INDEX `idCategoria_idx` (`idClassificacao` ASC),
  INDEX `fk_idColecao_obra_idx` (`idColecao` ASC),
  CONSTRAINT `fk_Obra_Classificacao`
    FOREIGN KEY (`idClassificacao`)
    REFERENCES `webMuseu`.`Classificacao` (`idClassificacao`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Obra_Colecao`
    FOREIGN KEY (`idColecao`)
    REFERENCES `webMuseu`.`Colecao` (`idColecao`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
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
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_TagObra_Obra`
    FOREIGN KEY (`idObra`)
    REFERENCES `webMuseu`.`Obra` (`numeroInventario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
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
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`Pesquisa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`Pesquisa` (
  `idPesquisa` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(150) NOT NULL,
  `descricao` TEXT NULL,
  `estaAtiva` TINYINT(1) NOT NULL,
  PRIMARY KEY (`idPesquisa`),
  UNIQUE INDEX `titulo_UNIQUE` (`titulo` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`Pergunta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`Pergunta` (
  `idPergunta` INT NOT NULL AUTO_INCREMENT,
  `titulo` TEXT NOT NULL,
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
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_PerguntaPesquisa_Pergunta`
    FOREIGN KEY (`idPergunta`)
    REFERENCES `webMuseu`.`Pergunta` (`idPergunta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`RespostaAberta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`RespostaAberta` (
  `idUsuario` INT NOT NULL,
  `idPesquisa` INT NOT NULL,
  `idPergunta` INT NOT NULL,
  `descricao` TEXT NOT NULL,
  PRIMARY KEY (`idUsuario`, `idPesquisa`, `idPergunta`),
  INDEX `fk_RespostaAberta_Pergunta_idx` (`idPergunta` ASC),
  INDEX `fk_RespostaAberta_Pesquisa_idx` (`idPesquisa` ASC),
  CONSTRAINT `fk_RespostaAberta_Usuario`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `webMuseu`.`Usuario` (`idUsuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_RespostaAberta_Pergunta`
    FOREIGN KEY (`idPergunta`)
    REFERENCES `webMuseu`.`Pergunta` (`idPergunta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_RespostaAberta_Pesquisa`
    FOREIGN KEY (`idPesquisa`)
    REFERENCES `webMuseu`.`Pesquisa` (`idPesquisa`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
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
  `descricao` TEXT NOT NULL,
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
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_PerguntaOpcao_Opcao`
    FOREIGN KEY (`idOpcao`)
    REFERENCES `webMuseu`.`Opcao` (`idOpcao`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`LogAlteracoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`LogAlteracoes` (
  `idLogAlteracoes` INT NOT NULL AUTO_INCREMENT,
  `matriculaFuncionario` INT NOT NULL,
  `idItemAlterado` INT NOT NULL,
  `tipoItemAlterado` ENUM('NOTICIA', 'OBRA', 'BACKUP', 'FUNCIONARIO') NOT NULL,
  `descricao` TEXT NOT NULL,
  `dataHora` DATETIME NOT NULL,
  PRIMARY KEY (`idLogAlteracoes`),
  INDEX `fk_LogAlteracoes_Funcionario_idx` (`matriculaFuncionario` ASC),
  CONSTRAINT `fk_LogAlteracoes_Funcionario`
    FOREIGN KEY (`matriculaFuncionario`)
    REFERENCES `webMuseu`.`Funcionario` (`matricula`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`UsuarioAcessoObra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`UsuarioAcessoObra` (
  `numeroInventario` INT NOT NULL,
  `idUsuario` INT NOT NULL,
  PRIMARY KEY (`idUsuario`, `numeroInventario`),
  INDEX `fk_UsuarioAcesso_Usuario_idx` (`idUsuario` ASC),
  INDEX `fk_UsuarioAcesso_AcessoObra_idx` (`numeroInventario` ASC),
  CONSTRAINT `fk_UsuarioAcesso_AcessoObra`
    FOREIGN KEY (`numeroInventario`)
    REFERENCES `webMuseu`.`Obra` (`numeroInventario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_UsuarioAcesso_Usuario`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `webMuseu`.`Usuario` (`idUsuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`Backup`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`Backup` (
  `idBackup` INT NOT NULL AUTO_INCREMENT,
  `caminho` TEXT NOT NULL,
  `dataHora` DATETIME NOT NULL,
  PRIMARY KEY (`idBackup`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webMuseu`.`RespostaFechada`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webMuseu`.`RespostaFechada` (
  `idUsuario` INT NOT NULL,
  `idPesquisa` INT NOT NULL,
  `idPergunta` INT NOT NULL,
  `idOpcao` INT NOT NULL,
  PRIMARY KEY (`idUsuario`, `idPesquisa`, `idPergunta`, `idOpcao`),
  INDEX `fk_RespostaSelecionada_Opcao_idx` (`idOpcao` ASC),
  INDEX `fk_RespostaFechada_Pergunta_idx` (`idPergunta` ASC),
  INDEX `fk_RespostaFechada_Pesquisa_idx` (`idPesquisa` ASC),
  CONSTRAINT `fk_RespostaFechada_Usuario`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `webMuseu`.`Usuario` (`idUsuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_RespostaFechada_Opcao`
    FOREIGN KEY (`idOpcao`)
    REFERENCES `webMuseu`.`Opcao` (`idOpcao`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_RespostaFechada_Pergunta`
    FOREIGN KEY (`idPergunta`)
    REFERENCES `webMuseu`.`Pergunta` (`idPergunta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_RespostaFechada_Pesquisa`
    FOREIGN KEY (`idPesquisa`)
    REFERENCES `webMuseu`.`Pesquisa` (`idPesquisa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

INSERT INTO classificacao(idClassificacao, nome) VALUES (49, 'Objetos de Casa');
INSERT INTO colecao(idColecao, nome) VALUES (66, 'Luminárias');
INSERT INTO obra(numeroInventario, nome, titulo, funcao, origem, procedencia, descricao, idColecao, idClassificacao,altura, largura, diametro, peso, comprimento, materiaisContruidos, tecnicasFabricacao, autoria, marcasInscricoes, historicoObjeto, modoAquisicao, dataAquisicao, autor, observacoes, estadoConservacao,caminhoImagem1, caminhoImagem2, caminhoImagem3, caminhoImagem4, caminhoImagem5, caminhoModelo3D) VALUES ('1', 'Luminária','Luminária sertaneja típica', '', 'Sertão da Bahia', '', 'Uma luminária típica do sertão da bahia.', '66', '49',1.5, 2, 3, 4, 10, 'Plástico e couro', 'Várias', 'Desconhecido', 'Alguns arranhões', '', '', NULL, '', '', '', '../media/obras/imagens/1/luminaria-rustica-de-juta-e-resina-chacaras.jpg', '../media/obras/imagens/1/lu-potes.jpg','', '', '', '../media/obras/modelo3d/1/lamp.obj');

INSERT INTO colecao(idColecao, nome) VALUES (1, 'Pote');
INSERT INTO obra(numeroInventario, nome, titulo, funcao, origem, procedencia, descricao, idColecao, idClassificacao,altura, largura, diametro, peso, comprimento, materiaisContruidos, tecnicasFabricacao, autoria, marcasInscricoes, historicoObjeto, modoAquisicao, dataAquisicao, autor, observacoes, estadoConservacao,caminhoImagem1, caminhoImagem2, caminhoImagem3, caminhoImagem4, caminhoImagem5, caminhoModelo3D) VALUES ('2', 'Pote','Pote sertanejo típica', '', 'Feira de Santana', '', 'Um pote típico do sertão da bahia.', '1', '49',1.5, 2, 3, 4, 10, 'Cerâmica', 'Várias', 'Desconhecido', 'Alguns arranhões', '', '', NULL, '', '', '', '../media/obras/imagens/2/pote.jpg', '','', '', '', '../media/obras/modelo3d/2/pote.obj');

INSERT INTO classificacao(idClassificacao, nome) VALUES (3, 'Objetos');
INSERT INTO colecao(idColecao, nome) VALUES (3, 'Caricaturas');
INSERT INTO obra(numeroInventario, nome, titulo, funcao, origem, procedencia, descricao, idColecao, idClassificacao,altura, largura, diametro, peso, comprimento, materiaisContruidos, tecnicasFabricacao, autoria, marcasInscricoes, historicoObjeto, modoAquisicao, dataAquisicao, autor, observacoes, estadoConservacao,caminhoImagem1, caminhoImagem2, caminhoImagem3, caminhoImagem4, caminhoImagem5, caminhoModelo3D) VALUES ('3', 'Rosto Asssustado','Rosto Asssustado do Sertão', '', 'Sertão da Bahia', '', 'Uma caricatura típica do sertão da bahia.', '3', '3',1.5, 2, 3, 4, 10, 'Cerâmica', 'Várias', 'Desconhecido', 'Alguns arranhões', '', '', NULL, '', '', '', '../media/obras/imagens/3/caricatura.jpg', '','', '', '', '');

INSERT INTO colecao(idColecao, nome) VALUES (5, 'Ferros');
INSERT INTO obra(numeroInventario, nome, titulo, funcao, origem, procedencia, descricao, idColecao, idClassificacao,altura, largura, diametro, peso, comprimento, materiaisContruidos, tecnicasFabricacao, autoria, marcasInscricoes, historicoObjeto, modoAquisicao, dataAquisicao, autor, observacoes, estadoConservacao,caminhoImagem1, caminhoImagem2, caminhoImagem3, caminhoImagem4, caminhoImagem5, caminhoModelo3D) VALUES ('5', 'Ferro de Passar Roupa','Ferro de Passar Roupa Carvão', '', 'Sertão da Bahia', '', 'Um ferro de passar típico do sertão da bahia.', '5', '49',1.5, 2, 3, 4, 10, 'Ferro e carvão', 'Várias', 'Desconhecido', 'Alguns arranhões', '', '', NULL, '', '', '', '../media/obras/imagens/5/f1.jpg', '../media/obras/imagens/5/f2.jpg','', '', '', '');

INSERT INTO classificacao(idClassificacao, nome) VALUES (6, 'Objetos Pessoais');
INSERT INTO colecao(idColecao, nome) VALUES (6, 'Chapéus');
INSERT INTO obra(numeroInventario, nome, titulo, funcao, origem, procedencia, descricao, idColecao, idClassificacao,altura, largura, diametro, peso, comprimento, materiaisContruidos, tecnicasFabricacao, autoria, marcasInscricoes, historicoObjeto, modoAquisicao, dataAquisicao, autor, observacoes, estadoConservacao,caminhoImagem1, caminhoImagem2, caminhoImagem3, caminhoImagem4, caminhoImagem5, caminhoModelo3D) VALUES ('4', 'Chapéu Típico','Chapéu Típico de Sertanejo', '', 'Sertão da Bahia', '', 'Um chapéu típico do sertão da bahia.', '6', '6',1.5, 2, 3, 4, 10, 'Couro', 'Várias', 'Desconhecido', 'Alguns arranhões', '', '', NULL, '', '', '', '../media/obras/imagens/4/chapeu.jpg', '','', '', '', '');

INSERT INTO noticia(idNoticia, titulo, subtitulo, descricao, caminhoImagem, data) VALUES (null, 'Inauguração Web Museu Casa do Sertão', '', 'O web museu casa do sertão foi inaugurado no dia 23/08/2017, desenvolvido pela MITHOLOGIC Software. O nome escolhido foi SERTOUR.', 'media/noticias/imagens/20170821172133museo_casa_certao_1.jpg', '2017-08-22');
INSERT INTO noticia(idNoticia, titulo, subtitulo, descricao, caminhoImagem, data) VALUES (null, 'Nova coleção no Museu Casa do Sertão', '', 'O web museu casa do sertão inaugurou uma nova coleção no dia 22/08/2017, nessa nova coleção estão expostos diversos tipos de máquinas.', 'media/noticias/imagens/20170821172456museo_casa_certao_2.jpg', '2017-08-22');

INSERT INTO usuario(idUsuario, nome, sobrenome, email, senha, cadastroConfirmado,tipoUsuario) VALUES (1, 'Jamylle', 'Santana', 'jamyllesf@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1,'ADMINISTRADOR');
INSERT INTO funcionario(matricula, idUsuario, funcao, cadastroObra, gerenciaObra, remocaoObra, cadastroNoticia, gerenciaNoticia, remocaoNoticia, backup) VALUES ('112233', '1', 'Dona', 1, 1, 1, 1, 1, 1, 1);

INSERT INTO usuario(idUsuario, nome, sobrenome, email, senha, cadastroConfirmado,tipoUsuario) VALUES (2, 'Usuário', 'Comum', 'usuariocomum@gmail.com', '2e9ec317e197819358fbc43afca7d837', 1,'USUARIO');

INSERT INTO usuario(idUsuario, nome, sobrenome, email, senha, cadastroConfirmado,tipoUsuario) VALUES (3, 'Funcionário', 'Museu', 'funcionariomuseu@gmail.com', '551b50cd77c369891fa02b5dc73c03a7', 1,'FUNCIONARIO');
INSERT INTO funcionario(matricula, idUsuario, funcao, cadastroObra, gerenciaObra, remocaoObra, cadastroNoticia, gerenciaNoticia, remocaoNoticia, backup) VALUES ('445566', '3', 'Funcionário', 1, 1, 1, 0, 0, 0, 1);



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
