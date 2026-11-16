<?php
// Run once after configuring config/database.php. Delete this file after installation.
require_once __DIR__.'/config/database.php';
$message='';$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $name=trim($_POST['admin_name']??'');$email=trim($_POST['admin_email']??'');$password=$_POST['admin_password']??'';
 if(!$name||!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($password)<10){$error='Enter a name, valid email and password of at least 10 characters.';}
 else try{
  $pdo=new PDO('mysql:host='.DB_HOST.';charset=utf8mb4',DB_USER,DB_PASS,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
  $pdo->exec("CREATE DATABASE IF NOT EXISTS `".str_replace('`','',DB_NAME)."` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
  $pdo->exec("USE `".str_replace('`','',DB_NAME)."`");
  $sql=[
  "CREATE TABLE IF NOT EXISTS admins(id INT AUTO_INCREMENT PRIMARY KEY,full_name VARCHAR(150) NOT NULL,email VARCHAR(190) NOT NULL UNIQUE,password_hash VARCHAR(255) NOT NULL,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB",
  "CREATE TABLE IF NOT EXISTS governors(id INT AUTO_INCREMENT PRIMARY KEY,full_name VARCHAR(150) NOT NULL,position VARCHAR(150) NOT NULL,bio TEXT NULL,sort_order INT DEFAULT 0,status VARCHAR(20) DEFAULT 'Active',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB",
  "CREATE TABLE IF NOT EXISTS programs(id INT AUTO_INCREMENT PRIMARY KEY,title VARCHAR(190) NOT NULL,description TEXT NOT NULL,status VARCHAR(20) DEFAULT 'Active',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB",
  "CREATE TABLE IF NOT EXISTS members(id INT AUTO_INCREMENT PRIMARY KEY,full_name VARCHAR(150) NOT NULL,email VARCHAR(190) NULL,phone VARCHAR(50) NOT NULL,state VARCHAR(100) NULL,lga VARCHAR(100) NULL,occupation VARCHAR(150) NULL,category VARCHAR(100) NOT NULL,reason TEXT NULL,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB",
  "CREATE TABLE IF NOT EXISTS event_registrations(id INT AUTO_INCREMENT PRIMARY KEY,event_name VARCHAR(190) NOT NULL,full_name VARCHAR(150) NOT NULL,email VARCHAR(190) NULL,phone VARCHAR(50) NOT NULL,organisation VARCHAR(190) NULL,attendance_mode VARCHAR(30) NOT NULL,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB"
  ];
  foreach($sql as $q)$pdo->exec($q);
  $s=$pdo->prepare('INSERT INTO admins(full_name,email,password_hash) VALUES(?,?,?) ON DUPLICATE KEY UPDATE full_name=VALUES(full_name),password_hash=VALUES(password_hash)');
  $s->execute([$name,$email,password_hash($password,PASSWORD_DEFAULT)]);
  $message='Installation completed. Your admin account has been created. Delete install.php now, then sign in at /admin/login.php.';
 }catch(Throwable $e){$error='Installation failed: '.$e->getMessage();}
}
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Install M&A Innovation Hub</title><link rel="stylesheet" href="assets/css/style.css"></head><body class="login-page"><form method="post" class="login-card"><div class="brand-symbol login-mark">M<span>&</span>A</div><span class="eyebrow">FIRST-TIME SETUP</span><h1>Install the website</h1><p>Make sure config/database.php has the correct MySQL settings before continuing.</p><?php if($error):?><div class="error-box"><?=htmlspecialchars($error)?></div><?php endif;?><?php if($message):?><div class="success-box"><?=htmlspecialchars($message)?></div><?php endif;?><label>Administrator full name<input name="admin_name" required></label><label>Administrator email<input type="email" name="admin_email" required></label><label>Create password (10+ characters)<input type="password" name="admin_password" minlength="10" required></label><button class="btn btn-dark">Create database and admin</button><p class="form-note">After successful installation, remove install.php from the project folder.</p></form></body></html>