CREATE TABLE usuario (
	id INTEGER PRIMARY KEY,
	nome VARCHAR(60) NOT NULL,
	email VARCHAR(1024) UNIQUE NOT NULL,
	senha VARCHAR(40) NOT NULL,
	criadoEm TIMESTAMP NOT NULL,
	atualizadoEm TIMESTAMP
);

CREATE TABLE sessao (
	id INTEGER PRIMARY KEY,
	usuario_id INTEGER NOT NULL,
	dataHoraInicio TIMESTAMP NOT NULL,
	dataHoraFim TIMESTAMP NOT NULL,
	tokenAcesso VARCHAR(40) NOT NULL,
	FOREIGN KEY (usuario_id) REFERENCES usuario (id)
);

CREATE TABLE filme (
	id INTEGER PRIMARY KEY,
	usuario_id INTEGER NOT NULL,
	titulo VARCHAR(120) NOT NULL,
	descricao TEXT,
	linkYoutube VARCHAR(1024) NOT NULL,
	criadoEm TIMESTAMP NOT NULL,
	atualizadoEm TIMESTAMP,
	FOREIGN KEY (usuario_id) REFERENCES usuario (id)
);
