--
-- PostgreSQL database dump
--

SET client_encoding = 'LATIN1';
SET check_function_bodies = false;

SET SESSION AUTHORIZATION 'postgres';

--
-- TOC entry 4 (OID 2200)
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


SET SESSION AUTHORIZATION 'asgeir';

SET search_path = public, pg_catalog;

--
-- TOC entry 5 (OID 18717)
-- Name: id_seq; Type: SEQUENCE; Schema: public; Owner: asgeir
--

CREATE SEQUENCE id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 6 (OID 18719)
-- Name: site; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE site (
    id integer NOT NULL,
    title text,
    description text,
    rights text,
    email text
);


--
-- TOC entry 7 (OID 18726)
-- Name: reaktoruser; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE reaktoruser (
    id integer NOT NULL,
    "type" text,
    name text,
    email text,
    "password" text,
    disabled boolean,
    salt text,
    nick text,
    public_name boolean,
    public_email boolean,
    description text,
    sex character(1),
    year_of_birth integer,
    in_mailinglist boolean,
    image text,
    place_of_residence text,
    telephone text,
    site integer,
    email_confirmed boolean,
    artwork_groups text,
    CONSTRAINT reaktoruser_sex CHECK (((sex = 'm'::bpchar) OR (sex = 'f'::bpchar))),
    CONSTRAINT reaktoruser_type CHECK (((("type" = 'external'::text) OR ("type" = 'editor'::text)) OR ("type" = 'administrator'::text)))
);


--
-- TOC entry 8 (OID 18739)
-- Name: artwork; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE artwork (
    id integer NOT NULL,
    "type" text,
    data text,
    screenshot text,
    creator integer,
    title text,
    description text,
    keywords text,
    howto text,
    help text,
    rights text,
    editor integer,
    width integer,
    height integer,
    site integer,
    publish_state text,
    under_discussion boolean,
    internal_discussion text,
    CONSTRAINT "$3" CHECK (((((rights = ':free'::text) OR (rights = ':educational'::text)) OR (rights = ':contactme'::text)) OR (rights = ':none'::text))),
    CONSTRAINT artwork_publish_state CHECK (((((publish_state = ':queued'::text) OR (publish_state = ':denied'::text)) OR (publish_state = ':accepted'::text)) OR (publish_state = ':disabled'::text))),
    CONSTRAINT artwork_type CHECK (((((((((((("type" = 'image'::text) OR ("type" = 'video'::text)) OR ("type" = 'flash'::text)) OR ("type" = 'pdf'::text)) OR ("type" = 'text'::text)) OR ("type" = 'verbatim text'::text)) OR ("type" = 'sound'::text)) OR ("type" = 'shockwave'::text)) OR ("type" = 'href'::text)) OR ("type" = 'images'::text)) OR ("type" = 'files'::text)))
);


--
-- TOC entry 9 (OID 18757)
-- Name: article; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE article (
    id integer NOT NULL,
    "type" text,
    title text,
    image text,
    ingress text,
    body text,
    published boolean,
    deleted boolean DEFAULT false,
    rank integer,
    artwork integer,
    CONSTRAINT article_type CHECK (((((((("type" = 'standard'::text) OR ("type" = 'mypage'::text)) OR ("type" = 'topic'::text)) OR ("type" = 'pick'::text)) OR ("type" = 'help'::text)) OR ("type" = 'about'::text)) OR ("type" = 'internal'::text)))
);


--
-- TOC entry 10 (OID 18770)
-- Name: topic; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE topic (
    id integer NOT NULL,
    parent integer,
    title text,
    description text,
    independent_title text
);


--
-- TOC entry 11 (OID 18781)
-- Name: artwork_formats; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE artwork_formats (
    artwork integer NOT NULL,
    topic integer NOT NULL
);


--
-- TOC entry 12 (OID 18793)
-- Name: artwork_topics; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE artwork_topics (
    artwork integer NOT NULL,
    topic integer NOT NULL
);


--
-- TOC entry 13 (OID 18805)
-- Name: article_formats; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE article_formats (
    article integer NOT NULL,
    topic integer NOT NULL
);


--
-- TOC entry 14 (OID 18817)
-- Name: article_topics; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE article_topics (
    article integer NOT NULL,
    topic integer NOT NULL
);


--
-- TOC entry 15 (OID 18829)
-- Name: artwork_help_articles; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE artwork_help_articles (
    article integer NOT NULL,
    artwork integer NOT NULL
);


