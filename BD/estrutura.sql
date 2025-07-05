-- 1. ProdutoQuimico
CREATE TABLE ProdutoQuimico (
  id_produto     INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nome_produto   VARCHAR(15)       NOT NULL UNIQUE,
  validade_produto INT              NULL
) ENGINE=InnoDB; 
-- Original Oracle: varchar2(3), nome_produto varchar2(15), validade_produto number(10) :contentReference[oaicite:0]{index=0}:contentReference[oaicite:1]{index=1}

-- 2. Pessoa
CREATE TABLE Pessoa (
  id_pessoa     INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  equipe        INT                NOT NULL,
  primeiro_nome VARCHAR(100)       NOT NULL,
  sobrenome     VARCHAR(100)       NOT NULL
) ENGINE=InnoDB;
-- Original Oracle: id_pessoa varchar2(5), equipe number(10), Primeiro_Nome clob, SobreNome clob :contentReference[oaicite:2]{index=2}:contentReference[oaicite:3]{index=3}

-- 3. Especializações de Pessoa
CREATE TABLE SupervisorProducao (
  id_suprod INT UNSIGNED PRIMARY KEY,
  FOREIGN KEY (id_suprod) REFERENCES Pessoa(id_pessoa)
) ENGINE=InnoDB;

CREATE TABLE OperadorProducao (
  id_operador INT UNSIGNED PRIMARY KEY,
  FOREIGN KEY (id_operador) REFERENCES Pessoa(id_pessoa)
) ENGINE=InnoDB;
-- Original Oracle: tabelas SupervisorProducao e OperadorProducao com fk para Pessoa :contentReference[oaicite:4]{index=4}:contentReference[oaicite:5]{index=5}

-- 4. Recipiente
CREATE TABLE Recipiente (
  id_recipiente     VARCHAR2(3)   NOT NULL,
  id_produto        VARCHAR2(3),
  status            VARCHAR2(10),
  data_chegada      DATE,
  capacidade_litros NUMBER(10)    NOT NULL,
  quantidade_litros NUMBER(10)    NOT NULL DEFAULT 0,
  data_validade     DATE,
  tipo              VARCHAR2(15)  NOT NULL,
  PRIMARY KEY (id_recipiente)
);
-- Original Oracle: varchar2, number, date, etc. :contentReference[oaicite:6]{index=6}:contentReference[oaicite:7]{index=7}

-- 5. TanqueOperacional
CREATE TABLE TanqueOperacional (
  id_tanque              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_produto             INT UNSIGNED               NULL,
  localizacao            VARCHAR(2)                 NULL,
  capacidade_maxima_litros INT                       NOT NULL,
  status                 ENUM('Stand By','Operacional','Manutenção') NOT NULL,
  nivel_atual_litros     INT                         NOT NULL DEFAULT 0,
  FOREIGN KEY (id_produto) REFERENCES ProdutoQuimico(id_produto)
) ENGINE=InnoDB;
-- Original Oracle: varchar2 e number(10) :contentReference[oaicite:8]{index=8}:contentReference[oaicite:9]{index=9}

-- 6. MovimentacaoEstoque
CREATE TABLE MovimentacaoEstoque (
  id_movimentacao     VARCHAR2(3)   NOT NULL,
  id_tanque           VARCHAR2(3),
  id_recipiente       VARCHAR2(3),
  id_operador         VARCHAR2(5),
  tipo_movimentacao   VARCHAR2(2)   NOT NULL,
  quantidade_litros   NUMBER(10)    NOT NULL,
  data_hora           DATE          NOT NULL,
  PRIMARY KEY (id_movimentacao)
);
-- Original Oracle: sem quantidade_litros, seis colunas :contentReference[oaicite:10]{index=10}:contentReference[oaicite:11]{index=11}

-- 7. SolicitaGEM
CREATE TABLE SolicitaGEM (
  id_solicitacao     INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_produto         INT UNSIGNED               NULL,
  id_suprod          INT UNSIGNED               NULL,
  status             ENUM('Pendente','Atendida','Cancelada') NOT NULL,
  tipo_solicitacao   ENUM('Entrada','Saida')         NOT NULL,
  data_solicitacao   DATE                         NULL,
  FOREIGN KEY (id_produto) REFERENCES ProdutoQuimico(id_produto),
  FOREIGN KEY (id_suprod)  REFERENCES SupervisorProducao(id_suprod)
) ENGINE=InnoDB;
-- Original Oracle: varchar2 e date :contentReference[oaicite:12]{index=12}:contentReference[oaicite:13]{index=13}
