---
title: Web Polling
updated: "2024-11-29"
author: Electricks
category: guides
sidebar: "297a4df"
---

# Web Polling

## Integrations with Other Apps
 
Web polling can be used to integrate the PeekSmith app with a variety of magic apps and devices, as listed on our Compatibility page under the “Web Based” section. It can be useful for retrieving real-time updates or new information from a web source.

Web polling involves the app checking another app’s database at a designated URL at set intervals, downloading any new text found at that URL, and displaying it on the device’s screen.

This feature requires an internet connection in order to work.
 
## Steps
 
These are the steps you should follow to try this feature:

- In the PeekSmith app’s Settings tab, go to the Display Web Data section.
- Turn on “Enable WEB data polling”.
- Tap the “Manage” button to Manage WEB data sources.
- Turn off all sources, except the “Test (current time)” source.
- Tap on “Save and close” at the top right corner of the screen.
- Tap on the “Start” button of “Start / stop polling”. The app will start downloading data from the specified sources, and display it on the device’s screen.
- You should see the actual GMT time on the PeekSmith’s screen. It will change every X seconds you have specified at the source.

To work with other sources (like Inject, or WikiTest), go again to Manage, turn off the “Test (current time)” source, and turn on the source you would like to use. You can turn on multiple sources, but for a start, you should try with one source only. Sources might need further information from you like Inject 2 needs your Inject ID, or WikiTest needs the URL you get when you buy the “Pro Tools” in-app purchase in WikiTest. Make sure you turn on polling with the “Start” button.

Most of the sources need you to set a polling interval. If you set it to 1 second, the app will check the source every second. It can be convenient for you, but the web servers of the source might be overloaded. We recommend selecting the interval that is the largest works with your routine. If you need quick updates, as you would like to reveal the information quickly, you should set a low value. If you will reveal the information minutes later, setting a higher value (like 5 seconds) can be okay for you.
 
## Other Apps
 
For further information, you might need to consult with the developer of the other application.