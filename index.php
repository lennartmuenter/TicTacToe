<?php
session_start();

$_SESSION = handlePost();
function handlePost(){
	if(isset($_POST["resetfields"])) {
		resetfields();
	}if(isset($_POST["o"])) {
		$_SESSION['player'] = 'o';
	}if(isset($_POST["x"])) {
		$_SESSION['player'] = 'x';
	}if(isset($_POST["n"])) {
		$_SESSION['mode'] = 'n';
	}if(isset($_POST["b"])) {
		$_SESSION['mode'] = 'b';
	}if(isset($_POST["start"])) {
		$_SESSION['fields'] = [[0,0,0], [0,0,0], [0,0,0]];
	}
	return $_SESSION;
}


if(isset($_SESSION['player']))	{$player = 	$_SESSION['player'];} 	else {$player = null;}
if(isset($_SESSION['mode']))	{$mode = 	$_SESSION['mode'];} 	else {$mode = null;}
if(isset($_SESSION['fields']))	{$fields = 	$_SESSION['fields'];} 	else {$fields = null;}
if(isset($_SESSION['moves']))	{$moves = 	$_SESSION['moves'];} 	else {$moves = null;}

$moves = [0,0,0,0,0,0];

$fields = updateBoard($fields, $player);
function updateBoard($fields, $player){
	$k = 0;
	for($i = 0; $i < 3; $i++){
		for($j = 0; $j < 3; $j++){
			if(isset($_POST["$k"])) {
				$fields[$i][$j] = $player;
				$_SESSION['fields'] = $fields;
			}
			$k++;
		}
	}
	return $fields;
}
if($player == null || $mode == null || $fields == null){
	$game = setup($player, $mode);
} else {
	$fields = has_winner($moves, $fields);
	$game = build($fields);
}

//print_r($fields);

function build($fields){
	$cross = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>';
	$circle = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
	$won = 'bg-green-200';
	$aftercontent = '</form><form method="post" class="mb-0 pt-10"><input name="resetfields" type="submit" value="reset" class="inline-flex items-center justify-center rounded-md border border-transparent bg-gray-600 w-20 h-10 text-base font-medium text-white hover:bg-black"/></form>';
	$game = '<form method="post" class="mb-0 grid grid-rows-3 grid-flow-col gap-5">';
	$i = 0;
	$input = '<input name="0" type="submit" value="" class="h-20 w-20"/>';

	foreach($fields as $rows){
		foreach($rows as $cols){
			$content = '';
			$color = 'bg-gray-100';
			switch($cols){
				case 'x':
					$content = $cross;
					break;
				case 'o':
					$content = $circle;
					break;
				case '1x':
					$content = $cross;
					$color = $won;
					break;
				case '1o':
					$content = $circle;
					$color = $won;
					break;
				case 'Q':
					break;
				default:
					$content = $input;
					$color .= ' hover:bg-gray-200';
			}
			$i++;
			$input = '<input name="'.$i.'" type="submit" value="" class="h-20 w-20"/>';
			$box = '<div class="box-border h-20 w-20 rounded-lg '.$color.' shadow-inner grid place-content-center p-3">'.$content.'</div>';
			$game .= $box;
		}
	}
	$game .= $aftercontent;
	return $game;
}

function setup($player, $mode){
	$game = '<h3 class="text-2xl tracking-tight text-gray-900 pb-5">settings</h3><form method="post" class="mb-0 grid grid-cols-2 gap-5">';
	$aftergame = '</form><form method="post" class="mb-0 pt-10"><input name="start" type="submit" value="start" class="inline-flex items-center justify-center rounded-md border border-transparent bg-gray-600 w-20 h-10 text-base font-medium text-white hover:bg-black"/></form>';
	$color = 'bg-gray-200';
	$cross = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-translate-y-20 w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>';
	$circle = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-translate-y-20 w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
	$human = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-translate-y-20 w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>';
	$bot = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-translate-y-20 w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>';
	if($player == 'o'){
		$color = 'bg-green-200';
	}
	$game .= '<div class="box-border h-20 w-20 rounded-lg '.$color.' shadow-inner grid place-content-center p-3"><lable class="h-20 w-20 p-3"><input name="o" type="submit" value="" class="relative z-10 h-20 w-20 -translate-y-3 -translate-x-3"/>'.$circle.'</lable></div>';
	$color = 'bg-gray-200';
	if($player == 'x'){
		$color = 'bg-green-200';
	}
	$game .= '<div class="box-border h-20 w-20 rounded-lg '.$color.' shadow-inner grid place-content-center p-3"><lable class="h-20 w-20 p-3"><input name="x" type="submit" value="" class="relative z-10 h-20 w-20 -translate-y-3 -translate-x-3"/>'.$cross.'</lable></div>';
	$color = 'bg-gray-200';
	
	if($mode == 'n'){
		$color = 'bg-green-200';
	}
	$game .= '<div class="box-border h-20 w-20 rounded-lg '.$color.' shadow-inner grid place-content-center p-3"><lable class="h-20 w-20 p-3"><input name="n" type="submit" value="" class="relative z-10 h-20 w-20 -translate-y-3 -translate-x-3"/>'.$human.'</lable></div>';
	$color = 'bg-gray-200';
	if($mode == 'b'){
		$color = 'bg-green-200';
	}
	$game .= '<div class="box-border h-20 w-20 rounded-lg '.$color.' shadow-inner grid place-content-center p-3"><lable class="h-20 w-20 p-3"><input name="b" type="submit" value="" class="relative z-10 h-20 w-20 -translate-y-3 -translate-x-3"/>'.$bot.'</lable></div>';
	$color = 'bg-gray-200';
	
	
	$game .= $aftergame;
	return $game;
}

