---
title: Troubleshooting
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "aa887b8"
---

# Troubleshooting

## Reporting an Issue

Before reaching out, please take a moment to explore our documentation – many common questions and solutions are already covered.

If you still need help, visit our dedicated [Reporting an Issue](https://electricks.info/docs/misc/get-help/) page for full details.

When contacting us, including the following details will help us assist you faster:

- What device are you using?  (iOS or Android)

- What is the firmware version  on your device?

- When and where did you purchase it?  Please include your  order ID  if available.

- What exactly is the issue?  Describe what happened and what you expected.

- Can you record a short video?  Seeing the issue helps us understand and solve it more quickly.

You can reach us via our [Contact Us page](https://electricks.info/contact-us/). We’re here to help!

## Can't Connect to the Atom Remote

If you are experiencing difficulty connecting your device to your phone, it may be due to a setting issue or a low battery. Even if the device seems to be functioning on its own, the device may not have enough power to maintain a Bluetooth connection. To troubleshoot this issue, you can check the following:

- Make sure Bluetooth is enabled on your phone.

- Check that the device is turned on. Do you see any sign that it is working?

- Ensure that no other devices or apps are currently connected to the device.

- Consider charging the device or replacing the battery if you have not done so recently.

- Keep in mind that phones have a limit on the number of devices they can connect to at one time. If you have many other devices (such as a fitness band or earphones) connected to your phone, try disconnecting some of them to see if this resolves the issue. Most modern phones can connect to 10-16 devices at once.

- Try restarting your phone, or moving at least 20 meters away from other devices to see if this helps to disconnect any other devices that may be connected to your watch.

- You do not need to connect to the device from your Bluetooth settings. The dedicated app will handle the connection process.

Try deleting the Bluetooth pairing from your phone and reconnecting the device. Sometimes Atom needs a new “pairing key” for the encrypted communication. Here’s the process of how you can reset it:

For Android:

- Make sure that GPS is enabled on your device. GPS may be required for Bluetooth communication to work properly.

- Allow the app to access Bluetooth and/or location services.

- Note that there may be some bugs in the Bluetooth implementation on Android devices. If you are experiencing connection issues, try turning on and off the flight mode, or restarting your phone.

- Open Settings: Navigate to your phone’s Settings app.

- Bluetooth Settings: Tap on Bluetooth or Connected devices (this may vary depending on your device).

- Paired Devices: Find and select the device you want to remove from the list of paired devices.

- Forget Device: Tap on Forget or Unpair to delete the pairing.

Now try it again, and accept pairing.

For IOS:

- Allow the app to access Bluetooth and/or location services.

- Open Settings: Go to the Settings app on your iPhone.

- Bluetooth Settings: Tap on Bluetooth to view the list of paired devices.

- Select the Device: Find the device you want to remove and tap the i icon next to it.

- Forget Device: Select Forget This Device and confirm to delete the pairing.

Now try it again, and accept pairing.

## Connect to Atom with Several Devices

You can connect Atom to several devices at a time, but it can be paired to only one device. If you see that Atom connects for a second and then disconnects, you need to delete pairing and reconnect the device.

Here’s how to do it:

For Android:

- Open Settings: Navigate to your phone’s Settings app.

- Bluetooth Settings: Tap on Bluetooth or Connected devices (this may vary depending on your device).

- Paired Devices: Find and select the device you want to remove from the list of paired devices.

- Forget Device: Tap on Forget or Unpair to delete the pairing.

For iOS:

- Open Settings: Go to the Settings app on your iPhone.

- Bluetooth Settings: Tap on Bluetooth to view the list of paired devices.

- Select the Device: Find the device you want to remove and tap the i icon next to it.

- Forget Device: Select Forget This Device and confirm to delete the pairing. After removing the pairing, try reconnecting the device to see if the issue is resolved.

## What Do Different Colored LEDs Mean?

The yellow blinking LED indicates that Atom’s battery is critically low or completely drained. To resolve this, connect Atom to its charger and allow it to charge for a few minutes. While charging, the LED will pulse yellow (drained battery), then red (low battery) as it gains charge. Once the LED turns solid green , Atom is fully charged, which usually takes about an hour.

## My Atom is Not Connecting to my X Device (like PeekSmith or SB Watch)

Ensure that the other device isn’t already connected to another app or device. It’s helpful to temporarily disable Bluetooth on your phone or move away from devices that might automatically connect.

Check your [Atom Settings](https://electricks.info/docs/atom-remote/settings/) to verify the correct device IDs. By default, the IDs are set to *, meaning Atom can connect to any available device. However, if it’s been changed, it might be set to the wrong name. For troubleshooting, reset the ID back to *. If the ID is set to *, Atom will connect to the first device it finds, which may cause it to connect to the wrong one if you have multiple devices. To resolve this, set the ID to the exact name of the device you want to connect to. Be sure to enter the full name correctly, with proper capitalization and no typos. For further troubleshooting, you can connect Atom to the MagiScript Editor and monitor the logs for connection attempts when a mini-app tries to connect to a device.