---
title: Database
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Database

## Introduction

It *will be* possible to upload data to Atom and query it with a MagiScript command.

Available data sources:

-

- pi : contains information about the [Pi Revelations](https://electricks.info/docs/magiscript/pi-revelations/) book

- card : card stack-related queries, several popular stacks are supported

## Querying the "pi" Database

To query the “pi” database, use the `db.query()` function with the first argument set to “pi”. The second argument should be a 4-digit number you want to search for in the database. For example, db.query(‘pi’, 4000) searches for the number 4000 in the “pi” database.

The `db.query()` function will return an object with keys page, line, and across. These keys represent the page number, line number, and column number where the 4-digit number can be found in the book.

Here’s an example code snippet that demonstrates how to query the “pi” database:

```javascript
let data = db.query('pi', '4000');
console.log(data.page); // outputs the page
console.log(data.line); // outputs the line
console.log(data.across); // outputs the column
```

```javascript

```

In this example, the `db.query()` function searches for the number 4000 in the “pi” database. The result is stored in the `data` variable, and then the `console.log()` function is used to output the result to the console.

## Card Database

```javascript

```

With the card database, you can work with card positions in popular stacks like:

-

- “simple”: a simple card deck order, clubs, diamonds, hearts, and spades from Ace to King:
AC->KC, AD->KD, AH->KH, AS->KS

- “new”: a new deck order:
AH->KH, AC->KC, KD->AD, KS->AS

- “sistebbins”: [Si Stebbins stack](https://en.wikipedia.org/wiki/Si_Stebbins_stack)

- “mnemonica”: Mnemonica by Juan Tamariz

- “aronson”: Aronson stack by Simon Aronson

- “memorandum”: Memorandum by Woody Aragón

You can query the card at position #n (please note, that the first card is n = 0):

```javascript
// first card in new deck order
let card = db.query('card', 'mnemonica', 0);
console.log(card.pos); // 0 - pos in this ("mnemonica") stack
console.log(card.code); // 3 - pos in "simple" stack
console.log(card.name); // 4C
console.log(card.value); // 3 - Four
console.log(card.color); // 0 - Clubs
console.log(card.vibration); // '.... .'
```

```javascript

```

The name property (‘4C’ in this case) can be sent to PeekSmith and it will recognize it as a poker card when Smart Text is ON. The code is the position of the card in the “simple” stack (suit * 13 + value).

You can also search for the card in the stacks by name, and receive the index (pos):

```javascript
// 10H in a new deck
let card = db.query('card', 'new', '10H');
console.log(card.pos); // 9 - 10th card in a new deck
console.log(card.code); // 35 - pos in "simple" stack
console.log(card.name); // 10H
console.log(card.value); // 9 - Ten
console.log(card.color); // 2 - Hearths
console.log(card.vibration); // '-- -'
```

```javascript

```

And finally, it is also an option to search for the card by providing the suit and value:

```javascript
// suit #2 (Hearts) and card value #11 (Q) card in the Si Stebbins stack
let card = db.query('card', 'sistebbings', 2, 11);
console.log(card.pos); // 11 - 10th card in stack
console.log(card.code); // 37 - pos in "simple" stack
console.log(card.name); // QH
console.log(card.value); // 11 - Queen
console.log(card.color); // 2 - Hearths
console.log(card.vibration); // '--.. -'
```

## Conclusion

```javascript

```

In MagiScript, it is possible to query information from a local “database” using the `db.query()` function.

The “pi” database is a predefined data source that can be queried using MagiScript. By passing a 4-digit number to the `db.query()` function, you can find the page, line, and column where the number can be found in the Pi book.

The “card” database is to help you work with card stacks, which can be useful for ACAAN routines.