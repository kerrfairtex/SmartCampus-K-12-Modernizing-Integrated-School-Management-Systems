import sys
import os
import secrets
import base64

def generate_laravel_key():
    # Generate 32 random bytes and base64 encode
    random_bytes = secrets.token_bytes(32)
    return base64.b64encode(random_bytes).decode('utf-8')

def parse_env_line(line):
    line = line.rstrip('\n')
    # Keep comments and empty lines unchanged
    if not line.strip() or line.strip().startswith('#'):
        return line, None  # (original_line, new_line) but we return the line to keep and None for key change?
    # If no '=', return as is (should not happen in proper .env)
    if '=' not in line:
        return line, None
    key, value = line.split('=', 1)
    # Remove trailing whitespace from key
    key = key.rstrip()
    # Remove leading whitespace from value
    value = value.lstrip()
    # Determine if value is quoted and what quote char
    quoted = False
    quote_char = ''
    if len(value) >= 2:
        if (value.startswith('"') and value.endswith('"')) or (value.startswith("'") and value.endswith("'")):
            quoted = True
            quote_char = value[0]
            # Extract the value inside quotes
            inner_value = value[1:-1]
        else:
            inner_value = value
    else:
        inner_value = value
    # Trim the inner value (remove leading/trailing spaces)
    trimmed_inner = inner_value.strip()
    # Now, we need to decide if we should quote the trimmed_inner.
    # According to dotenv, if the value contains a space, it must be quoted.
    # Also, if the original was quoted, we might want to keep it quoted for consistency.
    # We'll quote if:
    #   - The trimmed_inner contains a space, or
    #   - The original was quoted (to preserve the quoting style, but we'll use double quotes for simplicity)
    # However, note: if the original was quoted and the trimmed_inner does not contain a space, we can still quote it to be safe.
    # Let's quote if the trimmed_inner contains a space or if the original was quoted.
    if ' ' in trimmed_inner or quoted:
        new_value = f'"{trimmed_inner}"'
    else:
        new_value = trimmed_inner
    # Reconstruct the line
    new_line = f'{key}={new_value}'
    return new_line, key

def main():
    env_backup = '/data/data/com.termux/files/home/SmartCampus-K-12-Modernizing-Integrated-School-Management-Systems/.env.backup'
    env_path = '/data/data/com.termux/files/home/SmartCampus-K-12-Modernizing-Integrated-School-Management-Systems/.env'
    # Generate the key
    new_key = generate_laravel_key()
    print(f'Generated key: {new_key}')
    # Read the backup and process each line
    with open(env_backup, 'r') as f:
        lines = f.readlines()
    new_lines = []
    for line in lines:
        new_line, key = parse_env_line(line)
        if key == 'APP_KEY':
            # Replace the APP_KEY line with our new key
            # We need to format it: APP_KEY=base64:<new_key>
            # But note: the new_key is already base64, so we just do:
            new_line = f'APP_KEY=base64:{new_key}'
            # We should quote it if it contains a space? It doesn't.
            # However, to be consistent with the rest of the file, we might want to quote it.
            # Let's check: the new_key is base64, which does not contain spaces.
            # So we leave it unquoted.
            # But note: the original might have been quoted. We'll follow the same rule as above.
            # We'll quote if the value contains a space (it doesn't) or if the original was quoted.
            # We don't have the original quoted status here, so let's just use the same rule: if the value contains a space, quote.
            # Since it doesn't, we leave it unquoted.
            # However, many Laravel .env files have the key quoted. Let's look at the example: APP_KEY=
            # In the example, it's empty and not quoted.
            # But in practice, it's often quoted. Let's be safe and quote it.
            # We'll quote it because the value is important and we don't want any issues.
            new_line = f'APP_KEY="base64:{new_key}"'
        new_lines.append(new_line)
    # Write the new .env file
    with open(env_path, 'w') as f:
        for line in new_lines:
            f.write(line + '\n')
    print(f'Updated {env_path}')

if __name__ == '__main__':
    main()