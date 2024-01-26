CREATE TABLE public.tbproduto (
    id serial4 NOT NULL,
    titulo varchar NOT NULL,
    descricao varchar NOT NULL,
    quantidade int4 NOT NULL,
    valor float8 NULL,
    validade date NOT NULL,
    promocao bool NULL,
    pathfoto text NULL,
    CONSTRAINT pk_proid PRIMARY KEY (id)
);

CREATE TABLE public.tbusuario (
    id serial4 NOT NULL,
    re varchar NULL,
    nome varchar(50) NOT NULL,
    email varchar(200) NOT NULL,
    senha varchar(128) NULL,
    tipo varchar NULL,
    CONSTRAINT pk_usuaid PRIMARY KEY (id)
);

CREATE TABLE public.tbvenda (
    id serial4 NOT NULL,
    usua_id int4 NOT NULL,
    prod_id int4 NOT NULL,
    quantidade int4 NOT NULL,
    valor float8 NULL,
    datavenda timestamptz NOT NULL,
    databaixa date NULL,
    status varchar NOT NULL,
    CONSTRAINT pkvenid PRIMARY KEY (id),
    CONSTRAINT fkprodid FOREIGN KEY (prod_id) REFERENCES public.tbproduto(id) ON DELETE SET NULL,
    CONSTRAINT fkusuaid FOREIGN KEY (usua_id) REFERENCES public.tbusuario(id) ON DELETE SET NULL
);

CREATE TABLE public.tbvenda (
    id serial4 NOT NULL,
    datavenda timestamptz NOT NULL,
    databaixa date NULL,
    status varchar NOT NULL,
    CONSTRAINT pkvenid PRIMARY KEY (id)
);

INSERT INTO public.tbusuario (re,nome,email,senha,tipo) VALUES
                                                            ('1273914','MARLOS DE SA MADUREIRA','madureira@policiamilitar.sp.gov.br','1273914','ADMINISTRADOR'),
                                                            ('1305271','GLAUCO GARCIA CETARA','cetara@policiamilitar.sp.gov.br','1305271','ADMINISTRADOR'),
                                                            ('9900349','ANDERSON RODRIGO GONÇALVES DA SILVA','andersonrgs@policiamilitar.sp.gov.br','9900349','ADMINISTRADOR'),
                                                            ('1406566','DANILO SOBRAL DECARLI','danilodecarli@policiamilitar.sp.gov.br','1406566','ADMINISTRADOR'),
                                                            ('1177443','VANIA TUMITAN ZECHI ROBLEZ','roblez@policiamilitar.sp.gov.br','1177443','ADMINISTRADOR'),
                                                            ('9809422','Richardison Campos','richardison@policiamilitar.sp.gov.br','9809422','CLIENTE'),
                                                            ('1193708','Sidney José Ferreira Filho','sidneyfilho@policiamilitar.sp.gov.br','1193708','CLIENTE'),
                                                            ('1278185','Rafael Pesqueira Paié','rafaelpaie@policiamilitar.sp.gov.br','1278185','CLIENTE'),
                                                            ('8732396','Anderlúcia Paes','anderlucia@policiamilitar.sp.gov.br','8732396','CLIENTE'),
                                                            ('9912347','Sérgio Augusto de Abreu','sergioabreu@policiamilitar.sp.gov.br','9912347','CLIENTE');
INSERT INTO public.tbusuario (re,nome,email,senha,tipo) VALUES
                                                            ('9136177','Claudio José Ferreira','cjferreira@policiamilitar.sp.gov.br','9136177','CLIENTE'),
                                                            ('9912053','Wellington Floriano','wellingtonfloriano@policiamilitar.sp.gov.br','9912053','CLIENTE'),
                                                            ('1318098','Bruno Colnago Cavalcante','brunocavalcante@ policiamilitar.sp.gov.br','1318098','CLIENTE'),
                                                            ('1371754','Tiago de Jesus Silva','tiagodjs@policiamilitar.sp.gov.br','1371754','CLIENTE'),
                                                            ('9756833','Luis Roberto Alves dos Santos','luizrads@policiamilitar.sp.gov.br','9756833','CLIENTE'),
                                                            ('9912592','Rodrigo Gianegitz','gianegitz@policiamilitar.sp.gov.br','9912592','CLIENTE'),
                                                            ('992168A','Alessandro Alves da Silva','alvesalessandro@policiamilitar.sp.gov.br','992168A','CLIENTE'),
                                                            ('9921893','Fabiano Ajonas','fajonas@policiamilitar.sp.gov.br','9921893','CLIENTE'),
                                                            ('1193988','Vinicius Moura Leite','viniciusleite@policiamilitar.sp.gov.br','1193988','CLIENTE'),
                                                            ('9522662','José Carlos Francesquette','jcfrancesquette@policiamilitar.sp.gov.br','9522662','CLIENTE');
