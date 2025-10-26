---
title: Reacting to Button Presses
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Reacting to Button Presses

## Make Atom respond when you press a button

 
 
 
 
 **Goal:** Detect a button click and trigger a vibration.

 
 
 
 
 ## Step 1: Open the Editor

 
 
 
 
 Visit msedit.electricks.info, start a **New** project, and connect your Atom.

 
 
 
 
 ## Step 2: Paste This Code

 
 
 
 
 
 
 
 function main() {
 // Nothing to do at start
}

function onEvent(e) {
 if (e.type === 'click' && e.source === 'atom:button') {
 atom.vibrate('.');
 }
}
 
 
 
 
 
 
 
 ## Step 3: Upload and Test

 
 
 
 
 Upload the code, then press any button on Atom.

You’ll feel a short vibration every time you press.

 
 
 
 
 ## What’s Happening?

 
 
 
 
 - onEvent(e) is called every time something happens (like a button press).

- e.type tells what kind of event it is: 'click', 'press', 'release', etc.

- e.source tells where the event comes from: 'atom:button', 'ps:button', etc.

- We check if it’s a button **click**, and if yes, we trigger atom.vibrate('.').

 
 
 
 
 ## Try These Tweaks

 
 
 
 
 Only vibrate for Button #0:

 
 
 
 
 
 
 
 if (e.value === '0') {
 atom.vibrate('.');
}
 
 
 
 
 
 
 
 Different buttons, different patterns:

 
 
 
 
 
 
 
 if (e.value === '0') atom.vibrate('.');
if (e.value === '1') atom.vibrate('-');
if (e.value === '2') atom.vibrate('...');
 
 
 
 
 
 
 
 Show the button number:

 
 
 
 
 
 
 
 console.log(e.value);