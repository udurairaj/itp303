-- Comments in SQL

-- SELECT selects columns
SELECT *
FROM tracks;

SELECT *
FROM genres;

SELECT name, composer
FROM tracks;

-- Display tracks that cos more than $0.99
-- Sort them from shortest to longest (in length)
SELECT *
FROM tracks
WHERE unit_price > 0.99
ORDER BY milliseconds;

-- Display tracks that cos more than $0.99
-- Sort them from shortest to longest (in length)
-- Only show the track's id, name, price, and length
SELECT track_id, name, unit_price, milliseconds
FROM tracks
WHERE unit_price > 0.99
ORDER BY milliseconds;

-- Display tracks that have a composer
-- Only show the track's id, name, composer, and price
SELECT track_id, name, composer, unit_price
FROM tracks
WHERE composer IS NOT NULL;

-- Display tracks that have 'you' or 'day' in their titles
SELECT *
FROM tracks
WHERE (name LIKE '%you%' OR name LIKE '%day%');

-- Display tracks composed by U2 that have 'you' or 'day' in their titles
SELECT *
FROM tracks
WHERE composer LIKE '%U2%'
AND (name LIKE '%you%' OR name LIKE '%day%');

-- Display all albums and artists corresponding to each album
-- Only show album title and artist name
SELECT title AS album_title, name AS artist_name
FROM albums
JOIN artists
	ON albums.artist_id = artists.artist_id;
    
-- Display all Jazz tracks
SELECT *
FROM tracks
JOIN genres
	ON tracks.genre_id = genres.genre_id
WHERE genres.genre_id = 2;
-- could also use: WHERE genres.name = 'Jazz'
-- BUT its better to use primary keys (ids) when using WHERE
-- (searching for a simple integer is faster than searching for a string)

-- Display all Jazz tracks
-- Only show track name, genre name, album title, and artist name columns
SELECT tracks.name AS track_name, genres.name AS genre_name, 
albums.title AS album_name, artists.name AS artist_name
FROM tracks
JOIN genres
	ON tracks.genre_id = genres.genre_id
JOIN albums
	ON tracks.album_id = albums.album_id
JOIN artists
	ON albums.artist_id = artists.artist_id
WHERE genres.genre_id = 2;
