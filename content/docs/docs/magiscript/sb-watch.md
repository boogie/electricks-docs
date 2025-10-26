---
title: SB Watch
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# SB Watch

## About SB Watch Support

The SB Watch support of Atom remote in MagiScript allows developers to connect your SB Watch to Atom, and control the watch using commands. All SB Watch models are supported, including the Steel and Pocket models. Please note that Steel’s Bluetooth range is shorter compared to the other models because of the stainless steel material we have used, so the connection might be not reliable. You can:

- set the time

- reset the time to the current time

- display messages

- send vibrations

- turn accelerometer reporting on/off,

- receive button events

```javascript

```

## Connecting To Your SB Watch

To connect Atom to an SB Watch, you need to use the `sbwatch.connect` method.

If Atom is not yet connected to an SB Watch device, it will start searching for it and then connect. If an SB Watch device is already connected, but the specified name is different, Atom will disconnect from the SB Watch device, and start searching for the specified name.

You can use the `*` character to connect to any available SBWatch device.

The method is flexible regarding its parameters. Let’s review the possible options.

```javascript

```

## Connecting without a Device Name

This is the recommended way to connect, as this way you can share your code and no change will be necessary.

```javascript
sbwatch.connect();
```

You can configure a default SB Watch device ID in the Atom Editor Settings. By default, it is *, which means it will connect to the first SB Watch device it finds.

## Connecting by Specifying a Device Name

You can pass an SB Watch device ID as the first parameter, and Atom will connect to it. For example, to connect to an SB Watch with the ID “SBWatch-166666”, you would use the following command:

```javascript
sbwatch.connect('SBWatch-166666');
```

This is the legacy way, we recommend using it only if you have a specific use case.

## Connecting by Specifying a Device Name and a Callback

As a second parameter, you can specify a callback function. It will be called when Atom successfully connects to the SB Watch device. It will be called immediately if Atom is already connected to an SB Watch.

```javascript
sbwatch.connect('SBWatch-166666', connected);

function connected(event) {
console.log('SBWatch connected.');
}
```

When an SB Watch is connected, then an event will be triggered. Both the onEvent function, and the callback will be called with the event details.

```javascript
sbwatch.connect('SBWatch-166666', connected);

function connected(event) {
console.log('SBWatch connected.');
}
```

## Using the sbwatch.connect Method

```javascript

```

The best way to connect is by adding this call to the beginning of the `main` function, which runs when the code is loaded.

```javascript
function main() {
sbwatch.connect();
// ...
}
```

## Disconnecting your SB Watch

To disconnect your SB Watch, simply call the disconnect method. It will disconnect the active SB Watch device.

```javascript
sbwatch.disconnect();
```

You can also specify by it’s name which device you would like to disconnect:

```javascript
sbwatch.disconnect('SBWatch-036666');
```

## Querying the Connected SB Watch

You can query the Bluetooth name (ID) of the SB Watch device(s) Atom connected to. The id method gives you the active device’s ID, while the ids method returns an array with the SB Watch devices Atom connected to.

```javascript
sbwatch.id(); // the active SBWatch device
sbwatch.ids(); // all the SBWatch devices Atom connected to
```

You can query the connected SB Watch devices as a list of device objects as well using the list method.

```javascript
const devs = sbwatch.list();
for (let i = 0; i
```

If more than one SB Watch device is connected, you can set one of them to active with the select method. Messages will be sent to this unit.

```javascript
sbwatch.select('SBWatch-036666');
```

## Setting the Time on the SB Watch

You can use the sbwatch.setTime() command to set the time on the SB Watch. This will update the watch to display the time. There are many ways to use it, see below:

