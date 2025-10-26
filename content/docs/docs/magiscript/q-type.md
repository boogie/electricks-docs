---
title: "Q-Type"
updated: "2025-08-05"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Q-Type

### About Q-Type

 
 
 
 
 **Q-Type** transforms your Quantum into a stealthy **Bluetooth keyboard**, allowing you to send key presses – numbers, operators, even full equations – directly to a connected phone, tablet, or computer.

You can secretly type into a **notes app**, trigger inputs in your favorite **magic apps**, or even have the spectator hold their own phone while you make the impossible happen.

Perfect for remote peeks, subtle input, or bold reveals, Q-Type opens up a whole new layer of interaction between Quantum and other magic app.

On this page, you’ll find the full MagiScript code for Q-Type. Feel free to use it as-is or adapt it to suit your own creative routines.

 
 
 
 
 

[![YouTube Video](https://img.youtube.com/vi/VSiBoEHw_NA/0.jpg)](

[YouTube Video](https://www.youtube.com/watch?v=VSiBoEHw_NA)

)

 
 
 
 
 
 
 
 function main() {
}

function onEvent(event) {
 if (event.type !== 'press' || event.source !== 'quantum:button') {
 return;
 }
 const key = event.value;
 if (key === 'del') {
 keyboard.tap('backspace');
 return;
 }
 if (key === 'c') {
 keyboard.tap('enter');
 return;
 }
 keyboard.type(event.value);
}


 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 

[![YouTube Video](https://img.youtube.com/vi/VSiBoEHw_NA/0.jpg)](

[YouTube Video](https://www.youtube.com/watch?v=VSiBoEHw_NA)

)