#!/bin/bash

echo "Dumping environment variables to environment file..."

A2ENVVARS="$(env | grep -E "(^DB_|^BLIS_)" | sed -e 's/^/export /')"
echo "$A2ENVVARS" | sudo tee /etc/apache2/apache2_blis.env > /dev/null

GIT_COMMIT_SHA="$(cat /etc/blis_git_commit_sha 2>/dev/null)"
if [[ -n "$GIT_COMMIT_SHA" ]]; then
    echo "export GIT_COMMIT_SHA=\"$GIT_COMMIT_SHA\"" | sudo tee -a /etc/apache2/apache2_blis.env > /dev/null
fi

if ! grep -q 'apache2_blis.env' /etc/apache2/envvars; then
    echo "Adding BLIS environment variables to Apache2 configuration..."
    echo ". /etc/apache2/apache2_blis.env" | sudo tee -a /etc/apache2/envvars
fi

if [[ -d "/workspace" ]]; then
    # add sticky bit so all files remain belonging to vscode:vscode
    find /workspace -type d -exec sudo chmod ug+s {} \;
fi

sudo apache2ctl -D FOREGROUND
