---
title: Timed Secrets
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Timed Secrets

## Add delay before something happens

 
 
 
 
 **Goal:** Make Atom do something after a short pause (e.g. vibrate or blink the LED).

 
 
 
 
 ## Step 1: Open the Editor

 
 
 
 
 - Go to msedit.electricks.info
- Start a **New** mini-app and connect Atom.

 
 
 
 
 ## Step 2: Paste This Code

 
 
 
 
 
 
 
 function main() {
 setTimeout(() => {
 atom.vibrate('...');
 }, 3000);
}
 
 
 
 
 
 
 
 ## Step 3: Upload and Wait

 
 
 
 
 Press **Upload** (or Ctrl+S).Now wait… 3 seconds later, Atom will vibrate.

That’s a **delayed action**!

 
 
 
 
 ## Explanation

 
 
 
 
 - setTimeout(func, delay) waits and then runs func.

- 3000 = 3000 milliseconds = 3 seconds.

- The code inside () => { ... } will run once the timer ends.

 
 
 
 
 ## Try These Ideas

 
 
 
 
 Blink LED after 5 seconds:

 
 
 
 
 
 
 
 setTimeout(() => {
 atom.led('r*');
}, 5000);
 
 
 
 
 
 
 
 Vibrate, then LED, then another vibration:

 
 
 
 
 
 
 
 function main() {
 atom.vibrate('.');
 setTimeout(() => atom.led('g*'), 2000);
 setTimeout(() => atom.vibrate('-'), 4000);
}
 
 
 
 
 
 
 
 ## ⚠️ What Not to Do

 
 
 
 
 - Avoid using wait(3000) — it **blocks** everything.
- Use setTimeout() instead. It’s safer and more flexible.