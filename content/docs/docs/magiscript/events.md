---
title: Events
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Events

## MagiScript Event Handling Overview

MagiScript can process events from a variety of sources such as button presses, accelerometer data, and watch hand movements. To manage these, simply implement the `onEvent` function, which will handle all incoming events automatically. All event values, including numeric ones like button IDs, are passed as strings. The event object contains four keys: – `value`: the event data. – `type`: the nature of the event. – `source`: the device type and event source (formatted as `device::source`, e.g., `atom:button`). – `sourceID`: the ID of the device (typically its Bluetooth name).

```javascript
function onEvent(event) {
console.log(event.value, event.type, event.source, event.sourceID);
}
```

MagiScript categorizes events based on their source device: Atom, PeekSmith, or SB Watch .

## Atom Events

Button Events

Button Events Atom automatically reports button events, distinguishing between various interactions: – `press`: Button pressed. – `release`: Button released. – `click`: A quick press and release. – `click2`, `click3`: Double and triple clicks. – `longpress`: Button held for a longer duration. – `repeatpress`: Repeatedly sent every second while the button remains pressed. 

Event Details:

- value : Button ID (0 = top-left, 11 = bottom-right).

- type : `press`, `release`, `click`, `click2`, `click3`, `longpress`, `repeatpress`.

- source : `atom:button`.

- sourceID : Atom’s Bluetooth name.

Accelerometer Data

To receive accelerometer data from Atom, subscribe using the `atom.accel` method.

Event Details:

- value : Coordinates `x,y,z` (comma-separated).

- type : `xyz`.

- source : `atom:accel`.

- sourceID : Atom’s Bluetooth name

## PeekSmith Events

Bluetooth Events

When Atom connects to or disconnects from PeekSmith, or fails to connect, an event is triggered.

Event Details:

- value : PeekSmith’s Bluetooth name.

- type : `connected`, `disconnected`, `failed`.

- source : `ps:ble`.

- sourceID : PeekSmith’s Bluetooth name.

Button Events

PeekSmith reports button interactions similar to Atom.

Event Details:

- value : Button ID (0 = side button, 1 = front-left, 2 = front-right).

- type : `press`, `release`, `click`, `click2`, `click3`, `longpress`, `repeatpress`.

- source : `ps:button`.

- sourceID : PeekSmith’s Bluetooth name.

Accelerometer Data

Subscribe to PeekSmith’s accelerometer data using the `ps.accel` method.

Event Details:

- value : Coordinates `x,y,z` (comma-separated).

- type : `xyz`.

- source : `ps:accel`.

- sourceID : PeekSmith’s Bluetooth name.

## SB Watch Events

Button/Crown Events

SB Watch automatically reports button or crown interactions.

Event Details:

- value : Button ID (0 = crown, 1 = top, 2 = bottom).

- type : `press`, `release`, `click`, `click2`, `click3`, `longpress`, `repeatpress`.

- source : `sbwatch:button`.

- sourceID : SB Watch’s Bluetooth name.

Accelerometer Data

To receive accelerometer data from SB Watch, subscribe using the `sbwatch.accel` method.

Event Details:

- value : Coordinates `x,y,z` (comma-separated).

- type : `xyz`.

- source : `sbwatch:accel`.

- sourceID : SB Watch’s Bluetooth name.

Watch Hand Events

SB Watch reports the movement of its hands automatically, indicating when they start or finish moving.

Event Details:

- value : Time the hands are moving to (e.g., `10:10`).

- type : `started`, `finished`.

- source : `sbwatch:hands`.

- sourceID : SB Watch’s Bluetooth name.

This breakdown ensures that you understand how to handle and categorize events from different devices when using MagiScript.