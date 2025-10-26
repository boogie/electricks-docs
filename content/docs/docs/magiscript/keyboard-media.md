---
title: Keyboard Media
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Keyboard Media

## About

 
 
 
 
 With the Media Keyboard you gain control over volume and music playback on your phone, compatible with various platforms including Spotify, Apple Music, and YouTube. Furthermore, certain apps can detect volume up/down key presses, ensuring compatibility. For example, SB Mote and selfie remotes send volume-up signals, so apps supporting them should be compatible with this keyboard, too.

 
 
 
 
 

![](https://electricks.info/wp-content/uploads/2024/07/media-controls-1024x426.jpg)

 
 
 
 
 The code:

 
 
 
 
 
 
 
 const mapping = [
 null, '#VOL_UP', null,
 '#PREV', '#PLAY_PAUSE', '#NEXT',
 null, '#VOL_DOWN', null,
 null, '#MUTE', null,
];

function onAtomButtonClick(keyCode, count) {
 const key = mapping;
 if (!key) return;
 
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