---
title: GhostMove Direct Connection
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "297a4df"
---

# GhostMove Direct Connection

## Connect Your GhostMoves Directly

With firmware v1.7.41, we’ve introduced a direct GhostMove connection in standalone mode. This feature allows PeekSmith 3 to connect to your GhostMoves without the need for a phone, providing instant access to movement information.

There are two supported GhostMove routines:

- Which Side Up and
- Movement

## Which Side Up

The default routine upon connecting your GhostMoves is “Which Side Up,” supporting up to three devices. Simply ensure that both GhostMoves and your PeekSmith 3 are not connected to any app, then long-press the right button on your PS3. The device will establish a connection with the motion sensors, initiating the routine. On-screen cards will display numbers corresponding to the upward side of the GhostMove. When a GhostMove is in motion, an ‘X’ will be displayed.

## Movement

For the “Movement” routine, a bit more setup is required, but the connection process remains the same. Once configured, PeekSmith 3 will showcase the names of currently moving GhostMoves. Access this routine through PeekSmith 3’s menu by pressing the two front buttons, selecting the setting with the left front button, and choosing the routine with the right button. Exit the menu using the side button.

To name your GhostMoves for the “Movement” routine, follow these steps:

1. Connect your devices in the GhostMove app.
2. Tap on each GhostMove to reveal its “Original name” on the screen.
3. Note down the ID after the dash (e.g., 01ACE9 for GhostMove-01ACE9).
4. Connect your PeekSmith and go to its Details page.
5. Locate the text box and input “ *cg* 01ACE9:b:Bee,” replacing the ID with yours.
6. The first one-letter name after the double colon is unused, and the second one (e.g., “Bee”) is the name the “Movement” routine will use.
7. Upon successful configuration, you should see a “GhostMove Configured GM-01ACE9” message on the PeekSmith screen.

While this process may seem intricate initially, it’s a one-time setup, ensuring a smooth and personalized GhostMove interaction.