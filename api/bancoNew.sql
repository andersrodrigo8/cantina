CREATE TABLE public.tbusuario (
	id serial4 NOT NULL,
	re varchar NULL,
	nome varchar(50) NOT NULL,
	email varchar(200) NOT NULL,
	senha varchar(128) NULL,
	tipo varchar NULL,
	CONSTRAINT pk_usuaid PRIMARY KEY (id)
);

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

CREATE TABLE public.tbvendaitens (
	id serial4 NOT NULL,
	usua_id int4 NOT NULL,
	prod_id int4 NOT NULL,
	vend_id int4 NOT NULL,
	quantidade int4 NOT NULL,
	valorunit float8 NULL,
	valortotal float8 NULL,
	CONSTRAINT pkveniditens PRIMARY KEY (id),
	CONSTRAINT fkprodid FOREIGN KEY (prod_id) REFERENCES public.tbproduto(id) ON DELETE SET NULL,
	CONSTRAINT fkusuaid FOREIGN KEY (usua_id) REFERENCES public.tbusuario(id) ON DELETE SET NULL
);

CREATE TABLE public.tbvenda (
	id serial4 NOT NULL,
	datavenda timestamptz NOT NULL,
	databaixa timestamptz NULL,
	status varchar NOT NULL,
	usua_id int8 NULL,
	CONSTRAINT pkvenid PRIMARY KEY (id),
	CONSTRAINT fkusuaid FOREIGN KEY (usua_id) REFERENCES public.tbusuario(id) ON DELETE SET NULL
);