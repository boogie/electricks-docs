---
title: Keyboard Custom
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Keyboard Custom

## About

 
 
 
 
 The Custom Keyboard is our Jolly Joker. By default, it enters the keywords of the WikiTest (by Marc Kerstein), however you can assign any key press to the buttons. The backspace key is smart, if you enter a whole word with one press, backspace will delete all the letters.

 
 
 
 
 

![](https://electricks.info/wp-content/uploads/2024/07/custom-1024x426.jpg)

 
 
 
 
 The code:

 
 
 
 
 
 
 
 let separatorAfter, separatorTimeout, separatorLength = 1;
let submitAfter, submitTimeout, screenTimeout;

let lastCharLength = 0;
let lastAutoSeparator = false;

let actualValue = '';

function main() {
 const separator = config.get('keyboard.separator.key');
 if (strCharAt(separator, 1) !== '#') separatorLength = strLen(separator);
 
 separatorAfter = config.get('keyboard.separator.after');
 submitAfter = config.get('keyboard.submit.after')

 ps.connect();
 resetValue();
}

function resetValue() {
 actualValue = '';
}

function peekValue() {
 ps.print(actualValue);
 clearTimeout(screenTimeout);
 setTimeout(() => {
 ps.print('');
 }, 5000);
}

function sendSeparator(charLength) {
 keyboard.send('#SEPARATOR');
 resetValue();
 lastCharLength = separatorLength + charLength;
 actualValue = '';
}

function sendSubmit() {
 if (lastAutoSeparator) {
 for (let i = 0; i < separatorLength; i++) {
 keyboard.send('#BS');
 }
 }
 keyboard.send('#SUBMIT');
 lastCharLength = 1;
 actualValue = '';
 atom.vibrate('.');
}

function handleAfter() {
 peekValue();
 
 lastAutoSeparator = false;
 if (separatorAfter > 0) {
 if (separatorAfter < 99) { // after x character
 if (strLen(actualValue) >= separatorAfter) {
 lastAutoSeparator = true;
 sendSeparator(lastCharLength);
 }
 } else {
 clearTimeout(separatorTimeout);
 separatorTimeout = setTimeout(() => {
 lastAutoSeparator = true;
 sendSeparator(lastCharLength);
 }, separatorAfter);
 }
 }
 if (submitAfter > 0) {
 if (separatorAfter < 99) { // after x character
 clearTimeout(submitTimeout);
 }
 }
}

function handleKey(key) {
 if (keyboard.isSubmit(key)) {
 return sendSubmit();
 }

 if (keyboard.isCharacter(key)) {
 keyboard.send(key);
 lastCharLength = strLen(key);
 actualValue += key;
 return handleAfter();
 }

 if (keyboard.isBackspace(key)) {
 for (let i = 0; i < lastCharLength; i++) {
 keyboard.send(key);
 actualValue = strSub(actualValue, 0, -1);
 }
 lastCharLength = 1;
 return handleAfter();
 }

 if (keyboard.isSeparator(key)) {
 sendSeparator(0);
 return handleAfter();
 }
}

function onEvent(e) {
 if (e.source !== 'atom:button') return;

 const key = config.get(`keyboard.custom.${e.value}`);
 if (e.type === 'click') return handleKey(key);

 if (!keyboard.isBackspace(key)) return;
 if (e.type === 'longpress' || e.type === 'repeatpress') return handleKey(key);
 if (strSub(e.type, 0, 5) === 'click' && strLen(e.type) === 6) {
 const clickCount = parseInt(strCharAt(e.type, 5));
 for (let i = 0; i < clickCount; i++) handleKey(key);
 }
}