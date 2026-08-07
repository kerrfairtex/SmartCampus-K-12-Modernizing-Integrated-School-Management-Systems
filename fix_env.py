import sys

def process_line(line):
    line = line.rstrip('\n')
    if not line.strip() or line.strip().startswith('#'):
        return line
    if '=' not in line:
        return line
    key, value = line.split('=', 1)
    key = key.rstrip()
    value = value.lstrip()
    # Check if value is already quoted
    if (value.startswith('"') and value.endswith('"')) or (value.startswith("'") and value.endswith("'")):
        return f'{key}={value}'
    # If not quoted and contains space or tab, quote it
    if ' ' in value or '\t' in value:
        return f'{key}="{value}"'
    return f'{key}={value}'

with open('.env.backup', 'r') as f:
    lines = f.readlines()

with open('.env', 'w') as f:
    for line in lines:
        f.write(process_line(line) + '\n')