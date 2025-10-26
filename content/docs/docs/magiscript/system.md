---
title: System
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# System

## About

MagiScript offers some system related functions, like:

-

- atom.exit() – the code will stop running

- atom.sleep() – Atom turns off

- atom.rand() – for random number generation

- atom.launch() – to launch an other app

Let’s see how you can use them.

## Exit

The exit function stops the execution of the actually running MagiScript mini-app. When no device is connected to Atom, it will turn off after waiting for a connection.

```javascript
atom.exit();
```

## Sleep

The sleep function turns off Atom. If the code was not persisted, it also means it forgets the code running.

```javascript
atom.sleep();
```

## Rand

The rand function generates a random number. Can be called with 0, 1 or 2 parameters.

```javascript
let n = atom.rand(); // integer between 0 and 2,147,483,647
let n = atom.rand(52); // integer between 0 and 52
let n = atom.rand(-10, 10); // integer between -10 and 10
```

The minimum number specified or used by default will be included in the set of available number. The maximum number is excluded. So you can use it like this:

```javascript
sbwatch.setTime(atom.rand(12), atom.rand(60)); // random time
db.query('card', 'new', atom.rand(52)); // random card
```

## Launch

The launch function launches an other mini-app. The following code will launch the built-in Atom Pi mini-app.

```javascript
atom.launch('atom_pi');
```

## Conclusion

These system related functions will help you to control Atom, or access system functions like generating random numbers.