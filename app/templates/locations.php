<!DOCTYPE HTML>
<html>
	<head>
		<title>Locations list</title>
	</head>
	<body>
		<ul>
			<?php foreach($locations as $id => $location){ ?>
				<li>
					<a href="/locations/<?= $location->getId() ?>"><?= $location->getName() ?></a>
					<form action="/locations/<?= $location->getId() ?>" method="post">
						<input type="hidden" name="_method" value="DELETE">
						<input type="hidden" name="_id" value="<?= $location->getId() ?>">
						<input type="submit" value="Delete it" />
					</form>
				</li><br/>
			<?php } ?>
		</ul>
		
		<form action="/locations" method="post">
			<input type="text" name="locationName" />
			<input type="submit" value="Create it" />
		</form>
	</body>
</html>
