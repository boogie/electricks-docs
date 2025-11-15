---
title: Hydra
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "945e687-timesmith-app"
---

# Hydra

## Timesmith App Integration with Hydra

The Hydra Magic app, developed by Shameer Salim, is designed as a magic trick app that utilizes your smartphone to create impressive effects, often focusing on mind-reading and illusion. It integrates different magic performances that can be shown using simple tricks on the device, such as reading a spectator’s mind or predicting outcomes, all aided by the app’s features. It seems to cater to both beginners and experienced magicians by offering tricks that rely on the app’s capabilities and simple setup. 

To integrate Timesmith with Hydra and retrieve the latest time entry, follow these steps:

1. Get the Timesmith API URL ( Available under the user settings -> Tap on your Username )

Use the following API URL to retrieve the latest time from Timesmith: https://bsmagic.app/api/get_last_time_json.php?uid=username
Field: time

Replace USERNAME with your own username in Timesmith e.g., if your username is Benke, the URL becomes:
https://bsmagic.app/api/get_last_time_json.php?uid=benke
Field: time

also you can use the token from TimeSmith:
https://bsmagic.app/api/get_last_time_json.php?token=XXXXXXXXXX
Replace XXXXXXX with your own token in Timesmith e.g., if your Token is WET9868TYC, the URL becomes
https://bsmagic.app/api/get_last_time_json.php?token=WET9868TYC 
Field: time

2. Input the API URL in Hydra

Go to the integration page in Hydra. Enter the API URL you created and then Enter Field by following Step 1. Save the settings after entering the information.

3. Confirmation of Connection Once saved

Your Hydra app will now be successfully connected to Timesmith. Hydra will be able to retrieve the last time set in Timesmith automatically.

## Methods to Set Time in Timesmith

You can set the time in Timesmith using various input methods:

In-App Entry: Use the Timesmith app directly on your device to input the time.

Web Input Method: Go to bsmagic.app/time and log in with your credentials.

You can set the time from any device with internet access, so you don’t need your own phone or the app if using this web method.

By following these instructions, your Timesmith integration with Hydra should be quick and smooth.