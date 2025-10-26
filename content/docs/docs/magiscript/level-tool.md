---
title: Atom Level
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Atom Level

## About

 
 
 
 
 Did you know that PeekSmith 3 has an [accelerometer inside](https://electricks.info/docs/magiscript/peeksmith/)? Let us demonstrate with this code how you can use it to create a Level Tool. For sure it is for fun, however, you will get some idea of how you can work with accelerometer data. Atom and [SB Watch also has an accelerometer](https://electricks.info/docs/magiscript/sb-watch/)!

 
 
 
 
 

![](https://electricks.info/wp-content/uploads/2024/07/atomlevel-1024x768.jpg)

 
 
 
 
 

We are not going to complicate the project. At first, in the main function, the code connects to a PeekSmith, then turns on the accelerometer, and starts a timer to run the vibrate function once per second.

In the onEvent function, it returns if the event is not about accelerometer data from the PeekSmith accelerometer. Then convert the string to 3 numbers, and call the onAccel method with them.

In the onAccel function, we only need the x value. It is transformed into a number between 0 and 8, and the code prints the “graphics” to the PeekSmith screen.

And finally, the vibrate function, which is running every second, the code checks if the level is middle. If yes, it sends a short vibration to PeekSmith.

 
 
 
 
 
 
 
 function main() {
 ps.connect();
 ps.print('Atom\nLevel');
 ps.accel('on');
 setInterval(vibrate, 1000);
}

function onEvent(e) {
 if (e.type !== 'xyz' || e.source !== 'ps:accel') return;
 
 let xyz = strSplit(e.value, ',');
 for (let index = 0; index < 3; index++) {
 xyz = parseInt(xyz);
 }
 onAccel(xyz, xyz, xyz);
}

let currentLevel = -1; // unknown
let levels = [
 'O--------',
 '-O-------',
 '--O------',
 '---O-----',
 '====O====',
 '-----O---',
 '------O--',
 '-------O-',
 '--------O',
];

function onAccel(x, y, z) {
 currentLevel = ( (x / 2048) + 1) * 4.2 | 0; // calculate a number between 0 - 8
 if (currentLevel < 0) currentLevel = 0;
 if (currentLevel > 8) currentLevel = 8;
 ps.print(levels);
}

function vibrate() {
 if (currentLevel === 4) ps.vibrate('.');
}