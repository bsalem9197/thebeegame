<?php
session_start();
/**
 * Class autoloader
 * @param string $class
 */
function __autoload($class)
{
	require realpath(dirname(__FILE__)) . '/src/' . str_replace('\\', '/', (string)$class) . '.php';
}
?>
<!DOCTYPE html>
<html>
	<body>
<?php
use Manager\Game;
if (isset($_SESSION['game']) && !(isset($_REQUEST['reset']) && $_REQUEST['reset'])) {
	$game = unserialize($_SESSION['game']);
} else {
	$game = new Game();
}
echo "<h1>ROUND ".$game->getRound()."</h1>";
if (isset($_POST) && isset($_POST['hit'])) {
	if (isset($_REQUEST['position']) && $_REQUEST['position'] !== '') {
		$position = (int)$_REQUEST['position']-1;
	} else {
		$position = null;
	}
	$story = $game->play();
	echo "<pre>$story</pre>";
	if ($game->isDead()) {
		echo "<h2>Game Over. Press Hit to start a new game...</h2>";

		 header("location:restart.php");

		$game = new Game();
	}
	$_SESSION['game'] = serialize($game);
}
?>
<hr/>
<form id="hitForm" action="index.php" method="POST">
    
    <br/>

    <label for="reset">Force Hitting bee number </label> :
	<select id="position" name="position">
		<option value="">Random</option>
		<?php foreach ($game->getBees() as $pos => $bee) : ?>
			<option value="<?=$pos;?>"><?="#$pos {$bee->getClass(1)} ({$bee->getCurrentHP()} / {$bee::$MAX_HP}";?></option>
		<?php endforeach ?>
		</select>

    <br/>

	

   <input name="hit" type="submit" value="Hit !">


</form>

 
<?php
if (isset($_REQUEST['debug']) && $_REQUEST['debug']) {
	echo "Debug game : ";
	var_dump("game new status :", $game);
}
?>
	</body>
</html>