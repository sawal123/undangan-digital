# Payment Refund Policy

Midtrans refund callbacks are recorded on the transaction, but invitation access is not automatically disabled by refund callbacks.

## Current Decision

- `partial_refund` stores `payment_status` as `PARTIAL_REFUND` and keeps the invitation active.
- `refund` stores `payment_status` as `REFUND`, logs a warning, and keeps the invitation status unchanged.

## Follow-Up

Full refund handling needs an explicit business decision before automating invitation deactivation. Operations should review full refunds manually and decide whether the invitation should remain active, be suspended, or be handled through a separate entitlement process.
