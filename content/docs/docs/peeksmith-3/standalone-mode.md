---
title: Standalone Mode
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "297a4df"
---

# Standalone Mode

## About

Standalone mode is about using PeekSmith 3 without a phone. You can connect it to other devices via Bluetooth, and configure it by entering the settings menu.

 

[![](https://electricks.info/wp-content/uploads/2022/12/peeksmith-1024x768.png)](https://electricks.info/wp-content/uploads/2022/12/peeksmith.png)

## Left Button Long-Press - Device Information

If you long-press the left button for 3 seconds, PeekSmith will display the firmware version and some additional information about the device. Firmware is the software running on the device itself. You can find more information about updating it on the[ Firmware Update](https://electricks.info/docs/peeksmith-3/firmware-update/) page.

## Right Button Long-Press - Connecting to Other Devices

If you long press the right button for 3 seconds, PeekSmith will start scanning and connecting to other Bluetooth devices. Make sure the devices are not connected to an application running in the background on your phone. PeekSmith 3 can connect to:

- [SB Watch](https://electricks.info/docs/peeksmith-3/sbwatch-direct/)

- [Spotted Dice](https://electricks.info/docs/peeksmith-3/dice-thumper/)

- Kinetic Mental Dice (by Marc-Antoine)

- [Insight (by Hugo Shelley](https://electricks.info/docs/peeksmith-3/insight/))

- [Rainman 2 (by Labco)](https://electricks.info/docs/peeksmith-3/standalone-mode/rainman-2/)

- [SoulMate Smart Scale](https://electricks.info/docs/peeksmith-3/standalone-mode/soulmate-smart-scale/)

- Audience in Wonderland Pad (Lumen)

- Mindbuster pad (by Labco)

- Telepathy Pad

- Pitata Whiteboard

- Pitata Memopad.

SB Watch can be controlled with PeekSmith 3 – you can assign setting a force time or resetting the watch to the current time to the buttons. It is not working out of the box, you have to follow the[ SB Watch Remote instructions](https://electricks.info/docs/peeksmith-3/sbwatch-direct/) to pair PS3 and the watch, and setup the force time.

[Spotted Dice](https://electricks.info/product/spotted-dice-set/) and Kinetic Mental Dice values should be immediately displayed on the screen after scanning. As you move or roll them, you will see the changes. The moving of a Spotted Dice die is indicated with a green border. You have several options to configure the thumper functionality according to your needs, for further details, please read our[ Dice Thumper](https://electricks.info/docs/peeksmith-3/dice-thumper/) page.

When connected to Insight or Insight Pro by Hugo Shelly, as you read a card (or more) with Insight, it will display the name of the card. Both Poker and ESP cards are supported, and from firmware v1.1.44 you can see all three cards latest Inisght Pro devices can read. Please read our[ Insight related instructions](https://electricks.info/docs/peeksmith-3/insight/).

[youtube:o0t7N6rXy9k]

## Video: Entering the Settings Menu

[youtube:PT1skqyNCPo]

## Front Buttons - Entering the Settings Menu

Since firmware v1.2.1 you can configure PeekSmith 3 by pressing the left and right buttons on the front at the same time. You will see a menu with the available settings. Pressing the side button will close the menu. Pressing the left button will show you the next setting, and pressing the right button will change the setting.

Available settings:

- Card Presentation – PeekSmith can display cards: poker playing cards, ESP cards, color cards. By default it shows their values with text, but you can set it to “Visual”, which will display them as a card image, and to “Visual+Text”, which will display both a card image and text. If you set it to “Visual+Text” but have 3 cards on the screen, they will be presented visually, as there’s no room for text. You will see these cards if you use Insight, or you turn on Smart Text (see below) and send a text like “AH” or “Circle Red”.

- Dice Presentation – PeekSmith can display dice in color on its screen, and you can select how the dice values should be displayed. There are two options: “Dots” and “Numbers”. The default is “Dots”, which represents the value visually as it is on the die, while “Numbers” display them as simple numbers. PeekSmith can also display ESP symbols and colors (designed for Spotted Dice blank dice), this setting will not change their presentation.

- Dice Order – By default, the dice are ordered in connection order (“No Order”), however, you can order them “By Value” and “By Color”. The color order is fixed: red, white, blue, black, and green. Please note that the DiceSmith app offers more options, this setting is only for standalone mode.

- Dice Movement Indication – Spotted Dice (and KMD with recent firmware) can report dice movement. PeekSmith 3 shows a green border around the dice when they are moving. This setting is about how the movement should be indicated. The default option is “border”, but you can set it to “hidden” (the dots or numbers will be hidden when the dice move) or “switch”. With the option “switch” if the dice presentation is dots, PeekSmith 3 will show the dice value with a number while the die is moving, or if the dice presentation is numbers, PeekSmith 3 will show the dice value with dots while the die is moving.

- Dice Thumper Vibrations – PeekSmith can work as a thumper, and vibrate the value of the first die on the screen. You will get 1/2/3 short vibrations for 1/2/3, a long vibration for 4, a long and short vibration for 5, and a long and two short vibrations for 6.

- Smart Text – (previously Text Recognition) if you turn on this option, PeekSmith 3 will check text messages, and if it is recognizing a text as card value, smiley or icon, it will display it graphically.

- Screen Brightness – you can set the brightness level to save battery, or if the screen is too bright (in a theatre, a bright screen can be spotted by a spectator). This will be the brightness when you turn on the device, and while apps can override it, it will be the brighness level again when you disconnect the app.

- Screen Mirroring – when you turn on this feature, the screen will be mirrored vertically. In some situation you can get a better peek of the screen from a mirror (like when you are standing, and PeekSmith is in a card box). By default it would be hard to read, but this feature makes the screen readable. You can see some examples of using a mirror on our [Photos](https://peeksmith.info/gallery) page.

- Thumper Turns Screen Off – 

- Vibration Screen Off – if you would like to use PeekSmith 3 with dice as a vibration thumper hidden in your pocket, you don’t need the dice to be displayed on the screen. This setting turns the screen off on vibration to save power.

- Vibration Num Pattern – there are different ways to represent a number using vibrations. One way is through “Morse codes”, which will always play 5 vibrations – for more about Morse read our article:[ Learning Morse Code](https://electricks.info/docs/misc/learning-morse-code/). Magicians often use a mix of long and short vibrations. When you select “Long means 3”, “Long means 4”, and “Long means 5” it signifies a combination of long and short vibrations, with the long vibrations coming first. For instance, if we consider the number four, “Long means 3” produces one long vibration followed by one short vibration. Similarly, the same setup generates two long vibrations for the number six. If you select “Only shorts”, the number is represented by the total count of short vibrations.

- Vibration Repeats – the vibrations can be repeated, so you can be sure what you felt. With the default “No repeats”, the vibration will be played once, with “One repeat”, it will be played twice, and so on.

- Vibration Strength – depending on how you hide the device (in your palm, in your pocket, attached to your body, etc.), you need to fine-tune the strength of the vibration. A too-strong vibration may make some noise, while a weak vibration might be hard to feel. We have defined 10 different levels so you can find the best for your setup.

- Vibration Short – you can fine-tune the timing of the vibrations, this setting sets how long a short vibration is in milliseconds.

- Vibration Long – this sets the length of the long vibration.

- Vibration Space – between numbers, morse code letters a short pause will be added. You can also add a space character when you send a vibration from the PeekSmith app. The length of this time can be set with this setting.

- Vibration Pause – this sets the pause between each vibration.

- Vibration Repeat Gap – when a whole pattern is repeated, there’s a gap between the repeats – set this long enough to confidently feel that it is a repeat.

- Autoscan at Startup – if you turn this feature on, it will start a scan after you turn the device on – it is equivalent to pressing the right button for a long time after turning on the device. You only need this if you are mainly operating PeekSmith in standalone mode.

- Magnet Sensor Event – PeekSmith 3 has a magnet sensor, and it can report if a magnet is near to it, or just moved away. Please note that the magnet sensor is not ideal for which hand effects, so you might find no use cases for this feature. That said, you can assign actions to magnet events. If you set it to Vibrate, PeekSmith will vibrate for both events. If you set it to Clear Screen, it will clear the screen.

- Side Button Press – you can assign an action side button press. It will work if the device is in standalone mode, not connected to an app. The actions are the same as for magnet events, it can vibrate or it can clear the screen. If you have read the card value came from Inisght, or the dice values, you can clear the screen with this feature.

- Left Button Press – same as the side button press, but for the front left button.

- Right Button Press – same as the side button press, but for the front right button.

- SBWatch Crown Press – when[ SB Watch has been paired](https://electricks.info/docs/peeksmith-3/sbwatch-direct/) with your PeekSmith 3 directly, you can assign an action to the crown press of the watch.

- SBWatch Show Time – when the SB Watch is connected directly, the actual time on the watch can be displayed on the PeekSmith screen when this setting is “Enabled”.

- Drawing Boldness – PeekSmith 3 links up with impression pads directly. You can pick a “Normal” 1-pixel line for detailed drawings or go “Bold” with a 2-pixel line for simpler sketches.

- Drawing Rotation – You can rotate the drawing to better take advantage of the screen’s dimensions. If the drawing fits better on the screen when rotated, it’s a good idea to enable this feature.

- Drawing Auto Clear – If you ask your spectator to write several words or work with more spectators and they are writing multiple words, then you might find this feature useful. By default is “Never”, but set it to a different value (like 15 sec), and if there’s a longer pause between two drawings than your setting, then it will clear the screen when the next drawing starts.

- Reset on Disconnect – when you disconnect the device from an app (like the PeekSmith app), it can keep the settings or it can restart and reset all the settings to the default. We recommend keeping this setting “Enabled”.

- Auto Shutdown If Inactive – turns off PeekSmith after the time of inactivity you set. By default it is 60 minutes . Inactivity means when PeekSmith is not connected to an other device or app, and no button pressed. This feature it to prevent PeekSmith to consume battery when you accidentally leave it on. The device will display a countdown every 5 minutes, and also vibrates a short.

- GhostMove Routine – You can connect up to 3 GhostMove devices directly. Set this setting to “Which Side Up” to display which side of the GhostMove is up, or “Movement” to display which GhostMove is moving. For more about it, please read our GhostMove page.

- Ray Detect Orientation – Automatically detects which direction the Ray is facing and responds accordingly.

- Ray Vibrate On Magnet – Triggers a vibration when a magnet is detected nearby.

- Ray Sensitivity – Adjusts how sensitive the Ray is to magnetic detection.

- Device Indicators – Provides visual or vibration-based feedback to show the current status or events.

- Device Reconnect – By default, PeekSmith 3 will attempt to reconnect to devices for 30 seconds if the connection is lost. You can set it to reconnect indefinitely, but please note that device scanning significantly increases power consumption.

If you would like to disconnect the devices, just turn off and on PeekSmith.