import sys

def quote_value_if_needed(value):
    # If the value is empty, return as is
    if not value:
        return value
    # Check if already quoted with matching single or double quotes
    if (value.startswith('"') and value.endswith('"')) or (value.startswith("'") and value.endswith("'")):
        return value
    # If contains space, tab, or newline, we need to quote
    # Also, dotenv may have issues with certain characters like #, $, etc. when unquoted.
    # But the error is about spaces, so we focus on that.
    # However, to be safe, we'll also quote if it starts with #, $, etc. or contains certain characters.
    # But let's just follow the error and quote if there's a space.
    if ' ' in value or '\t' in value or '\n' in value:
        return f'"{value}"'
    return value

def process_env_file(input_path, output_path):
    with open(input_path, 'r') as infile:
        lines = infile.readlines()
    with open(output_path, 'w') as outfile:
        for line in lines:
            stripped = line.rstrip('\n')
            # If empty line or comment, write as is
            if not stripped.strip() or stripped.strip().startswith('#'):
                outfile.write(stripped + '\n')
                continue
            # If no '=', write as is (should not happen in proper .env)
            if '=' not in stripped:
                outfile.write(stripped + '\n')
                continue
            key, value = stripped.split('=', 1)
            # Now, we need to check the value for spaces and quote if needed.
            new_value = quote_value_if_needed(value)
            outfile.write(f'{key}={new_value}\n')

if __name__ == '__main__':
    process_env_file('/data/data/com.termux/files/home/SmartCampus-K-12-Modernizing-Integrated-School-Management-Systems/.env',
                     '/data/data/com.termux/files/home/SmartCampus-K-12-Modernizing-Integrated-School-Management-Systems/.env.new')