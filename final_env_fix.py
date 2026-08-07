import sys
import os
import secrets
import base64

def generate_laravel_key():
    random_bytes = secrets.token_bytes(32)
    return base64.b64encode(random_bytes).decode('utf-8')

def process_line(key, value, seen_keys, new_app_key=None):
    # If we have seen this key before, skip (duplicate)
    if key in seen_keys:
        return None  # Skip this line
    seen_keys.add(key)
    
    # If this is the APP_KEY line, replace the value
    if key == 'APP_KEY':
        # We want to set it to base64:<new_app_key>
        # Note: the new_app_key is already base64 encoded
        return f'APP_KEY=base64:{new_app_key}'
    
    # Fix DB_HOST line that contains DB_PORT= in the value
    if key == 'DB_HOST' and 'DB_PORT=' in value:
        # Split the value by whitespace and look for the host and the DB_PORT assignment
        tokens = value.split()
        host = tokens[0]
        port_value = None
        for token in tokens[1:]:
            if token.startswith('DB_PORT='):
                port_value = token.split('=', 1)[1]
                break
        if port_value is None:
            # If we didn't find DB_PORT=, then just return the line as is (should not happen)
            return f'{key}={value}'
        # Return two lines
        return f'{key}={host}\nDB_PORT={port_value}'
    
    # Fix RAILWAY_SSH_KEY line: quote the value if it contains spaces and is not already quoted
    if key == 'RAILWAY_SSH_KEY':
        # Check if the value is already quoted
        if (value.startswith('"') and value.endswith('"')) or (value.startswith("'") and value.endswith("'")):
            # Already quoted, return as is
            return f'{key}={value}'
        else:
            # Check if it contains space, tab, or newline
            if ' ' in value or '\t' in value or '\n' in value:
                return f'{key}="{value}"'
            else:
                return f'{key}={value}'
    
    # Fix PROJECT_PUBLISHABLE_KEY line that contains PROJECT_URL= in the value
    if key == 'PROJECT_PUBLISHABLE_KEY' and 'PROJECT_URL=' in value:
        tokens = value.split()
        pub_key_value = tokens[0]
        url_value = None
        for token in tokens[1:]:
            if token.startswith('PROJECT_URL='):
                url_value = token.split('=', 1)[1]
                break
        if url_value is None:
            return f'{key}={value}'
        return f'{key}={pub_key_value}\nPROJECT_URL={url_value}'
    
    # For all other lines, return as is
    return f'{key}={value}'

def main():
    backup_path = '/data/data/com.termux/files/home/SmartCampus-K-12-Modernizing-Integrated-School-Management-Systems/.env.backup'
    env_path = '/data/data/com.termux/files/home/SmartCampus-K-12-Modernizing-Integrated-School-Management-Systems/.env'
    
    new_app_key = generate_laravel_key()
    print(f'Generated APP_KEY: {new_app_key}')
    
    seen_keys = set()
    output_lines = []
    
    with open(backup_path, 'r') as f:
        for line in f:
            line = line.rstrip('\n')
            # Keep comments and empty lines unchanged
            if not line.strip() or line.strip().startswith('#'):
                output_lines.append(line)
                continue
            
            # If there's no '=', keep the line as is (should not happen in proper .env)
            if '=' not in line:
                output_lines.append(line)
                continue
            
            key, value = line.split('=', 1)
            # Note: we do not strip the key or value here because we want to preserve the original spacing?
            # But the split above gives us the key (without trailing spaces) and the value (with leading spaces).
            # We will strip the key and value for processing, but then we reconstruct without extra spaces.
            key_stripped = key.rstrip()
            value_stripped = value.lstrip()
            
            processed = process_line(key_stripped, value_stripped, seen_keys, new_app_key)
            if processed is None:
                # Skip duplicate
                continue
            # The processed string might contain multiple lines (separated by \n)
            for proc_line in processed.split('\n'):
                output_lines.append(proc_line)
    
    # Write the new .env file
    with open(env_path, 'w') as f:
        for line in output_lines:
            f.write(line + '\n')
    
    print(f'Updated {env_path}')

if __name__ == '__main__':
    main()