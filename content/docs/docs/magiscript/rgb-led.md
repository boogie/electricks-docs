---
title: RGB LED
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# RGB LED

## The Hardware of Atom

Atom comes with an RGB LED that can be used to display information. It can display any color, however, we have limited the colors to a list, and brightness is a constantly dimmed light at the moment.

## Supported Colors

Atom currently supports the following colors:

-

- w: white

- x: black (LED off)

- r: red

- g: green

- b: blue

- y: yellow

- o: orange

- p: purple

- c: cyan

## Setting a Static LED Color

To set a static LED color, you need to send the letter of the color and a star (*) character. The star character will repeat the color infinitely, and the LED will not turn off.

```javascript
atom.led('r*'); // set the LED to red
atom.led('g*'); // set the LED to green
atom.led('x*'); // turn off the LED
atom.led(''); // turn off the LED
```

## Sending Basic Color Sequences

To display a color sequence, you need to send the letters of the colors in a row. Each color will be displayed for 50 ms.

```javascript

```

```javascript
atom.led('rgb'); // red, green, blue, then off
```

You can combine it with infinite repeats by adding a star character at the end.

```javascript

```

```javascript
atom.led('rb*'); // red and blue colors will alternate
atom.led('rx*'); // red will blink (red, off will alternate)
```

## Timings

You can control how long a color will stay displayed by adding timing characters to set the time. The default is 50ms, and you can override it with these characters:

```javascript
. 50 ms
- 250 ms
= 1000 ms
```

## You Can Use It Like This:

```javascript
atom.led('r'); // red for 50 ms, then off
atom.led('r.'); // red for 50 ms, then off
atom.led('r..'); // red for 100 ms, then off
atom.led('r-'); // red for 250 ms, then off
atom.led('r='); // red for 1000 ms, then off
atom.led('r=-'); // red for 1250 ms, then off
atom.led('r=x..*'); // red for 1000 ms, then off for 100 ms, and repeat
```

## Repeats

You can specify the number of repeats by adding exclamation marks (!) at the end of the pattern. The repeat-related characters must be at the end of the pattern; otherwise, they will be ignored. These are the two characters to control the repeats:

```javascript
! repeat +1 times
* repeat infinite times

And you can use them like this:

atom.led('r x='); // red for 50 ms then off for 1 s - once
atom.led('r x=!'); // red for 50 ms then off for 1 s - once
atom.led('r x=!!'); // red for 50 ms then off for 1 s - twice
atom.led('r x=!!!'); // red for 50 ms then off for 1 s - three times
atom.led('r x=*'); // red for 50 ms then off for 1 s - infinitely
```

## Conclusion

That’s it! We hope this documentation page has been helpful in using the RGB LED of Atom in MagiScript. Remember, you can play color patterns with atom.led(‘r*’) calls, where the parameter is a color pattern consisting of the supported colors (‘w’, ‘x’, ‘r’, ‘g’, ‘b’, ‘y’, ‘o’, ‘p’, ‘c’), timing characters (‘.’, ‘-‘, ‘=’), and repeat characters (‘!’, ‘*’).