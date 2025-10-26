---
title: Devices
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Devices

## About

MagiScript supports connecting Atom to several other devices (see [PeekSmith](https://electricks.info/docs/magiscript/peeksmith/) and [SB Watch](https://electricks.info/docs/magiscript/sb-watch/) pages for more information).

## Querying the Connected Device

You can query the Bluetooth name (ID) of the device(s) Atom connected to. The id method gives you the active device’s ID, while the ids method returns an array with the devices Atom connected to.

You can query the connected devices as a list of device objects as well using the list method.

If more than one device is connected, you can set one of them to active with the select method. Messages will be sent to this unit.