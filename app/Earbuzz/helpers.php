<?php

function errors_for($attribute, $errors)
{
	return $errors->first($attribute, '<span class="error">:message</span>');
}

function link_to_profile($text = 'Profile')
{
	return link_to_route('profile', $text, Auth::user()->username);
}

function link_to_artist($text = 'Artist')
{
	return link_to_route('profile', $text, $artist->name);
}

function validate_file_extensions($tracks, $ext)
{
	foreach($tracks as $track)
	{
		if($ext !== $track->getClientOriginalExtension())
			return false;
	}
	return true;
}

// function arr2obj($arr)
// {
// 	if(gettype($arr) === 'array')
// 	{
// 		foreach($arr as )
// 	}
// }