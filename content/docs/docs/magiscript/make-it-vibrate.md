---
title: Make It Vibrate
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Make It Vibrate

## Learn to Use Atom's Vibration Motor

 
 
 
 
 **Goal:** Add a vibration pattern to your mini-app.

 
 
 
 
 ## Step 1: Start from Scratch

 
 
 
 
 Open the MagiScript Editor, click **New**, and connect your Atom if you haven’t already.

 
 
 
 
 ## Step 2: Paste This Code

 
 
 
 
 
 
 
 function main() {
 atom.vibrate('...');
}
 
 
 
 
 
 
 
 ## Step 3: Upload and Feel It

 
 
 
 
 Click **Upload** or press Ctrl+S / Cmd+S.

Atom will now vibrate 3 short pulses — like a secret tap code.

 
 
 
 
 ## How Vibration Works

 
 
 
 
 You can create custom vibration patterns using:

- ' = very short

- . = short (100ms)

- - = long (250ms)

- = = extra long (350ms)

You can also write:

 
 
 
 
 
 
 
 atom.vibrate('SOS');
 
 
 
 
 
 
 
 And Atom will vibrate Morse code for SOS: ... --- ...

 
 
 
 
 ## Repeat the Pattern

 
 
 
 
 Want it to vibrate 3 times?

 
 
 
 
 
 
 
 atom.vibrate('.!!!'); // short vibration 3 times
 
 
 
 
 
 
 
 Want it to loop forever?

 
 
 
 
 
 
 
 atom.vibrate('.-*'); // short, long, repeat forever
 
 
 
 
 
 
 
 ## Try These Patterns

 
 
 
 
 
 
 
 atom.vibrate('.-'); // short, long
atom.vibrate('--.'); // long, long, short
atom.vibrate('12'); // Morse for 1-2