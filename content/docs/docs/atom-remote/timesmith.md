---
title: TimeSmith
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "aa887b8"
---

# TimeSmith

## Introduction

TimeSmith is the companion app for SB Watch and you can use many input methods, including remotes. This documentation page will guide you through the steps to use Atom with it.

## Prerequisites

Before you begin, you must ensure that you have the following prerequisites:

- TimeSmith app: You must have the latest version of the TimeSmith app installed on your device, at least version v1.8.25.

- Atom: We recommend disconnecting Atom from other apps and devices, and don’t run a MagiScript app on it.

## Connecting Atom with TimeSmith

The first step is to enable the Atom remote support in TimeSmith. To do this, follow these steps:

- Open the TimeSmith app and go to Settings.

- Select the Accessories section.

- Enable the Atom remote option.

Once you have enabled the Atom remote, you need to connect Atom to TimeSmith. To do this, follow these steps:

- Make sure that Atom is ON. The RGB LED should blink in blue.

- Go to the top of Settings, and tap “Select Atom remote”.

- Choose your device and tap on it.

Congrats, Atom is connected to the app.

## Button Layout

Each and every apps and MagiScript mini-apps defines its own button layout. Our most common layout is the “numeric” layout, but even this layout can change how it handles the bottom-left and bottom-right buttons. TimeSmith app also has a different layout when you are on the swipe screen.

[

![](https://electricks.info/wp-content/uploads/2023/04/atom_numeric_buttons_timesmith-1024x658.png)

](https://electricks.info/wp-content/uploads/2023/04/atom_numeric_buttons_timesmith.png)

This is how the TimeSmith app works with the buttons. The bottom-left button clears the entered numbers, and the bottom-right button acts as a backspace.

You can assign additional actions to the buttons in the Atom settings. To run those actions, you have to long-press the button for about a second.

## Setting the Time

Tap the Play icon at the bottom of the screen in the TimeSmith app. You should see here that several input methods are supported.

On the main screen , you can use the buttons as number buttons to type the time you would like to set on the watch. You will see the numbers entered in the small input field. After a few seconds the app is processing the time you entered. To set how long this timeout is, go to Settings, Manual Time Input, and set the “Wait for manual input” according to your preferences.

[

![](https://electricks.info/wp-content/uploads/2023/04/IMG_285D2323E256-1-1024x390.jpeg)

](https://electricks.info/wp-content/uploads/2023/04/IMG_285D2323E256-1.jpeg)

This is how the numbers will be processed:

- Numbers between 0-23 will set the hours to your input. Entering 15 will set the time to 3 PM.

- Numbers between 24-99 will set the hours to the first digit, and the minutes to the second. For example, 48 means 4:08.

- And finally, 3 or 4-digit long numbers will set the minutes to the two last digits, and the hours to the first or firsts. 910 will set the time to 9:10. 1234 will set the time to 12:34.

Incorrect hours or minutes will be corrected. For example, if you manage to enter hours 25, 24 will be subtracted until it is between 0-23, so it will end up 1. The minute 99 will be 99-60, which is 39.

Entering number 4444 or 9999 will set the current time.

## Swipe Screen

![](https://electricks.info/wp-content/uploads/2023/04/timesmith_swipe-1024x869.png)

Optionally , you can go to the swipe input screen, it’s the black button on the main screen, and use the remote buttons as up/left/right/down buttons.

[

![](https://electricks.info/wp-content/uploads/2023/04/atom_swipe_buttons_timesmith-1024x658.png)

](https://electricks.info/wp-content/uploads/2023/04/atom_swipe_buttons_timesmith.png)

The swipe method is explained on our [TimeSmith Swipe](https://electricks.info/docs/sbwatch/clock-swipe/) documentation page

## Conclusion

Using Atom with the TimeSmith app can work as a flexible remote you can use to set the time on your watch.