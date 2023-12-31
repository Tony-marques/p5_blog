<div class="main-container">
    <div class="block">
        <div class="article-one">
            <div class="main-article">
                <h2><?= htmlspecialchars(html_entity_decode($article->getTitle())) ?></h2>
                <p class="chapo"><?= nl2br(htmlspecialchars(html_entity_decode($article->getChapo(), ENT_QUOTES, 'UTF-8'))) ?></p>
                <p class="content"><?= nl2br(htmlspecialchars(html_entity_decode($article->getContent(), ENT_QUOTES, 'UTF-8'))) ?></p>
            </div>
            <div class="separator"></div>
            <div class="informations">
                <div class="article-author">
                    <?php if (!empty($article->getUser()->getAvatar())): ?>
                        <img class="article-author-picture"
                             src="/uploads/profile/<?= $article->getUser()->getAvatar() ?>" alt="profile picture">
                    <?php endif; ?>
                    <p>Ecrit par <span
                                class="name-author"><?= htmlspecialchars(ucfirst($article->getUser()->getFirstname())) ?> <?= htmlspecialchars(strtoupper(substr($article->getUser()->getLastname(), 0, 1))) . "." ?></span>
                    </p>
                </div>
                <div class="date">
                    <?php if (strtotime($article->getCreatedAt()) === strtotime($article->getUpdatedAt())) : ?>
                        <p>Ecrit le <?= date('d/m/Y à H:i:s', strtotime($article->getCreatedAt())) ?></p>
                    <?php endif; ?>

                    <?php if (strtotime($article->getCreatedAt()) < strtotime($article->getUpdatedAt())) : ?>
                        <p>Modifié le <?= date('d/m/Y à H:i:s', strtotime($article->getUpdatedAt())) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if (isset($_SESSION["user"])): ?>

            <?php if ($article->getUserId() == $_SESSION["user"]["id"]
                || $isAdmin
            ) : ?>
                <a href="/article/edition/<?= $article->getId() ?>" class="button button-primary">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span class="ml-10">Modifier</span>
                </a>
            <?php endif; ?>

            <?php if ($article->getUserId() == $_SESSION["user"]["id"]
                || $isAdmin
            ) : ?>
                <a href="/article/suppression/<?= $article->getId() ?>" class="button button-danger ml-10">
                    <i class="fa-solid fa-trash"></i>
                    <span class="ml-10">Supprimer</span>
                </a>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="block">
        <?php if (isset($_SESSION["user"])) : ?>
            <?= $commentForm ?>
        <?php else : ?>
            <p>Veuillez vous connecter pour écrire un commentaire</p>
        <?php endif; ?>
        <div class="comment-container">

            <?php if (!$isAdmin) : ?>

                <p> <?= $countValidateComments ?>
                    commentaire<?= $countValidateComments > 1 ? "s" : "" ?></p>
                <?php foreach ($article->getComment() as $key => $comment) : ?>
                    <?php if ($article->getComment()[$key]->getPublished() == true): ?>
                        <div class="comment">
                            <p><?= nl2br(htmlspecialchars($comment->getContent())) ?></p>
                            <div class="separator"></div>
                            <div class="informations">
                                <div class="people">
                                    <span><?= htmlspecialchars(ucfirst($comment->getUser()->getFirstname())) ?></span>
                                    <span><?= htmlspecialchars(substr(strtoupper($comment->getUser()->getLastname()), 0, 1)) . "." ?></span>
                                    <span>le <?= date("d/m/Y", strtotime($comment->getCreatedAt())) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <p> <?= count($article->getComment()) ?>
                    commentaire<?= count($article->getComment()) > 1 ? "s" : "" ?></p>

                <?php foreach ($article->getComment() as $comment) : ?>
                    <div class="comment">
                        <p><?= nl2br(htmlspecialchars($comment->getContent())) ?></p>
                        <div class="separator"></div>
                        <div class="informations">
                            <div class="people">
                                <span><?= htmlspecialchars(ucfirst($comment->getUser()->getFirstname())) ?></span>
                                <span><?= htmlspecialchars(substr(strtoupper($comment->getUser()->getLastname()), 0, 1)) . "." ?></span>
                                <span>le <?= date("d/m/Y", strtotime($comment->getCreatedAt())) ?></span>
                            </div>
                            <div class="buttons">

                                <a href="/commentaire/suppression/<?= $comment->getId() ?>"
                                   class="button button-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                                <?php if ($comment->getPublished() == 0) : ?>
                                    <a href="/commentaire/validation/<?= $comment->getId() ?>"
                                       class="button button-primary ml-10">
                                        <i class="fa-solid fa-check"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>