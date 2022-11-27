<?php
session_start();
$fields = [0,0,0, 0,0,0, 0,0,0];
if($_SESSION["fields"] != null){
	$fields = $_SESSION["fields"];
}
if($_SESSION['user'] == null){
	$user = 1;
} else {
	$user = $_SESSION['user'];
}


if($_SESSION['user'] == 2){
	$bot = 1;
} else{
	$bot = 2;
}


$crossbox = '<div class="box-border h-20 w-20 rounded-lg bg-gray-100 shadow-inner grid place-content-center p-3"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></div>';
$circlebox = '<div class="box-border h-20 w-20 rounded-lg bg-gray-100 shadow-inner grid place-content-center p-3"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>';
$content = '';
$emptybox = '<div class="box-border h-20 w-20 rounded-lg bg-gray-100 shadow-inner grid place-content-center p-3"></div>';
$box = 'type="submit" value="" class="box-border h-20 w-20 rounded-lg bg-gray-100 hover:bg-gray-200 shadow-inner grid place-content-center p-3"/>';
$wcross = '<div class="box-border h-20 w-20 rounded-lg bg-green-200 shadow-inner grid place-content-center p-3"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></div>';
$wcircle = '<div class="box-border h-20 w-20 rounded-lg bg-green-200 shadow-inner grid place-content-center p-3"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>';

$i = 0;
$mode = 0;

for($a = 0; $a <= 9; $a++){
	if(isset($_POST["$a"])) {
		$fields[$a] = $user;
		if($mode == 0){
			$fields = bot($fields, $bot, $user);
		} else {
			if($user == 1){
				$_SESSION['user'] = 2;
			} else if($user == 2){
				$_SESSION['user'] = 1;
			}
		}
		$fields = win($fields);
		$_SESSION["fields"] = $fields;
	}
}
function buildfield(){
	
}
if(isset($_POST["reset"])) {
	session_destroy();
	$fields = [0,0,0, 0,0,0, 0,0,0];
}
function win($fields){
	$over = false;
	for($c = 0; $c < 7; $c+=3){
		if($fields[0+$c] != 0 && $fields[0+$c] == $fields[1+$c] && $fields[1+$c] == $fields[2+$c]){
			$fields[0+$c] =$fields[1+$c]=$fields[2+$c]= winner($fields[0+$c]);
			$over = true;
		}
	}
	for($c = 0; $c < 3; $c++){
		if($fields[0+$c] != 0 && $fields[0+$c] == $fields[3+$c] && $fields[3+$c] == $fields[6+$c]){
			$fields[0+$c] =$fields[3+$c]=$fields[6+$c]= winner($fields[0+$c]);
			$over = true;
		}
	}
	if($fields[0] != 0 && $fields[0] == $fields[4] && $fields[4] == $fields[8]){
		$fields[0] = $fields[4] = $fields[8] = winner($fields[0]);
		$over = true;
	} else if($fields[2] != 0 && $fields[2] == $fields[4] && $fields[4] == $fields[6]){
		$fields[2] = $fields[4] = $fields[6] = winner($fields[2]);
		$over = true;
	}
	
	if($over == true){
		for($x = 0; $x < 9; $x++){
			if($fields[$x]==0){
				$fields[$x]=3;
			}
		}
	}
	return $fields;
}
function winner($field){
	if($field == 1){
		return 4;
	} else {
		return 5;
	}
}

function bot($fields, $bot, $user){
	$a = $fields[0];
	$b = $fields[1];
	$c = $fields[2];
	$d = $fields[3];
	$e = $fields[4];
	$f = $fields[5];
	$g = $fields[6];
	$h = $fields[7];
	$j = $fields[8];
	
	if($e== 0){
		$e = $bot;
	} else if($a && $c == $user && $b == 0){
		$b = $bot;
	} else if($g && $j == $user && $h == 0){
		$h = $bot;
	} else if($a && $g == $user && $d == 0){
		$d = $bot;
	} else if($c && $j == $user && $f == 0){
		$f = $bot;
	} else if($e == $user && $g == 0){
		$g = $bot;
	}
	

	$fields[0] = $a;
	$fields[1] = $b;
	$fields[2] = $c;
	$fields[3] = $d;
	$fields[4] = $e;
	$fields[5] = $f;
	$fields[6] = $g;
	$fields[7] = $h;
	$fields[8] = $j;
	return $fields;
}


foreach($fields as $field){
	if($field == 1){
		$content .= $crossbox;
	} else if ($field == 2){
		$content .= $circlebox;
	} else if($field == 3){
		$content .= $emptybox;
	} else if($field == 4){
		$content .= $wcross;
	} else if($field == 5){
		$content .= $wcircle;
	} else {
		$content .= "<input name='$i' ".$box;
	}
	$i++;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>TicTacToe</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-gray-600 py-6 sm:py-12">
  	<div class="relative bg-white p-10 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10">
    	<div class="mx-auto max-w-md">
			<h2 class="text-3xl font-bold tracking-tight text-gray-900 text-4xl pb-10">TicTacToe</h2>
			<form method="post" class="mb-0 grid grid-rows-3 grid-flow-col gap-4">
				<?php echo $content;?>
			</form>
			<form method="post" class="mb-0 pt-10">
				<input name="reset" type="submit" value="reset" class="inline-flex items-center justify-center rounded-md border border-transparent bg-gray-600 w-20 h-10 text-base font-medium text-white hover:bg-black"/>
			</form>
		</div>
	</div>
</div>

</body>
</html>	