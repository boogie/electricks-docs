---
title: Keyboard NOKIA
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Keyboard NOKIA

## About

 
 
 
 
 The NOKIA Keyboard embraces the iconic layout synonymous with NOKIA phones to enter letters (and numbers). For instance, to type the letter “E,” press the third button twice. The illustration below shows how much times you have to push a button quickly to get a letter.

 
 
 
 
 

![](https://electricks.info/wp-content/uploads/2024/07/NOKIA-1024x426.jpg)

 
 
 
 
 The code:

 
 
 
 
 
 
 
 let separatorAfter, separatorTimeout, separatorLength = 1;
let submitAfter, submitTimeout;

let decimalMarker = 0; // language based
let lastCharLength = 1;
let lastAutoSeparator = false;

let actualValue = '';

function main() {
 let separator = config.get('keyboard.separator.key');
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

let mapping = [
 , , ,
 , , ,
 , , ,
 , , 
];

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
 separatorTimeout = setTimeout(function() {
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
 sendSubmit();
 return;
 }

 if (keyboard.isCharacter(key)) {
 keyboard.send(key);
 lastCharLength = strLen(key);
 actualValue += key;
 handleAfter();
 return;
 }

 if (keyboard.isBackspace(key)) {
 for (let i = 0; i < lastCharLength; i++) {
 keyboard.send(key);
 actualValue = strSub(actualValue, 0, -1);
 }
 lastCharLength = 1;
 handleAfter();
 return;
 }

 if (keyboard.isSeparator(key)) {
 sendSeparator(0);
 handleAfter();
 }
}

function onAtomButtonClick(keyCode, count) {
 let key = mapping;
 if (typeof key === 'string' && strCharAt(key, 0) !== '#') {
 if (strLen(key) >= count + 1) {
 key = strCharAt(key, count);
 } else {
 return;
 }
 }
 handleKey(key);
}

function onAtomButtonLongPress(keyCode) {
 let key = mapping;
 handleKey(key);
}

function onAtomButtonRepeatPress(keyCode) {
 let key = mapping;
 handleKey(key);
}

function onEvent(e) {
 if (e.source === 'atom:button') {
 const buttonId = parseInt(e.value);
 if (e.type === 'click') {
 return onAtomButtonClick(buttonId, 0);
 }
 if (e.type === 'longpress') {
 return onAtomButtonLongPress(buttonId);
 }
 if (e.type === 'repeatpress') {
 return onAtomButtonRepeatPress(buttonId);
 }
 if (strSub(e.type, 0, 5) === 'click' && strLen(e.type) === 6) {
 let clickCount = parseInt(strCharAt(e.type, 5));
 onAtomButtonClick(buttonId, clickCount - 1);
 }
 }
}