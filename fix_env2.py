import sys

def process_env_line(line):
    line = line.rstrip('\n')
    # Keep comments and empty lines unchanged
    if not line.strip() or line.strip().startswith('#'):
        return line
    # If line does not contain '=', return as is (should not happen in proper .env)
    if '=' not in line:
        return line
    key, value = line.split('=', 1)
    # Remove trailing whitespace from key
    key = key.rstrip()
    # Remove leading whitespace from value
    value = value.lstrip()
    # If value is already quoted with matching single or double quotes, keep it
    if (value.startswith('"') and value.endswith('"')) or (value.startswith("'") and value.endswith("'")):
        return f'{key}={value}'
    # If value contains space or tab, quote it with double quotes
    if ' ' in value or '\t' in value:
        return f'{key}="{value}"'
    # Otherwise, return as is
    return f'{key}={value}'

def main():
    with open('.env.backup', 'r') as f:
        lines = f.readlines()
    with open('.env', 'w') as f:
        for line in lines:
            f.write(process_env_line(line) + '\n')

if __name__ == '__main__':
    main()