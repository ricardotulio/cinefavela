CREATE TABLE IF NOT EXISTS usuario (
	id INTEGER NOT NULL auto_increment,
	nome VARCHAR(60) NOT NULL,
	email VARCHAR(767) UNIQUE NOT NULL,
	senha VARCHAR(40) NOT NULL,
	criadoEm DATETIME NOT NULL,
	atualizadoEm DATETIME DEFAULT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS sessao (
	id VARCHAR(40) NOT NULL,
	usuario_id INTEGER NOT NULL,
	dataHoraInicio DATETIME NOT NULL,
	dataHoraFim DATETIME NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (usuario_id) REFERENCES usuario (id)
);

CREATE TABLE IF NOT EXISTS filme (
	id INTEGER NOT NULL auto_increment,
	usuario_id INTEGER NOT NULL,
	titulo VARCHAR(120) NOT NULL,
	sinopse TEXT NOT NULL,
	linkYoutube VARCHAR(1024) NOT NULL,
	criadoEm DATETIME NOT NULL,
	atualizadoEm DATETIME DEFAULT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (usuario_id) REFERENCES usuario (id)
);
