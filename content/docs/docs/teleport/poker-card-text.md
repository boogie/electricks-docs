---
title: Poker Card from Text
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "6bc33bd"
---

# Poker Card from Text

This feature lets you display a playing card image on Teleport, using a simple text input like `"AD"` for Ace of Diamonds or `"10H"` for Ten of Hearts. It’s perfect for effects where the card is identified through RFID, a Swami input, or coming from other integrations.

Like other Teleport reveals, this routine uses a remote trigger (SBMote, Atom, PeekSmith 3, etc.) to reveal the card image at the right moment.

[youtube:IumYZXyneyY]

## Configuring and Sending The Card to Teleport

To use this routine, you’ll need to configure a quick trigger (using SBMote or a similar device) and save the message you want to send.

Step 1:Configure Action Control
Once Teleport is connected in the PeekSmith app:

- Open the Settings menu.

- Scroll down to find Action Control.

- Enable Monitor Volume Button.

- Under the Volume Up section, select Playing Card to Teleport.

This tells the app what action to perform when you press the assigned button (like SBMote’s top button). You can also assign actions to PeekSmith 3 button presses or an Atom button press. To do that, go to the “Details…” page of the device, and you will be able to assign actions.

Step 2: Prepare the Card Text

Make sure the card is available as text in the format:

- “AS” = Ace of Spades

- “10H” = Ten of Hearts

- “KC” = King of Clubs

- and so on.

This text can come from external sources like:

- Swami input

- RFID/NFC systems

- Other integrations

- Manual entry in the PeekSmith app (for testing/demo)

Let’s enter the text manually:

- Go to the Play screen in the PeekSmith app.

- Tap Send Text.

- Enter your card (e.g., “QH”).

- Tap Send.

This saves your text (and display it on a PeekSmith or a Bond if connected) so it’s ready to be triggered.

Step 3: Send Text to Teleport
Now, when you press the assigned button on your SB Mote, the saved card is instantly sent to your Teleport screen, appearing as a card photo.