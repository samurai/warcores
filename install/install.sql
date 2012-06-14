-- Loading this under a properly permissioned user in psql will build the required schema for warcores to run on.  This expects that you know how to permission things, as it does none of that.
-- There is no guarentee this will work for now. happy hacking


CREATE TABLE battle (
    id integer NOT NULL,
    rounds integer DEFAULT 1,
    core_size integer DEFAULT 8000,
    tie_cycles integer DEFAULT 80000,
    max_size integer DEFAULT 100,
    min_distance integer DEFAULT 0,
    battle_time integer
);

CREATE TABLE battle_has_result (
    id integer NOT NULL,
    battleid integer,
    warriorid integer,
    score integer,
    win integer,
    loss integer,
    draw integer
);

CREATE SEQUENCE battle_has_result_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;

ALTER SEQUENCE battle_has_result_id_seq OWNED BY battle_has_result.id;

CREATE TABLE battle_has_warrior (
    id integer NOT NULL,
    battleid integer,
    warriorid integer,
    "position" integer
);


CREATE SEQUENCE battle_has_warrior_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;

ALTER SEQUENCE battle_has_warrior_id_seq OWNED BY battle_has_warrior.id;

CREATE SEQUENCE battle_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER SEQUENCE battle_id_seq OWNED BY battle.id;

CREATE TABLE players (
    id integer NOT NULL,
    username character varying(50),
    password character varying(100),
    email character varying(100),
    admin integer DEFAULT 0
);

CREATE SEQUENCE players_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;

ALTER SEQUENCE players_id_seq OWNED BY players.id;


CREATE TABLE warriors (
    id integer NOT NULL,
    name character varying(50),
    notes text,
    code text,
    create_time integer,
    owner integer,
    version integer DEFAULT 1
);

CREATE SEQUENCE warriors_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER SEQUENCE warriors_id_seq OWNED BY warriors.id;

ALTER TABLE ONLY battle ALTER COLUMN id SET DEFAULT nextval('battle_id_seq'::regclass);

ALTER TABLE ONLY battle_has_result ALTER COLUMN id SET DEFAULT nextval('battle_has_result_id_seq'::regclass);

ALTER TABLE ONLY battle_has_warrior ALTER COLUMN id SET DEFAULT nextval('battle_has_warrior_id_seq'::regclass);

ALTER TABLE ONLY players ALTER COLUMN id SET DEFAULT nextval('players_id_seq'::regclass);

ALTER TABLE ONLY warriors ALTER COLUMN id SET DEFAULT nextval('warriors_id_seq'::regclass);