--
-- TOC entry 16 (OID 18841)
-- Name: comment; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE "comment" (
    id integer DEFAULT nextval('id_seq'::text) NOT NULL,
    parent integer,
    creator integer,
    artwork integer,
    hidden boolean DEFAULT false,
    subject text,
    body text
);


--
-- TOC entry 17 (OID 18862)
-- Name: changelog; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE changelog (
    id integer DEFAULT nextval('id_seq'::text) NOT NULL,
    "timestamp" timestamp without time zone DEFAULT ('now'::text)::timestamp(6) with time zone,
    reaktoruser integer,
    object integer,
    object_type text,
    "action" text,
    description text,
    ip text,
    browser text,
    CONSTRAINT changelog_action CHECK (((((((("action" = ':CREATE'::text) OR ("action" = ':EDIT'::text)) OR ("action" = ':DELETE'::text)) OR ("action" = ':PUBISH'::text)) OR ("action" = ':DENY'::text)) OR ("action" = ':ACCEPT'::text)) OR ("action" = ':LOGIN'::text))),
    CONSTRAINT changelog_object_type CHECK (((((((object_type = 'artwork'::text) OR (object_type = 'article'::text)) OR (object_type = 'reaktoruser'::text)) OR (object_type = 'topic'::text)) OR (object_type = 'comment'::text)) OR (object_type = 'comment_complaint'::text)))
);


--
-- TOC entry 18 (OID 18877)
-- Name: rating; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE rating (
    reaktoruser integer NOT NULL,
    artwork integer NOT NULL,
    rating integer
);


--
-- TOC entry 19 (OID 18889)
-- Name: comment_complaint; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE comment_complaint (
    id integer DEFAULT nextval('id_seq'::text) NOT NULL,
    state text DEFAULT ':queued'::text,
    "comment" integer,
    creator integer,
    description text,
    CONSTRAINT comment_complaint_state CHECK ((((state = ':queued'::text) OR (state = ':denied'::text)) OR (state = ':accepted'::text)))
);


--
-- TOC entry 20 (OID 18907)
-- Name: reaktor; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE reaktor (
    id integer DEFAULT nextval('id_seq'::text) NOT NULL,
    frontpage_articles_top integer,
    frontpage_articles_left integer,
    frontpage_articles_right integer,
    frontpage_help_top integer,
    frontpage_help_left integer,
    frontpage_help_right integer,
    frontpage_topic integer,
    editor_pick integer,
    frontpage_articles_top2 integer,
    mypage_articles_top integer,
    mypage_articles_top2 integer,
    frontpage_help_1 integer,
    frontpage_help_2 integer,
    frontpage_help_3 integer,
    frontpage_help_4 integer,
    frontpage_help_5 integer,
    frontpage_help_6 integer
);


--
-- TOC entry 21 (OID 18944)
-- Name: topic_shortlist; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE topic_shortlist (
    reaktor integer,
    topic integer NOT NULL,
    rank integer
);


--
-- TOC entry 22 (OID 29978)
-- Name: persmem; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE persmem (
    "key" text NOT NULL,
    value text
);


--
-- TOC entry 23 (OID 29985)
-- Name: persdict; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE persdict (
    "key" text NOT NULL,
    value text
);


--
-- TOC entry 24 (OID 36348)
-- Name: total_artworks; Type: VIEW; Schema: public; Owner: asgeir
--

CREATE VIEW total_artworks AS
    SELECT count(*) AS count FROM artwork WHERE (artwork.publish_state = ':accepted'::text);


--
-- TOC entry 25 (OID 36354)
-- Name: denied_works; Type: VIEW; Schema: public; Owner: asgeir
--

CREATE VIEW denied_works AS
    SELECT count(*) AS count FROM artwork WHERE (artwork.publish_state = ':denied'::text);


--
-- TOC entry 26 (OID 36357)
-- Name: queued_works; Type: VIEW; Schema: public; Owner: asgeir
--

CREATE VIEW queued_works AS
    SELECT count(*) AS count FROM artwork WHERE (artwork.publish_state = ':queued'::text);


--
-- TOC entry 27 (OID 36360)
-- Name: total_users; Type: VIEW; Schema: public; Owner: asgeir
--

CREATE VIEW total_users AS
    SELECT count(*) AS count FROM reaktoruser WHERE (reaktoruser."type" = 'external'::text);


