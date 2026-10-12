# VerificaPay administration

The AdminLTE panel is available to authenticated accounts with the `ADMIN`
role at `/admin`. Accounts with the regular `USER` role cannot access the panel.
The panel requires a database migration before use:

```sh
php index.php migrate
```

An active administrator can also open `/migrate` in a browser and submit the
confirmation form. The route requires an authenticated administrator and
CSRF-protected POST; it does not run migrations on a plain page visit.

## Panel features

- **Dashboard:** live contact-lead, email-queue, and active-user totals.
- **Contact requests:** search by contact information, update follow-up status,
  and keep internal notes that are not sent to the contact.
- **Email queue:** inspect delivery status and requeue failed messages. The
  hosting cron worker still performs the actual SMTP delivery; see
  [email-sender.md](./email-sender.md).
- **Users and access:** create accounts, assign the `ADMIN` or `USER` role, and
  activate/deactivate accounts. New passwords must be at least 12 characters.
  The current administrator cannot deactivate or demote their own account, and
  the last active administrator cannot be demoted or deactivated.
- **Activity:** review recent administrative changes. Audit details record IDs,
  status/role changes, and whether internal notes changed; they do not copy
  contact details or note contents.

Administrative forms use CodeIgniter CSRF protection. Run the migration before
deploying the updated application so contact status fields and the audit log
table are available.

The hosting application is installed at the domain root. Set
`VERIFICAPAY_BASE_URL` to `https://verificapay.com/` so generated links and
form submissions use the root domain, not a `/verificapay_web/` subdirectory.
Locally, the XAMPP fallback remains `http://localhost/verificapay_web/`.
Without this environment variable, the app detects `verificapay.com` and
`www.verificapay.com` and generates HTTPS root URLs. This avoids generating
HTTP asset links when hosting terminates TLS at a reverse proxy.

Configure the hosting database credentials as environment variables:
`VERIFICAPAY_DB_HOST`, `VERIFICAPAY_DB_USER`, `VERIFICAPAY_DB_PASSWORD`, and
`VERIFICAPAY_DB_NAME`. Without these values, the application uses the local
XAMPP defaults. After configuring the database, run `php index.php migrate`
from the deployed project root before testing login.
