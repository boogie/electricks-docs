---
title: Keyboard Cursor
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Keyboard Cursor

## About

 
 
 
 
 The Cursor Keyboard replicates keyboard cursor keys, facilitating input in apps like Inject 2 (by Greg Rostami), where cursor based swipe input is utilized. Leveraging all 12 keys of Atom, this keyboard enables effortless finger navigation.

 
 
 
 
 

![](https://electricks.info/wp-content/uploads/2024/07/cursor-1024x426.jpg)

 
 
 
 
 The code:

 
 
 
 
 
 
 
 const mapping = [
 '#LEFT', '#UP', '#RIGHT',
 '#LEFT', '#DOWN', '#RIGHT',
 '#LEFT', '#DOWN', '#RIGHT',
 '#LEFT', '#DOWN', '#RIGHT',
];

function onAtomButtonClick(keyCode) {
 const key = mapping;
 keyboard.send(key);
}

function onEvent(e) {
 if (e.source !== 'atom:button') return;

 const buttonId = parseInt(e.value);
 if (e.type === 'click' || e.type === 'longpress' || e.type === 'repeatpress') {
 return onAtomButtonClick(buttonId);
 }
 if (strSub(e.type, 0, 5) === 'click' && strLen(e.type) === 6) {
 const clickCount = parseInt(strCharAt(e.type, 5));
 for (let i = 0; i < clickCount; i++) {
 onAtomButtonClick(buttonId);
 }
 }
}