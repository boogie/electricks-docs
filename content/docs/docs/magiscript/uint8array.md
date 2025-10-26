---
title: Uint8Array
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Uint8Array

## About

The `Uint8Array` is a built-in data structure in MagiScript which allows you to store an array of 8-bit unsigned integers (values between 0 and 255). This data structure is particularly useful when you need to store a large number of small integers in a memory-efficient way.

It is a specialized [array](https://electricks.info/docs/magiscript/arrays/), with fix length and restricted values.

## Creating a Uint8Array

You can create a `Uint8Array` by calling the `newUint8Array` function with a single argument: the size of the array. For example, the following code creates a `Uint8Array` with 10 elements:

```javascript
let myArray = newUint8Array(10);
```

## Accessing Array Items

You can access the elements of a `Uint8Array` using the bracket notation (`[]`). The index of the first element is `0`, and the index of the last element is `length - 1`.

For example, the following code sets the first element of the `myArray` to `42`:

```javascript
myArray[0] = 42;
```

And the following code retrieves the value of the third element:

```javascript
let thirdElement = myArray[2];
```

## Querying the Length

You can query the length of a `Uint8Array` using the `length` property. For example, the following code prints the length of the `myArray`:

```javascript
console.log(myArray.length);
```

## Example

The following code creates a `Uint8Array` with 5 elements, sets their values to 0, 1, 2, 3, and 4, respectively, and then prints them:

```javascript
let myArray = newUint8Array(5);

for (let i = 0; i
```

This will output the numbers from 0 to 5.

## Conclusion

```javascript
The Uint8Array is a memory-efficient data structure that allows you to store an array of 8-bit unsigned integers in MagiScript. You can create a Uint8Array by calling the newUint8Array function with a single argument: the size of the array. You can access the elements of a Uint8Array using the bracket notation, and query its length using the length property.
```