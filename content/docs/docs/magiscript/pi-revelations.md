---
title: Atom Pi (Pi Revelations) · MagiScript
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Atom Pi (Pi Revelations) · MagiScript

## David Penn's Pi Revelations

 
 
 
 
 Pi Revelations is a stunning magic trick that will leave your spectators in awe. With the help of this trick, you can reveal your spectator’s PIN Number, Passcode, Date Of Birth, or Random Time in a unique and fascinating way – within the first fifty thousand decimals of Pi. The trick is sold with a book and a link to an indexing website, allowing you to create unbelievable revelations without the need for memory work.

BUY THE BOOK HERE: [Pi Revelations by David Penn (worldmagicshop.com)](https://www.worldmagicshop.com/product-page/pi-revelations-by-david-penn)

You will be able to enter the 4 digits on Atom, and it will reveal on PeekSmith where the digits are in the book (page, line number, and column). Atom stores the necessary logic to calculate this information, so we will have to query it.

See below the code for a Pi Revelations mini-app. It demonstrates how database queries will work, and also how you can implement entering numbers and doing calculations.

Please note, that the built-in [Atom Time](https://electricks.info/docs/magiscript/atomtime/) mini-app also supports displaying this information.

Thanks to Badasha Khan for helping me to add this feature.

 
 
 
 
 ## How is it Working?

 
 
 
 
 The main function runs when Atom loads your script (upload, or power on if you persisted the code). It connects to your PeekSmith.

The onEvent function is called when an event occurs. It displays “Atom Pi” on the PeekSmith when connected. For now, we are interested in button-press events from Atom. When an event like this happens, it transforms the value parameter to an integer number (it contains the button ID of Atom), and sends it to the onButtonPress function.

The onButtonPress function is processing the button ID. If it is a number button, it concatenates it to the number we are building. If it’s the button represents backspace, then it removes the last character if the num string is not empty. If it’s the bottom left button, then it just clears the number.

If the number has 4 digits, then it calculates the page information based on the number, and displays everything on the PeekSmith screen. Function show responsible to display this information.

 
 
 
 
 
 
 
 
let num = '', lastNum = '';

function main() {
 ps.connect();
}

// Atom keyboard layout
const layout = [
 '1', '2', '3',
 '4', '5', '6',
 '7', '8', '9',
 'c', '0', '