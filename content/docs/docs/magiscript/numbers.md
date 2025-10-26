---
title: Numbers
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Numbers

## Introduction

In MagiScript you can use numbers as like in JavaScript, however it is a notable difference that at the moment it only supports integers and does not support floating-point numbers.

## Integer Literals

Integer literals are used to represent integers in MagiScript. An integer literal can be written in decimal, binary, octal, or hexadecimal notation.

## Decimal Notation

Decimal notation is the most common way of writing integer literals. An integer literal written in decimal notation consists of a sequence of digits without any prefix or suffix.

```javascript
let x = 42;
```

## Binary Notation

Binary notation is used to represent integers in binary form. An integer literal written in binary notation consists of the prefix `0b` followed by a sequence of binary digits (0 or 1).

```javascript
let x = 0b101010; // 42
```

## Octal Notation

Octal notation is used to represent integers in octal form. An integer literal written in octal notation consists of the prefix `0o` followed by a sequence of octal digits (0 to 7).

```javascript
let x = 0o52; // 42
```

## Hexadecimal Notation

Hexadecimal notation is used to represent integers in hexadecimal form. An integer literal written in hexadecimal notation consists of the prefix `0x` followed by a sequence of hexadecimal digits (0 to 9 and A to F).

```javascript
let x = 0x2A;
```

## Arithmetic Operators

MagiScript supports several arithmetic operators for performing arithmetic operations on integers. The following table shows the arithmetic operators that are supported in MagiScript:

Operator
Description
Example

+
Addition
`x + y`

–
Subtraction
`x - y`

*
Multiplication
`x * y`

/
Division
`x / y`

%
Modulus (remainder)
`x % y`

++
Increment
`x++` or `++x`

—
Decrement
`x--` or `--x`

## Examples

```javascript
let x = 10;
let y = 3;

let sum = x + y; // 13
let difference = x - y; // 7
let product = x * y; // 30
let quotient = x / y; // 3
let remainder = x % y; // 1

let a = 5;
let b = ++a; // a is now 6, b is 6
let c = b--; // b is now 5, c is 6
```

## Comparison Operators

MagiScript supports several comparison operators for comparing integers. The following table shows the comparison operators that are supported in MagiScript:

Operator
Description
Example

===
Equal to
`x === y`

!==
Not equal to
`x !== y`

>
Greater than
`x > y`

<
Less than
`x < y`

>=
Greater than or equal to
`x >= y`

<=
Less than or equal to
`x <= y`

## Examples

```javascript
let x = 10;
let y = 3;

let isEqual = x == y; // false
let isNotEqual = x != y; // true
let isGreater = x > y; // true
let isLess = x = y; // true
let isLessOrEqual = x
```

## Bitwise Operators

MagiScript also supports several bitwise operators for performing bitwise operations on integers. The following table shows the bitwise operators that are supported in MagiScript:

Operator
Description
Example

&
Bitwise AND
`x & y`

|
Bitwise OR
`x &#124; y`

^
Bitwise XOR (exclusive OR)
`x ^ y`

~
Bitwise NOT (one’s complement)
`~x`

<<
Left shift
`x << y`

>>
Right shift (sign-preserving)
`x >> y`

>>>
Right shift (zero-fill)
`x >>> y`

## Examples

```javascript
let x = 0b1010;
let y = 0b1100;

let andResult = x & y; // 0b1000
let orResult = x | y; // 0b1110
let xorResult = x ^ y; // 0b0110
let notResult = ~x; // -0b1011 (two's complement)
let leftShiftResult = x > 2; // 0b0010 (sign-preserving)
let zeroFillRightShiftResult = x >>> 2; // 0b0010 (zero-fill)
```

## Conclusion

MagiScript supports integers and several operators for performing arithmetic, comparison, and bitwise operations on them. However, it does not support floating-point numbers.