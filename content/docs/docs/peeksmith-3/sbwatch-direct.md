---
title: SB Watch direct connection · PeekSmith 3
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "297a4df"
---

# SB Watch direct connection · PeekSmith 3

## Experimental Feature

With firmware v1.7.7, we have introduced direct connection functionality with our [SB Watch](/product-category/sbwatch/) watches. When PeekSmith 3 and SB Watch are not connected to a phone or an other device, you can connect them, and you will have these features:

- PS3 button press can set the current time.
- PS3 button press can set a forced time.
- PS3 button press can set ANY time (since firmware v1.7.12).
- PS3 can display the time on the watch.
- PS3 will vibrate when the watch hands arrived.
- SBW crown press can clear or toggle PS3 screen.
- SBW crown press can send a signal, and PS3 will vibrate until the crown released.

This feature will change as we improve the firmware, and we are looking for your feedback.

[youtube:xwCh8YdDlfc]

## Setting Up the Feature

First of all, make sure that your PeekSmith 3 has firmware version v1.7.7 or later and SB Watch has the latest firmware, too. Then you have to “pair” the two devices, and setup the actions assigned to the

- Check your SB Watch identifier (for example, in the TimeSmith app). Your watch name should be something like SBWatch-123456. We will need the 6 digit number.
- Start the PeekSmith app and send the message “*pw*123456” (without the quotes, the number should be your watch’s identifier) to your PeekSmith. It will display a message “Watch Paired SBWatch123456”.
- By default you will be able to force the time 7:14 on the watch, but optionally you can configure an other time by sending the text “*ft*07:14” (without the quotes, the time should be your preferred time). Both the hours and minutes must be 2 digits.
- Disconnect your PeekSmith app, and make sure the watch is not connected to an app or other device (like a remote).
- Setup the actions for the PeekSmith buttons: press the two front buttons to enter the PeekSmith menu, navigate to the Button Press settings by pressing the front left button several times, and you can assign the action to button presses by pressing the right button. For example you can assign “SBW Force” to the front left button, and “SBW Current” to the front right button.
- You can also assign “SBW Quick” to one of the buttons, like the front left button. Pressing this button will initiate a 3-step time setting process, and the watch will display 12:00. First, you can set the hours by using the left (-1 hour) or right (+1 hour) button. The watch will immediately update the time as you press these buttons. Once you’ve set the hours, press the side button to move to the next step, where you can set the minutes. Use the left (-5 minutes) or right (+5 minutes) button to adjust the minutes. Press the side button again to move to the final step, where you can fine-tune the minutes using the left or right button. To exit the routine, simply press the side button again. If you don’t do anything for 15 seconds, the routine will automatically exit. If you’ve configured your PeekSmith 3 to display time, you’ll see the steps indicated by an underscore.
- An other setting called “SBWatch Crown Press” allows you to receive signals from the watch and vibrate PeekSmith 3 until you press the crown, just select Vibrate. Or you can clear the screen, toggle the screen on and off, set the time on the watch as well.
- You can also configure if the watch time should be displayed on the PeekSmith 3 screen, the setting name is “SBWatch Show Time”.
- Exit the menu by pressing the side button on the left of PeekSmith and you are ready.

Now long press the front right button to connect your watch. You should see that it is connected. Its time will be displayed on the screen if you enabled it.

By pressing the buttons you can set the time now. To give you a feedback, PeekSmith will vibrate when the hands arrived.

And you can try pressing the crown if you assigned an action to it, too.

This integration redefines how SB Watch and PeekSmith 3 can be used together and enable you to perform many effects without using your phone.