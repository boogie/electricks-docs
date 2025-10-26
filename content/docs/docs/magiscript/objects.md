---
title: Objects
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Objects

## Introduction

Objects are a fundamental feature of the language that allows programmers to represent complex data and organize it into logical structures. Objects in MagiScript are similar to objects in other programming languages like JavaScript, and they are essential for building more advanced programs.

## What are Objects?

Objects are collections of key-value pairs that represent a set of related properties and methods. Each key in an object is a string that represents a property, and the value associated with each key can be any valid MagiScript expression. For example, an object representing a person might have properties like “name,” “age,” and “gender,” each with a corresponding value.

Objects can also have methods, which are functions that are associated with the object and can be called using the object’s name. Methods can be used to perform operations on the object’s data or manipulate the object in other ways.

## Creating Objects

To create an object, you can use curly braces to define the object’s properties and values. For example:

```javascript
let person = {
name: "John",
age: 25,
gender: "male",
sayHello: function() {
console.log("Hello, my name is " + this.name + ".");
}
};
person.sayHello(); // prints the hello message
```

In this example, we’ve created an object called `person` with properties `name`, `age`, and `gender`. We’ve also defined a method called `sayHello` that prints a greeting to the console.

## Accessing Object Properties

To access the properties of an object, you can use dot notation or square bracket notation. For example:

```javascript
console.log(person.name); // Output: John console.log(person['age']); // Output: 25
```

In both cases, we’re accessing the value associated with the `name` and `age` properties of the `person` object.

## Using Reflect.ownKeys

MagiScript supports Reflect.ownKeys, which is a method that returns an array of all the keys (both properties and methods) defined on an object. For example:

```javascript
let keys = Reflect.ownKeys(person);
for (let i = 0; i
```

In this example, we’re using `Reflect.ownKeys` to get an array of all the keys defined on the `person` object, including both properties and the `sayHello` method.

## Conclusion

Objects are a powerful feature of MagiScript that allow you to represent complex data and organize it into logical structures. By understanding how to create and access object properties, and how to use `Reflect.ownKeys` to get a list of an object’s keys, you can start building more advanced programs in MagiScript.