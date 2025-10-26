---
title: Strings
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Strings

## Introduction

Strings are a sequence of characters enclosed in either single quotes (`''`), double quotes (`""`), or backticks (````). Single quotes and double quotes are working the same way, but backticks (string templates) have some special features.

## Creating Strings

To create a string, simply enclose a sequence of characters in single or double quotes. For example:

```javascript
let str1 = 'Hello, world!';
let str2 = "MagiScript is awesome!";
```

MagiScript also supports template strings, which are enclosed in backticks (````) instead of single or double quotes. Template strings allow multiple lines and also embed expressions inside a string using placeholders. Placeholder expressions are enclosed in `${}`. For example:

```javascript
let name = "MagiScript";
let message = `Hello, ${name}!`;
```

## String Methods

Below are the String Methods:

## strLen

`strLen` is a built-in function in MagiScript that returns the length of a string. It takes one argument, which is the string to be measured. For example:

```javascript
let myStr = "MagiScript";
let len = strLen(myStr); // len is 10
```

## strSub

`strSub` is a built-in function in MagiScript that extracts a substring from a string. It takes two arguments: the string from which the substring will be extracted, and the starting index (inclusive) and the ending index (exclusive) of the substring. For example:

```javascript
let myStr = "MagiScript";
let subStr = strSub(myStr, 0, 4); // subStr is "Magi"
```

## strCharAt

`strCharAt` is a built-in function in MagiScript that returns the character at a specified index in a string. It takes two arguments: the string from which the character will be extracted, and the index of the character. For example:

```javascript
let myStr = "MagiScript";
let char = strCharAt(myStr, 2); // char is "g"
```

## strSplit

`strSplit` is a built-in function in MagiScript that splits a string into an array of substrings. It takes two arguments: the string to be split, and the separator character or substring. For example:

```javascript
let myStr = "MagiScript is awesome!";
let words = strSplit(myStr, " "); // words is ["MagiScript", "is", "awesome!"]
```

## Conclusion

In MagiScript, strings are a fundamental data type that can be created using single or double quotes or backticks for template strings. While MagiScript doesn’t support the length property of strings, and accessing the letter at an index using brackets (str[2]), we have `strLen`, `strSub`, `strCharAt` and `strSplit` to help manipulate and extract information from strings.