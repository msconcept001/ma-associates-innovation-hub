<?php require __DIR__.'/_header.php';
$counts=['Governors'=>db()->query("SELECT COUNT(*) FROM governors")->fetchColumn(),'Programmes'=>db()->query("SELECT COUNT(*) FROM programs")->fetchColumn(),'Members'=>db()->query("SELECT COUNT(*) FROM members")->fetchColumn(),'Event registrations'=>db()->query("SELECT COUNT(*) FROM event_registrations")->fetchColumn()];
?>
<div class="admin-heading"><div><span class="eyebrow">OVERVIEW</span><h1>Welcome, <?=e($_SESSION['admin_name']??'Administrator')?>.</h1><p>Here is an overview of your hub website.</p></div><a class="btn btn-dark" href="../index.php" target="_blank">View website ↗</a></div>
<div class="dashboard-grid"><?php foreach($counts as $label=>$count):?><div class="metric-card"><span><?=e($label)?></span><strong><?=e($count)?></strong></div><?php endforeach;?></div>
<div class="admin-shortcuts"><a href="governors.php">Manage Board of Trustees →</a><a href="programs.php">Manage programmes →</a><a href="members.php">View membership registrations →</a><a href="events.php">View event registrations →</a></div>
<?php require __DIR__.'/_footer.php'; ?>