---
title: "Cards, Stacks and Magic"
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Cards, Stacks and Magic

## Lookup cards from built-in stacks

 
 
 
 
 **Goal:** Use the internal database to show stacked cards on your PeekSmith screen.

 
 
 
 
 ## Step 1: New Project

 
 
 
 
 - Go to msedit.electricks.info and start a **New** mini-app.

 
 
 
 
 ## Step 2: Paste This Code

 
 
 
 
 
 
 
 function main() {
 ps.connect();
 let card = db.query("card", "mnemonica", 0);
 ps.print(card);
}
 
 
 
 
 
 
 
 ## Step 3: Upload and See the Magic

 
 
 
 
 Upload the code — your PeekSmith should show: **4♣**

That’s the **first card** of the Mnemonica stack!

 
 
 
 
 ## How It Works

 
 
 
 
 
 
 
 db.query("card", "mnemonica", 0)
 
 
 
 
 
 
 
 - "card" = the type of data we want

- "mnemonica" = the stack name (you can also try "sistebbins")

- 0 = index (0 means top of stack)

 
 
 
 
 ## Browse the Stack

 
 
 
 
 Here’s a version that scrolls through the stack with button presses:

 
 
 
 
 
 
 
 let index = 0;

function main() {
 ps.connect();
 showCard();
}

function onEvent(e) {
 if (e.type === "click" && e.source === "atom:button") {
 index++;
 showCard();
 }
}

function showCard() {
 let card = db.query("card", "mnemonica", index);
 ps.print(card);
}
 
 
 
 
 
 
 
 Each click shows the next card in the Mnemonica stack.

 
 
 
 
 
 
 
 function main() {
 atom.vibrate('.');
 setTimeout(() => atom.led('g*'), 2000);
 setTimeout(() => atom.vibrate('-'), 4000);
}
 
 
 
 
 
 
 
 ## Try This

 
 
 
 
 Start from card #10:

 
 
 
 
 
 
 
 let index = 10;
 
 
 
 
 
 
 
 Use "sistebbins" instead of "mnemonica"