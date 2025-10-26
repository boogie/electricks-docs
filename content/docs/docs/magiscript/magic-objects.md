---
title: Objects
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Objects

## Event - onEvent

To handle events in MagiScript, such as button presses, accelerometer data, or Bluetooth connections, simply implement the onEvent function. This function will automatically receive and manage all incoming events for you.

```javascript
function onEvent(event) {
console.log(event.value, event.type, event.source, event.sourceId);
}
```

For more information, see our events documentation.

## Device

Atom can connect to other devices, like PeekSmith or SB Watch. You can query the list of connected devices with the devices.list() function, or with device specific functions like ps.list() or sbwatch.list().

```javascript
const devs = devices.list();
for (let i = 0; i
```

We have some magic related JavaScript objects we support, like a time or card object. You will get them from functions, or pass them to functions. Expect more objects and functions coming.

## Time - parseTime

Time has 4 properties: hours, minutes, seconds and text.

```javascript
let time = parseTime('714');
console.log(time.text, time.hours, time.minutes, time.seconds);
```

You can use the string representation to set the time on an SB Watch, for example:

```javascript
sbwatch.setTime(time.text);
```

Or display it on a PeekSmith:

```javascript
ps.print(time.text);
```

## Card - parseCard

Card has many properties: pos, name, code, color, value.

```javascript
let card = parseCard('QH');
console.log(card.pos); // 37 - pos in "simple" stack
console.log(card.code); // 37 - pos in "simple" stack
console.log(card.name); // QH
console.log(card.value); // 11 - Queen
console.log(card.color); // 2 - Hearts
```

The name property (‘4C’ in this case) can be sent to PeekSmith and it will recognize it as a poker card when Smart Text is ON. The code is the position of the card in the “simple” stack (color * 13 + value).