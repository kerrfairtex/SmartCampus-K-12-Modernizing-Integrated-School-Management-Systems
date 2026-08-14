# Serverless Deployment Baseline (AWS)

This repository is currently Laravel 5.5-era code. The serverless baseline in this document is intended as a modernization path, not a one-click deploy.

## What is included in this repository

- `serverless.yml` for AWS Lambda + API Gateway (Bref runtime model).
- `.env.serverless.example` with stateless defaults.
- Serverless-aware defaults in config files:
  - Session defaults to Redis when `APP_SERVERLESS=true`
  - Cache defaults to Redis when `APP_SERVERLESS=true`
  - Queue defaults to Redis when `APP_SERVERLESS=true`
  - Filesystem defaults to S3 when `APP_SERVERLESS=true`
- Upload handling now uses `UPLOADS_DISK` so file URLs can be generated from local/public or S3 disk.

## Prerequisites

1. Managed MySQL (RDS/PlanetScale/etc.)
2. Managed Redis (Elasticache/Upstash/Redis Cloud/etc.)
3. S3 bucket for uploaded files
4. IAM permissions for Lambda + API Gateway + S3 (prefer Lambda execution role, not static AWS keys in env vars)

## Environment setup

1. Copy `.env.serverless.example` to your deployment secret manager/environment.
2. Set `APP_KEY` (generate from Laravel artisan in a secure environment).
3. Fill DB, Redis, and S3 settings.
4. Keep `APP_SERVERLESS=true`.

## Deployment notes

1. Install and configure Serverless Framework in CI/CD.
2. Ensure Bref dependency is available (`vendor/bref/bref`) before `serverless deploy`.
3. Deploy by stage:
   - `serverless deploy --stage dev`
   - `serverless deploy --stage staging`
   - `serverless deploy --stage production`

## Validation checklist

- Auth/session login flow
- File upload and download URLs
- Queue job execution
- Database migration flow
- Background tasks/scheduled command strategy

## Important limitation

A full production migration still requires framework/runtime modernization to supported Laravel and PHP versions before relying on Lambda in production.
