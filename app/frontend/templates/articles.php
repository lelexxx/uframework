<!DOCTYPE HTML>
<html>
	<head>
		<title>Article list</title>
	</head>
	
	<body>
		<ul>
			<?php foreach($articles as $id => $article){ ?>
				<li>
					<a href="/articles/<?= $article->getId() ?>"><?= $article->getName() ?></a>
				</li><br/>
			<?php } ?>
		</ul>
	</body>
</html>
