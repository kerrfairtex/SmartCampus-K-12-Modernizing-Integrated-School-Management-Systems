import sys
import os
import secrets
import base64

def generate_laravel_key():
    random_bytes = secrets.token_bytes(32)
    return base64.b64encode(random_bytes).decode('utf-8')

def needs_quoting(value):
    # Check if the value contains space, tab, or newline
    if ' ' in value or '\t' in value or '\n' in value:
        return True
    # Also, if the value starts with #, $, etc., but the error is about spaces.
    # We'll stick to the error.
    return False

def is_quoted(value):
    return (value.startswith('"') and value.endswith('"')) or (value.startswith("'") and value.endswith("'"))

def process_line(line, new_app_key=None):
    line = line.rstrip('\n')
    # Keep comments and empty lines unchanged
    if not line.strip() or line.strip().startswith('#'):
        return line
    # If no '=', return as is (should not happen in proper .env)
    if '=' not in line:
        return line
    key, value = line.split('=', 1)
    key = key.rstrip()
    value = value.lstrip()
    # If we are to replace the APP_KEY, do it now
    if new_app_key is not None and key == 'APP_KEY':
        # We'll set the value to base64:<new_app_key> and then quote if needed (but it doesn't have spaces)
        value = f'base64:{new_app_key}'
        # Now, we need to decide if to quote. Since the value has no spaces, we can leave unquoted.
        # However, to be safe and consistent, we'll quote it.
        # But note: the original might have been quoted. We'll quote it.
        return f'{key}="{value}"'
    # Otherwise, process the value for quoting
    if is_quoted(value):
        # Already quoted, return as is
        return line
    if needs_quoting(value):
        return f'{key}="{value}"'
    return f'{key}={value}'

def main():
    env_backup = '/data/data/com.termux/files/home/SmartCampus-K-12-Modernizing-Integrated-School-Management-Systems/.env.backup'
    env_path = '/data/data/com.termux/files/home/SmartCampus-K-12-Modernizing-Integrated-School-Management-Systems/.env'
    new_key = generate_laravel_key()
    print(f'Generated key: {new_key}')
    with open(env_backup, 'r') as f:
        lines = f.readlines()
    with open(env_path, 'w') as f:
        for line in lines:
            f.write(process_line(line, new_key) + '\n')
    print(f'Updated {env_path}')

if __name__ == '__main__':
    main()