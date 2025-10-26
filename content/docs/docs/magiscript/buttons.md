---
title: Buttons
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Buttons

## Button Support

Atom relies heavily on button inputs, making them the most important input method. MagiScript supports button press and release events from three devices:

-

- Atom, which has 12 buttons,

- PeekSmith 3, which has 3 buttons, and

- SB Watch, which has a single button (the crown).

## Atom Hardware

Atom has 12 buttons, numbered from 0 to 11. They are in 4 rows, and there are 3 buttons per row.

Currently, there is no default layout or behavior associated with them, but the system reports button press-related events.

![](https://electricks.info/wp-content/uploads/2024/07/atom-layout-225x300.jpg)

## Events

MagiScript is receiving events via the `onEvent` function. The event structure is the same for the buttons:

-

- value: a string with the button ID

- type: “press”, “release” strings

- source: “atom:button”, “ps:button”, “sbwatch:button”

```javascript
function onEvent(e) {
console.log(e.value, e.type, e.source);
}
```

## Events Types

### Different devices have different support.

-

- Atom supports press, release, click, longpress and repeatpress events.

- PeekSmith has press and release events only (for now, maybe a later firmware will introduce the same events as Atom).

- SB Watch supports press, release, click, longpress and repeatpress events, however sometimes a click event is coming with no button press (it is a bug, which might be fixed in the future).