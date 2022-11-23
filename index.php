<?php
session_start();
$fields = [0,0,0, 0,0,0, 0,0,0];
$game = build($fields);

function build($fields){
	$input = '<input name="test" type="submit" value="" class="h-20 w-20"/>';
	$cross = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>';
	$circle = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
	$won = 'bg-green-200';

	$game = '';
	foreach($fields as $field){
		$content = '';
		$color = 'bg-gray-100';
		switch($field){
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
		$box = '<div class="box-border h-20 w-20 rounded-lg '.$color.' shadow-inner grid place-content-center p-3">'.$content.'</div>';
		$game .= $box;
	}
	return $game;
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
				<?php echo $game;?>
			</form>
			<form method="post" class="mb-0 pt-10">
				<input name="reset" type="submit" value="reset" class="inline-flex items-center justify-center rounded-md border border-transparent bg-gray-600 w-20 h-10 text-base font-medium text-white hover:bg-black"/>
			</form>
		</div>
	</div>
</div>

</body>
</html>	