---
title: Time Practice
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Time Practice

## Introduction

 
 
 
 
 You should practice using the remote, so you can enter any time confidently without watching. The Time Practice mini-game is here to help you.

The app generates a random time, and you have to enter it correctly. When connected to a browser, it will also tell you the time with an Audio Assistant, and give you a feedback if you were successful or not.

Here’s the MagiScript code of the built-in Atom Practice mini-app, which is using some of the latest language features:

 
 
 
 
 
 
 
 let time = ''; // the time entered
let timeout; // will contain a timeout ID
let startTimeout; // delay at app start
let targetTime; // the time you have to enter

function main() {
 ps.connect();
 startTimeout = setTimeout(start, 2000);
}

function start() {
 voice.say('Ready?');
 generateTime();
}

// prints the target time and the time input
function printFormattedTime() {
 ps.print(`${targetTime.text}\n`);
}

function generateTime() {
 targetTime = parseTime(rand(12), rand(60));
 voice.say(targetTime.text);
 printFormattedTime();
}

const layout = [ // button layour
 '1', '2', '3',
 '4', '5', '6',
 '7', '8', '9',
 'c', '0', '= 4 && processAfterFourDigits) {
 check();
 return;
 }

 break;
 }

 // delete the previous timer, and start a new
 clearTimeout(timeout);
 const processAfter = config.get('keyboard.submit.after');
 if (processAfter > 0) timeout = setTimeout(() => {
 check();
 }, processAfter);

 // display the times
 printFormattedTime();
}

// there are events coming from the SB Watch and the buttons of Atom
function onEvent(e) {
 if (e.source === 'ps:ble' && e.type === 'connected') {
 ps.print('Atom\nPractice');
 clearTimeout(startTimeout);
 startTimeout = setTimeout(start, 2000);
 return;
 }

 if (e.source === 'atom:button') {
 const buttonId = parseInt(e.value);
 if (e.type === 'click') {
 onButtonClick(buttonId);
 }
 if (strSub(e.type, 0, 5) === 'click' && strLen(e.type) === 6) {
 const clickCount = parseInt(strCharAt(e.type, 5));
 for (let i = 0; i < clickCount; i++) {
 onButtonClick(buttonId);
 }
 }
 }
}