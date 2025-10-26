---
title: Atom THMPR
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Atom THMPR

## About

 
 
 
 
 Atom Thmpr is a basic thumper tool you can send messages with. Are you pressing a button on Atom? The PeekSmith will vibrate. Are you pressing a button on the PeekSmith? The Atom will vibrate.

The code is quite simple:

 
 
 
 
 
 
 
 function main() {
 ps.connect();
 ps.print("Atom\nTHMPR");
}

function onAtomButtonPress() {
 ps.vibrate(".");
}

function onPeekSmithButtonPress() {
 atom.vibrate(".");
}

function onEvent(e) {
 if (e.type === "press") {
 if (e.source === "atom:button") onAtomButtonPress();
 if (e.source === "ps:button") onPeekSmithButtonPress();
 }
}