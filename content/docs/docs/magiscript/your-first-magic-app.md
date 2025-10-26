---
title: Your First Magic App
updated: "2025-05-23"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Your First Magic App

## Tutorial for Beginners

 
 
 
 
 **Goal:** Run your first MagiScript mini-app and blink Atom’s LED.

 
 
 
 
 ## Step 1: Open the MagiScript Editor

 
 
 
 
 Go to msedit.electricks.info using Chrome or Edge on your desktop or laptop.

Make sure Atom is turned on and has Bluetooth.

 
 
 
 
 ## Step 2: Connect Atom

 
 
 
 
 Click the **Connect** button in the top-left. Select your Atom and click **Pair**.

If you’re asked whether you want to use Atom as a keyboard, choose **Cancel** – this will help avoid issues while editing code.

 
 
 
 
 ## Step 3: Paste This Code

 
 
 
 
 
 
 
 function main() {
 atom.led('rgb*');
}
 
 
 
 
 
 
 
 This turns on the red, green, and blue lights for 50ms each, and loops forever.

 
 
 
 
 ## Step 4: Upload It

 
 
 
 
 Click the **Upload** button (or press Ctrl+S / Cmd+S). After a few seconds, Atom’s LED will start blinking red, green, and blue!

Congratulations – your first MagiScript app is running!