---
title: Atom Time
updated: "2025-05-27"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Atom Time

## About

 
 
 
 
 Let’s create a basic mini-app to set a time on the SB Watch with a numeric keyboard. The functionality will be similar you can achieve with the TimeSmith app, however, you can directly connect Atom and SB Watch and you will need no phone. This mini-app is called Atom Time.

Technically you only need Atom and an SB Watch, but this app supports PeekSmith 3 as well to display the time entered and to give you visual feedback about the time you set. If you have no PeekSmith connected, then it will be ignored.

We are sharing a basic version, and the source code of the built-in Atom Time mini-app.

 
 
 
 
 ## Basic Version

 
 
 
 
 Let’s start with a basic version. The advantage of this code is that it is shorter, and maybe easier to understand.

After uploading this code to Atom, the main() the function will be called and connect to your PeekSmith and SB Watch. As the device names are not specified, it will use the device names specified in the Settings (* = any device by default). It will display “Atom Time” (\n means a new line, so in two lines) on the PeekSmith as soon as it is connected.

There are three variables declared in the lines 8 – 15. The time variable will contain the time you enter. The timeout variable will contain a timeout variable, which is about sending the time entered after 4 seconds of the last key press. The mapping contains the key mapping, what the keys mean.

The send() function from line 18 is about sending the time to the watch. It is called when you press the bottom left button, or after 4 seconds. The 4 seconds timer (timeout) is cleared to prevent calling the send function again. If the time variable is an empty string, there’s nothing to send, so the code returns. If 4444 or 9999 was entered, it sets the current time, otherwise the time has been entered. Finally the time variable will be cleared.

The onButtonClickfunction is called with the button ID  (between 0 and 11, from top left to bottom right) pressed, and the first line maps it to a string that can be easier to understand than the button ID. If it is s, then it immediately sends the time. If it is <, then it deletes the last number of the time, otherwise it adds the number to the end of the time string. Then it clears the timeout timer, and set it to 4 seconds. Finally, it displays the actual time entered on the PeekSmith’s screen.

The function printFormattedTime is about displaying the time going to be set on the watch. The second parameter is if the hands are moving, if it is true, then two stars will be displayed before and after the time.

And the onEventfunction is responsible for event handling. It cares about the hands started, hands finished and button click events, and calls the printFormattedTime and onButtonClick functions.

 
 
 
 
 
 
 
 function main() {
 ps.connect();
 ps.print('Atom\nTime');
 sbwatch.connect();
 // sbwatch.setTime('12:00'); 
}

let time = ''; // the time entered
let timeout = 0; // will contain a timeout ID
let mapping = [ // button layour
 '1', '2', '3',
 '4', '5', '6',
 '7', '8', '9',
 's', '0', '