<div class="main-container comments">
    <?php foreach ($articles as $article) : ?>
        <?php foreach ($article->getComment() as $key => $comment): ?>
            <?php if ($comment->getPublished() == false): ?>
                <div class="article-comment">
                    <div class="article">
                        <div class="main-article">
                            <h2><?= htmlspecialchars($article->getTitle()) ?></h2>
                            <p class="content"><?= nl2br(html_entity_decode($article->getContent(), ENT_QUOTES, 'UTF-8')) ?></p>
                        </div>
                        <div class="separator"></div>
                        <div class="informations">
                            <div class="article-author">
                                <img class="article-author-picture"
                                     src="/uploads/profile/<?= $article->getUser()->getAvatar() ?>"
                                     alt="profile picture">
                                <p>Ecrit par <span
                                            class="name-author"><?= htmlspecialchars(ucfirst($article->getUser()->getFirstname())) ?>
                                        <?= htmlspecialchars(substr(ucfirst($article->getUser()->getLastname()), 0, 1)) . "." ?>
                                </span></p>
                            </div>
                            <div class="date">
                                <?php if (date('d/m/Y à H:i:s', strtotime($article->getCreatedAt())) == date('d/m/Y à H:i:s', strtotime($article->getUpdatedAt()))) : ?>
                                    <p>Ecrit le <?= date('d/m/Y à H:i:s', strtotime($article->getCreatedAt())) ?></p>
                                <?php endif; ?>

                                <?php if (date('d/m/Y à H:i:s', strtotime($article->getCreatedAt())) < date('d/m/Y à H:i:s', strtotime($article->getUpdatedAt()))) : ?>
                                    <p>Modifié le <?= date('d/m/Y à H:i:s', strtotime($article->getUpdatedAt())) ?></p>
                                <?php endif; ?>
                            </div>


                        </div>
                    </div>
                    <div class="comment-body">
                        <p><?= $comment->getContent() ?></p>
                        <div class="separator"></div>
                        <div class="comment-group">
                            <p>
                                <?= htmlspecialchars(ucfirst($comment->getUser()->getFirstname())) ?>
                                <?= htmlspecialchars(substr(strtoupper($comment->getUser()->getlastname()), 0, 1)) . "." ?>
                                le <?= date("d/m/Y", strtotime($comment->getCreatedAt())) ?>

                            </p>
                            <div class="button-group">
                                <a href="/commentaire/validation/page/<?= $comment->getId() ?>"
                                   class="button button-primary">Valider</a>
                                <a href="/commentaire/suppression/page/<?= $comment->getId() ?>"
                                   class="button button-danger">Supprimer</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>