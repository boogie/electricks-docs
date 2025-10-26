---
title: Arrays
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Arrays

## Basics

Arrays are ordered lists of values and can hold values of any type, including numbers, strings, and other arrays.

Please note that using big arrays will significantly increase the size and memory usage of your program, and both are quite limited for MagiScript. If you need more than a few tens of elements, you should use Uint8Array or our database feature (which will be implemented later).

## Creating an Array

To create an array you can use the following syntax:

```javascript
let myArray = [1, 2, 3, "four", true];
```

This creates an array called `myArray`, which contains the values `1`, `2`, `3`, `"four"`, and `true`.

## Accessing Array Elements

You can access elements in an array using the square bracket notation:

```javascript
let myArray = [1, 2, 3, "four", true];

console.log(myArray[0]); // Output: 1
console.log(myArray[3]); // Output: four
```

In the above example, we access the first element of the array using `myArray[0]`, and the fourth element using `myArray[3]`.

## Length of an Array

Arrays have a `length` property, which returns the number of elements in the array:

```javascript
let myArray = [1, 2, 3, "four", true];

console.log(myArray.length); // Output: 5
```

In the above example, we access the `length` property of the `myArray` array using `myArray.length`.

## Modifying Array Elements

You can modify elements in an array using the square bracket notation as well:

```javascript
let myArray = [1, 2, 3, "four", true];

myArray[1] = "two";

console.log(myArray[1]); // Output: two
```

In the above example, we modify the second element of the `myArray` array by setting it to `"two"` using `myArray[1]`.

## Iterating Over the Elements of an Array

You can use a `for` loop to iterate over every element of an array:

```javascript
let myArray = [1, 2, 3, "four", true];

for (let index = 0; index
```

## Conclusion

Arrays in MagiScript are similar to arrays in JavaScript. They are created using square brackets, and you can access elements using the square bracket notation. They also have a `length` property, which returns the number of elements in the array. At this time, there are no other methods available for arrays in MagiScript.