import sys

def update_app_key(env_path, new_key):
    lines = []
    with open(env_path, 'r') as f:
        for line in f:
            stripped = line.rstrip('\n')
            if stripped.startswith('APP_KEY='):
                # Replace the line with APP_KEY=base64:<new_key>
                # But note: the new_key we have is already base64, so we just need to prepend 'base64:'
                # However, if the original line had quotes, we should preserve them? 
                # Let's check if the original line had quotes around the value.
                # We'll split at the first '='.
                key, rest = stripped.split('=', 1)
                # If rest starts and ends with same quote, we keep the quotes and put the new value inside.
                if (rest.startswith('"') and rest.endswith('"')) or (rest.startswith("'") and rest.endswith("'")):
                    quote = rest[0]
                    new_line = f'{key}={quote}base64:{new_key}{quote}'
                else:
                    new_line = f'{key}=base64:{new_key}'
                lines.append(new_line)
            else:
                lines.append(stripped)
    with open(env_path, 'w') as f:
        for line in lines:
            f.write(line + '\n')

if __name__ == '__main__':
    # The new key we generated (base64 of 32 random bytes)
    new_key = 'F6jlVARNksdHIwXsQ6r6GTMl5hX5K4RKKh8HBgOAhzI='
    update_app_key('/data/data/com.termux/files/home/SmartCampus-K-12-Modernizing-Integrated-School-Management-Systems/.env', new_key)