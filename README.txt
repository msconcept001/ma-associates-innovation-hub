# M & Associates Innovation Hub Website (PHP + MySQL)

## Requirements
- Laragon (Apache + MySQL)
- PHP 8.0+ recommended
- MySQL/MariaDB with PDO MySQL enabled

## Local installation in Laragon
1. Extract `ma_innovation_hub` into `D:\laragon\www\`.
2. Start Apache and MySQL in Laragon.
3. Open `config/database.php`. Laragon defaults are already entered:
   - host: 127.0.0.1
   - database: ma_innovation_hub
   - username: root
   - password: blank
   Change these if your MySQL setup is different.
4. Visit `http://localhost/ma_innovation_hub/install.php`.
5. Create the first administrator account. Use a strong password of at least 10 characters.
6. When installation succeeds, delete `install.php` from the project folder.
7. Open `http://localhost/ma_innovation_hub/`.
8. Admin login: `http://localhost/ma_innovation_hub/admin/login.php`.

## First tasks after installation
- Open Admin > Trustees and add the confirmed Board of Trustees.
- Open Admin > Programmes and add approved programmes.
- Test both public registration forms.
- Review registrations in the admin dashboard.

## Important before going online
- Update `config/database.php` with your hosting database details.
- Upload the project files to your hosting web root.
- Create the MySQL database and user in your hosting control panel, then run `install.php` once.
- Delete `install.php` immediately after successful installation.
- Use HTTPS/SSL and a strong unique admin password.
- Add a privacy notice and obtain any required consent before collecting personal information.
- Confirm the organisation's official name, legal status, contact details and board appointments before publishing them as final.

This is a starter portfolio and registration system. It does not yet include email notifications, trustee photograph uploads, password reset, CSV export, CAPTCHA or advanced role permissions.


## Board of Trustees update
- Replace the old project files with the updated package, keeping your existing config/database.php.
- The Trustees admin page adds the photo_path database column automatically on first visit.
- Trustee photos accept JPG, PNG and WEBP files up to 3MB and are stored in uploads/trustees/.
- Existing trustee/governor records are retained. The public page and admin labels now say Board of Trustees.
- Back up your project folder and database before replacing files.