```javascript
sbwatch.setTime(9); // sets 9:00:00
sbwatch.setTime(23); // sets 23:00:00
sbwatch.setTime(42); // sets 4:02:00
sbwatch.setTime(930); // sets 9:30:00
sbwatch.setTime('9'); // sets 9:00:00
sbwatch.setTime('23'); // sets 23:00:00
sbwatch.setTime('42'); // sets 4:02:00
sbwatch.setTime('930'); // sets 9:30:00
sbwatch.setTime(9, 10); // sets 9:10:00
sbwatch.setTime(9, 10, 30); // sets 9:10:30
sbwatch.setTime('now'); // sets the current time
sbwatch.setTime('7:12'); // sets 7:12:00
sbwatch.setTime('7:12:11'); // sets 7:12:11
```

## Setting the Current Time on the SB Watch

You can use the sbwatch.setCurrentTime() command to set the current time on the SB Watch. This will update the watch to display the current time according to the system clock of the SB Watch. To use this command, simply call it with no arguments, like this:

```javascript
sbwatch.setCurrentTime();
```

## Displaying Text on SB Watch 2 Screen

```javascript

```

It works only with SB Watch 2 models. Once you have connected to an SB Watch 2 device, you can display text on its screen using the `ps.print` method. The method takes a single argument, which is the text that you want to display on the screen. If SB Watch 2 is not yet connected, MagiScript will collect your messages and send them as soon as a device is connected.

For example, if you want to display the text “Hello World” on the SB Watch 2 screen, you can use the following code:

```javascript
sbwatch.print('Hello World');
```

```javascript

```

This will display the text “Hello World” on the SB Watch 2 screen.

## Vibrating SB Watch 2

```javascript

```

You can also vibrate the SB Watch 2 device using the `sbwatch.vibrate` method. The method takes a single argument, which is the pattern that you want to vibrate.

For example, if you want to vibrate the SB Watch 2 device with a pattern of three short vibrations, you can use the following code:

```javascript
sbwatch.vibrate('...');
```

## Accelerometer Data (since firmware v1.1.31)

```javascript

```

SB Watch has an accelerometer, and Atom can turn it on or off. When turned on, the accelerometer will start reporting raw x, y, and z data.

## Accelerometer ON

```javascript

```

There are more ways to turn on the accelerometer, but they have the same effect:

```javascript
sbwatch.accel('on'); // please note that ON or On will not work
sbwatch.accel(true);
```

## Accelerometer OFF

```javascript

```

Turning off the accelerometer is similar:

```javascript
sbwatch.accel('off'); // please note that OFF or Off will not work
sbwatch.accel(false);
```

## Accelerometer Data

```javascript

```

You will start receiving events with XYZ data when you turn on the accelerometer via the onEvent function. The value is going to be comma-separated numbers, the type ‘xyz’, and the source ‘ps::accel’.

## Example

```javascript

```

Here’s an example code of how you can use them:

```javascript
function main() {
sbwatch.connect('SBWatch-155309');
sbwatch.accel('on');
}

function onEvent(value, type, source) {
if (type === 'xyz' && source === 'sbwatch:accel') {
let xyz = strSplit(value, ',');
let x = parseInt(xyz[0]);
let y = parseInt(xyz[1]);
let z = parseInt(xyz[2]);
console.log(x, y, z);
}
}
```

## Battery Percentage

```javascript

```

###

The battery level of SB Watch can be queried with the battery method. It reports a number between 0 and 100. It is checked when Atom connects to the device, and is subsequently updated every other minute.

```javascript
const percentage = sbwatch.battery();
console.log(SBWatch battery level: ${percentage}%);
```

## Receiving Button Events

```javascript

```

###

When an SB Watch is connected, it will start sending button press and release events of the crown. You can process them with the onEvent function.

###

Read our [Buttons](https://electricks.info/docs/magiscript/buttons/) documentation page for more details.

## Conclusion

```javascript

```

###

The SB Watch support of Atom remote in MagiScript provides a convenient way for developers to connect their SB Watch to Atom and control its functions. By following the steps outlined in this documentation, you can easily connect to your SB Watch and set its time using MagiScript.