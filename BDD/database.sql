Drop schema if EXISTS animeDataBase cascade;
CREATE SCHEMA animeDataBase;
set search_path to animeDataBase;


CREATE table Studios(
    id_studio SERIAL PRIMARY KEY,
    nom_studio TEXT
);

CREATE table Genres(
    id_genre SERIAL PRIMARY key ,
    nom_genre TEXT
);

CREATE Table Animes (
    id_anime serial PRIMARY KEY,
    titre TEXT,
    nb_saisons INT ,
    date_sortie DATE  ,
    statut TEXT,
    id_studio INT REFERENCES Studios(id_studio)
);

CREATE Table Anime_Genres(
    id_anime INT REFERENCES Animes(id_anime),
    id_genre INT REFERENCES Genres(id_genre),
    PRIMARY KEY(id_anime, id_genre)
);

CREATE TABLE tempo(
    Anime TEXT,
    Genre TEXT,
    Studio_Animation TEXT,
    Nb_Saisons TEXT,
    Date_Sortie DATE,
    Statut TEXT
);

COPY tempo(anime, genre, studio_animation, nb_saisons, date_sortie, statut)
FROM 'C:\Users\thiba\Desktop\animeList\Data.csv'
WITH(
    format CSV,
    HEADER true,
    DELIMITER ';',
    ENCODING 'UTF8'
);

INSERT INTO Studios(nom_studio)
    (select DISTINCT studio_animation
     FROM tempo);

INSERT INTO Genres(nom_genre)
SELECT DISTINCT TRIM(genre_isole) -- TRIM enlève les espaces inutiles au début/fin
FROM (
    -- Cette fonction découpe le texte à chaque virgule
    SELECT regexp_split_to_table(genre, ',') AS genre_isole
    FROM tempo
    WHERE genre IS NOT NULL
) AS subquery;

INSERT INTO Animes (titre, nb_saisons, date_sortie, statut, id_studio)
SELECT 
    t.anime,
    substring(t.Nb_Saisons FROM '^[0-9]+')::INT,          -- Conversion directe en entier
    t.Date_Sortie::DATE,        -- Conversion en vrai type DATE
    COALESCE(t.Statut, 'Inconnu'), -- Si le statut est NULL, on met 'Fini' (ou 'Inconnu') par défaut
    s.id_studio                 -- On récupère l'id généré pour le studio
FROM tempo t
LEFT JOIN Studios s ON t.Studio_Animation = s.nom_studio;


INSERT INTO Anime_Genres (id_anime, id_genre)
SELECT DISTINCT a.id_anime, g.id_genre
FROM (
    -- 1. On isole chaque genre textuel de la table tempo
    SELECT anime, TRIM(regexp_split_to_table(genre, ',')) AS genre_isole
    FROM tempo
    WHERE genre IS NOT NULL
) AS t_decoupe
-- 2. On récupère l'id de l'animé via son titre
JOIN Animes a ON t_decoupe.anime = a.titre
-- 3. On récupère l'id du genre via son nom
JOIN Genres g ON t_decoupe.genre_isole = g.nom_genre;

DROP TABLE tempo;


DROP VIEW IF EXISTS nbAnimeRomance;

CREATE OR REPLACE VIEW vue_total_par_genre AS
SELECT 
    genres.nom_genre, 
    COUNT(anime_genres.id_anime) AS total_anime
FROM genres
LEFT JOIN anime_genres USING(id_genre)
GROUP BY genres.id_genre, genres.nom_genre
ORDER BY nom_genre;

SELECT nom_genre, total_anime
FROM vue_total_par_genre
ORDER BY total_anime DESC
;

select COUNT(id_anime) from animes;

