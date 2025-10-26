---
title: Number and the PI Revelation
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Number and the PI Revelation

## Search for numbers in the digits of π

 
 
 
 
 **Goal:** Search for a 4-digit number in the Pi book, and show its position on the PeekSmith screen.

 
 
 
 
 ## Step 1: New Project

 
 
 
 
 - Visit msedit.electricks.info
- Start a **New** mini-app and connect PeekSmith.

 
 
 
 
 ## Step 2: Paste This Code

 
 
 
 
 
 
 
 function main() {
 ps.connect();
 let input = "2024";
 let result = db.query("pi", input);
 ps.print(result);
}
 
 
 
 
 
 
 
 ## Step 3: Upload and Watch

 
 
 
 
 After uploading, your PeekSmith will show something like: “**12345″**

This means **“2024” first appears at digit 12,345** in the decimal expansion of π!

 
 
 
 
 ## What’s Happening?

 
 
 
 
 - db.query("pi", input) searches for a number (as string) inside the digits of π.

- It returns the **position** where it first appears.

You can change the input value to any number (e.g. "3141", "7777", etc.).

 
 
 
 
 ## Make It Interactive

 
 
 
 
 Here’s a version that lets you enter digits using Atom’s buttons:

 
 
 
 
 
 
 
 let input = "";

function main() {
 ps.connect();
 ps.print("Type:");
}

function onEvent(e) {
 if (e.type === "click" && e.source === "atom:button") {
 if (e.value === "4") {
 input = input.slice(0, -1); // Backspace
 } else if (e.value === "5") {
 let pos = db.query("pi", input);
 ps.print(pos);
 } else {
 input += e.value;
 ps.print(input);
 }
 }
}
 
 
 
 
 
 
 
 Button meanings:

- 0–3 → digits 0–3

- 4 → backspace

- 5 → submit and show result

 
 
 
 
 ## Performance Idea

 
 
 
 
 - Let the spectator name any 4-digit number.

- Type it in using Atom buttons behind your back.

- Show that it appears at a crazy high digit in π.