--
-- TOC entry 28 (OID 36363)
-- Name: new_users; Type: VIEW; Schema: public; Owner: asgeir
--

CREATE VIEW new_users AS
    SELECT u.id, u.name, u.nick FROM changelog c, reaktoruser u WHERE ((((c.object_type = 'reaktoruser'::text) AND (c."action" = ':CREATE'::text)) AND (c."timestamp" > ('2005-01-05 14:34:15.665607'::timestamp without time zone - '1 mon'::interval))) AND (c.object = u.id));


--
-- TOC entry 29 (OID 36366)
-- Name: top20_users; Type: VIEW; Schema: public; Owner: asgeir
--

CREATE VIEW top20_users AS
    SELECT max(u.id) AS id, max(u.name) AS name, max(u.nick) AS artworks, count(a.id) AS count FROM artwork a, changelog c, reaktoruser u WHERE (((((c.object_type = 'artwork'::text) AND (c."action" = ':CREATE'::text)) AND (c."timestamp" > ('2005-01-05 14:34:15.669707'::timestamp without time zone - '3 mons'::interval))) AND (a.id = c.object)) AND (a.creator = u.id)) GROUP BY u.id ORDER BY count(a.id) DESC LIMIT 20;


--
-- TOC entry 30 (OID 38997)
-- Name: user_help; Type: TABLE; Schema: public; Owner: asgeir
--

CREATE TABLE user_help (
    create_time timestamp without time zone,
    creator integer,
    url text
);


--
-- TOC entry 31 (OID 46340)
-- Name: artwork_by_day; Type: VIEW; Schema: public; Owner: asgeir
--

CREATE VIEW artwork_by_day AS
    SELECT date_trunc('day'::text, changelog."timestamp") AS date_trunc, count(artwork.id) AS count FROM artwork, changelog WHERE (((artwork.publish_state = ':accepted'::text) AND (changelog.object = artwork.id)) AND (changelog."action" = ':CREATE'::text)) GROUP BY date_trunc('day'::text, changelog."timestamp") ORDER BY date_trunc('day'::text, changelog."timestamp");


SET SESSION AUTHORIZATION 'reaktortest';

--
-- TOC entry 32 (OID 47342)
-- Name: new_works; Type: VIEW; Schema: public; Owner: reaktortest
--

CREATE VIEW new_works AS
    SELECT count(*) AS count FROM changelog WHERE (((changelog.object_type = 'artwork'::text) AND (changelog."action" = ':CREATE'::text)) AND (changelog."timestamp" > ('2005-05-26 17:03:08.021782'::timestamp without time zone - '1 mon'::interval)));


SET SESSION AUTHORIZATION 'asgeir';

--
-- TOC entry 33 (OID 18724)
-- Name: site_pkey; Type: CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY site
    ADD CONSTRAINT site_pkey PRIMARY KEY (id);


--
-- TOC entry 34 (OID 18733)
-- Name: reaktoruser_pkey; Type: CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY reaktoruser
    ADD CONSTRAINT reaktoruser_pkey PRIMARY KEY (id);


--
-- TOC entry 35 (OID 18747)
-- Name: artwork_pkey; Type: CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY artwork
    ADD CONSTRAINT artwork_pkey PRIMARY KEY (id);


--
-- TOC entry 36 (OID 18764)
-- Name: article_pkey; Type: CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY article
    ADD CONSTRAINT article_pkey PRIMARY KEY (id);


--
-- TOC entry 37 (OID 18775)
-- Name: topic_pkey; Type: CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY topic
    ADD CONSTRAINT topic_pkey PRIMARY KEY (id);


--
-- TOC entry 38 (OID 18783)
-- Name: artwork_formats_pkey; Type: CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY artwork_formats
    ADD CONSTRAINT artwork_formats_pkey PRIMARY KEY (artwork, topic);


--
-- TOC entry 39 (OID 18795)
-- Name: artwork_topics_pkey; Type: CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY artwork_topics
    ADD CONSTRAINT artwork_topics_pkey PRIMARY KEY (artwork, topic);


--
-- TOC entry 40 (OID 18807)
-- Name: article_formats_pkey; Type: CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY article_formats
    ADD CONSTRAINT article_formats_pkey PRIMARY KEY (article, topic);


--
-- TOC entry 41 (OID 18819)
-- Name: article_topics_pkey; Type: CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY article_topics
    ADD CONSTRAINT article_topics_pkey PRIMARY KEY (article, topic);


