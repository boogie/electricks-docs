---
title: Poker Hands by Jordy Thys
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Poker Hands by Jordy Thys

## Introduction

 
 
 
 
 MagiScript has a built-in database for several cards stack. Jordy Thys has contributed this code which can calculate poker hands and display the hands on a PeekSmith screen. The code is slightly updated to use the latest features of Atom / MagiScript.

 
 
 
 
 ## The Routine

 
 
 
 
 Have a spectator cut the deck until they are satisfied, let them choose how many poker hands they want to be dealt, and let them choose which pile they want.

The magician can name all five cards from the pile.

The magician can also name the cards from the other piles upon request.

The effect uses a memorized deck. You can set the stack in the MagiScript Editor’s Settings.

Four digits are entered into Atom:

- 

- First two digits: the stack value of the bottom card after cutting (peek at the bottom card)

- Third digit: number of hands to deal

- Fourth digit: the chosen hand

This effect is based on an idea by Craig Raley of the “TAP Users Group”.

 
 
 
 
 
 
 
 /*
 Effect:
 Have a spectator cut the deck until they are
 satisfied, let them choose how many poker hands
 they want to deal and let them choose which pile
 they want.
 The magician can name all five cards from the pile.
 On request, the magician can also name the cards
 from the other piles.

 The effect uses a memorised deck.

 Four digits are entered into Atom:
 First two digits: the stack value of the bottom
 card after cutting (peek the bottom card)
 Third digit: number of hands to deal
 Fourth digit: the chosen hand

 This effect is based on an idea by Craig Raley
 of the "TAP Users Group".

 Hope you like it!
 Jordi Thys
*/

let STACK;
function main() {
 ps.connect();
 ps.print('Poker\nHands');
 STACK = config.get('app.cards.stack');
}

let timeout = 0;
let card = '';
let bottomCard = -1;
let hands = -1;
let whichHand = -1;
let mapping = [
 '1', '2', '3',
 '4', '5', '6',
 '7', '8', '9',
 ''
];

function search() {
 if (card === '') return;
 let cardCode = parseInt(card);
 card = ''; // reset the input

 if (cardCode === 0) {
 cardCode = -1;
 return;
 }

 bottomCard = cardCode;
}

function move(direction) {
 if (direction === '') {
 whichHand++;
 if (whichHand > hands - 1) whichHand = 0;
 }
 display();
}

function onButtonClick(buttonId) {
 const key = mapping;

 if (key === "") {
 move(key);
 return;
 }

 if (bottomCard !== -1) {
 if (hands === -1) {
 hands = parseInt(key);
 ps.print(``);
 return;
 }
 if (whichHand === -1) {
 whichHand = parseInt(key) - 1;
 if (whichHand > hands - 1) {
 whichHand = -1;
 return;
 }
 // ps.print(``);
 display();
 return;
 }
 }

 bottomCard = -1;
 hands = -1;
 whichHand = -1;

 card += key;
 ps.print(``);

 clearTimeout(timeout);
 if (strLen(card) === 2) {
 search();
 } else {
 let processAfter = config.get("keyboard.submit.after");
 if (processAfter === 0) processAfter = 3000;
 timeout = setTimeout(search, processAfter);
 }
}

function display() {
 const cards = ;

 for (let i = 0; i < 5; i++) {
 const index = bottomCard + whichHand + hands * i;
 cards = db.query('card', STACK, index);
 }

 const cardString = `${cards.name} ${cards.name} ${cards.name} ${cards.name} ${cards.name}`;
 ps.print(cardString);

 card = '';
}

function onEvent(e) {
 if (e.source === 'ps:ble' && e.type === 'connected') {
 ps.print('Poker\nHands');
 return;
 }
 if (e.source === 'atom:button' && e.type === 'click') {
 onButtonClick(parseInt(e.value));
 }
}