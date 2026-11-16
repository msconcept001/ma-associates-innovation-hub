<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle='Our Programmes';
$programs=db()->query("SELECT * FROM programs WHERE status='Active' ORDER BY id DESC")->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero"><div class="wrap"><span class="eyebrow">LEARNING • EVENTS • DEVELOPMENT</span><h1>Our programmes</h1><p>Activities designed to turn knowledge and collaboration into practical impact.</p></div></section>
<section class="section wrap"><div class="card-grid">
<?php if($programs): foreach($programs as $p): ?><article class="content-card"><span class="card-kicker">HUB PROGRAMME</span><h3><?=e($p['title'])?></h3><p><?=nl2br(e($p['description']))?></p></article><?php endforeach; else: ?>
<article class="content-card"><span class="card-kicker">01 / DIGITAL</span><h3>Digital skills training</h3><p>Digital literacy, computer skills and practical technology training.</p></article>
<article class="content-card"><span class="card-kicker">02 / YOUTH</span><h3>Youth empowerment</h3><p>Leadership, employability, entrepreneurship and personal development.</p></article>
<article class="content-card"><span class="card-kicker">03 / EDUCATION</span><h3>Education technology</h3><p>Technology awareness and solutions that support schools and educators.</p></article>
<article class="content-card"><span class="card-kicker">04 / EVENTS</span><h3>Summits and conferences</h3><p>Knowledge-sharing events, workshops and stakeholder engagement.</p></article>
<?php endif; ?></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>