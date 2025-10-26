---
title: Talking to PeekSmith
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Talking to PeekSmith

## Show any text on the PeekSmith screen

 
 
 
 
 **Goal:** Connect to a PeekSmith device and send a message to the screen.

 
 
 
 
 ## Step 1: Open the Editor

 
 
 
 
 - Go to msedit.electricks.info
- Start a **New** project and make sure PeekSmith is powered on.

 
 
 
 
 ## Step 2: Paste This Code

 
 
 
 
 
 
 
 function main() {
 ps.connect();
 ps.print("Ready...");
}
 
 
 
 
 
 
 
 ## Step 3: Upload and Watch

 
 
 
 
 Click **Upload**.Within 1–2 seconds, the PeekSmith screen should display: “**Ready…”**

 
 
 
 
 ## What This Code Does

 
 
 
 
 - ps.connect() — connects to the first available PeekSmith.

- ps.print("text") — displays text on screen.

You can call ps.connect() as often as you like; it won’t hurt if it’s already connected.

 
 
 
 
 ## Tips

 
 
 
 
 You can print numbers too:

 
 
 
 
 
 
 
 ps.print("42");
 
 
 
 
 
 
 
 Try updating it later:

 
 
 
 
 
 
 
 setTimeout(() => {
 ps.print("Now!");
}, 2000);
 
 
 
 
 
 
 
 Clear the screen:

 
 
 
 
 
 
 
 ps.print("");
 
 
 
 
 
 
 
 ## Creative Ideas

 
 
 
 
 Reveal a chosen card:

 
 
 
 
 
 
 
 ps.print("7♦");
 
 
 
 
 
 
 
 Countdown effect:

 
 
 
 
 
 
 
 ps.print("3");
setTimeout(() => ps.print("2"), 1000);
setTimeout(() => ps.print("1"), 2000);
setTimeout(() => ps.print("Boom!"), 3000);