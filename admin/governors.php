<?php
require __DIR__.'/_header.php';

$uploadDir = __DIR__ . '/../uploads/trustees/';
$uploadUrl = '../uploads/trustees/';
if (!is_dir($uploadDir)) { mkdir($uploadDir, 0755, true); }

// Safe, automatic database upgrade for an existing installation.
$columns = db()->query("SHOW COLUMNS FROM governors")->fetchAll(PDO::FETCH_COLUMN);
if (!in_array('photo_path', $columns, true)) {
    db()->exec("ALTER TABLE governors ADD COLUMN photo_path VARCHAR(255) NULL AFTER bio");
}

function save_trustee_photo($field, $uploadDir) {
    if (empty($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) return null;
    $file = $_FILES[$field];
    if ($file['error'] !== UPLOAD_ERR_OK) throw new RuntimeException('The photograph could not be uploaded.');
    if ($file['size'] > 3 * 1024 * 1024) throw new RuntimeException('Photograph must not exceed 3MB.');
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $extensions = ['image/jpeg'=>'jpg', 'image/png'=>'png', 'image/webp'=>'webp'];
    if (!isset($extensions[$mime])) throw new RuntimeException('Use a JPG, PNG or WEBP photograph.');
    $filename = bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) throw new RuntimeException('Could not save the photograph.');
    return 'uploads/trustees/' . $filename;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['action'] ?? 'save';
    try {
        if ($action === 'delete') {
            $stmt = db()->prepare('SELECT photo_path FROM governors WHERE id=?');
            $stmt->execute([(int)$_POST['id']]);
            $old = $stmt->fetchColumn();
            db()->prepare('DELETE FROM governors WHERE id=?')->execute([(int)$_POST['id']]);
            if ($old && is_file(__DIR__.'/../'.$old)) unlink(__DIR__.'/../'.$old);
            flash('Trustee profile deleted.');
        } else {
            $id = (int)($_POST['id'] ?? 0);
            $name = trim($_POST['full_name'] ?? '');
            $position = trim($_POST['position'] ?? '');
            $bio = trim($_POST['bio'] ?? '');
            $sort = (int)($_POST['sort_order'] ?? 0);
            if ($name === '' || $position === '') throw new RuntimeException('Full name and position are required.');
            $photo = save_trustee_photo('photo', $uploadDir);
            if ($id > 0) {
                $stmt = db()->prepare('SELECT photo_path FROM governors WHERE id=?');
                $stmt->execute([$id]);
                $old = $stmt->fetchColumn();
                if ($photo) {
                    db()->prepare('UPDATE governors SET full_name=?,position=?,bio=?,photo_path=?,sort_order=? WHERE id=?')->execute([$name,$position,$bio,$photo,$sort,$id]);
                    if ($old && is_file(__DIR__.'/../'.$old)) unlink(__DIR__.'/../'.$old);
                } else {
                    db()->prepare('UPDATE governors SET full_name=?,position=?,bio=?,sort_order=? WHERE id=?')->execute([$name,$position,$bio,$sort,$id]);
                }
                flash('Trustee profile updated.');
            } else {
                db()->prepare('INSERT INTO governors(full_name,position,bio,photo_path,sort_order) VALUES(?,?,?,?,?)')->execute([$name,$position,$bio,$photo,$sort]);
                flash('Trustee added successfully.');
            }
        }
    } catch (Throwable $e) {
        flash($e instanceof RuntimeException ? $e->getMessage() : 'The change could not be saved. Please check the database and try again.', 'error');
    }
    header('Location: governors.php'); exit;
}
$rows = db()->query('SELECT * FROM governors ORDER BY sort_order,id')->fetchAll();
$edit = null;
if (isset($_GET['edit'])) {
    $stmt = db()->prepare('SELECT * FROM governors WHERE id=?');
    $stmt->execute([(int)$_GET['edit']]);
    $edit = $stmt->fetch() ?: null;
}
?>
<div class="admin-heading"><div><span class="eyebrow">LEADERSHIP &amp; GOVERNANCE</span><h1>Board of Trustees</h1><p>Add and manage trustee profiles, photographs and biographies.</p></div></div>
<form method="post" enctype="multipart/form-data" class="form-card admin-form">
<?=csrf_field()?><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?=e($edit['id'] ?? 0)?>">
<h2><?=$edit ? 'Edit trustee' : 'Add trustee'?></h2>
<label>Full name<input name="full_name" required value="<?=e($edit['full_name'] ?? '')?>"></label>
<label>Position<input name="position" required placeholder="e.g. Chairperson, Board of Trustees" value="<?=e($edit['position'] ?? '')?>"></label>
<label>Short biography<textarea name="bio" rows="4" placeholder="Briefly describe the trustee's background and experience"><?=e($edit['bio'] ?? '')?></textarea></label>
<label>Passport photograph (JPG, PNG or WEBP, maximum 3MB)<input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"></label>
<?php if (!empty($edit['photo_path'])): ?><p>Current photograph:</p><img src="../<?=e($edit['photo_path'])?>" alt="Current trustee photograph" style="width:90px;height:90px;object-fit:cover;border-radius:12px"><?php endif; ?>
<label>Display order<input type="number" name="sort_order" value="<?=e($edit['sort_order'] ?? 0)?>"></label>
<button class="btn btn-dark"><?=$edit ? 'Save changes' : 'Add trustee'?></button>
<?php if($edit): ?> <a class="text-link" href="governors.php">Cancel edit</a><?php endif; ?>
</form>
<div class="table-wrap"><table><thead><tr><th>Photo</th><th>Name</th><th>Position</th><th>Actions</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><?php if(!empty($r['photo_path'])): ?><img src="../<?=e($r['photo_path'])?>" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:50%"><?php else: ?>—<?php endif; ?></td><td><?=e($r['full_name'])?></td><td><?=e($r['position'])?></td><td><a href="governors.php?edit=<?=$r['id']?>">Edit</a> &nbsp; <form method="post" style="display:inline" onsubmit="return confirm('Delete this trustee profile?')"><?=csrf_field()?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?=$r['id']?>"><button class="small-danger">Delete</button></form></td></tr><?php endforeach; ?>
<?php if(!$rows): ?><tr><td colspan="4">No trustees have been added yet.</td></tr><?php endif; ?>
</tbody></table></div>
<?php require __DIR__.'/_footer.php'; ?>
