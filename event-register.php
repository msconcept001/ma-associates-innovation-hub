<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle='Event Registration';
$errors=[];$success=false;
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf();
 $d=['event_name'=>trim($_POST['event_name']??''),'full_name'=>trim($_POST['full_name']??''),'email'=>trim($_POST['email']??''),'phone'=>trim($_POST['phone']??''),'organisation'=>trim($_POST['organisation']??''),'attendance_mode'=>trim($_POST['attendance_mode']??'In-person')];
 if(!$d['event_name']||!$d['full_name']||!$d['phone'])$errors[]='Event name, full name and phone number are required.';
 if($d['email']&&!filter_var($d['email'],FILTER_VALIDATE_EMAIL))$errors[]='Please enter a valid email address.';
 if(!$errors){$s=db()->prepare("INSERT INTO event_registrations(event_name,full_name,email,phone,organisation,attendance_mode) VALUES(?,?,?,?,?,?)");$s->execute(array_values($d));$success=true;}
}
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero"><div class="wrap"><span class="eyebrow">TAKE PART</span><h1>Event registration</h1><p>Register your interest in an upcoming hub event or programme.</p></div></section>
<section class="section wrap narrow">
<?php if($success): ?><div class="success-box"><h2>You're registered!</h2><p>Thank you. Your event registration has been received.</p><a class="btn btn-dark" href="index.php">Return home</a></div><?php else: ?>
<?php if($errors): ?><div class="error-box"><?php foreach($errors as $error): ?><p><?=e($error)?></p><?php endforeach; ?></div><?php endif; ?>
<form method="post" class="form-card"><?=csrf_field()?>
<label>Event / programme name *<input name="event_name" required placeholder="e.g. Plateau Digital Futures Summit 2027" value="<?=e($_POST['event_name']??'')?>"></label>
<div class="form-grid"><label>Full name *<input name="full_name" required value="<?=e($_POST['full_name']??'')?>"></label><label>Phone number *<input name="phone" required value="<?=e($_POST['phone']??'')?>"></label><label>Email address<input type="email" name="email" value="<?=e($_POST['email']??'')?>"></label><label>Organisation / school<input name="organisation" value="<?=e($_POST['organisation']??'')?>"></label><label>Attendance mode<select name="attendance_mode"><option>In-person</option><option>Virtual</option></select></label></div>
<button class="btn btn-dark" type="submit">Submit event registration</button></form>
<?php endif; ?></section>
<?php require __DIR__ . '/includes/footer.php'; ?>