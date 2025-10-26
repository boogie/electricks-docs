---
title: "Q-Mirror"
updated: "2025-08-05"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Q-Mirror

### About Q-Mirror

 
 
 
 
 **Q-Mirror** is a clever mini-app that lets two Quantum calculators sync wirelessly — so whatever is typed on one device appears instantly on the other.

Designed for both duo acts and solo mentalism, Q-Mirror turns your calculator into a live peeking tool or a silent telepathy transmitter. Whether you’re revealing a thought-of number from across the stage or secretly reading a spectator’s input without looking, this mini-app unlocks powerful new ways to connect and perform.

On this page, you’ll find the full MagiScript code for Q-Mirror. Feel free to use it as-is or adapt it to suit your own creative routines.

 
 
 
 
 

[![YouTube Video](https://img.youtube.com/vi/30VnewwCwVE/0.jpg)](

[YouTube Video](https://www.youtube.com/watch?v=30VnewwCwVE)

)

 
 
 
 
 
 
 
 function main() {
 quantum.connect();
}

function onEvent(event) {
 if (event.type === 'press' &&
 event.source === 'quantum:button' &&
 event.sourceId !== quantum.id()) {
 calc.type(event.value);
 return false;
 }
 if (strSub(event.type, 0, 5) === 'edit:') {
 const num = event.value;
 quantum.send(`#${num},\n`);
 return;
 }
 if (strSub(event.type, 0, 7) === 'result:') {
 const num = event.value;
 const op = strSub(event.type, 7);
 quantum.send(`#${num},${op}\n`);
 return;
 }
}