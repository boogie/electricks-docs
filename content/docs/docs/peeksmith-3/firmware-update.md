---
title: Firmware Update
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "297a4df"
---

# Firmware Update

## Firmware Version

Firmware is a type of software that is running on a device, such as PeekSmith 3, and controls its hardware functions. It’s like the operating system of a device, but it’s specifically designed to manage the hardware and low-level functions.

To update with the PeekSmith app, always make sure you are logged in with your Google or Apple account.

You can check which firmware version you have on your PeekSmith:

[youtube:CjgM07gLl1U]

## Issue with Earlier Firmware (<v1.5.7)

PeekSmith 3’s firmware controls its basic functions and features, such as how it controls the screen, how it connects to other devices, how it processes data, and how it responds to user input. Updating the firmware can improve performance and add new features to the device.

If you are trying to update the firmware of a device from an iPhone 11, iPhone SE 2, or any iPhone with iOS 16.1 or later , and your device has an earlier firmware version than v1.5.7, then you may experience issues with the update process.

In order to fix this issue, you can use a different device to perform the update (simply borrow an Android phone, or use an older iOS), or you can try updating the firmware through a browser . Please note that this issue also affects macOS Ventura and Sonoma.

After updating the firmware to v1.5.7 or a later version, this issue should no longer occur.

## Updating with the PeekSmith App

Watch the following video about updating your device with the PeekSmith app.

Make sure:

- You have the latest PeekSmith app
- You are logged in with your Google/Apple account

The update option should appear on the home screen as a yellow button.

Just follow the instructions on the screen.

[youtube:B5bP7pCGhow]

## Updating with a Browser

Updating the firmware on your PeekSmith 3 device is straightforward with our browser-based updater tool as well. This tool uses Web Bluetooth to communicate with PeekSmith and is available on desktop browsers like Chrome, Edge (Opera, Safari and mobile browsers are not supported). You will need a desktop or laptop machine with Bluetooth. Recent computers have Bluetooth support (to connect with a wireless keyboard or a mouse). Make sure it is enabled.

To begin the firmware update process, make sure that your PeekSmith 3 is turned on and has at least 10% battery. If the battery is low, charge it before starting the update.

Releases:

v1.9.9 is the latest firmware we have released. It is our most stable edition. [DOWNLOAD](https://peeksmith.electricks.info/ps3_202505270710_v1.9.9.bin)

Steps:

1. Download the latest firmware you would like to upgrade your device to. We have linked the available firmware from the link above.
2. Open our firmware update tool in a compatible browser: [https://boogie.github.io/mcumgr-web/](https://boogie.github.io/mcumgr-web/)
3. Connect to your PeekSmith 3 by pressing the Connect button on this page. Make sure that PeekSmith is not connected to your phone. Type “PeekSmith” (without quotes and paying attention to letter case) into the input field to ensure that only your device is listed.
4. The page will list the firmware available on your device. There are usually two firmware images available, with the first one being the active one.
5. To make room for the new firmware, press the Erase button to delete the second firmware image. The connection may be lost at this point. If the page is not reconnecting properly to your PeekSmith, try reloading the page and connecting again. If nothing happens when you press the button, move on to the next step.
6. In the Image Upload section, press the Select file button to choose the new firmware.
7. You should see the new firmware’s version number and other details. Press the Upload button to send the new firmware to your PeekSmith 3.
8. If the connection is lost during the upload process, reload the page and repeat step 5.
9. Once the new firmware has been uploaded to your PeekSmith, press the Test button to flag the firmware for activation. The next time you turn on your PeekSmith, it will set the new firmware as active and start it up.
10. The new firmware should now be marked as “Pending: true”. Press the Reset button at the top of the page to restart your device and install the new firmware. This process should take about 30-40 seconds, the LED will be ON.
11. When the new firmware is ready and running, the page should reconnect to your PeekSmith 3. If it doesn’t, reload the page and connect again.
12. Confirm that the new firmware is active by checking the first slot. If it’s still in the second position, repeat the process from step 9.
13. The new firmware is not yet permanent. If you restart your PeekSmith, it will downgrade to the previous firmware. If you can connect to PeekSmith via Bluetooth, the new firmware is working. Press the Confirm button to make it permanent.

Please note that beta firmware may contain bugs. If you experience any issues during the update process or with the new firmware, please report them. Enjoy the new features!

Using this tool, you can also downgrade the firmware to a previous version. To do this, follow the steps for updating the firmware, starting at step 9. Once you reach the Test button, use it to flag the previous firmware for activation. Then, confirm the downgrade by pressing the Confirm button to make it permanent. Keep in mind that downgrading the firmware may remove any new features or improvements that were added in newer versions.

In addition to updating the firmware with a newer version, it is also possible to downgrade the firmware by uploading an older version. However, we strongly recommend only doing this when instructed to do so by our team, as downgrading the firmware may remove any new features or improvements that have been added in newer versions. Proceed with caution when considering a firmware downgrade.

## Downgrading on the Device

Starting with firmware version 1.5.7, we’ve added a feature that allows you to switch back to a previous firmware version directly on your PeekSmith 3 device. Here’s how to do it:

- Turn off your PeekSmith
- Press and hold the side button and the right button at the same time – do not release the buttons until you enter the System menu.
- Press the left button to access the “Switch to Firmware vx.x.x” option.
- Press and hold the right button until the device restarts.

This will switch your PeekSmith 3 back to the previous firmware version. Keep in mind that downgrading the firmware may remove any new features or improvements that were added in newer versions.