---
title: "Q-Sequence"
updated: "2025-08-05"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Q-Sequence

### About Q-Sequence

 
 
 
 
 **Q-Sequence** turns Quantum into a programmable, multi-phase controller – allowing you to trigger a chain of magical effects from a single, natural-looking calculation.

Each number you enter (up to 8) – like 1234 + 88 + 3434 + 16 = – becomes a command. Behind the scenes, every number activates a different action you’ve assigned, such as setting a time on an *SB Watch*, displaying a *Magic Square*, or triggering a *Pi-based reveal*.

You’ll find the full MagiScript code on this page. You can customize each step through the **PeekSmith app** under **Quantum Settings → Sequence**.

 
 
 
 
 

[![YouTube Video](https://img.youtube.com/vi/-yhb4jKEGYM/0.jpg)](

[YouTube Video](https://www.youtube.com/watch?v=-yhb4jKEGYM)

)

 
 
 
 
 
 
 
 let numbers = ;
let resetNumbers = true;

function main() {
 let needPeekSmith = false;
 let needSBWatch = false;
 for (let i = 0; i < 8; i++) {
 const action = config.get(`app.sequence.action.${i}`);
 if (action === 'time') needSBWatch = true;
 if (action === 'magic_square') needPeekSmith = true;
 if (action === 'pi_revelations') needPeekSmith = true;
 }

 if (needPeekSmith) {
 ps.connect();
 }
 if (needSBWatch) {
 sbwatch.connect();
 sbwatch.setCurrentTime();
 }
}

// ACTIONS

// - time -

function setTime(number) {
 sbwatch.setTime(number);
 const time = parseTime(number);
 ps.send(`/Tfau\n/Tac\n$${time.text}\n`);
}

// - magic square -

let square = newUint8Array(16);
function formatNumber(n) {
 if (n < 10) return `\xA0${n}`;
 return `${n}`;
}
function printMagicSquare(n) {
 if (n < 22 || n > 117) {
 ps.send(`${n}\rINVALID\n`);
 return;
 }
 let correction = (n - 22) / 6 | 0;
 if (n > 25) correction += rand(2);
 square = 7 + correction;
 square = 12 + correction;
 square = 1 + correction;
 square = n - 20 - correction * 3;
 square = 2 + correction;
 square = n - 21 - correction * 3;
 square = 8 + correction;
 square = 11 + correction;
 square = n - 18 - correction * 3;
 square = 3 + correction;
 square = 10 + correction;
 square = 5 + correction;
 square = 9 + correction;
 square = 6 + correction;
 square = n - 19 - correction * 3;
 square = 4 + correction;
 let vFlipped = rand(0, 2);
 let rotated = rand(0, 2);
 let startRow = vFlipped === 1 ? 3 : 0;
 let endRow = vFlipped === 1 ? -1 : 4;
 let step = vFlipped === 1 ? -1 : 1;
 let result = '';
 for (let row = startRow; row !== endRow; row += step) {
 for (let col = 0; col < 4; col++) {
 if (rotated === 0) {
 result += formatNumber(square);
 } else { // col row
 result += formatNumber(square);
 }
 result += col < 3 ? ' ' : '\r';
 }
 }
 ps.send(`/Tfau\n/Tac\n$${result}\n`);
}

// - pi revelations -

function printPiRevelations(n) {
 if (strLen(n) > 4) {
 n = strSub(n, 0, 4);
 }
 while (strLen(n) < 4) {
 n = `0${n}`;
 }
 // query the information and display it
 const piInfo = db.query('pi', parseInt(n));
 const text = `${piInfo.page} ${piInfo.line} ${piInfo.across}`;
 ps.send(`$${text}\n`);
}

function doAction(index, number) {
 if (index > 7) { return; }
 
 const action = config.get(`app.sequence.action.${index}`);
 if (action === '') { return; }

 if (action === 'time') setTime(number);
 if (action === 'magic_square') printMagicSquare(number);
 if (action === 'pi_revelations') printPiRevelations(number);
}

function onEvent(event) {
 if (event.source === 'quantum:button') {
 if (event.value === 'c') {
 resetNumbers = true;
 }
 }
 if (event.source === 'quantum:calc') {
 if (strSub(event.type, 0, 8) === 'operand:') {
 if (resetNumbers) {
 numbers = ;
 resetNumbers = false;
 }
 const n = parseInt(event.value);
 const idx = numbers.length;
 doAction(idx, n);
 numbers.push(n);
 }
 if (strSub(event.type, 0, 7) === 'result:') {
 const operator = strSub(event.type, 7);
 if (operator === '=') {
 resetNumbers = true;
 }
 }
 }
}


 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 

[![YouTube Video](https://img.youtube.com/vi/-yhb4jKEGYM/0.jpg)](

[YouTube Video](https://www.youtube.com/watch?v=-yhb4jKEGYM)

)