---
title: NFC/RFID Reader
updated: "2024-11-29"
author: Electricks
category: guides
sidebar: "297a4df"
---

# NFC/RFID Reader

## Overview

 
 
 
 
 The PeekSmith app supports reading NFC/RFID cards through two distinct methods. This feature allows you to identify specially embedded objects, such as poker cards or ESP cards, equipped with NFC/RFID chips, seamlessly integrating modern technology into your magic performances. These kind of cards are available from Electricks: RFID/NFC cards.

 
 
 
 
 ## What is NFC/RFID?

 
 
 
 
 
NFC (Near Field Communication) and RFID (Radio-Frequency Identification) are wireless communication technologies that allow data to be exchanged between a reader and a tag when they are in close proximity. NFC is a subset of RFID and operates at a shorter range, typically within a few centimeters. RFID and NFC tags contain small chips that can store data, which can be read by an appropriate device. For magicians, NFC/RFID technology is incredibly useful because it allows for the discreet identification of objects like playing cards, poker chips, or other items that can be embedded with these tags. This capability can enhance magic tricks by enabling performers to secretly identify objects in real-time without any visible interaction.

 
 
 
 
 ## Using Your Phone’s NFC Reader

 
 
 
 
 

Using Your Phone’s NFC Reader If your smartphone is equipped with an NFC reader, you can use it directly within the PeekSmith app to read NFC/RFID cards. This method is convenient and requires no additional hardware. Simply hold the card near the phone’s NFC reader, and the app will display the card’s value on the PeekSmith screen.

We are selling compatible NFC/RFID cards (poker, flash and blank face), typically phones can work with both ISO14443A and ISO15693 variations.

Please note, that the PeekSmith app is not writing these cards, but using their unique identifier, and stores their assigned values in the app. This is different than other kind of solutions, where the value of the card is stored on the NFC/RFID tag.

Please check the video below for instructions.

 
 
 
 
 
 
 
 
 
 
 ## Using Hugo Shelley’s Insight / Insight Pro

 
 
 
 
 

PeekSmith app also supports integration with Hugo Shelley’s Insight and Insight Pro RFID readers. These devices are specifically designed for magicians and can read up to three RFID tags (cards) from a distance of up to 9 cm (Insight supports one card, Insight Pro supports three).

We are selling compatible NFC/RFID cards (poker, flash and blank face), make sure you buy the ISO14443A variations.

 
 
 
 
 Reading the cards

 
 
 
 
 Connect to the Insight device in the PeekSmith app – go to Settings, section NFC Reader and press the List devices button next to the Connect Insight title. Tap on your device’s name. Once you read a card with Insight, the detected card(s) will be displayed on the PeekSmith screen (or can be sent to an API or so on).

Originally Insight supported Poker and ESP cards, we extended this support with letter, number and color cards. PeekSmith can display these cards as well. You need nothing extra to read these cards, but for programming, see the next section.

Make sure you turn on Smart Text and configure how PeekSmith 3 should display the cards (check the PeekSmith settings for related configuration).

 
 
 
 
 Programming the Cards

 
 
 
 
 You can use the original Insight app to program the cards. Another option is using the “Experimental version” of the PeekSmith app. We recommend going back to the “Official version” of the PeekSmith app once you finished programming the cards, as it was not updated and doesn’t have the latest features.

To access the Experimental version of the PeekSmith app, simply go to the User Guide’s “Credits and thanks” section, and press the “Switch to experimental” button.

To restore the Official version of the app, go the the User Guide’s “Version history” and press the “Restore official version”. Once you restored it, you might need to update the card.

Please check the video below for instructions.