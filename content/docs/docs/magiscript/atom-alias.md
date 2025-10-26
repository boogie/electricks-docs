---
title: Atom Alias
updated: "2025-01-28"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Atom Alias

## Camouflage Your Device

 
 
 
 
 The [Atom Alias](https://electricks.info/docs/atom-remote/atom-alias/) mini-app simply changes the device’s Bluetooth name and launches an other mini-app – based on the specific settings of Atom.

 
 
 
 
 ## How is it Working?

 
 
 
 
 The main function runs when Atom loads your script.

It reads your settings with the config.get function, and sets the device name with atom.id, then launches an other app with atom.launch.

 
 
 
 
 
 
 
 function main() {
 atom.id(config.get('app.alias.name'));
 atom.launch(config.get('app.alias.launch'));
}