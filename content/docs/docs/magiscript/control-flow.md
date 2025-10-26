---
title: Control Flow
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Control Flow

## Introduction

Control flow refers to the order in which statements and instructions are executed in a program. MagiScript supports several control flow statements that allow you to control the flow of your program.

## If/Else Statement

The if/else statement is used to perform different actions based on different conditions. The syntax is as follows:

```javascript
if (condition) {
// code to be executed if the condition is true
} else {
// code to be executed if the condition is false
}
```

Here, the `condition` is evaluated, and if it is true, the code inside the first block is executed. If the condition is false, the code inside the second block is executed.

You can also use multiple `else if` statements to test for additional conditions:

```javascript
if (condition1) {
// code to be executed if condition1 is true
} else
if (condition2) {
// code to be executed if condition2 is true
} else {
// code to be executed if neither condition1 nor condition2 is true
}
```

## While Loop

The while loop is used to execute a block of code repeatedly as long as a certain condition is true. The syntax is as follows:

```javascript
while (condition) {
// code to be executed repeatedly while the condition is true
}
```

Here, the `condition` is evaluated before each iteration of the loop, and if it is true, the code inside the block is executed. This continues until the condition becomes false.

## do..while Loop

The do..while loop is similar to the while loop, but the condition is checked at the end of each iteration instead of the beginning. This means that the block of code is always executed at least once. The syntax is as follows:

```javascript
do {
// code to be executed at least once, and
// repeatedly as long as the condition is true
} while (condition);
```

## For Loop

The for loop is used to execute a block of code a specific number of times. The syntax is as follows:

```javascript
for (initialization; condition; update) {
// code to be executed repeatedly while the condition is true
}
```

Here the initialization is executed before the loop starts, the `condition` is checked before each iteration, and the `update` is executed after each iteration. The loop continues until the condition becomes false.

Typically for loops are used to count from a number until a number, like this (will print the numbers from 1 to 10):

```javascript
for (let i = 1; i
```

## Conclusion

Control flow statements are essential for any programming language, and MagiScript provides the most used statements to help you control the flow of your program. By using if/else statements, while and do..while loops, and for loops, you can create complex programs that perform a variety of tasks.