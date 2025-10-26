---
title: PeekSmith
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# PeekSmith

## About

The PeekSmith support of Atom remote in MagiScript allows developers to connect your PeekSmith to Atom, and control the watch using commands. PeekSmith 3 or SuperPeek are supported. You can:

-

- display messages on its screen,

- send vibration patterns,

- turn its accelerometer reporting on/off,

- receive button events.

## Connecting to a PeekSmith

To interact with a PeekSmith device, you must first connect to it using the `ps. connect` method.

If Atom is not yet connected to a PeekSmith device, it will start searching for it and then connect. If a PeekSmith device is already connected, but the specified name is different, Atom will disconnect from the PeekSmith device, and start searching for the specified name.

You can use the `*` character to connect to any available PeekSmith device.

The method is flexible regarding its parameters. Let’s review the possible options.

## Connecting without a Device Name

This is the recommended way to connect, as this way you can share your code and no change will be necessary.

```javascript
ps.connect();
```

You can configure a default PeekSmith device ID in the Atom Editor Settings. By default, it is *, which means it will connect to the first PeekSmith device it finds.

## Connecting by Specifying a Device Name

You can pass a PeekSmith device ID as the first parameter, and Atom will connect to it.

```javascript
ps.connect('PeekSmith-036666');
```

This is the legacy way, we recommend using it only if you have a specific use case.

## Connecting by Specifying a Device Name and a Callback

As a second parameter, you can specify a callback function. It will be called when Atom successfully connects to the PeekSmith device. It will be called immediately if Atom is already connected to a PeekSmith.

```javascript
ps.connect('PeekSmith-036666', connected);

function connected(event) {
console.log('PeekSmith connected.');
}
```

When a PeekSmith is connected, then an event will be triggered. Both the onEvent function, and the callback will be called with the event details.

```javascript
ps.connect('PeekSmith-036666', connected);

function connected(event) {
console.log('PeekSmith connected.');
}
```

## Using the ps.connect Method

The best way to connect is by adding this call to the beginning of the `main` function, which runs when the code is loaded.

```javascript
function main() {
ps.connect();
// ...
}
```

## Disconnecting your PeekSmith

To disconnect your PeekSmith, simply call the disconnect method. It will disconnect the active PeekSmith device.

```javascript
ps.disconnect();
```

You can also specify by it’s name which device you would like to disconnect:

```javascript
ps.disconnect('PeekSmith-036666');
```

## Querying the Connected PeekSmith(s)

You can query the Bluetooth name (ID) of the PeekSmith device(s) Atom connected to. The id method gives you the active device’s ID, while the ids method returns an array with the PeekSmith devices Atom connected to.

```javascript
ps.id(); // the active PeekSmith device
ps.ids(); // all the PeekSmith devices Atom connected to
```

You can query the connected PeekSmith devices as a list of device objects as well using the list method.

```javascript
const devs = ps.list();
for (let i = 0; i
```

If more than one PeekSmith device is connected, you can set one of them to active with the select method. Messages will be sent to this unit.

```javascript
ps.select('PeekSmith-036666');
```

## Displaying Text on PeekSmith Screen

```javascript

```

Once you have connected to a PeekSmith device, you can display text on its screen using the `ps.print` method. The method takes a single argument, which is the text that you want to display on the screen. If PeekSmith is not yet connected, MagiScript will collect your messages and send them as soon as a device is connected.

For example, if you want to display the text “Hello World” on the PeekSmith screen, you can use the following code:

```javascript
ps.print('Hello World');
```

```javascript

```

This will display the text “Hello World” on the PeekSmith screen.

Using PeekSmith’s “Smart Text”, you can display cards or colors on the screen like sending messages:

```javascript
ps.print('AH'); // displays an Ace of Heart
ps.print('7D KS'); // seven of diamonds, king of spades
ps.pring('star'); // displays a star ESP sign
ps.print('yellow'); // displays a yellow card
```

## Vibrating PeekSmith

```javascript

```

You can also vibrate the PeekSmith device using the `ps.vibrate` method. The method takes a single argument, which is the pattern that you want to vibrate.

For example, if you want to vibrate the PeekSmith device with a pattern of three short vibrations, you can use the following code:

```javascript
ps.vibrate('...');
```

```javascript

```

This will vibrate the PeekSmith device three times in a short pattern. The latest PeekSmith firmware supports the [same patterns as Atom](https://electricks.info/docs/magiscript/vibration-motor/) (except the short tick).

## Accelerometer Data (since firmware v1.1.31)

```javascript

```

PeekSmith 3 has an accelerometer, and Atom can turn it on or off. When turned on, the accelerometer will start reporting raw x, y, and z data.

## Accelerometer ON

```javascript

```

There are more ways to turn on the accelerometer, but they have the same effect:

```javascript
ps.accel('on'); // please note that ON or On will not work
ps.accel(true);
```

## Accelerometer OFF

```javascript

```

Turning off the accelerometer is similar:

```javascript
ps.accel('off'); // please note that OFF or Off will not work
ps.accel(false);
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
ps.connect('PeekSmith-031060');
ps.accel('on');
}

function onEvent(value, type, source) {
if (type === 'xyz' && source === 'ps:accel') {
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

The battery level of PeekSmith can be queried with the battery method. It reports a number between 0 and 100. It is checked when Atom connects to the device, and is subsequently updated every other minute.

```javascript
const percentage = ps.battery();
console.log(PeekSmith battery level: ${percentage}%);
```

## Receiving Button Events

```javascript

```

When a PeekSmith is connected, it will start sending button press and release events. PeekSmith has 3 buttons, #0 is the side button, #1 is the front left button, and #2 is the front right button. You can process them with the onEvent function.

Read our [Buttons](https://electricks.info/docs/magiscript/buttons/) documentation page for more details.

## Conclusion

```javascript

```

MagiScript provides an easy way to connect to and control PeekSmith devices directly from Atom. By using the `ps.connect`, `ps.print`, and `ps.vibrate` methods, you can interact with the PeekSmith device and display text and patterns on its screen, as well as vibrate it.