---
title: Quantum Settings
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a56f609-quantum"
---

# Quantum Settings

### Configuring Your Quantum

You can configure your Quantum device using the free PeekSmith app.

First, connect your Quantum in the app, then tap the Details… button next to its name on the Settings page to open the Quantum Settings screen.

Here, you can:

- Disconnect Quantum
- Check firmware version and battery level
- Configure key behavior and connected devices

### Firmware Version

This section displays your current firmware version.

The factory version is v0.9.1 , but we recommend updating to the latest version for new features and improvements.

### Battery Level

Shows the current battery percentage.

💡 We recommend charging your Quantum to 100% before your performance to avoid interruptions.

### PeekSmith App settings

[youtube:K88eAe5BuRk]

### General Settings

Backlight level

You can adjust the backlight level, which sets the segments’ blackness on the display.

Peek Text

When enabled, the PeekSmith app will send all text to Quantum (just like it does for PeekSmith, Bond, SB Watch 2, or MrCard).

Note: Quantum uses a 7-segment display, so it’s not ideal for reading long text – but it can be a bold and innocent peek when used cleverly.

Show Partial Result

By default, Quantum behaves like a standard calculator, showing partial results.

For example, entering 100 + 100 + shows 200 on screen.

However, during performances where multiple spectators enter values and a final result is forced, it’s better if they don’t see intermediate totals.

Turn Partial Result off to only show the last entered number – this keeps the final outcome more mysterious.

### Devices

Here you can define which external devices Quantum should connect to.

By default, the setting is * (displayed as “any”), meaning Quantum connects to the first compatible device it finds. 

You can also enter a specific device name (e.g., PeekSmith-031234) to ensure Quantum connects only to that one.

When you enter a specific device name, pay attention where you use lowercase , capital letter and space. (one mistake and you can’t connect to your device)

If you entered the device name correctly, it will appear in a green box. If not, it will appear in a red box.

💡 Quantum will attempt to connect when needed – such as when launching a mini-app.

### Force Settings

These settings are used by the default [ Q-Force ](https://electricks.info/docs/quantum/q-force/) mini-app:

- Force Number : The number that will be displayed when = is pressed, if forcing is active.
- Force Range Min / Max : The force is only applied if the actual calculated result falls within this range.

These options let you control when and what number is forced.

PeekSmith Peek

Enable this to mirror Quantum’s screen to a PeekSmith device.

PeekSmith Toggle Force

This lets you toggle the force on or off using a button on your PeekSmith or Bond device – useful for hands-off control.

Slide Sets Force

It allows you to set the force on the Quantum.

- UP: Force Mode Off
- 5/4 : Lets you to use PeekSmith Toggle Force Also you can use the opening brace “(” by press and holding to set a force number or turn on/off the Force Mode. The closing brace “)” by press and holding lets you to enter a new forced number.
- CUT : Force Mode On

If the Slide Sets Force is  ON and you switch it to the  UP/CUT you can’t turn the Force Mode On/Off with other devices.

### Sequence

The [ Q-Sequence ](https://electricks.info/docs/quantum/q-sequence/) mini-app allows you to assign up to 8 actions to numbers entered during a calculation.

For example, you can assign an action like Set Time , so when a specific number is entered, Quantum will interpret it as a time and send it to an SB Watch.

This opens up powerful possibilities for multi-step routines and silent device control .

- Set Time
- Mirror To Quantum
- Type and Submit
- Show Magic Square
- Show Pi Revelation

### Type

Chaniging the Typing Mode allows you to configure the [Q-Type](https://electricks.info/docs/quantum/q-type/) mini-app.

Key by Key : Displays the name of each key you press, except:

- Delete → deletes the last character
- ON/AC → creates a new line

Calculator Tape :  Shows partial results, final results, and operation symbols

Result: Full : After the equal “=” sign, shows the full result followed by an Enter (new line)

Result: Last 2 : After the equal “=” sign, shows only the last two digits of the result followed by an Enter (new line)

Numbers only : Only number keys are shown

- Decimal point “.” → dot
- Delete → deletes the last character
- ON/AC → Enter (new line)
- All other keys → space