---
title: "Q-Force"
updated: "2025-08-05"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Q-Force

### About Q-Force

 
 
 
 
 **Q-Force** is the built-in number forcing engine for the Quantum calculator – a clever mini-app that transforms everyday math into a powerful prediction tool.

It allows you to set a custom number that will appear as the “result” whenever your spectator presses the **equals (=)** key. Whether it’s a birthday, a phone number, or a secret code, Q-Force ensures your force number shows up *exactly when you need it* – making classic mentalism routines easier and more deceptive than ever.

This page includes the full MagiScript code for Q-Force. You can use it as-is or modify it to create your own routines with different conditions, input handling, or presentation twists.

Let your calculator do the impossible – right under their noses.

 
 
 
 
 

[![YouTube Video](https://img.youtube.com/vi/b7EtO7Q3EOY/0.jpg)](

[YouTube Video](https://www.youtube.com/watch?v=b7EtO7Q3EOY)

)

 
 
 
 
 
 
 
 let psPeek = false;
let psToggle = false;
let forceMode = true;
let forceModeTimeout = false;
let messageOnScreen = false;

function main() {
 calc.forceValue(config.get('calculator.force_value'));
 calc.forceRangeMin(config.get('calculator.force_range_min'));
 calc.forceRangeMax(config.get('calculator.force_range_max'));
 calc.force('on');

 psPeek = config.get('app.force.peeksmith_peek');
 psToggle = config.get('app.force.peeksmith_toggle');
 if (psPeek || psToggle) {
 ps.connect();
 }
}

function onEvent(event) {
 if (event.value === ')' && event.type === 'longpress' && event.source === 'quantum:button') {
 const value = calc.value();
 calc.forceValue(value);
 if (value === 0) {
 quantum.print('cleared'); 
 } else {
 quantum.print('saved');
 }
 messageOnScreen = true;
 }
 if (event.value === ')' && event.type === 'release' && event.source === 'quantum:button') {
 if (messageOnScreen) {
 calc.type('c');
 if (psPeek) {
 ps.send(`/Tf24\n/Tar\n$\xA00\n$0\r\xA0\n`);
 }
 }
 }
 if (psPeek) {
 if (strSub(event.type, 0, 5) === "edit:") {
 const num = event.value;
 ps.send(`/Tf24\n/Tar\n$\xA00\n$${num}\r\xA0\n`);
 }
 if (strSub(event.type, 0, 7) === "result:") {
 const num = event.value;
 const op = strSub(event.type, 7);
 ps.send(`/Tf24\n/Tar\n$\xA00\n$${num}\r${op}\n`);
 }
 }
 if (psToggle && event.type === 'press' && event.source === 'ps:button') {
 if (forceModeTimeout) {
 clearTimeout(forceModeTimeout);
 }

 forceMode = !forceMode;
 calc.force(forceMode);

 ps.send(`/Tf24\n/Tac\n$Force Mode\r${forceMode ? 'ON' : 'OFF'}\n`);

 forceModeTimeout = setTimeout(() => {
 ps.send(`/Tf24\n/Tar\n$\xA00\n$${calc.value()}\r\xA0\n`);
 forceModeTimeout = false;
 }, 1500);
 }
}