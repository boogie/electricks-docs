---
title: Language · MagiScript
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Language · MagiScript

## JavaScript Similarities

MagiScript is a programming language similar to JavaScript, designed specifically for magicians to create mini-apps. While MagiScript is similar to JavaScript, it only supports a limited subset of the JavaScript language. Here’s what’s currently supported:

- [Variables](https://electricks.info/docs/magiscript/variable-declarations/): var, let, and const; literals; basic types.

- [Operators](https://electricks.info/docs/magiscript/operators/): like addition, subtraction, and comparison.

- [Control flow](https://electricks.info/docs/magiscript/control-flow/): `if/else`, `while`, `do..while`, and `for`.

- [Functions](https://electricks.info/docs/magiscript/functions/): they can be nested and arrow expressions.

- Basic classes.

However, there are also some features that are not supported in MagiScript. These include:

- Most of the built-in functions are missing, such as math, string, and array manipulation-related methods. We can add them on demand.

- Only `===` and `!==` equality operators are supported, `==` and `!=` are not.

- Some operators are not working with strings: `-`, `/`, `%`, `*`, ``, `<=`, `<`, `>=`, `>`. Using them can cause a fatal error and the system will restart.

- Regular expressions are not supported.

- No modern features like destructuring, spread, rest, and default parameters.

It’s important to note that any feature from the ECMAScript standard, whether supported or unsupported, is subject to change as we continue to work on improving the language.

We hope this breakdown of supported and unsupported language features has been helpful in understanding the capabilities of MagiScript. For more detailed information on how to use these features, please refer to the relevant sections of this documentation.