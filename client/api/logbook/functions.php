<?php

/**
 * @file logbook/functions.php
 * @author Ben Shealy
 */

/**
 * Get the current show.
 *
 * @param mysqli
 * @return show ID, or null if there is no current show
 */
function get_current_show_id($mysqli)
{
	$q = "SELECT MAX(showID) AS showID FROM `show` "
		. "WHERE end_time IS NULL;";
	$result = exec_query($mysqli, $q);

	if ( $result->num_rows > 0 ) {
		$show = $result->fetch_assoc();
		return $show["showID"];
	}
	else {
		return null;
	}
}

/**
 * Get information about an album.
 *
 * @param mysqli
 * @param album_code
 * @return associative array of album
 */
function get_album($mysqli, $album_code)
{
	$keys = array(
		"al.albumID",
		"r.binAbbr AS rotation",
		"ar.artist_name",
		"al.album_name",
		"la.label"
	);

	$q = "SELECT " . implode(",", $keys) . " FROM `libalbum` AS al "
		. "INNER JOIN `libartist` AS ar ON ar.artistID=al.artistID "
		. "INNER JOIN `liblabel` AS la ON la.labelID=al.labelID "
		. "INNER JOIN `def_rotations` AS r ON r.rotationID=al.rotationID "
		. "WHERE al.album_code = '$album_code';";
	$album = exec_query($mysqli, $q)->fetch_assoc();

	return $album;
}

/**
 * Get information about a track.
 *
 * @param mysqli
 * @param albumID
 * @param disc_num
 * @param track_num
 * @return associative array of track
 */
function get_track($mysqli, $albumID, $disc_num, $track_num)
{
	$keys = array(
		"al.album_code",
		"t.disc_num",
		"t.track_num",
		"r.binAbbr AS rotation",
		"t.track_name",
		"t.airabilityID",
		"ar.artist_name",
		"al.album_name",
		"la.label"
	);

	$q = "SELECT " . implode(",", $keys) . " FROM `libtrack` AS t "
		. "INNER JOIN `libalbum` AS al ON al.albumID=t.albumID "
		. "INNER JOIN `libartist` AS ar ON ar.artistID=al.artistID "
		. "INNER JOIN `liblabel` AS la ON la.labelID=al.labelID "
		. "INNER JOIN `def_rotations` AS r ON r.rotationID=al.rotationID "
		. "WHERE t.albumID = '$albumID' "
		. "AND t.disc_num = '$disc_num' AND t.track_num = '$track_num';";
	$track = exec_query($mysqli, $q)->fetch_assoc();

	return $track;
}

/**
 * Log a track in the logbook.
 *
 * @param mysqli
 * @param showID
 * @param track
 */
function log_track($mysqli, $showID, $track)
{
	// log track
	$q = "INSERT INTO `logbook` SET "
		. "showID = '$showID', "
		. "lb_album_code = '$track[album_code]', "
		. "lb_disc_num = '$track[disc_num]', "
		. "lb_track_num = '$track[track_num]', "
		. "lb_rotation = '$track[rotation]', "
		. "lb_track_name = '$track[track_name]', "
		. "lb_artist = '$track[artist_name]', "
		. "lb_album = '$track[album_name]', "
		. "lb_label = '$track[label]', "
		. "played = 1;";
	exec_query($mysqli, $q);

	// update now playing
	$q = "UPDATE `now_playing` SET "
		. "logbookID = LAST_INSERT_ID(), "
		. "lb_track_name = '$track[track_name]', "
		. "lb_artist_name = '$track[artist_name]';";
	exec_query($mysqli, $q);

	// TODO: send RDS
}
?>
