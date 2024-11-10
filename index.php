<?php

if(isset($_SESSION['username'])){
	session_destroy();
	echo '<script>window.location="auth/"</script>';
}
else
{
	
	echo '<script>window.location="auth/"</script>';
}

?>