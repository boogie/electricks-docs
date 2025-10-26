---
title: Roadmap
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a56f609"
---

# Roadmap

## Our Most Versatile Product

Bond has been meticulously designed to be highly compatible with PeekSmith 3. If you’re already familiar with PeekSmith, you’ll find the experience seamless. That said, Bond is still in its early stages, and while we’ve made great strides, some features are still in development. Here is a list of the functional features, along with a roadmap for what’s coming next. Please note that standalone mode (Bond without a phone) is not yet available, but it’s on our radar.

## Home Screen

Bond offers an interactive Home Screen. It will be replaced once we add watch features and standalone features, but it is acting like a quick demo of the features, too. It is only active when no app is connected.

You can wake up the screen by pressing the button or touching the screen, and it will stay on for a few seconds. You can see the current brightness value at the top-left of the screen, the temperature at the top-middle and the battery percentage at the top right. Touch the temperature to switch between Celsius and Fahrenheit. Swipe up and down on the screen to change the brightness.

The home screen also displays the URL of this documentation and if you touch it, it displays the serial number of your device.

The plan is introducing a configurable watch face with one of the next releases.

## Basics

The most basic goal of Bond and PeekSmith is to display information for the magician. It should be easy to read, available as long as the magician not reads it, and offer as much information as possible.

Here’s what’s available:

- Text Engine : Bond offers 5 different size of the “PeekSmith font”, however we are not using the smallest. The text engine is automatically resizing the font depending on how much text should be displayed. The largest font can display 5 letters in a row, and 3 rows, and the smallest can display 14 letters in a row and 9 rows. On a single screen the text can be aligned left, center and right, and top, middle and bottom. There’s a special view to display lines of text from the bottom up. The first line can be set to a different color and font size as the rest. These can end up displaying one highlighted information and a complex history or meta information. We will experience with more kind of presentations to utilize the huge screen.
- Smart Text : Bond, just like PeekSmith 3, features smart text recognition. It detects poker card names (such as AH or 10S), colors, single-digit numbers, and individual letters, then displays them graphically. This is always enabled now, will be configurable later.
- International Fonts : currently only the Latin character set is supported. We plan to add Hebrew and Arabic text support with one of the upcoming firmware (it is available with the Roboto font on PeekSmith 3).
- Scrolling : scrolling is not available. Bond can display so much text, that it might be not important to implement it.
- Drawings : drawings from impression pads, or the Doodle feature of the PeekSmith app is working well. Not yet tested with other apps – it might work or not.
- Images : as far as we know, only the PeekSmith app is sending images, when it is sending resized (“zoomed”) drawings. It is currently not supported, so the drawing you see on Bond’s screen will be not zoomed. Thanks to Bond’s high-res display it is not critical to have zoom, but it will be implemented.
- Cards and Dice : Bond can display up to 3 cards and up to 6 dice values. Currently the presentation of them is not configurable. Displaying dice might have a bug in the first firmware.
- Vibrations : the vibration engine is fully capable. Apps can send complex vibration patterns while Bond is on your wrist or in your pocket.
- Buttons : Bond has one physical button, that is acting like PeekSmith 3’s side button. By default, the touch screen emulates two additional buttons, tapping on the left is acting like PS3’s front-left, tapping on the right is acting like the front-right button. You can assign actions to these buttons in the compatible apps.
- Touch Screen : the touch screen sends drawing and 4 directions of swipes. The PeekSmith apps’ Doodle and Swami features are already using the drawing functionality.
- Accelerometer : the accelerometer reports X, Y, Z coordinates and movement information. Taps on the watch body not yet reported.
- Raise to peek:  it turns on the clock
- Thermometer : Bond can measure and display the current temperature. It is displayed on its home screen, and the PeekSmith app can display it as well.
- Settings : configuring Bond is mostly missing. You can temporarily set some features, and some settings are remembered by the app.

## App Compability

We have tested Bond with some of Benke’s apps and they worked. There’s no information yet about other apps, however Bond advertises itself as a PeekSmith 3, so in general they should work.

We are sending Bond devices to some developer friends to ensure maximum compatibility.

## Future Plans

We’re constantly exploring new ideas to enhance our product. While we can’t make any guarantees, here are a few features we’re considering. Rest assured, we’ll do our best to bring them to life!

- watch face, smartwatch like features

- standalone mode to connect to other Bluetooth devices (like Spotted Dice, SB Watch, etc.)

- Bluetooth Keyboard mode to enter numbers or cursor moves with swipes

- and more…