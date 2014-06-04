<?php foreach($articles as $id => $article){ ?>
    <li>
        <a href="/articles/<?= $article->getId() ?>"><?= $article->getName() ?></a>
    </li><br/>
<?php } ?>