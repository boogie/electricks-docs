---
title: Vibration Motor
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Vibration Motor

## Atom's Hardware

Atom has a vibration motor that can be used for creating custom vibration patterns. These vibration patterns are similar to Morse code but with many extensions.

In MagiScript, you can start vibration patterns with an `atom.vibrate(pattern)` function call, where the parameter is a vibration pattern.

```javascript
atom.vibrate('...'); // will play 3 short vibrations
```

## PeekSmith Support

You can also send vibration patterns to a PeekSmith that Atom is connected to. Read more details about it on the PeekSmith page of the MagiScript documentation, however the format is similar:

```javascript
ps.vibrate('...'); // will play 3 short vibrations on PeekSmith
```

## Basic Vibration

There are 4 different lengths of vibrations Atom Knows:

```javascript
' a very short notification (used for button press feedback)
. a short vibration (default length is 100ms)
- a long vibration (default length is 250ms)
= an extra long vibration (default length is 350ms)
```

You should send a combination of these characters, the pattern to vibrate:

```javascript
atom.vibrate('...'); // plays three short vibrations
atom.vibrate('---'); // plays three long vibrations
atom.vibrate('==='); // plays three extra-long vibrations
atom.vibrate('-..'); // plays a long and two short vibrations
```

## Numbers and English Letters

Numbers and English characters are also supported. English characters will be played as Morse code. Numbers can be configured to play as magicians used to encode numbers or as Morse code defines them. The default for the numbers is Morse encoding.

## Morse Encoding

```javascript
0: ----- 1: .---- 2: ..--- 3: ...-- 4: ....-
5: ..... 6: -.... 7: --... 8: ---.. 9: ----.
```

## Only Shorts

```javascript
0: .......... (ten shorts) 5: .....
1: . 6: ......
2: .. 7: .......
3: ... 8: ........
4: .... 9: .........
```

## Long Means 3

```javascript
0: ---. 5: -..
1: . 6: --
2: .. 7: --.
3: - 8: --..
4: -. 9: ---
```

## Long Means 4

```javascript
0: --.. 5: -.
1: . 6: -..
2: .. 7: -...
3: ... 8: --
4: - 9: --.
```

## Long Means 5

```javascript
0: -- 5: -
1: . 6: -.
2: .. 7: -..
3: ... 8: -...
4: .... 9: -....
```

## Letters Encoding with Morse Code

```javascript
A: .- H: .... O: --- V: ...-
B: -... I: .. P: .--. W: .--
C: -.-. J: .--- Q: --.- X: -..-
D: -.. K: -.- R: .-. Y: -.--
E: . L: .-.. S: ... Z: --..
F: ..-. M: -- T: -
G: --. N: -. U: ..-
```

## Examples

```javascript
atom.vibrate('SOS'); // plays ... --- ...
atom.vibrate('OK'); // plays --- -.-
atom.vibrate('12'); // plays .---- ..--- (by default)
```

## Repeat

A pattern will be played once by default. However, you can add exclamation characters to the end of the pattern, and it will be played as many times as the number of exclamation characters.

```javascript
atom.vibrate('.'); // plays a short vibration once
atom.vibrate('.!'); // plays a short vibration once
atom.vibrate('.!!'); // plays a short vibration twice
atom.vibrate('.!!!'); // plays a short vibration three times
```

## Conclusion

This is how you can use the vibration motor from MagiScript! Hopefully, this information has helped you get started with configuring vibration patterns in your projects. Don’t hesitate to experiment with different patterns and lengths to create custom vibrations that suit your needs.