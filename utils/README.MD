1. Install package
Run this command to install the required dependencies.

2. Add files
Add env variables, create Supabase client helpers, and set up middleware to keep sessions refreshed.
Code:
File: utils/supabase.ts
```
1import { createClient } from "@supabase/supabase-js";
2
3const supabaseUrl = process.env.NEXT_PUBLIC_SUPABASE_URL!;
4const supabaseKey = process.env.NEXT_PUBLIC_SUPABASE_PUBLISHABLE_KEY!;
5
6export const supabase = createClient(supabaseUrl, supabaseKey);
```

File: pages/index.tsx
```
1import { useState, useEffect } from 'react'
2import { supabase } from '../utils/supabase'
3
4export default function Page() {
5  const [todos, setTodos] = useState([])
6
7  useEffect(() => {
8    async function getTodos() {
9      const { data: todos } = await supabase.from('todos').select()
10
11      if (todos) {
12        setTodos(todos)
13      }
14    }
15
16    getTodos()
17  }, [])
18
19  return (
20    <ul>
21      {todos.map((todo) => (
22        <li key={todo.id}>{todo.name}</li>
23      ))}
24    </ul>
25  )
26}
```

3. Install Agent Skills (optional)
Agent Skills give AI coding tools ready-made instructions, scripts, and resources for working with Supabase more accurately and efficiently.
Code:
File: Code
```
npx skills add supabase/agent-skills
```
