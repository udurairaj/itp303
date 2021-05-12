-- Add album 'Fight On' by artist 'Spirit of Troy'
SELECT *
FROM albums;

INSERT INTO albums (title, artist_id)
VALUES ('Fight On', 276);

SELECT *
FROM artists
WHERE name LIKE '%spirit%';

INSERT INTO artists (name)
VALUES ('Spirit of Troy');

-- Double check that 'Fight On' was added to albums table
SELECT *
FROM albums
ORDER BY album_id DESC;


-- Update track 'All My Love' composed by 'E. Schrody and L. Dimant' to be part of
-- 'Fight On' album and composed by 'Tommy Trojan'
SELECT *
FROM tracks
WHERE name = 'All My Love';

UPDATE tracks
SET album_id = 348, composer = 'Tommy Trojan'
WHERE track_id = 3316;


-- Delete the album 'Fight On'
SELECT *
FROM albums
WHERE album_id = 348;

DELETE FROM albums
WHERE album_id = 348;
-- ERRORS: cannot delete a record that is being referenced by another table
-- ex: 'All My Love' is a track in the 'Fight On' album

-- Two ways to handle this issue:
-- 1) Delete the references (delete the 'All My Love' track)
-- 2) Nullify the reference (nullify album_id 348 in 'All My Love' track)

UPDATE tracks
SET album_id = null
WHERE album_id = 348;


-- Create a view that displays all albums and their artist names.
-- (Only show album id, album title, and artist name)
CREATE OR REPLACE VIEW album_artists AS
SELECT album_id, title AS album_title, name AS artist_name
FROM albums
JOIN artists
	ON albums.artist_id = artists.artist_id;
    
SELECT *
FROM album_artists;


-- Create a view that displays all Rock tracks, sorted from shortest to longest.
-- (Only show track name, genre name, and millisecond columns)
CREATE OR REPLACE VIEW rock_sorted AS
SELECT tracks.name AS track_name, genres.name AS genre_name, tracks.milliseconds
FROM tracks
JOIN genres
	ON tracks.genre_id = genres.genre_id
WHERE genres.genre_id = 1
ORDER BY milliseconds ASC;


DROP VIEW album_artists;


-- AGGREGATE FUNCTIONS --

-- counts number of rows in tracks
SELECT COUNT(*)
FROM tracks;

-- counts number of rows in tracks and number of rows with composer (not null)
SELECT COUNT(*), COUNT(composer)
FROM tracks;

-- min/max to get the shortest song length, average song length, and longest song length
SELECT MIN(milliseconds), AVG(milliseconds), MAX(milliseconds)
FROM tracks;

-- show character length of each track name and the track name itself
SELECT CHAR_LENGTH(name), name
FROM tracks;

-- find the shortest, average, max length for songs in EACH album
SELECT album_id, MIN(milliseconds), AVG(milliseconds), MAX(milliseconds)
FROM tracks
GROUP BY album_id;

-- For each artist, show how many albums they have
SELECT artist_id, COUNT(*)
FROM albums
GROUP BY artist_id;

-- Same as above, but also show artist name
SELECT albums.artist_id, artists.name, COUNT(*)
FROM albums
JOIN artists
	ON albums.artist_id = artists.artist_id
GROUP BY albums.artist_id;