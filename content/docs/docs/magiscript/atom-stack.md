---
title: Atom Stack
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Atom Stack

## About

 
 
 
 
 This mini-app is called Atom Stack. You can learn using MagiScript’s [database functions](https://electricks.info/docs/magiscript/database/) to work with cards and card stacks. You can also use this app to learn stacks. The **Si Stebbins**, **Mnemonica**, **Aronson**, and **Memorandum** stacks are currently supported, but we can add more on demand.

The idea is simple. Enter the position of a card in an AC->AK, AD->KD, AH->KH, and AS->KS card stack (we call this “simple”), and Atom will display this and the next two cards in your chosen card stack. AC is 1. 2C is 2. 9C is 9. AH is 27. 3H is 29. AK is 52.

You can also “move around” with the bottom left and bottom right buttons. Use this to learn the stacks, try guessing the next cards.

If you need help, just enter 0, and you will get some. 🙂

 
 
 
 
 
 
 
 
let STACK;
let stackName;
let card = '';
let cardPosInStack = null;

/*
 'simple': simple deck: clubs, diamonds, hearts, and spades from Ace to King
 'new': a new deck order: AH->KH, AC->KC, KD->AD, KS->AS
 'sistebbins': Si Stebbins stack
 'mnemonica': Mnemonica by Juan Tamariz
 'aronson': Aronson stack by Simon Aronson
 'memorandum': Memorandum by Woody Aragón
*/

function main() {
 STACK = config.get('app.cards.stack');
 stackName = STACK;
 if (STACK === 'simple') stackName = 'Simple';
 if (STACK === 'new') stackName = 'New Deck';
 if (STACK === 'sistebbins') stackName = 'SiStebbins';
 if (STACK === 'mnemonica') stackName = 'Mnemonica';
 if (STACK === 'aronson') stackName = 'Aronson';
 if (STACK === 'memorandum') stackName = 'Memorandum';
 ps.connect();
}

// Atom keyboard layout
const layout = [
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
 help();
 return;
 }
 cardCode = (cardCode - 1) % 52; // 1st card has index 0

 let simpleCard = db.query('card', 'simple', cardCode);
 let cardInStack = db.query('card', STACK, simpleCard.name);
 cardPosInStack = cardInStack.pos;
 display();
}

function move(direction) {
 cardPosInStack = cardPosInStack + direction;
 if (cardPosInStack < 0) cardPosInStack = 51;
 if (cardPosInStack > 51) cardPosInStack = 0;
 display();
}

let timeout = 0;
function onButtonClick(buttonId) {
 let key = layout;
 clearTimeout(timeout);

 switch (key) {
 case '':
 if (strLen(card) === 1) return search();
 move(+1);
 return;
 }

 card += key;
 if (strLen(card) === 2) return search();
 const processAfter = config.get('keyboard.submit.after');
 if (processAfter > 0) {
 timeout = setTimeout(search, processAfter);
 }
 printNumberEntered();
}

function printNumberEntered() {
 ps.print(``);
}

function display() {
 const card1 = db.query('card', STACK, cardPosInStack);
 const card2 = db.query('card', STACK, cardPosInStack + 1);
 const card3 = db.query('card', STACK, cardPosInStack + 2);
 ps.print(`${card1.name} ${card2.name} ${card3.name}`);
}

function help() {
 ps.print(`${stackName}\nA♣ 1 A♦14\nA♥27 A♠40`);
}

function onEvent(e) {
 if (e.source === 'ps:ble' && e.type === 'connected') {
 ps.print('Atom\nStack');
 setTimeout(help, 2000);
 return;
 }
 if (e.source === 'atom:button') {
 const buttonId = parseInt(e.value);
 if (e.type === 'click') {
 onButtonClick(buttonId);
 }
 if (strSub(e.type, 0, 5) === 'click' && strLen(e.type) === 6) {
 const clickCount = parseInt(strCharAt(e.type, 5));
 for (let i = 0; i < clickCount; i++) {
 onButtonClick(buttonId);
 }
 }
 }
}
 
 
 
 
 
 
 
 Let me explain how the code calculates the cards. In the search()function, at line 47, it gets the representation of the card referred by the position number you have entered. Then using the name of this card (like 7D), it gets the representation of the card in the chosen stack. The important property is the “pos”, we are storing it to cardPosInStack. From line 90 in the display function, the three cards will be queried, and their string name will be used to display them. If PeekSmith 3’s “Smart Text” is on, these will be displayed as colorful cards.

 
 
 
 
 ## Tips and Tricks

 
 
 
 
 Change the “Card Stack” configuration (the cog icon in the MagiScript editor, and you will find it on the App Settings tab)  to use a different stack.

See the layout array, that is the button layout, if you create one, this is a great way to format it like this.

 
 
 
 
 ## Challanges

 
 
 
 
 Modify the code to print this at the beginning. Use the \n notation to add a new line character.

AtomStack
Si Stebbins

Modify the code to not display the card you entered, but the next 3, or the previous 3 cards.

What about displaying 6 cards in 2 lines?
3S 6D 9C
QH 2S 5D

Can you add PeekSmith button support? The front buttons should move backward and forward as the Atom buttons do.