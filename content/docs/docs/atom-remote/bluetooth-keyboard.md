---
title: Bluetooth Keyboard
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "aa887b8"
---

# Bluetooth Keyboard

## Introduction

Atom functions as a Bluetooth keyboard, enabling you to input information directly into apps on your phone.

Please note that this feature works only when the app is active, compatible with Bluetooth keyboards, and the screen is unlocked.

Make sure you have the [latest firmware](https://electricks.info/docs/atom-remote/firmware-upgrade/). Bluetooth keyboard support has been introduced with a firmware update.

## Pairing Atom

When Atom works as a Bluetooth keyboard, operating systems (iOS, Android, Windows, Mac) will need to pair it. It is a Bluetooth term to set up safe communication between two devices. For example, this dialog will appear on iOS. Expect to see similar dialogs on Android, Windows and Mac as well. Please note that Atom can be paired with only one device at a time.

![atom2-pair-request](https://electricks.info/wp-content/uploads/elementor/thumbs/atom2-pair-request-r3173kcxie418k07ngxp0niy7n305aoeo8wey7wzte.png)

When the pairing dialog appears, you have two options:

- Canceling the pairing will prevent Atom from functioning as a Bluetooth keyboard.

- Selecting “Connect” will allow it to pair and function as a keyboard.

Canceling the pairing can be useful when using the [MagiScript Editor](https://electricks.info/docs/magiscript/basics/) on a desktop to develop mini-apps. If you cancel, you’ll be prompted to pair again the next time you connect.

Occasionally, you may need to re-pair Atom – this can happen after pairing with another device, a firmware update, or similar changes. If Atom connects briefly and then disconnects, it’s likely time to re-pair. Check our [Troubleshooting Guide](https://electricks.info/docs/atom-remote/troubleshooting/) for steps on how to remove the pairing from your phone’s Bluetooth settings.

Once paired, most operating systems will automatically reconnect to Atom when you turn it on. However, note that this does not establish a connection to an app – you’ll still need to connect to your app manually as before.

## Caveats

On iOS, when a Bluetooth keyboard is connected, the onscreen virtual keyboard is automatically disabled. However, pressing Atom’s power button will bring the virtual keyboard back.

If you pair Atom with an operating system (Windows, Mac, iOS, Android), the pairing with another operating system may fail. You will have to “forgot this device” and pair it again to connect.

## Keyboard Mini-Apps

We created many [built-in mini-apps](https://electricks.info/docs/atom-remote/built-in-mini-apps/) to use Atom as a Bluetooth keyboard. If you would like to modify them, our [MagiScript documentation](https://electricks.info/docs/magiscript/) includes their source code or you can create your own with MagiScript’s [Bluetooth Keyboard](https://electricks.info/docs/magiscript/bluetooth-keyboard/) support.

- [Numeric keyboard](https://electricks.info/docs/atom-remote/numeric-keyboard/) – enter numbers

- [NOKIA alphanumeric keyboard](https://electricks.info/docs/atom-remote/nokia-alphanumeric-keyboard/) – enter any word

- [Cursor keyboard](https://electricks.info/docs/atom-remote/cursor-keyboard/) – for Inject 2 (for example)

- [Media controls](https://electricks.info/docs/atom-remote/media-controls/) – control music

- [Custom keyboard](https://electricks.info/docs/atom-remote/custom-keyboard/) – type WikiTest keywords, setup your own keyboard

## International Keyboard Support

Bluetooth keyboards are sending keyboard positions, not the exact character associated with that key. For example, on a German or Hungarian “QWERTZ” keyboard (if that’s your OS setting), when the keyboard sends “0”, an “ö” character will be typed. On a French “AZERTY” keyboard when the keyboard sends “a”, then the “q” character will be typed. The selected keyboard layout defines which characters Atom will be able to send.

Operating systems are handling the situation differently. You are likely to use an iOS or Android phone with Atom, and perhaps a Windows or Mac for development. You will know the settings of the device you are working with, but you can also connect Atom to a spectator’s phone. This allows you to perform a lock screen effect or to type a prediction on their phone, however, their keyboard settings will be unknown.

Currently we support a keyboard variation called “International Keyboard”. We have tested it with both iOS and Android. By default, all the English letters and other characters are working, and additionally some accented letters (mostly Western European) are working as well, but to have them, make sure you configure your OS in the Keyboard section of [Atom Settings](https://electricks.info/docs/atom-remote/). Currently, the accented characters are available with MagiScript only, no built-in mini-apps supports entering them.
