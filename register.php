<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle='Membership Registration';
$errors=[];$success=false;
if($_SERVER['REQUEST_METHOD']==='POST'){
  verify_csrf();
  $data=['full_name'=>trim($_POST['full_name']??''),'email'=>trim($_POST['email']??''),'phone'=>trim($_POST['phone']??''),'state'=>trim($_POST['state']??''),'lga'=>trim($_POST['lga']??''),'occupation'=>trim($_POST['occupation']??''),'category'=>trim($_POST['category']??'General Member'),'reason'=>trim($_POST['reason']??'')];
  if($data['full_name']===''||$data['phone']==='')$errors[]='Please enter your full name and phone number.';
  if($data['email']!==''&&!filter_var($data['email'],FILTER_VALIDATE_EMAIL))$errors[]='Please enter a valid email address.';
  if(!$errors){$stmt=db()->prepare("INSERT INTO members(full_name,email,phone,state,lga,occupation,category,reason) VALUES(?,?,?,?,?,?,?,?)");$stmt->execute(array_values($data));$success=true;}
}
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero"><div class="wrap"><span class="eyebrow">JOIN THE COMMUNITY</span><h1>Membership registration</h1><p>Share your details and tell us how you would like to be involved.</p></div></section>
<section class="section wrap narrow">
<?php if($success): ?><div class="success-box"><h2>Registration received!</h2><p>Thank you for your interest in M & Associates Innovation Hub. Our team will review your submission.</p><a class="btn btn-dark" href="index.php">Return home</a></div><?php else: ?>
<?php if($errors): ?><div class="error-box"><?php foreach($errors as $error): ?><p><?=e($error)?></p><?php endforeach; ?></div><?php endif; ?>
<form method="post" class="form-card"><?=csrf_field()?>
<div class="form-grid"><label>Full name *<input name="full_name" required value="<?=e($_POST['full_name']??'')?>"></label><label>Email address<input type="email" name="email" value="<?=e($_POST['email']??'')?>"></label><label>Phone number *<input name="phone" required value="<?=e($_POST['phone']??'')?>"></label><label>State<input name="state" value="<?=e($_POST['state']??'')?>"></label><label>Local Government Area<input name="lga" value="<?=e($_POST['lga']??'')?>"></label><label>Occupation<input name="occupation" value="<?=e($_POST['occupation']??'')?>"></label><label>Membership category<select name="category"><option>General Member</option><option>Volunteer</option><option>Student Member</option><option>Professional Member</option><option>Partner / Organisation</option></select></label></div>
<label>Why would you like to join?<textarea name="reason" rows="4"><?=e($_POST['reason']??'')?></textarea></label>
<button class="btn btn-dark" type="submit">Submit membership form</button><p class="form-note">Your details will be used by the hub to respond to your registration.</p></form>
<?php endif; ?></section>
<?php require __DIR__ . '/includes/footer.php'; ?>