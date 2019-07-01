<?php
$no_of_records_per_page = 5;
$query = "SELECT * FROM posts";
$statement = $pdo->prepare($query);
$statement->execute();		
$post = $statement->fetchAll(PDO::FETCH_ASSOC);
$row_count = $statement->rowCount();
$total_pages = ceil($row_count / $no_of_records_per_page);

if (isset($_GET['pageno'])) {
	$pageno = $_GET['pageno'];
	if ($pageno <= 0)
		$pageno = 1;
	else if ($pageno > $total_pages)
		$pageno = $total_pages;
} else {
	$pageno = 1;
}
$offset = ($pageno - 1) * $no_of_records_per_page;
?>
