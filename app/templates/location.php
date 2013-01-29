<!DOCTYPE HTML>
<html>
	<head>
		<title>A location</title>
	</head>
	<body>
		<?= $location //$location->getName(); ?>
		
		<form action="/locations/<?= $id //$location->getId();  ?>" method="post">
			<input type="hidden" name="locationId" value="<?= $id //$location->getId(); ?>"/>
			<input type="hidden" name="_method" value="PUT">
			<input type="text" name="locationName" value="<?= $location //$location->getName(); ?>"/>
			<input type="submit" value="Update it" />
		</form>
		
		<a href="/locations">Back</a>
	</body>
</html>
