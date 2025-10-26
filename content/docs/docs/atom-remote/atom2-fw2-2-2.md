---
title: Atom 2 Firmware v2.2.2
updated: "2024-09-16"
author: Electricks
category: guides
sidebar: "aa887b8"
---

# Atom 2 Firmware v2.2.2

## What's New

 
 
 
 
 With this firmware update, you can access five keyboard layouts, facilitating input across various apps supporting basic input fields or Bluetooth keyboard connectivity.

 
 
 
 
 ## Quick Try

 
 
 
 
 Once you are ready with the update, follow these steps to try the new keyboard support:

- Turn on Atom 2 by pressing the power button

- Go to your phone’s Bluetooth settings, and pair Atom. On iOS it will be listed at the bottom. On Android, go with Pair New Device.

- Accept pairing (You don’t have to share contact data on Android).

- Go to a Notes app (or any app you can enter text). On iOS, if you need to use the virtual keyboard, press the power button on Atom to display it.

- Launch the numeric keyboard mini-app: double-click the power button (Atom’s LED will go cyan), then press button #7 (third row, first).

- Press the buttons of Atom, and they’ll type in numbers. Button #10 is ENTER, #12 is BACKSPACE.

- You can use it in your favorite app to enter numbers.

 
 
 
 
 ## Turning Atom 2 ON and OFF

 
 
 
 
 You can turn ON Atom 2 with the power button at the bottom of the device. You can turn it OFF by long pressing the power button.

When Atom is on a charger, you cannot turn it ON.

When Atom is OFF and on the charger, you can reset all your settings if you are long-pressing button #12 (bottom-right) for a few seconds (it will vibrate a short 3 times, then a longer one). This feature is there, but use it only when necessary. It will not erase Atom’s Flash drive (apps and other data).

 
 
 
 
 ## Bluetooth Keyboard

 
 
 
 
 Atom 2 now functions as a Bluetooth Keyboard, seamlessly emulating typing on your phone across all applications.

When you connect Atom to a device (iOS, Android, Windows, Mac), it will offer pairing them. If you allow it, Atom will automatically connect to your device immediately as you turn it on. If you don’t need it, visit your Bluetooth settings to unpair Atom.

On iOS if a Bluetooth keyboard is connected, the operating system hides the virtual on-screen keyboard – click the power button to show it.

You can choose to no allowing it to pair. The Bluetooth connection will still work with the Atom Editor or apps like PeekSmith / TimeSmith – but it will ask for pairing the next connection next time.

By default, nothing will happen when you press a button, because Bluetooth keyboards are built-in mini-apps, and you need to launch them.

Bluetooth keyboards have different layouts on iOS and Android, you can configure which operating system you will connect Atom to enter text. You might not notice the difference now, but it will be important later.

French, and German (and UK/US) alphabets are available in MagiScript.

 
 
 
 
 ## Launching Mini-Apps

 
 
 
 
 10 built-in mini-applications came with the firmware. These mini-apps connected to your PeekSmith 3 and/or SB Watch automatically.

*Standalone Apps*

- 

- #1 – Atom Time (to set the time on an SB Watch without a phone)

- #2 – Atom Stack (enter a card and it will display the next cards in the selected stack – it is for practicing the stacks)

- #3 – Atom Pi (please note that Pi starts with 3, so we assigned it to this button – enter a 4 digit number and it will display Pi Revelations information by David Penn)

- #4 – Atom Square (a square has 4 sides, so we assigned this app to button 4 – enter a number between 25 and 99 and a magic square will be displayed)

- #5 – Atom Practice (practice entering time to learn working with Atom)

*Keyboard Apps*

- 

- #7 – Numeric Keyboard (to enter numbers)

- #8 – Nokia Keyboard (to enter text)

- #9 – Cursor Keyboard (for Inject 2 – to move up-down-left-right)

- #10 – Media Keyboard (to set volume, play previous/next song, play/pause/mute music)

- #11 – Custom Keyboard (by default it types in the English WikiTest words – app is by Marc-Kerstein)

Turn on Atom, and you have 5 seconds to launch an app by pressing the button assigned to the app. Later you can launch an app by double-clicking on the power button and pressing the app’s button.

To exit the app, double-click the power button and press button #12.

You can set an app to launch when you are turning on Atom. For this, press and hold the power button and press the app’s button. Don’t press the power button for a long time, otherwise it will turn off the device.

Launcher is a system feature now (it was previously a mini-app).

**MagiScript Updates**

- 

- keyboard.type now supports German and French special letters like ä or ü.

- peeksmith.id() and sbwatch.id() returns the connected device’s Bluetooth name, or undefined

- strSub improvements: you can specify a negative length parameter which means until the xth character from back the end of the string

- if you double, triple (and so on) click a button, it will send a “click3” event value, where 3 is the number of the clicks (one click is “click”)

- voice.say("hello") says hello on your computer when Atom is connected to the editor, and behaves similarly when Atom is connected to the PeekSmith app.

- sound.play("tom1") plays predefined sounds (“tom1”, “tom2”, “tom3” are available now) on your computer.

- config.get() and config.set() functions to query (and use) and set Atom settings.

- keyboard.send() is a smart function, you can send special keys, but simple strings like “hello”, too. For example, keyboard.send("Hello World!", "#ENTER", "#PLAY") types “Hello World!”, presses the ENTER, and plays (or pauses the music)

- peeksmith.connect() and sbwatch.connect() can be called with no parameters, it will connect to the device you configured (it is ‘*’ by default, which means the first PS or SBW it finds)

- there are events for connecting and disconnecting PeekSmith and SB Watch

- sbwatch.print() and sbwatch.vibrate() are ready for SB Watch 2.

Atom can directly connect to PeriPage printers now. It is not a finished feature, we will talk about it in the future.