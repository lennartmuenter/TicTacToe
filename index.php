<?php
$fields = [0,0,0, 0,0,0, 0,0,0];
$user = 2;


$crossbox = '<div class="box-border h-20 w-20 rounded-lg bg-gray-100 shadow-inner grid place-content-center p-3"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></div>';
$circlebox = '<div class="box-border h-20 w-20 rounded-lg bg-gray-100 shadow-inner grid place-content-center p-3"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>';
$content = '';

$box = 'type="submit" class="box-border h-20 w-20 rounded-lg bg-gray-100 shadow-inner grid place-content-center p-3"/>';

$i = 0;

for($a = 0; $a <= 9; $a++){
	if(isset($_POST["$a"])) {$fields[$a] = $user;}
}


foreach($fields as $field){
	if($field == 1){
		$content .= $crossbox;
	} else if ($field == 2){
		$content .= $circlebox;
	} else {
		$content .= "<input name='$i' ".$box;
	}
	$i++;
}

$html = '
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
					<form method="post" class="grid grid-rows-3 grid-flow-col gap-4">
						'.$content.'
					</form>
			</div>
		</div>
	</div>

	</body>
	</html>	
';

echo $html;
?>