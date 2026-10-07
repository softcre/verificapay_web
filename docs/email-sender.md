# VerificaPay email sender

Contact form submissions are saved to the database together with an email in
`email_outbox`. A CLI worker sends queued messages over SMTP. If SMTP is
temporarily unavailable, the worker retries the message with increasing delays
and stops after five attempts.

## SMTP configuration

Create `application/config/email.local.php` on the server by copying
`application/config/email.local.php.example`. This local file is ignored by
Git; do not add SMTP passwords to tracked files. Alternatively, set the
following environment variables in the hosting control panel:

- `VERIFICAPAY_SMTP_HOST`
- `VERIFICAPAY_SMTP_USER`
- `VERIFICAPAY_SMTP_PASS`
- `VERIFICAPAY_SMTP_PORT` (typically `465` for SSL or `587` for TLS)
- `VERIFICAPAY_SMTP_CRYPTO` (`ssl` or `tls`)
- `VERIFICAPAY_MAIL_FROM` (an address authorized by the SMTP account)
- `VERIFICAPAY_MAIL_FROM_NAME` (optional; defaults to `VerificaPay`)
- `VERIFICAPAY_CONTACT_EMAIL_TO` (optional; defaults to
  `soportesoftcre@gmail.com`)

Use the SMTP settings and sender mailbox supplied by the hosting provider.
The sender address generally needs to belong to a domain authenticated with
that SMTP service.

## Database migration

Run the migration once from the application directory using the hosting
terminal:

```sh
php index.php migrate
```

The migration creates the email outbox table. The migration endpoint accepts
CLI execution only.

## Hosting cron job

The project includes `run_email_sender.php` in its root. It runs the same
CodeIgniter command as the earlier manual workflow,
`php index.php email_sender send_emails`, using the current PHP executable and
the project directory. It is CLI-only and forwards the worker's output and
exit code.

Test the wrapper from the project directory:

```sh
php run_email_sender.php
```

On Windows/XAMPP the equivalent command is:

```powershell
php .\run_email_sender.php
```

Run the wrapper every five minutes in hosting cron. Replace the project path,
PHP path, and log path with the values shown by the hosting provider:

```sh
*/5 * * * * /usr/bin/php /home/ACCOUNT/public_html/verificapay_web/run_email_sender.php >> /home/ACCOUNT/logs/verificapay-email.log 2>&1
```

The worker processes up to 10 queued messages per run. It prints aggregate
counts only; recipient addresses and submitted contact details are not written
to its output.
