---
title: Functions
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Functions

## Basics

Functions are a fundamental concept in programming languages, including MagiScript. A function is a block of code that performs a specific task and can be called from anywhere in the program. Functions help in writing reusable code and make the code more organized and modular.

In MagiScript, there are two ways to define a function: using the `function` keyword and using arrow functions.

## Function Keyword

Using the `function` Keyword: The `function` keyword is used to define a named function in MagiScript. The syntax for defining a function is as follows:

```javascript
function functionName(parameter1, parameter2, ... parameterN) {
// function code
}
```

Here, `functionName` is the name of the function, and `parameter1`, `parameter2`, … `parameterN` are the parameters passed to the function. The function code is enclosed within curly braces `{}`.

For example, let’s define a function that adds two numbers and returns the result:

```javascript
function addNumbers(num1, num2) {
return num1 + num2;
}
console.log(addNumbers(3, 4));
```

Here, `addNumbers` is the name of the function, and `num1` and `num2` are the parameters passed to the function. The function code adds the two parameters and returns the result using the `return` keyword.

## Arrow Functions

Arrow functions are a shorthand way to define a function in JavaScript, and it is supported by MagiScript as well. They are also known as “fat arrow” functions. The syntax for an arrow function is as follows:

```javascript
(parameter1, parameter2, ... parameterN) => {
// function code
}
```

Here, `parameter1`, `parameter2`, … `parameterN` are the parameters passed to the function, and the function code is enclosed within curly braces `{}`. The `=>` operator separates the parameters and the function code.

For example, let’s define an arrow function that multiplies two numbers and returns the result:

```javascript
const multiplyNumbers = (num1, num2) => {
return num1 * num2;
}
console.log(multiplyNumbers(111, 6));
```

Here, `multiplyNumbers` is the name of the arrow function, and `num1` and `num2` are the parameters passed to the function. The function code multiplies the two parameters and returns the result using the `return` keyword.

## Calling a Funktion

Once a function is defined, it can be called from anywhere in the program. To call a function, use the function name followed by parentheses `()` and pass the arguments, if any, inside the parentheses.

For example, to call the `addNumbers` function defined above, we can write:

```javascript
let result = addNumbers(10, 20);
console.log(result); // Output: 30
```

Here, we pass `10` and `20` as arguments to the `addNumbers` function, which adds them and returns `30`. We store the result in the `result` variable and log it to the console using the `console.log()` function.

## Conclusion

Functions will help you to write modular and reusable code. They can be defined using the `function` keyword or arrow functions and can be called from anywhere in the program. By using functions, you can write code that is more organized, easier to maintain, and more efficient.