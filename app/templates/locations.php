<!DOCTYPE HTML>
<html>
	<head>
		<title>Locations list</title>
	</head>
	<body>
		<ul>
			<?php foreach($locations as $id => $location){ ?>
				<li>
					<a href="/locations/<?= $id ?>"><?= $location //$location->getName() ?></a>
					<form action="/locations/<?= $id ?>" method="post">
						<input type="hidden" name="_method" value="DELETE">
						<input type="hidden" name="_id" value="<?= $id ?>">
						<input type="submit" value="Delete it" />
					</form>
				</li><br/>
			<?php } ?>
		</ul>
		
		<form action="/locations" method="post">
			<input type="hidden" name="_method" value="POST">
			<input type="text" name="locationName" />
			<input type="submit" value="Create it" />
		</form>
	</body>
</html>
