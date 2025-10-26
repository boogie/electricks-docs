---
title: Silent Card Input
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Silent Card Input

## Secret Input + Database + Reveal = Magic!

 
 
 
 
 **Goal:** Enter a card’s stack position with Atom’s buttons, secretly look it up, and reveal it on PeekSmith.

 
 
 
 
 ## What This Trick Does

 
 
 
 
 - You secretly type a number (like 5) using Atom buttons.

- Press a “confirm” button.

- The matching **Mnemonica** card is displayed on PeekSmith.

- Everything is silent and secret — great for live shows.

 
 
 
 
 ## Step 1: Paste This Code

 
 
 
 
 
 
 
 let input = "";

function main() {
 ps.connect();
 ps.print("Enter:");
}

function onEvent(e) {
 if (e.type === "click" && e.source === "atom:button") {
 if (e.value === "4") {
 // Backspace
 input = input.slice(0, -1);
 } else if (e.value === "5") {
 // Submit
 let index = parseInt(input);
 let card = db.query("card", "mnemonica", index);
 ps.print(card);
 atom.vibrate('-');
 } else {
 // Add digit
 input += e.value;
 atom.vibrate('.');
 ps.print(input);
 }
 }
}
 
 
 
 
 
 
 
 Button Mapping (Recommended for Atom):

ButtonFunction0–3Enter digits4Backspace5Submit input This way you can type numbers up to 39 (Mnemonica size), correct mistakes, and confirm secretly.

 
 
 
 
 ## Step 2: Upload and Try It

 
 
 
 
 - Type 1 → 3 → Submit → You’ll see: “**King♣”**

That’s the 13th card in the Mnemonica stack!

 
 
 
 
 ## Tips for Real Performances

 
 
 
 
 - Use haptic feedback (atom.vibrate) to confirm inputs silently.

- Keep PeekSmith hidden in your pocket or case — only *you* see the reveal.

- Replace "mnemonica" with "sistebbins" for a different stack.

 
 
 
 
 ## What You Just Learned

 
 
 
 
 - Combining inputs + database + output

- Using vibration for secret feedback

- Building *interactive* and *custom* tricks!