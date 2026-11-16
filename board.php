<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = 'Board of Trustees';
$people = db()->query("SELECT * FROM governors WHERE status='Active' ORDER BY sort_order ASC, id ASC")->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
  <div class="wrap">
    <span class="eyebrow">LEADERSHIP &amp; GOVERNANCE</span>
    <h1>Board of Trustees</h1>
    <p>Meet the people providing guidance, oversight and strategic direction for M &amp; Associates Innovation Hub.</p>
  </div>
</section>
<section class="section wrap">
  <div class="section-heading">
    <div><span class="eyebrow">OUR LEADERSHIP</span><h2>Guided by purpose. Driven by impact.</h2></div>
  </div>
  <div class="people-grid people-grid-large">
    <?php if ($people): foreach ($people as $person): ?>
      <article class="person-card person-card-large">
        <?php if (!empty($person['photo_path'])): ?>
          <img src="<?=e($person['photo_path'])?>" alt="Portrait of <?=e($person['full_name'])?>" class="trustee-photo" loading="lazy">
        <?php else: ?>
          <div class="avatar"><?=e(strtoupper(substr($person['full_name'], 0, 1)))?></div>
        <?php endif; ?>
        <h3><?=e($person['full_name'])?></h3>
        <p class="person-role"><?=e($person['position'])?></p>
        <?php if (!empty($person['bio'])): ?><p class="person-bio"><?=nl2br(e($person['bio']))?></p><?php endif; ?>
      </article>
    <?php endforeach; else: ?>
      <p class="empty-note">Trustee profiles will appear here once they are added through the administration dashboard.</p>
    <?php endif; ?>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
