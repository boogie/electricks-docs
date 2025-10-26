---
title: Atom Square
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Atom Square

## About

 
 
 
 
 A magic square is a grid of numbers arranged such that the sum of the numbers in each row, column, and diagonal is the same.

 
 
 
 
 

![](https://electricks.info/wp-content/uploads/2024/07/magic-square-1-1024x558.jpg)

 
 
 
 
 

As a magician, you can use a magic square for mentalism or as a mathematical magic trick. Ask a spectator to choose any number between 22 and 117, and then reveal the sum of the numbers in any row, column, or diagonal that contains that number.

This mini-app helps you create a magic square based on a chosen number. Simply enter the number provided by the spectator, and copy the resulting numbers displayed on the PeekSmith 3 screen.

 
 
 
 
 
 
 
 
// the number
let num = '';
// the array will contain the numbers of the 4x4 square
let square = newUint8Array(16);

function main() {
 ps.connect();
}

function formatNumber(n) {
 if (n < 10) return `\xA0${n}`;
 return `${n}`;
}

function buildSquare(n) {
 // we can calculate a magic square for numbers
 // between 22 and 117 when we would like to end with
 // max. two digit positive numbers
 if (n < 22 || n > 117) {
 ps.print(`${n}\nINVALID`);
 return;
 }
 let correction = (n - 22) / 6 | 0;
 if (n > 25) correction += rand(2);
 square = 7 + correction;
 square = 12 + correction;
 square = 1 + correction;
 square = n - 20 - correction * 3;
 square = 2 + correction;
 square = n - 21 - correction * 3;
 square = 8 + correction;
 square = 11 + correction;
 square = n - 18 - correction * 3;
 square = 3 + correction;
 square = 10 + correction;
 square = 5 + correction;
 square = 9 + correction;
 square = 6 + correction;
 square = n - 19 - correction * 3;
 square = 4 + correction;
 let vFlipped = rand(0, 2);
 let rotated = rand(0, 2);
 let startRow = vFlipped === 1 ? 3 : 0;
 let endRow = vFlipped === 1 ? -1 : 4;
 let step = vFlipped === 1 ? -1 : 1;
 let result = '';
 for (let row = startRow; row !== endRow; row += step) {
 for (let col = 0; col < 4; col++) {
 if (rotated === 0) {
 result += formatNumber(square);
 } else { // col row
 result += formatNumber(square);
 }
 result += col < 3 ? ' ' : '\n';
 }
 }
 ps.print(result);
}

let layout = [
 '1', '2', '3',
 '4', '5', '6',
 '7', '8', '9',
 's', '0', '