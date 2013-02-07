<!DOCTYPE HTML>
<html>
	<head>
		<title>A location</title>
	</head>
	<body>
		<?= $location->getName(); ?>
		
		<form action="/locations/<?= $location->getId();  ?>" method="post">
			<input type="hidden" name="locationId" value="<?= $location->getId(); ?>"/>
			<input type="hidden" name="_method" value="PUT">
			<input type="text" name="locationName" value="<?= $location->getName(); ?>"/>
			<input type="submit" value="Update it" />
		</form>
		
		<?php foreach($location->getComments() as $id => $comment){ ?>
			<li>
				<?= $comment->getUserName()." : ".$comment->getBody() ?>
			</li><br/>
		<?php } ?>
		
		<form action="/comments" method="post">
			<input type="hidden" name="locationId" value="<?= $location->getId(); ?>"/>
			<input type="text" name="userName" /><br />
			<textarea name="commentBody" /></textarea>
			<input type="submit" value="Add it" />
		</form>
		
		<a href="/locations">Back</a>
	</body>
</html>
