---
title: Atom 2 Firmware v2.2.7
updated: "2024-08-16"
author: Electricks
category: guides
sidebar: "aa887b8"
---

# Atom 2 Firmware v2.2.7

## What's New

 
 
 
 
 

- 
fixes the bug (built-in mini-apps were not launching)

- 
adds a keep-alive feature for background app running (PeekSmith and TimeSmith apps will utilize this feature)

- 
introduces the `atom.id()` function to query the Atom’s Bluetooth name

- 
introduces the `atom.battery()`, `ps.battery()` and `sbwatch.battery()` functions to query the battery percentage of the devices. If no PS or SB Watch connected, it responds with `undefined`.