--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.5
-- Dumped by pg_dump version 9.6.5

-- Started on 2017-10-14 21:34:51

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 1 (class 3079 OID 12387)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2226 (class 0 OID 0)
-- Dependencies: 1
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- TOC entry 214 (class 1255 OID 16565)
-- Name: get_candidatos(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_candidatos() RETURNS TABLE(numero integer, foto character varying, nombre character varying, segundo_nombre character varying, apellido character varying, segundo_apellido character varying, tipo_documento character varying, numero_documento character varying, genero character varying, fecha_de_nacimiento character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
 RETURN QUERY select c.id_candidato as numero,
		c.foto as foto, 
		p.nombre as nombre,
		p.segundo_nombre as segundo_nombre,
		p.apellido as apellido,
		p.segundo_apellido as segundo_apellido,
		p.tipo_documento as tipo_documento,
		p.numero_documento as numero_documento,
		p.genero as genero,
		p.fecha_de_nacimiento as fecha_naciemiento
	from public.candidatos as c
	inner join public.personas as p on p.id_persona = c.id_persona;
END; $$;


ALTER FUNCTION public.get_candidatos() OWNER TO postgres;

--
-- TOC entry 213 (class 1255 OID 16567)
-- Name: get_candidatos_por_eleccion(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_candidatos_por_eleccion(_id_eleccion integer) RETURNS TABLE(numero integer, foto character varying, nombre character varying, segundo_nombre character varying, apellido character varying, segundo_apellido character varying, tipo_documento character varying, numero_documento character varying, genero character varying, fecha_de_nacimiento character varying, eleccion character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
 RETURN QUERY select c.id_candidato as numero,
		c.foto as foto, 
		p.nombre as nombre,
		p.segundo_nombre as segundo_nombre,
		p.apellido as apellido,
		p.segundo_apellido as segundo_apellido,
		p.tipo_documento as tipo_documento,
		p.numero_documento as numero_documento,
		p.genero as genero,
		p.fecha_de_nacimiento as fecha_naciemiento,
		el.nombre as eleccion
	from public.candidatos_por_elecciones as cpe
	inner join public.elecciones as el on el.id_eleccion = cpe.id_eleccion
	inner join public.candidatos as c on c.id_candidato = cpe.id_candidato
	inner join public.personas as p on p.id_persona = c.id_persona
	where cpe.id_eleccion = _id_eleccion;
	
END; $$;


ALTER FUNCTION public.get_candidatos_por_eleccion(_id_eleccion integer) OWNER TO postgres;

--
-- TOC entry 215 (class 1255 OID 16573)
-- Name: get_usuarios(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_usuarios() RETURNS TABLE(id integer, usuario character varying, nombre character varying, segundo_nombre character varying, apellido character varying, segundo_apellido character varying, tipo_documento character varying, numero_documento character varying, genero character varying, fecha_de_nacimiento character varying, rol character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
 RETURN QUERY select us.id_usuario as id,
		us.usuario as usuario, 
		p.nombre as nombre,
		p.segundo_nombre as segundo_nombre,
		p.apellido as apellido,
		p.segundo_apellido as segundo_apellido,
		p.tipo_documento as tipo_documento,
		p.numero_documento as numero_documento,
		p.genero as genero,
		p.fecha_de_nacimiento as fecha_naciemiento,
		r.nombre as rol
	from public.usuarios as us 
	inner join public.personas as p on p.id_persona = us.id_persona
	inner join public.roles as r on r.id_rol = us.id_rol;
END; $$;


ALTER FUNCTION public.get_usuarios() OWNER TO postgres;

--
-- TOC entry 216 (class 1255 OID 16574)
-- Name: iniciar_sesion(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION iniciar_sesion(_usuario character varying, _clave character varying) RETURNS TABLE(id integer, usuario character varying, nombre character varying, segundo_nombre character varying, apellido character varying, segundo_apellido character varying, tipo_documento character varying, numero_documento character varying, genero character varying, fecha_de_nacimiento character varying, rol character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
 RETURN QUERY select us.id_usuario as id,
		us.usuario as usuario, 
		p.nombre as nombre,
		p.segundo_nombre as segundo_nombre,
		p.apellido as apellido,
		p.segundo_apellido as segundo_apellido,
		p.tipo_documento as tipo_documento,
		p.numero_documento as numero_documento,
		p.genero as genero,
		p.fecha_de_nacimiento as fecha_naciemiento,
		r.nombre as rol
	from public.usuarios as us 
	inner join public.personas as p on p.id_persona = us.id_persona
	inner join public.roles as r on r.id_rol = us.id_rol
	where us.usuario = _usuario and us.clave = _clave limit 1;
END; $$;


ALTER FUNCTION public.iniciar_sesion(_usuario character varying, _clave character varying) OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 185 (class 1259 OID 16394)
-- Name: candidatos_por_elecciones; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE candidatos_por_elecciones (
    id_eleccion integer,
    id_candidato integer,
    id_candidato_eleccion integer NOT NULL
);


ALTER TABLE candidatos_por_elecciones OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 16397)
-- Name: candidato_elecciones_id_candidato_elecciones_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE candidato_elecciones_id_candidato_elecciones_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE candidato_elecciones_id_candidato_elecciones_seq OWNER TO postgres;

--
-- TOC entry 2227 (class 0 OID 0)
-- Dependencies: 186
-- Name: candidato_elecciones_id_candidato_elecciones_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE candidato_elecciones_id_candidato_elecciones_seq OWNED BY candidatos_por_elecciones.id_candidato_eleccion;


--
-- TOC entry 187 (class 1259 OID 16399)
-- Name: candidatos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE candidatos (
    foto character varying(100),
    id_candidato integer NOT NULL,
    id_persona integer
);


ALTER TABLE candidatos OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 16402)
-- Name: candidatos_id_candidatos_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE candidatos_id_candidatos_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE candidatos_id_candidatos_seq OWNER TO postgres;

--
-- TOC entry 2228 (class 0 OID 0)
-- Dependencies: 188
-- Name: candidatos_id_candidatos_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE candidatos_id_candidatos_seq OWNED BY candidatos.id_candidato;


--
-- TOC entry 196 (class 1259 OID 16485)
-- Name: elecciones; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE elecciones (
    id_eleccion integer NOT NULL,
    fecha_inicio timestamp without time zone,
    fecha_fin timestamp without time zone,
    nombre character varying(250)
);


ALTER TABLE elecciones OWNER TO postgres;

--
-- TOC entry 195 (class 1259 OID 16483)
-- Name: elecciones_id_elecion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE elecciones_id_elecion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE elecciones_id_elecion_seq OWNER TO postgres;

--
-- TOC entry 2229 (class 0 OID 0)
-- Dependencies: 195
-- Name: elecciones_id_elecion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE elecciones_id_elecion_seq OWNED BY elecciones.id_eleccion;


--
-- TOC entry 193 (class 1259 OID 16453)
-- Name: personas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE personas (
    nombre character varying(40),
    segundo_nombre character varying(40),
    apellido character varying(40),
    segundo_apellido character varying(40),
    id_persona integer NOT NULL,
    tipo_documento character varying(2),
    numero_documento character varying(11),
    genero character varying(1),
    fecha_de_nacimiento character varying(20)
);


ALTER TABLE personas OWNER TO postgres;

--
-- TOC entry 194 (class 1259 OID 16456)
-- Name: persona_id_persona_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE persona_id_persona_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE persona_id_persona_seq OWNER TO postgres;

--
-- TOC entry 2230 (class 0 OID 0)
-- Dependencies: 194
-- Name: persona_id_persona_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE persona_id_persona_seq OWNED BY personas.id_persona;


--
-- TOC entry 189 (class 1259 OID 16409)
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE roles (
    id_rol integer NOT NULL,
    nombre character varying(60)
);


ALTER TABLE roles OWNER TO postgres;

--
-- TOC entry 190 (class 1259 OID 16412)
-- Name: rol_id_rol_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE rol_id_rol_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE rol_id_rol_seq OWNER TO postgres;

--
-- TOC entry 2231 (class 0 OID 0)
-- Dependencies: 190
-- Name: rol_id_rol_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE rol_id_rol_seq OWNED BY roles.id_rol;


--
-- TOC entry 191 (class 1259 OID 16414)
-- Name: usuarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE usuarios (
    id_usuario integer NOT NULL,
    usuario character varying(40),
    clave character varying(250),
    id_persona integer,
    id_rol integer
);


ALTER TABLE usuarios OWNER TO postgres;

--
-- TOC entry 192 (class 1259 OID 16420)
-- Name: usuarios_id_usuarios_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE usuarios_id_usuarios_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE usuarios_id_usuarios_seq OWNER TO postgres;

--
-- TOC entry 2232 (class 0 OID 0)
-- Dependencies: 192
-- Name: usuarios_id_usuarios_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE usuarios_id_usuarios_seq OWNED BY usuarios.id_usuario;


--
-- TOC entry 198 (class 1259 OID 16505)
-- Name: usuarios_por_elecciones; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE usuarios_por_elecciones (
    id_usuario integer,
    id_eleccion integer,
    estado boolean,
    id_usuarios_por_elecciones integer NOT NULL
);


ALTER TABLE usuarios_por_elecciones OWNER TO postgres;

--
-- TOC entry 197 (class 1259 OID 16503)
-- Name: usuarios_por_elecciones_id_usuarios_por_elecciones_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE usuarios_por_elecciones_id_usuarios_por_elecciones_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE usuarios_por_elecciones_id_usuarios_por_elecciones_seq OWNER TO postgres;

--
-- TOC entry 2233 (class 0 OID 0)
-- Dependencies: 197
-- Name: usuarios_por_elecciones_id_usuarios_por_elecciones_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE usuarios_por_elecciones_id_usuarios_por_elecciones_seq OWNED BY usuarios_por_elecciones.id_usuarios_por_elecciones;


--
-- TOC entry 200 (class 1259 OID 16523)
-- Name: votos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE votos (
    id_voto integer NOT NULL,
    id_eleccion integer,
    fecha_votacion timestamp without time zone,
    id_candidato integer,
    estado character varying(20)
);


ALTER TABLE votos OWNER TO postgres;

--
-- TOC entry 199 (class 1259 OID 16521)
-- Name: votos_id_voto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE votos_id_voto_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE votos_id_voto_seq OWNER TO postgres;

--
-- TOC entry 2234 (class 0 OID 0)
-- Dependencies: 199
-- Name: votos_id_voto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE votos_id_voto_seq OWNED BY votos.id_voto;


--
-- TOC entry 2049 (class 2604 OID 16433)
-- Name: candidatos id_candidato; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY candidatos ALTER COLUMN id_candidato SET DEFAULT nextval('candidatos_id_candidatos_seq'::regclass);


--
-- TOC entry 2048 (class 2604 OID 16432)
-- Name: candidatos_por_elecciones id_candidato_eleccion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY candidatos_por_elecciones ALTER COLUMN id_candidato_eleccion SET DEFAULT nextval('candidato_elecciones_id_candidato_elecciones_seq'::regclass);


--
-- TOC entry 2053 (class 2604 OID 16488)
-- Name: elecciones id_eleccion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY elecciones ALTER COLUMN id_eleccion SET DEFAULT nextval('elecciones_id_elecion_seq'::regclass);


--
-- TOC entry 2052 (class 2604 OID 16458)
-- Name: personas id_persona; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY personas ALTER COLUMN id_persona SET DEFAULT nextval('persona_id_persona_seq'::regclass);


--
-- TOC entry 2050 (class 2604 OID 16435)
-- Name: roles id_rol; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY roles ALTER COLUMN id_rol SET DEFAULT nextval('rol_id_rol_seq'::regclass);


--
-- TOC entry 2051 (class 2604 OID 16436)
-- Name: usuarios id_usuario; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios ALTER COLUMN id_usuario SET DEFAULT nextval('usuarios_id_usuarios_seq'::regclass);


--
-- TOC entry 2054 (class 2604 OID 16508)
-- Name: usuarios_por_elecciones id_usuarios_por_elecciones; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_por_elecciones ALTER COLUMN id_usuarios_por_elecciones SET DEFAULT nextval('usuarios_por_elecciones_id_usuarios_por_elecciones_seq'::regclass);


--
-- TOC entry 2055 (class 2604 OID 16526)
-- Name: votos id_voto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY votos ALTER COLUMN id_voto SET DEFAULT nextval('votos_id_voto_seq'::regclass);


--
-- TOC entry 2235 (class 0 OID 0)
-- Dependencies: 186
-- Name: candidato_elecciones_id_candidato_elecciones_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('candidato_elecciones_id_candidato_elecciones_seq', 1, false);


--
-- TOC entry 2206 (class 0 OID 16399)
-- Dependencies: 187
-- Data for Name: candidatos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY candidatos (foto, id_candidato, id_persona) FROM stdin;
\N	1	2
\N	2	1
\.


--
-- TOC entry 2236 (class 0 OID 0)
-- Dependencies: 188
-- Name: candidatos_id_candidatos_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('candidatos_id_candidatos_seq', 1, true);


--
-- TOC entry 2204 (class 0 OID 16394)
-- Dependencies: 185
-- Data for Name: candidatos_por_elecciones; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY candidatos_por_elecciones (id_eleccion, id_candidato, id_candidato_eleccion) FROM stdin;
1	1	1
\.


--
-- TOC entry 2215 (class 0 OID 16485)
-- Dependencies: 196
-- Data for Name: elecciones; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY elecciones (id_eleccion, fecha_inicio, fecha_fin, nombre) FROM stdin;
1	2017-10-14 15:29:24.431677	2017-10-14 15:29:24.431677	Eleccion por representante estudiantil
2	2017-10-14 15:29:33.736702	2017-10-14 15:29:33.736702	Eleccion por representante docentes
\.


--
-- TOC entry 2237 (class 0 OID 0)
-- Dependencies: 195
-- Name: elecciones_id_elecion_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('elecciones_id_elecion_seq', 2, true);


--
-- TOC entry 2238 (class 0 OID 0)
-- Dependencies: 194
-- Name: persona_id_persona_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('persona_id_persona_seq', 1, false);


--
-- TOC entry 2212 (class 0 OID 16453)
-- Dependencies: 193
-- Data for Name: personas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY personas (nombre, segundo_nombre, apellido, segundo_apellido, id_persona, tipo_documento, numero_documento, genero, fecha_de_nacimiento) FROM stdin;
Kevin	Javier 	Serrano	Arciniegas	2	CC	654321	M	Ayer
Jhon	Fredy	Pedroza	Pineda	1	CC	123456	M	AntesdeAyer
\.


--
-- TOC entry 2239 (class 0 OID 0)
-- Dependencies: 190
-- Name: rol_id_rol_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('rol_id_rol_seq', 1, false);


--
-- TOC entry 2208 (class 0 OID 16409)
-- Dependencies: 189
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY roles (id_rol, nombre) FROM stdin;
1	Administrador
\.


--
-- TOC entry 2210 (class 0 OID 16414)
-- Dependencies: 191
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY usuarios (id_usuario, usuario, clave, id_persona, id_rol) FROM stdin;
2	kserrano	12345	2	1
1	jpedroza	12345	1	1
\.


--
-- TOC entry 2240 (class 0 OID 0)
-- Dependencies: 192
-- Name: usuarios_id_usuarios_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('usuarios_id_usuarios_seq', 1, false);


--
-- TOC entry 2217 (class 0 OID 16505)
-- Dependencies: 198
-- Data for Name: usuarios_por_elecciones; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY usuarios_por_elecciones (id_usuario, id_eleccion, estado, id_usuarios_por_elecciones) FROM stdin;
\.


--
-- TOC entry 2241 (class 0 OID 0)
-- Dependencies: 197
-- Name: usuarios_por_elecciones_id_usuarios_por_elecciones_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('usuarios_por_elecciones_id_usuarios_por_elecciones_seq', 1, false);


--
-- TOC entry 2219 (class 0 OID 16523)
-- Dependencies: 200
-- Data for Name: votos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY votos (id_voto, id_eleccion, fecha_votacion, id_candidato, estado) FROM stdin;
\.


--
-- TOC entry 2242 (class 0 OID 0)
-- Dependencies: 199
-- Name: votos_id_voto_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('votos_id_voto_seq', 1, false);


--
-- TOC entry 2057 (class 2606 OID 16440)
-- Name: candidatos_por_elecciones candidato_eleccion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY candidatos_por_elecciones
    ADD CONSTRAINT candidato_eleccion_pkey PRIMARY KEY (id_candidato_eleccion);


--
-- TOC entry 2061 (class 2606 OID 16442)
-- Name: candidatos candidatos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY candidatos
    ADD CONSTRAINT candidatos_pkey PRIMARY KEY (id_candidato);


--
-- TOC entry 2072 (class 2606 OID 16490)
-- Name: elecciones elecciones_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY elecciones
    ADD CONSTRAINT elecciones_pkey PRIMARY KEY (id_eleccion);


--
-- TOC entry 2070 (class 2606 OID 16463)
-- Name: personas persona_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY personas
    ADD CONSTRAINT persona_pkey PRIMARY KEY (id_persona);


--
-- TOC entry 2064 (class 2606 OID 16446)
-- Name: roles rol_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY roles
    ADD CONSTRAINT rol_pkey PRIMARY KEY (id_rol);


--
-- TOC entry 2068 (class 2606 OID 16448)
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id_usuario);


--
-- TOC entry 2074 (class 2606 OID 16510)
-- Name: usuarios_por_elecciones usuarios_por_elecciones_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_por_elecciones
    ADD CONSTRAINT usuarios_por_elecciones_pkey PRIMARY KEY (id_usuarios_por_elecciones);


--
-- TOC entry 2077 (class 2606 OID 16528)
-- Name: votos votos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY votos
    ADD CONSTRAINT votos_pkey PRIMARY KEY (id_voto);


--
-- TOC entry 2058 (class 1259 OID 16496)
-- Name: fki_candidato_por_eleccion_candidato_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_candidato_por_eleccion_candidato_fk ON candidatos_por_elecciones USING btree (id_candidato);


--
-- TOC entry 2059 (class 1259 OID 16502)
-- Name: fki_candidato_por_eleccion_eleccion_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_candidato_por_eleccion_eleccion_fk ON candidatos_por_elecciones USING btree (id_eleccion);


--
-- TOC entry 2062 (class 1259 OID 16469)
-- Name: fki_persona_candidatos_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_persona_candidatos_fk ON candidatos USING btree (id_persona);


--
-- TOC entry 2065 (class 1259 OID 16481)
-- Name: fki_usuario_rol_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_usuario_rol_fk ON usuarios USING btree (id_rol);


--
-- TOC entry 2066 (class 1259 OID 16475)
-- Name: fki_usuarios_persona_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_usuarios_persona_fk ON usuarios USING btree (id_persona);


--
-- TOC entry 2075 (class 1259 OID 16539)
-- Name: fki_votos_candidatios_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_votos_candidatios_fk ON votos USING btree (id_candidato);


--
-- TOC entry 2078 (class 2606 OID 16491)
-- Name: candidatos_por_elecciones candidato_por_eleccion_candidato_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY candidatos_por_elecciones
    ADD CONSTRAINT candidato_por_eleccion_candidato_fk FOREIGN KEY (id_candidato) REFERENCES candidatos(id_candidato);


--
-- TOC entry 2079 (class 2606 OID 16497)
-- Name: candidatos_por_elecciones candidato_por_eleccion_eleccion_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY candidatos_por_elecciones
    ADD CONSTRAINT candidato_por_eleccion_eleccion_fk FOREIGN KEY (id_eleccion) REFERENCES elecciones(id_eleccion);


--
-- TOC entry 2080 (class 2606 OID 16464)
-- Name: candidatos persona_candidatos_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY candidatos
    ADD CONSTRAINT persona_candidatos_fk FOREIGN KEY (id_persona) REFERENCES personas(id_persona);


--
-- TOC entry 2082 (class 2606 OID 16476)
-- Name: usuarios usuario_rol_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios
    ADD CONSTRAINT usuario_rol_fk FOREIGN KEY (id_rol) REFERENCES roles(id_rol);


--
-- TOC entry 2081 (class 2606 OID 16470)
-- Name: usuarios usuarios_persona_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios
    ADD CONSTRAINT usuarios_persona_fk FOREIGN KEY (id_persona) REFERENCES personas(id_persona);


--
-- TOC entry 2084 (class 2606 OID 16516)
-- Name: usuarios_por_elecciones usuarios_por_elecciones_elecciones_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_por_elecciones
    ADD CONSTRAINT usuarios_por_elecciones_elecciones_fk FOREIGN KEY (id_eleccion) REFERENCES elecciones(id_eleccion);


--
-- TOC entry 2083 (class 2606 OID 16511)
-- Name: usuarios_por_elecciones usuarios_por_elecciones_usuarios_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_por_elecciones
    ADD CONSTRAINT usuarios_por_elecciones_usuarios_fk FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario);


--
-- TOC entry 2086 (class 2606 OID 16534)
-- Name: votos votos_candidatios_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY votos
    ADD CONSTRAINT votos_candidatios_fk FOREIGN KEY (id_candidato) REFERENCES candidatos(id_candidato);


--
-- TOC entry 2085 (class 2606 OID 16529)
-- Name: votos votos_elecciones_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY votos
    ADD CONSTRAINT votos_elecciones_fk FOREIGN KEY (id_eleccion) REFERENCES elecciones(id_eleccion);


-- Completed on 2017-10-14 21:34:53

--
-- PostgreSQL database dump complete
--