function resetsession(){
	session_destroy();
	header("Refresh:0");
}
function resetfields(){
	unset($_SESSION['fields']);
}

function has_winner($moves, $fields){
	if($moves == null){
		return $fields;
	} else if(count($moves) < 5){
		return $fields;
	}
	$has_winner = false;
	for($i = 0; $i < 3; $i++){
		if($fields[$i][0] && $fields[$i][1] && $fields[$i][2] == 'x'){
			$fields[$i][0] = $fields[$i][1] = $fields[$i][2] = '1x';
			$has_winner = true;
		}else if ($fields[$i][0] && $fields[$i][1] && $fields[$i][2] == 'o'){
			$fields[$i][0] = $fields[$i][1] = $fields[$i][2] = '1o';
			$has_winner = true;
		}
	}
	for($i = 0; $i < 3; $i++){
		if($fields[0][$i] && $fields[1][$i] && $fields[2][$i] == 'x'){
			$fields[0][$i] = $fields[1][$i] = $fields[2][$i] = '1x';
			$has_winner = true;
		}else if($fields[0][$i] && $fields[1][$i] && $fields[2][$i] == 'o'){
			$fields[0][$i] = $fields[1][$i] = $fields[2][$i] = '1o';
			$has_winner = true;
		}
	}
	if($fields[0][0] && $fields[1][1] && $fields[2][2] == 'x'){
		$fields[0][0] = $fields[1][1] = $fields[2][2] = '1x';
		$has_winner = true;
	} else if($fields[0][0] && $fields[1][1] && $fields[2][2] == 'o'){
		$fields[0][0] = $fields[1][1] = $fields[2][2] = '1o';
		$has_winner = true;
	}
	if($fields[0][2] && $fields[1][1] && $fields[2][0] == 'x'){
		$fields[0][2] = $fields[1][1] = $fields[2][0] = '1x';
		$has_winner = true;
	} else if($fields[0][2] && $fields[1][1] && $fields[2][0] == 'o'){
		$fields[0][2] = $fields[1][1] = $fields[2][0] = '1o';
		$has_winner = true;
	}
	
	if($has_winner == true){
		$fields = disable_game($fields);
	}

	return $fields;
}
function disable_game($fields){
	for($i = 0; $i < 3; $i++){
		for($j = 0; $j < 3; $j++){
			if($fields[$i][$j] == 0){
				$fields[$i][$j] = 'Q';
			}
		}
	}
	return $fields;
}

function html($game){
	$html = '
		<!DOCTYPE html>
		<html>
		<head>
		<title>TicTacToe</title>
		<script src="https://cdn.tailwindcss.com"></script>
		</head>
		<body>

		<div class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-gray-600">
		  	<div class="relative bg-white p-10 shadow-xl ring-1 ring-gray-900/5 mx-auto max-w-lg rounded-lg">
		    	<div class="mx-auto max-w-md">
					<h2 class="text-4xl font-bold tracking-tight text-gray-900 pb-10">TicTacToe</h2>
			
						'.$game.'
			
				</div>
			</div>
		</div>

		</body>
		</html>	
	';
	return $html;
}

echo html($game);
/*
if($mode == 'n'){
	if($player == 'x'){
		$_SESSION['player'] = 'o';
		$player = 'o';
	} else {
		$_SESSION['player'] = 'x';
		$player = 'x';
	}
}*/