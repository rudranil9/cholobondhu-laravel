#!/bin/bash

# Set production environment variables for Railway
export APP_ENV=production
export APP_DEBUG=false
export APP_URL=https://web-production-563b2.up.railway.app
export FORCE_HTTPS=true

# Force HTTPS URLs in Laravel
export ASSET_URL=https://web-production-563b2.up.railway.app

# Set secure session configuration
export SESSION_SECURE_COOKIE=true
export SESSION_SAME_SITE_COOKIE=strict
export SANCTUM_STATEFUL_DOMAINS=web-production-563b2.up.railway.app

# Start the application
exec "$@"
