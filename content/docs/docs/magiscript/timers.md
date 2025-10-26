---
title: Timers
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Timers

## Introduction

Most of the time, you will need to do some things periodically or after a time, or you would like to wait between two instructions.

MagiScript has several functions to support you.

## Wait

This basic call will add a delay to your code. Use it wisely, as it is blocking the script engine, so no other code will run until it ends (like no button presses or timeouts will be executed).

Because of this, *we recommend not using it at all* . But for experience with MagiScript, it’s OK to use, just don’t add a long wait.

It is a simple function, with one parameter:

```javascript
wait(100); // wait 100 milliseconds (0.1 seconds)
```

```javascript

```

For example, you can try this code. The LED will go green for 1 second, but this is running in the background, and the code execution goes on. The wait function then waits 2 seconds. The LED will turn off after 1 second and will stay off for a second until the wait function ends. Then it turns yellow and stays on.

```javascript
function main() {
atom.led('g='); // green LED for 1 second
wait(2000);
atom.led('y*'); // yellow infinitely
}
```

```javascript

```

Read on about the timers below, however, this is the alternative we recommend. It is harder to read, more code, but MagiScript events won’t be blocked at all.

```javascript
function main() {
atom.led('g='); // green LED for 1 second
setTimeout(function() {
atom.led('y*'); // yellow infinitely
}, 2000);

}
```

## Timers

```javascript

```

Timers are to run code parts periodically or after a time. You can work with 16 timers at a time. These functions are coming in a pair:

setTimeout and clear

TimeoutsetInterval and ClearInterval

The setTimeout triggers a code once, the setInterval triggers the code infinitely. The clearTimeout will prevent the timer from triggering the code if called before the execution. The clearInterval will stop the timer, so it will not trigger the code again.

Using them is simple:

```javascript
setTimeout(function() { 
console.log('hello'); 
}, 1000);
setInterval(function() { 
console.log('hey'); 
}, 100);
```

```javascript

```

Both setTimeout and setInterval need two arguments, a function and an interval in milliseconds.

There are at least three ways to pass a function. You can pass an “anonymous” function like in the code above, you can pass an “arrow function”, and you can pass the name of a function declared before or later:

```javascript
// anonymous funnction
setTimeout(function() { 
console.log('howdy'); 
}, 1000);
// arrow function
setTimeout(() => { 
console.log('cheers'); 
}, 1000);
// reference
setTimeout(log, 1000);
function log() { 
console.log('hiya'); 
}
```

```javascript

```

Both the setTimeout and setInterval functions are returning a number. You can use this to cancel them:

```javascript
let timeoutId = setTimeout(() => console.log('I will never run'), 1000);
clearTimeout(timeoutId);
```

All in all, they are working quite similarly to JavaScript. If you are looking for some ideas about how you can use them, the Atom Time and Atom Level examples can give you some hints.