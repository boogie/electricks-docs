---
title: Variable Declarations
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Variable Declarations

## About Variables

Variables are an essential part of any programming language, and MagiScript is no exception. In programming, a variable is a container that stores a value, which can be accessed and manipulated by the program. A variable can hold different types of values, such as numbers, strings, and booleans, or it can contain more complex structures as well.

Variable declarations allow you to create a new variable and optionally assign a value to it. There are three ways to declare a variable in MagiScript, using the keywords `var`, `let`, and `const`.

## Let

The `let` declaration is a newer way to declare variables in JavaScript. It has block scope. This means that variables declared with `let` are only accessible within the block (a block is from a curly bracket until a curly bracket) where they are declared, such as a loop or an if statement.

Here’s an example of how to declare a variable with `let`:

```javascript
let name = "Alice";
```

In this example, we’ve declared a variable called `name` and assigned it a value of `"Alice"`. We can use the `name` variable within the block where it was declared.

###

Please check this example to understand how it works. It will print “Bob”, then “Alice”, because the variable `name` belongs to the main function, but overridden by a variable with the same name inside the if’s block. If you were remove the redeclaration from line 4, it would print “Alice” two times.

```javascript
function main() {
let name = 'Alice';
if (1 === 1) {
let name = 'Bob';
console.log(name);
}
console.log(name);
}
```

## Const

`const` is also a newer way to declare variables in JavaScript and has block scope. However, once a value is assigned to a `const` variable, it cannot be reassigned. This makes `const` useful for declaring constants in your code.

Here’s an example of how to declare a variable with `const`:

```javascript
const PI = 3.14;
```

In this example, we’ve declared a constant called `PI` and assigned it a value of `3.14`. We can use the `PI` constant throughout our code, but we cannot reassign its value.

###

It is a bit more difficult to understand when the value of the constant variable is an array or object. While you cannot assign an other array or object to the variable, you can modify the contents. In the following code, I’m going to add a new key to the object:

```javascript
function main() {
const name = {
first: 'John'
};
name.family = 'Doe';
console.log(name.family);
}
```

## Var

Var is the oldest way to declare variables in JavaScript. While it is supported by MagiScript, it can be easily misused, so we don’t recommend using it. Variables declared with `var` have function scope or global scope, depending on where they are declared. This means that they are accessible within the function where they are declared, or globally if they are declared outside of a function. It can go wrong if you are overriding your variable or start using before the `var` keyword.

Here’s an example of how to declare a variable with `var`:

```javascript
var age = 30;
```

In this example, we’ve declared a variable called `age` and assigned it a value of `30`. We can now use the `age` variable throughout our code.

## Conclusion

In conclusion, variables are containers that store values. Variable declarations allow you to create new variables and assign values to them. `var`, `let`, and `const` are the three ways to declare variables in MagiScript, each with their own scope and rules.