--
-- TOC entry 42 (OID 18831)
-- Name: artwork_help_articles_pkey; Type: CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY artwork_help_articles
    ADD CONSTRAINT artwork_help_articles_pkey PRIMARY KEY (article, artwork);


--
-- TOC entry 43 (OID 18848)
-- Name: comment_pkey; Type: CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY "comment"
    ADD CONSTRAINT comment_pkey PRIMARY KEY (id);


--
-- TOC entry 44 (OID 18871)
-- Name: changelog_pkey; Type: CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY changelog
    ADD CONSTRAINT changelog_pkey PRIMARY KEY (id);


--
-- TOC entry 45 (OID 18879)
-- Name: rating_pkey; Type: CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY rating
    ADD CONSTRAINT rating_pkey PRIMARY KEY (reaktoruser, artwork);


--
-- TOC entry 46 (OID 18897)
-- Name: comment_complaint_pkey; Type: CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY comment_complaint
    ADD CONSTRAINT comment_complaint_pkey PRIMARY KEY (id);


--
-- TOC entry 47 (OID 18910)
-- Name: reaktor_pkey; Type: CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY reaktor
    ADD CONSTRAINT reaktor_pkey PRIMARY KEY (id);


--
-- TOC entry 48 (OID 18946)
-- Name: topic_shortlist_pkey; Type: CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY topic_shortlist
    ADD CONSTRAINT topic_shortlist_pkey PRIMARY KEY (topic);


--
-- TOC entry 49 (OID 29983)
-- Name: persmem_pkey; Type: CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY persmem
    ADD CONSTRAINT persmem_pkey PRIMARY KEY ("key");


--
-- TOC entry 50 (OID 29990)
-- Name: persdict_pkey; Type: CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY persdict
    ADD CONSTRAINT persdict_pkey PRIMARY KEY ("key");


