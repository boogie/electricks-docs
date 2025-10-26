---
title: Operators
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Operators

## Basics

Operators are special characters or symbols used to perform operations on values or variables. These operators can be used for arithmetic, logical, and comparison operations. let’s discuss the operators supported by MagiScript and their usage.

Please note that some operators are not compatible with strings, and can cause the system to restart. `+`, `===` and `!==` are working with strings.

## Arithmetic Operators

The arithmetic operators are used to perform basic mathematical operations on values or variables.

## Addition (+)

The addition operator is represented by the `+` symbol and is used to add two or more values or variables together.

```javascript
let a = 10;
let b = 20;
let c = a + b;
console.log(c); // Output: 30
```

## Increment (++)

The increment operator is represented by the `++` symbol and is used to increase the value of a variable by 1.

```javascript
let a = 10;
a++;
console.log(a); // Output: 11
```

## Subtraction (-)

The subtraction operator is represented by the `-` symbol and is used to subtract one value from another.

```javascript
let a = 10;
let b = 20;
let c = b - a;
console.log(c); // Output: 10
```

## Decrement (--)

The decrement operator is represented by the `--` symbol and is used to decrease the value of a variable by 1.

```javascript
let a = 10;
a--;
console.log(a); // Output: 9
```

## Division (/)

The division operator is represented by the `/` symbol and is used to divide one value by another.

```javascript
let a = 20;
let b = 5;
let c = a / b;
console.log(c); // Output: 4
```

## Modulo (%)

The modulo operator is represented by the `%` symbol and is used to find the remainder of a division operation.

```javascript
let a = 20;
let b = 3;
let c = a % b;
console.log(c); // Output: 2
```

## Multiplication (*)

The multiplication operator is represented by the `*` symbol and is used to multiply two or more values or variables together.

```javascript
let a = 5;
let b = 2;
let c = a * b;
console.log(c); // Output: 10
```

## Exponentiation ()

The exponentiation operator is represented by the `` symbol and is used to raise a value to a power.

```javascript
let a = 2;
let b = 3;
let c = a b;
console.log(c); // Output: 8
```

## Comparison Operators

The comparison operators are used to compare two values or variables and return a Boolean value (true or false).

## Strict Equality (===)

The strict equality operator is represented by the `===` symbol and is used to check if two values are equal in both type and value.

```javascript
let a = 5;
let b = "5";
console.log(a === b); // Output: false
```

## Strict Inequality (!==)

The strict inequality operator is represented by the `!==` symbol and is used to check if two values are not equal in both type and value.

```javascript
let a = 5;
let b = "5";
console.log(a !== b); // Output: true
```

## Greater Than (>)

The greater than operator is represented by the `>` symbol and is used to check if one value is greater than another.

```javascript
let a = 5;
let b = 2;
console.log(a > b); // Output: true
```

## Less Than (<)

The less than operator is represented by the `<` symbol and is used to check if one value is less than another.

```javascript
let a = 5;
let b = 2;
console.log(a
```

## Greater Than or Equal To (>=)

The greater than or equal to operator is represented by the `>=` symbol and is used to check if one value is greater than or equal to another.

```javascript
let a = 5;
let b = 5;
console.log(a >= b); // Output: true
```

## Less Than or Equal To (<=)

The less than or equal to operator is represented by the `<=` symbol and is used to check if one value is less than or equal to another.

```javascript
let a = 5;
let b = 5;
console.log(a
```

## Bitwise Operators

The bitwise operators are used to perform operations on binary values.

## Bitwise AND (&)

The bitwise AND operator is represented by the `&` symbol and is used to perform a logical AND operation on the bits of two values.

```javascript
let a = 3; // 0011 in binary
let b = 6; // 0110 in binary
let c = a & b; // 0010 in binary
console.log(c); // Output: 2
```

## Bitwise OR (|)

The bitwise OR operator is represented by the `|` symbol and is used to perform a logical OR operation on the bits of two values.

```javascript
let a = 3; // 0011 in binary
let b = 6; // 0110 in binary
let c = a | b; // 0111 in binary
console.log(c); // Output: 7
```

## Bitwise XOR (^)

The bitwise XOR operator is represented by the `^` symbol and is used to perform a logical XOR operation on the bits of two values.

```javascript
let a = 3; // 0011 in binary
let b = 6; // 0110 in binary
let c = a ^ b; // 0101 in binary
console.log(c); // Output: 5
```

## Bitwise NOT (~)

The bitwise NOT operator is represented by the `~` symbol and is used to invert the bits of a value.

```javascript
let a = 3; // 0011 in binary
let b = ~a; // 1100 in binary
console.log(b); // Output: -4
```

## Bitwise Right Shift (>>)

The bitwise right shift operator is represented by the `>>` symbol and is used to shift the bits of a value to the right.

```javascript
let a = 8; // 1000 in binary
let b = a >> 1; // 0100 in binary
console.log(b); // Output: 4
```

## Bitwise Unsigned Right Shift (>>>)

The bitwise unsigned right shift operator is represented by the `>>>` symbol and is used to shift the bits of a value to the right, but it always fills the leftmost bits with 0.

```javascript
let a = -8; // 11111111111111111111111111111000 in binary
let b = a >>> 1; // 01111111111111111111111111111100 in binary
console.log(b); // Output: 2147483644
```

## Bitwise Left Shift (<<)

The bitwise left shift operator is represented by the `<<` symbol and is used to shift the bits of a value to the left.

```javascript
let a = 4; // 000100 in binary
let b = a
```

## Other Operators

Further operations are listed below:

## Logical NOT (!)

The logical NOT operator is represented by the `!` symbol and is used to invert a Boolean value. If the value is true, it returns false. If the value is false, it returns true.

```javascript
let a = true;
let b = !a;
console.log(b); // Output: false
```

## Conditional (Ternary) Operator (?:)

The conditional operator is represented by the `?:` symbols and is used to create a short if-else statement. If the condition is true, it returns the first expression. If the condition is false, it returns the second expression.

```javascript
let a = 5;
let b = 2;
let c = a > b ? "a is greater than b" : "a is less than or equal to b";
console.log(c); // Output: "a is greater than b"
```

## Type of Operator

The type of operator is used to determine the type of a value or variable.

```javascript
let a = 5;
let b = "Hello, world!";
let c = true;

console.log(typeof a); // Output: "number"
console.log(typeof b); // Output: "string"
console.log(typeof c); // Output: "boolean"
```

## Conclusion

Operators are an essential part of any programming language, and MagiScript supports a wide range of operators for performing various operations. Understanding the use of the most common operators is crucial for writing efficient and effective MagiScript code.