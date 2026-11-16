<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = 'Home';
$programs = db()->query("SELECT * FROM programs WHERE status='Active' ORDER BY id DESC LIMIT 3")->fetchAll();
$governors = db()->query("SELECT * FROM governors WHERE status='Active' ORDER BY sort_order ASC, id ASC LIMIT 3")->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <div class="hero-copy">
    <span class="eyebrow">INNOVATION • COMMUNITY • OPPORTUNITY</span>
    <h1>Innovating today.<br><em>Transforming tomorrow.</em></h1>
    <p>We empower young people, communities, schools and businesses through innovation, technology, learning and collaboration.</p>
    <div class="hero-actions">
      <a class="btn btn-gold" href="register.php">Become a member</a>
      <a class="btn btn-outline-light" href="about.php">Discover our work</a>
    </div>
  </div>
  <div class="hero-panel">
    <div class="hero-mark">M<span>&</span>A</div>
    <p class="hero-panel-title">M & ASSOCIATES<br>INNOVATION HUB</p>
    <p class="hero-panel-sub">Ideas into impact.</p>
  </div>
</section>
<section class="stats wrap">
  <div><strong>01</strong><span>Innovation-led</span></div>
  <div><strong>02</strong><span>Community-focused</span></div>
  <div><strong>03</strong><span>Youth-empowering</span></div>
</section>
<section class="section wrap">
  <div class="section-heading"><div><span class="eyebrow">WHO WE ARE</span><h2>Ideas grow when people work together.</h2></div><a class="text-link" href="about.php">More about us →</a></div>
  <p class="lead">M & Associates Innovation Hub is a platform for people and organisations to connect, learn, create solutions and contribute to positive community development.</p>
  <div class="feature-grid">
    <article class="feature-card"><span class="feature-icon">✦</span><h3>Digital skills</h3><p>Practical learning that helps people participate in the digital economy.</p></article>
    <article class="feature-card"><span class="feature-icon">⌘</span><h3>Innovation</h3><p>Encouraging creative thinking, entrepreneurship and useful technology.</p></article>
    <article class="feature-card"><span class="feature-icon">◎</span><h3>Community impact</h3><p>Building partnerships that support schools, businesses and communities.</p></article>
  </div>
</section>
<section class="section section-soft">
  <div class="wrap">
    <div class="section-heading"><div><span class="eyebrow">WHAT WE DO</span><h2>Our programmes</h2></div><a class="text-link" href="programs.php">View all programmes →</a></div>
    <div class="card-grid">
      <?php if ($programs): foreach ($programs as $p): ?>
        <article class="content-card"><span class="card-kicker">PROGRAMME</span><h3><?= e($p['title']) ?></h3><p><?= e($p['description']) ?></p></article>
      <?php endforeach; else: ?>
        <article class="content-card"><span class="card-kicker">01 / LEARNING</span><h3>Digital skills and capacity building</h3><p>Training and practical learning opportunities for young people and communities.</p></article>
        <article class="content-card"><span class="card-kicker">02 / EVENTS</span><h3>Conferences and innovation events</h3><p>Bringing people together to exchange ideas and build partnerships.</p></article>
        <article class="content-card"><span class="card-kicker">03 / DEVELOPMENT</span><h3>Education and enterprise support</h3><p>Exploring technology-driven solutions for schools and businesses.</p></article>
      <?php endif; ?>
    </div>
  </div>
</section>
<section class="section wrap">
  <div class="section-heading"><div><span class="eyebrow">LEADERSHIP</span><h2>Board of Trustees</h2></div><a class="text-link" href="board.php">Meet the board →</a></div>
  <div class="people-grid">
  <?php if ($governors): foreach ($governors as $g): ?>
    <article class="person-card"><div class="avatar"><?= e(strtoupper(substr($g['full_name'],0,1))) ?></div><h3><?= e($g['full_name']) ?></h3><p><?= e($g['position']) ?></p></article>
  <?php endforeach; else: ?>
    <p class="empty-note">Board profiles will be published here after they are added by the website administrator.</p>
  <?php endif; ?>
  </div>
</section>
<section class="join-band"><div class="wrap join-inner"><div><span class="eyebrow">BE PART OF THE JOURNEY</span><h2>Have an idea? Let's build something meaningful.</h2></div><a class="btn btn-dark" href="register.php">Join our community</a></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>