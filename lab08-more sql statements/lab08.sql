-- 1. Create a view, mpeg_tracks, that displays all tracks with MPEG audio file format.
-- Display track name (track_name) artist name (artist_name), composer, 
-- album title (album_title), and media type (media_type).
-- Sort results in alphabetical order by track name.
CREATE OR REPLACE VIEW mpeg_tracks AS
SELECT tracks.name AS track_name, artists.name AS artist_name, composer,
albums.title AS album_title, media_types.name AS media_type
FROM tracks
JOIN albums
	ON tracks.album_id = albums.album_id
JOIN artists
	ON albums.artist_id = artists.artist_id
JOIN media_types
	ON tracks.media_type_id = media_types.media_type_id
WHERE media_types.media_type_id = 1
ORDER BY tracks.name ASC;

-- 2. Add a track below to the database: 
-- Track Title: The Ocean, Album: The Song Remains The Same (Disc 1),
-- Artist: Led Zeppelin, Media Type: MPEG audio file, Genre: Rock, 
-- Composer: John Bonham/John Paul Jones/Robert Plant, Milliseconds: 248000, Bytes: 7990000
-- Unit Price: 0.99
INSERT INTO tracks (name, album_id, media_type_id, genre_id, composer, milliseconds, bytes, unit_price)
VALUES ('The Ocean', 137, 1, 1, 'John Bonham/John Paul Jones/Robert Plant', 248000, 7990000, 0.99);

-- 3. Make the following changes to the track added above:
-- New Bytes: 8998765, New Unit Price: 1.99
UPDATE tracks
SET bytes = 8998765, unit_price = 1.99
WHERE track_id = 3504;

-- 4. Delete track 20 Flight Rock by BackBeat from the database.
DELETE FROM playlist_track
WHERE track_id = 122;

DELETE FROM tracks
WHERE track_id = 122;

-- 5. Display how many tracks there are for each album.
-- Show album ID, album title (album_title), and track count (track_count).
SELECT albums.album_id, albums.title AS album_title, COUNT(track_id) AS track_count
FROM tracks
JOIN albums
	ON tracks.album_id = albums.album_id
GROUP BY album_id;
