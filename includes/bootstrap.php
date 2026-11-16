<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/database.php';
function e($value){return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');}
function db(){static $pdo=null;if($pdo===null){$pdo=new PDO(DB_DSN,DB_USER,DB_PASS,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);}return $pdo;}
function csrf_token(){if(empty($_SESSION['csrf_token']))$_SESSION['csrf_token']=bin2hex(random_bytes(32));return $_SESSION['csrf_token'];}
function csrf_field(){return '<input type="hidden" name="csrf_token" value="'.e(csrf_token()).'">';}
function verify_csrf(){if(!hash_equals($_SESSION['csrf_token']??'',$_POST['csrf_token']??'')){http_response_code(419);exit('Your form session expired. Please go back and try again.');}}
function admin_logged_in(){return !empty($_SESSION['admin_id']);}
function require_admin(){if(!admin_logged_in()){header('Location: login.php');exit;}}
function flash($message,$type='success'){$_SESSION['flash']=['message'=>$message,'type'=>$type];}
function show_flash(){if(!empty($_SESSION['flash'])){$f=$_SESSION['flash'];unset($_SESSION['flash']);echo '<div class="'.e($f['type']).'-box">'.e($f['message']).'</div>';}}
