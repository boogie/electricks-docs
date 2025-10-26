---
title: Keyboard Numeric
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Keyboard Numeric

## About

 
 
 
 
 The Numeric Keyboard streamlines number input with dedicated keys for submission and backspace. Long-pressing the submit key inserts a separator key, which you can customize to input a comma or comma and space. The latest version of this code can automatically insert the separator key after a specified number of digits or time delay. Additionally, the submit key can activate after a set duration. Smart features ensure efficient usage, such as automatically deleting inserted separators.

 
 
 
 
 

![](https://electricks.info/wp-content/uploads/2024/07/numeric-keyboard-1024x426.jpg)

 
 
 
 
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

const mapping = [
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
 return;
 }
}

function onAtomButtonClick(keyCode) {
 let key = mapping;
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
 return onAtomButtonClick(buttonId);
 }
 if (e.type === 'longpress') {
 return onAtomButtonLongPress(buttonId);
 }
 if (e.type === 'repeatpress') {
 return onAtomButtonRepeatPress(buttonId);
 }
 if (strSub(e.type, 0, 5) === 'click' && strLen(e.type) === 6) {
 let clickCount = parseInt(strCharAt(e.type, 5));
 for (let i = 0; i < clickCount; i++) {
 onAtomButtonClick(buttonId);
 }
 }
 }
}