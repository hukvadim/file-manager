<?php
	defined('security') or die('Access denied'); // Add light protection against file access

	// HTML site footer
	include 'block--footer.php';
?>

<?php unset($_SESSION['answer']); // Errors, we will output in an array $_SESSION['answer'] and it must be shown once  ?>
</body>
</html>