--
-- TOC entry 51 (OID 18735)
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY reaktoruser
    ADD CONSTRAINT "$1" FOREIGN KEY (site) REFERENCES site(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 52 (OID 18749)
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY artwork
    ADD CONSTRAINT "$1" FOREIGN KEY (creator) REFERENCES reaktoruser(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 53 (OID 18753)
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY artwork
    ADD CONSTRAINT "$2" FOREIGN KEY (editor) REFERENCES reaktoruser(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 54 (OID 18766)
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY article
    ADD CONSTRAINT "$1" FOREIGN KEY (artwork) REFERENCES artwork(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 55 (OID 18777)
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY topic
    ADD CONSTRAINT "$1" FOREIGN KEY (parent) REFERENCES topic(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 56 (OID 18785)
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY artwork_formats
    ADD CONSTRAINT "$1" FOREIGN KEY (artwork) REFERENCES artwork(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 57 (OID 18789)
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY artwork_formats
    ADD CONSTRAINT "$2" FOREIGN KEY (topic) REFERENCES topic(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 58 (OID 18797)
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY artwork_topics
    ADD CONSTRAINT "$1" FOREIGN KEY (artwork) REFERENCES artwork(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 59 (OID 18801)
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY artwork_topics
    ADD CONSTRAINT "$2" FOREIGN KEY (topic) REFERENCES topic(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 60 (OID 18809)
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY article_formats
    ADD CONSTRAINT "$1" FOREIGN KEY (article) REFERENCES article(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 61 (OID 18813)
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY article_formats
    ADD CONSTRAINT "$2" FOREIGN KEY (topic) REFERENCES topic(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 62 (OID 18821)
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY article_topics
    ADD CONSTRAINT "$1" FOREIGN KEY (article) REFERENCES article(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 63 (OID 18825)
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY article_topics
    ADD CONSTRAINT "$2" FOREIGN KEY (topic) REFERENCES topic(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 64 (OID 18833)
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY artwork_help_articles
    ADD CONSTRAINT "$1" FOREIGN KEY (article) REFERENCES article(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 65 (OID 18837)
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY artwork_help_articles
    ADD CONSTRAINT "$2" FOREIGN KEY (artwork) REFERENCES artwork(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 66 (OID 18850)
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY "comment"
    ADD CONSTRAINT "$1" FOREIGN KEY (parent) REFERENCES "comment"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 67 (OID 18854)
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY "comment"
    ADD CONSTRAINT "$2" FOREIGN KEY (creator) REFERENCES reaktoruser(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 68 (OID 18858)
-- Name: $3; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY "comment"
    ADD CONSTRAINT "$3" FOREIGN KEY (artwork) REFERENCES artwork(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 69 (OID 18873)
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY changelog
    ADD CONSTRAINT "$1" FOREIGN KEY (reaktoruser) REFERENCES reaktoruser(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 70 (OID 18881)
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY rating
    ADD CONSTRAINT "$1" FOREIGN KEY (reaktoruser) REFERENCES reaktoruser(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 71 (OID 18885)
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY rating
    ADD CONSTRAINT "$2" FOREIGN KEY (artwork) REFERENCES artwork(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 72 (OID 18899)
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY comment_complaint
    ADD CONSTRAINT "$1" FOREIGN KEY ("comment") REFERENCES "comment"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 73 (OID 18903)
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY comment_complaint
    ADD CONSTRAINT "$2" FOREIGN KEY (creator) REFERENCES reaktoruser(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 74 (OID 18912)
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY reaktor
    ADD CONSTRAINT "$1" FOREIGN KEY (frontpage_articles_top) REFERENCES article(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 75 (OID 18916)
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY reaktor
    ADD CONSTRAINT "$2" FOREIGN KEY (frontpage_articles_left) REFERENCES article(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 76 (OID 18920)
-- Name: $3; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY reaktor
    ADD CONSTRAINT "$3" FOREIGN KEY (frontpage_articles_right) REFERENCES article(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 77 (OID 18924)
-- Name: $4; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY reaktor
    ADD CONSTRAINT "$4" FOREIGN KEY (frontpage_help_top) REFERENCES article(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 78 (OID 18928)
-- Name: $5; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY reaktor
    ADD CONSTRAINT "$5" FOREIGN KEY (frontpage_help_left) REFERENCES article(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 79 (OID 18932)
-- Name: $6; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY reaktor
    ADD CONSTRAINT "$6" FOREIGN KEY (frontpage_help_right) REFERENCES article(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 80 (OID 18936)
-- Name: $7; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY reaktor
    ADD CONSTRAINT "$7" FOREIGN KEY (frontpage_topic) REFERENCES article(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 81 (OID 18940)
-- Name: $8; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY reaktor
    ADD CONSTRAINT "$8" FOREIGN KEY (editor_pick) REFERENCES article(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 89 (OID 18948)
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY topic_shortlist
    ADD CONSTRAINT "$1" FOREIGN KEY (reaktor) REFERENCES reaktor(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 90 (OID 18952)
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY topic_shortlist
    ADD CONSTRAINT "$2" FOREIGN KEY (topic) REFERENCES topic(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 82 (OID 38969)
-- Name: $88; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY reaktor
    ADD CONSTRAINT "$88" FOREIGN KEY (frontpage_articles_top2) REFERENCES article(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 83 (OID 38973)
-- Name: $9; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY reaktor
    ADD CONSTRAINT "$9" FOREIGN KEY (mypage_articles_top) REFERENCES article(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 84 (OID 38977)
-- Name: $10; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY reaktor
    ADD CONSTRAINT "$10" FOREIGN KEY (mypage_articles_top2) REFERENCES article(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 85 (OID 38981)
-- Name: $12; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY reaktor
    ADD CONSTRAINT "$12" FOREIGN KEY (frontpage_help_1) REFERENCES topic(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 86 (OID 38985)
-- Name: $13; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY reaktor
    ADD CONSTRAINT "$13" FOREIGN KEY (frontpage_help_4) REFERENCES topic(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 87 (OID 38989)
-- Name: $14; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY reaktor
    ADD CONSTRAINT "$14" FOREIGN KEY (frontpage_help_5) REFERENCES topic(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 88 (OID 38993)
-- Name: $15; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY reaktor
    ADD CONSTRAINT "$15" FOREIGN KEY (frontpage_help_6) REFERENCES topic(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 91 (OID 39002)
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: asgeir
--

ALTER TABLE ONLY user_help
    ADD CONSTRAINT "$1" FOREIGN KEY (creator) REFERENCES reaktoruser(id) ON UPDATE CASCADE ON DELETE CASCADE;


SET SESSION AUTHORIZATION 'postgres';

--
-- TOC entry 3 (OID 2200)
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'Standard public namespace';