INSERT INTO public.tbusuario (re,nome,email,senha,tipo) VALUES
                                                            ('9638750','Renato da Silva Sgobbi','sgobbi@policiamilitar.sp.gov.br','9638750','CLIENTE'),
                                                            ('9726250','Rogério  Evaristo de Souza','souzared@policiamilitar.sp.gov.br','9726250','CLIENTE'),
                                                            ('9758038','José Carlos Alves Queiroz','jcaqueiroz@policiamilitar.sp.gov.br','9758038','CLIENTE'),
                                                            ('9758208','Reginaldo Aparecido de Oliveira','aparecidoreginaldo@policiamilitar.sp.gov.br','9758208','CLIENTE'),
                                                            ('1077970','Luiz Antônio Doni','doni@policiamilitar.sp.gov.br','1077970','CLIENTE'),
                                                            ('1246445','Idrasil Henrique Muniz','idrasil@policiamilitar.sp.gov.br','1246445','CLIENTE'),
                                                            ('1537652','Ector Henrique Vitollo Costa','ectorcosta@policiamilitar.sp.gov.br','1537652','CLIENTE'),
                                                            ('1362976','Fernando Ricardo Maraston','maraston@policiamilitar.sp.gov.br','1362976','CLIENTE'),
                                                            ('1348183','Leonardo Batista Faria','leonardofaria@policiamilitar.sp.gov.br','1348183','CLIENTE'),
                                                            ('1488805','André Sapia Azevedo','andresapia@policiamilitar.sp.gov.br','1488805','CLIENTE');

INSERT INTO public.tbproduto (titulo,descricao,quantidade,valor,validade,promocao,pathfoto) VALUES
                                                                                                ('Active','Active Laxante',10,1.0,'2023-03-15',false,'arquivos/ID__20230213074159_ACTIVE.JPG'),
                                                                                                ('Pé de Moça','Pé de Moça',20,1.0,'2023-03-15',false,'arquivos/ID__20230213074304_PE DE MOçA.JPEG'),
                                                                                                ('Água Gás','Água Gás',10,1.0,'2023-03-15',false,'arquivos/ID__20230213074321_AGUA.PNG'),
                                                                                                ('Alpino Achocolatado','Alpino Achocolatado',5,1.0,'2023-03-15',false,'arquivos/ID__20230213074350_ALPINHO.PNG'),
                                                                                                ('Amendoin','Amendoin',5,1.0,'2023-03-15',false,'arquivos/ID__20230213074411_AMENDOIN.JPG'),
                                                                                                ('Bis Xtra','Bis Xtra',5,1.0,'2023-03-15',false,'arquivos/ID__20230213074443_BIS XTRA.PNG'),
                                                                                                ('Coca Café','Coca Café',5,1.0,'2023-03-15',false,'arquivos/ID__20230213074523_COCA CAFE.PNG'),
                                                                                                ('Guaraná','Guaraná',5,1.0,'2023-03-15',false,'arquivos/ID__20230213074543_GUARANA.JPG'),
                                                                                                ('KitaKat','KitaKat',5,1.0,'2023-03-15',false,'arquivos/ID__20230213074600_KITKAT.PNG'),
                                                                                                ('Lasanha','Lasanha',1,1.0,'2023-03-15',false,'arquivos/ID__20230213074627_LASANHA.PNG');
INSERT INTO public.tbproduto (titulo,descricao,quantidade,valor,validade,promocao,pathfoto) VALUES
                                                                                                ('Lanche','Lanche',1,1.0,'2023-03-15',false,'arquivos/ID_10_20230213074810_LANCHE.JPEG'),
                                                                                                ('Macarrão','Macarrão',1,1.0,'2023-03-15',false,'arquivos/ID__20230213074854_MACARRãO.PNG'),
                                                                                                ('Monster','Monster',5,1.0,'2023-03-15',false,'arquivos/ID__20230213074910_MONTER.JPG'),
                                                                                                ('Nescafe Smoovlatte','Nescafe Smoovlatte',5,1.0,'2023-03-15',false,'arquivos/ID__20230213074933_NESCAFESMOOVLATTE.JPG'),
                                                                                                ('Snickers','Snickers',10,1.0,'2023-03-15',false,'arquivos/ID__20230213075009_SNICKERS.PNG'),
                                                                                                ('Paçoca','Paçoca',10,1.0,'2023-03-15',false,'arquivos/ID_15_20230213075102_PAçOCA.PNG'),
                                                                                                ('Todinho Leve','Todinho Leve',5,1.0,'2023-03-15',false,'arquivos/ID__20230213075117_TODINHO LEVINHO.PNG'),
                                                                                                ('Todinho Normal','Todinho Normal',5,1.0,'2023-03-15',false,'arquivos/ID__20230213075136_TODINHO.PNG'),
                                                                                                ('Trento Bites','Trento Bites',1,1.0,'2023-03-15',false,'arquivos/ID__20230213075158_TRENTO BITES.PNG'),
                                                                                                ('Trento','Trento',5,1.0,'2023-03-15',false,'arquivos/ID__20230213075212_TRENTO.JPG');
INSERT INTO public.tbproduto (titulo,descricao,quantidade,valor,validade,promocao,pathfoto) VALUES
    ('Frutap','Frutap',5,1.0,'2023-03-15',false,'arquivos/ID__20230213075230_FRUTAP.PNG');
