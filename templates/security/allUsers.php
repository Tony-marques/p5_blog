<div class="main-container users">

  <table>
    <thead>
      <tr>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Adresse email</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $user) : ?>
        <tr>
          <td><?= $user->getFirstname() ?></td>
          <td><?= $user->getLastname() ?></td>
          <td><?= $user->getEmail() ?></td>
          <td class="table-button">
            <a href="/profil/edition/<?= $user->getId() ?>" class="button button-primary">Modifier</a>
            <a href="/utilisateur/suppression/<?= $user->getId() ?>" class="button button-primary-stroke">Supprimer</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>