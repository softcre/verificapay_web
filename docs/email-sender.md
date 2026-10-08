# VerificaPay email sender and hosting cron

Contact form submissions are saved to the database together with an email in
`email_outbox`. A CLI worker sends queued messages over SMTP. It handles up to
10 messages per run and retries temporary failures with increasing delays,
stopping after five attempts.

## 1. Confirm hosting prerequisites

Before configuring cron, make sure:

- The application is deployed and its database credentials are valid for the
  hosting database.
- The database migrations have run. From the hosting terminal, in the project
  root, run:

  ```sh
  php index.php migrate
  ```

  Alternatively, an authenticated administrator can open `/migrate` and submit
  the confirmation form.
- PHP CLI is available. Ask the hosting provider for the full path to its PHP
  executable if it is not shown in the control panel. With SSH access, check:

  ```sh
  php -v
  command -v php
  ```

- The project root is the directory that contains `index.php` and
  `run_email_sender.php`. The cron command must use the **server path**, not a
  URL such as `https://verificapay.com/run_email_sender.php`.

## 2. Where SMTP settings are read and stored

The application reads email settings in
`application/config/email.php`. That file reads the `VERIFICAPAY_*` values
using PHP's `getenv()` when CodeIgniter starts the email worker. For cron,
configure the environment variables in the hosting panel's cron environment
settings so they are available to the CLI process:

| Variable | Value |
| --- | --- |
| `VERIFICAPAY_SMTP_HOST` | SMTP hostname supplied by the hosting provider |
| `VERIFICAPAY_SMTP_USER` | SMTP mailbox username |
| `VERIFICAPAY_SMTP_PASS` | SMTP mailbox password |
| `VERIFICAPAY_SMTP_PORT` | Usually `465` for SSL or `587` for TLS |
| `VERIFICAPAY_SMTP_CRYPTO` | `ssl` or `tls`, according to the provider |
| `VERIFICAPAY_MAIL_FROM` | Sender address authorized by the SMTP account |
| `VERIFICAPAY_MAIL_FROM_NAME` | Optional; defaults to `VerificaPay` |
| `VERIFICAPAY_CONTACT_EMAIL_TO` | Optional; defaults to `soportesoftcre@gmail.com` |

Alternatively, the loader checks for
`application/config/email.local.php` and includes it **after** reading the
environment variables. Settings assigned in this file override the
corresponding environment-based values. This local file is intended for
server-only configuration and is ignored by Git. Never put SMTP passwords in
tracked code, cron command arguments, or logs. Use the provider's SMTP host and
sender requirements.

If the hosting provider does not expose environment variables to cron, create
`application/config/email.local.php` directly on the server with the following
settings and replace the placeholder values:

```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['smtp_host'] = 'SMTP_HOST_FROM_PROVIDER';
$config['smtp_user'] = 'SMTP_USERNAME';
$config['smtp_pass'] = 'SMTP_PASSWORD';
$config['smtp_port'] = 587;
$config['smtp_crypto'] = 'tls';
$config['mail_from'] = 'AUTHORIZED_SENDER_ADDRESS';
$config['mail_from_name'] = 'VerificaPay';
$config['contact_email_to'] = 'soportesoftcre@gmail.com';
```

Restrict this file to the hosting account that runs the site (normally file
permissions `600` or `640`, depending on the hosting setup). Do not leave the
example placeholders in production.

The database connection is separate from the SMTP settings. It is configured
in `application/config/database.php` (or an environment-specific database
config, if the deployment uses one). The CLI cron process must use valid
database credentials because it reads queued messages from the same
`email_outbox` database table used by the website.

## 3. Test the worker manually

From the project root in the hosting terminal, run:

```sh
php run_email_sender.php
```

If PHP's `exec()` function is disabled by the host, use the underlying
CodeIgniter command directly instead:

```sh
php index.php email_sender send_emails
```

Expected output when messages were processed looks like:

```text
Email queue processed. Sent: 1; failed: 0.
```

If there is nothing ready to send, both counts can be zero. An incomplete SMTP
configuration or database connection problem should be fixed before scheduling
the task. Check the hosting PHP/CodeIgniter error log for details; do not paste
credentials into support messages.

## 4. Add a cron job in the hosting panel

Open **Cron Jobs** (sometimes under **Advanced**) in the hosting control panel
and add a job with these settings:

- **Minute:** `*/5` (run every five minutes)
- **Hour:** `*`
- **Day:** `*`
- **Month:** `*`
- **Weekday:** `*`
- **Command:** replace all example paths with the absolute paths given by the
  host.

For example, if `exec()` is available and the host's PHP executable is
`/usr/bin/php`:

```sh
/usr/bin/php /home/ACCOUNT/domains/verificapay.com/public_html/run_email_sender.php >> /home/ACCOUNT/logs/verificapay-email.log 2>&1
```

If `exec()` is disabled, call CodeIgniter directly. The working directory must
be the project root:

```sh
cd /home/ACCOUNT/domains/verificapay.com/public_html && /usr/bin/php index.php email_sender send_emails >> /home/ACCOUNT/logs/verificapay-email.log 2>&1
```

Use the PHP path, project root, and writable log directory shown by the host.
Keep the log outside the public web directory if possible. If the hosting
control panel has separate schedule fields, enter `*/5` for minutes and `*` for
each remaining field instead of pasting the five-field schedule expression.

## 5. Verify and monitor

1. Save the cron job and check that the control panel lists it as active.
2. Submit a test contact request using an address you control.
3. Confirm the request was accepted and the notification email arrives.
4. Check the cron log after the next five-minute run. The worker prints
   aggregate counts, not contact details or recipient addresses.
5. If messages remain pending, confirm the cron is enabled, the CLI process can
   read the same database and SMTP configuration as the web application, and
   inspect the hosting PHP/CodeIgniter error logs.

Do not use a browser URL as the cron command. `run_email_sender.php` only runs
under PHP CLI and intentionally returns 404 when requested over HTTP.

## Windows / XAMPP local test

From the project directory in PowerShell:

```powershell
php .\run_email_sender.php
```

If `php` is not on `PATH`, use the full PHP path:

```powershell
& 'C:\xampp\php\php.exe' 'C:\xampp\htdocs\verificapay_web\run_email_sender.php'
```
