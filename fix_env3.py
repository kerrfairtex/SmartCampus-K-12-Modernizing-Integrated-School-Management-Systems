import sys

def fix_env_line(line):
    line = line.rstrip('\n')
    # Preserve comments and empty lines
    if not line.strip() or line.strip().startswith('#'):
        return line
    # If no '=', return as is (should not happen in proper .env)
    if '=' not in line:
        return line
    key, value = line.split('=', 1)
    key = key.rstrip()
    value = value.lstrip()
    # If value is already quoted with matching single or double quotes, keep it
    if (value.startswith('"') and value.endswith('"')) or (value.startswith("'") and value.endswith("'")):
        return f'{key}={value}'
    # If value contains space, tab, or certain special characters that might cause dotenv parsing issues, quote it
    # According to dotenv, values containing spaces, tabs, newlines, #, $, etc. should be quoted.
    # We'll quote if contains space or tab, or starts with #, $, etc. But to be safe, we'll quote if contains any of: space, tab, #, $, `, \\, or starts with -, +, !, ~, *, &, |, <, >, (, ), {, }, [, ], ;, ?
    # However, we don't want to over-quote. Let's just follow the error: 'Dotenv values containing spaces must be surrounded by quotes.'
    # So we only need to quote if value contains space or tab.
    # But also, values that start with quote are already handled.
    if ' ' in value or '\t' in value:
        return f'{key}="{value}"'
    return f'{key}={value}'

def main():
    with open('.env.backup', 'r') as f:
        lines = f.readlines()
    fixed_lines = [fix_env_line(line) for line in lines]
    with open('.env', 'w') as f:
        for line in fixed_lines:
            f.write(line + '\n')

if __name__ == '__main__':
    main()