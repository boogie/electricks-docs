---
title: Basics
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Basics

## Welcome

Congratulations on taking the first step to become a MagiScript programmer! MagiScript Editor is a platform where you can edit and upload your own mini-apps.

Please note that Atom can be connected to multiple devices simultaneously. While developing your mini-app, you can also keep it connected to an app on your phone.

Requirements:

-

- A desktop or laptop machine running Chrome, Edge browser with Bluetooth connectivity . These days most laptops have built-in Bluetooth, while for a (Windows) desktop you might need to buy a Bluetooth dongle. Chrome on Android might work, but the editor screen is not optimized for mobile.

- Atom, our intelligent remote that can run MagiScript.

## How to Connect?

![](https://electricks.info/wp-content/uploads/2025/03/magiscript-editor-connect-768x550.png)

On the [MagiScript Editor](https://msedit.electricks.info/) page click the “Connect” button, and a window will pop up showing all available devices. Select the desired device and click the “Pair” button.

![](https://electricks.info/wp-content/uploads/2024/08/mac-pairing-request-768x357.png)

You might see a window prompting you to pair your device. If you want to use Atom as a keyboard with your computer, select “Connect.” If not, choose “Cancel.” We recommend selecting “Cancel” and testing or developing the Bluetooth keyboard mini-app using your phone instead.

The MagiScript Editor also allows you to install the latest Atom firmware. If a new firmware release is available, an update window will appear.

## Layout

![](https://electricks.info/wp-content/uploads/2025/03/magiscript-editor-layout.png)

After connecting to your device, you will see the following sections:

Header

Top left: connected device name, battery voltage and the firmware version Top right: optional firmware upgrade or downgrade button

Toolbar

- App Store : load example mini-apps

- New : start with an “empty” mini-app

- Load : load a mini-app from a file

- Save : save a mini-app to a file

- Upload : upload the mini-app you are developing to Atom

- Persist : save the mini-app to Atom’s storage, it becomes selectable in the launcher

- List of Mini-Apps : manage the mini-apps available on your Atom device (built-ins and the mini-apps you persisted)

- Settings : several settings of your device

 
Help

You can read the first steps instructions and find some keyboard shortcuts.

Logs

System messages will appear here, and you can also send messages from the Magiscript application with the `console.log` command.

Documentation

Here you can find all the documentation and information about MagiScript.

Atom Commands

You can enter special commands here, which will be sent to Atom as Bluetooth messages. In most cases, you won’t need to use this feature.

Footer

Here you can see the current app, a message, the devices connected and the battery level percentage of Atom.