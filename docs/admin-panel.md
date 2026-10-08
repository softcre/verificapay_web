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

For hosting deployments, set `VERIFICAPAY_BASE_URL` to the public site root
(for example, `https://verificapay.com/`) if the host does not use
`verificapay.com` or `www.verificapay.com`. The `.htaccess` rewrite rules
support installing the application either at the domain root or under a
subdirectory.
