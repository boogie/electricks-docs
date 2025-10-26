---
title: Fossil Watch
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Fossil Watch

## About Fossil Watch Support

The Fossil Watch support of Atom remote in MagiScript allows developers to connect your Fossil Watch to Atom, and control the watch using commands. You can:

- set the time

- reset the time to the current time

```javascript

```

## Connecting To Your Fossil Watch

To connect Atom to a Fossil Watch, you need to use the `fossil.connect` method.

If Atom is not yet connected to a Fossil Watch device, it will start searching for it and then connect. If a Fossil Watch device is already connected, but the specified name is different, Atom will disconnect from the Fossil Watch device, and start searching for the specified name.

You can use the `*` character to connect to any available Fossil Watch device.

The method is flexible regarding its parameters. Let’s review the possible options.

```javascript

```

## Connecting without a Device Name

This is the recommended way to connect, as this way you can share your code and no change will be necessary.

```javascript
fossil.connect();
```

You can configure a default Fossil Watch device ID in the Atom Editor Settings. By default, it is *, which means it will connect to the first Fossil Watch device it finds.

## Connecting by Specifying a Device Name

You can pass a Fossil Watch device ID as the first parameter, and Atom will connect to it. For example, to connect to a Fossil Watch with the ID “Fossil-166666”, you would use the following command:

```javascript
fossil.connect('Fossil-166666');
```

This is the legacy way, we recommend using it only if you have a specific use case.

## Connecting by Specifying a Device Name and a Callback

As a second parameter, you can specify a callback function. It will be called when Atom successfully connects to the Fossil Watch device. It will be called immediately if Atom is already connected to a Fossil Watch.

```javascript
fossil.connect('Fossil-166666', connected);

function connected(event) {
console.log('Fossil connected.');
}
```

When a Fossil Watch is connected, then an event will be triggered. Both the onEvent function, and the callback will be called with the event details.

```javascript
fossil.connect('Fossil-166666', connected);

function connected(event) {
console.log('Fossil connected.');
}
```

## Using the fossil.connect Method

```javascript

```

The best way to connect is by adding this call to the beginning of the `main` function, which runs when the code is loaded.

```javascript
function main() {
fossil.connect();
// ...
}
```

## Disconnecting your Fossil Watch

To disconnect your Fossil Watch, simply call the disconnect method. It will disconnect the active Fossil Watch device.

```javascript
fossil.disconnect();
```

You can also specify by it’s name which device you would like to disconnect:

```javascript
fossil.disconnect('Fossil-036666');
```

## Querying the Connected Fossil Watch

You can query the Bluetooth name (ID) of the Fossil Watch device(s) Atom connected to. The id method gives you the active device’s ID, while the ids method returns an array with the Fossil Watch devices Atom connected to.

```javascript
fossil.id(); // the active Fossil device
fossil.ids(); // all the Fossil devices Atom connected to
```

You can query the connected Fossil Watch devices as a list of device objects as well using the list method.

```javascript
const devs = fossil.list();
for (let i = 0; i
```

If more than one Fossil Watch device is connected, you can set one of them to active with the select method. Messages will be sent to this unit.

```javascript
fossil.select('Fossil-036666');
```

## Setting the Time on the Fossil Watch

You can use the fossil.setTime() command to set the time on the Fossil Watch. This will update the watch to display the time. There are many ways to use it, see below:

```javascript
fossil.setTime(9); // sets 9:00:00
fossil.setTime(23); // sets 23:00:00
fossil.setTime(42); // sets 4:02:00
fossil.setTime(930); // sets 9:30:00
fossil.setTime('9'); // sets 9:00:00
fossil.setTime('23'); // sets 23:00:00
fossil.setTime('42'); // sets 4:02:00
fossil.setTime('930'); // sets 9:30:00
fossil.setTime(9, 10); // sets 9:10:00
fossil.setTime(9, 10, 30); // sets 9:10:30
fossil.setTime('now'); // sets the current time
fossil.setTime('7:12'); // sets 7:12:00
fossil.setTime('7:12:11'); // sets 7:12:11
```

## Setting the Current Time on the Fossil Watch

You can use the fossil.setCurrentTime() command to set the current time on the Fossil Watch. This will update the watch to display the current time according to the system clock of the Fossil Watch. To use this command, simply call it with no arguments, like this:

```javascript
fossil.setCurrentTime();
```

## Battery Percentage

```javascript

```

###

The battery level of Fossil Watch can be queried with the battery method. It reports a number between 0 and 100. It is checked when Atom connects to the device, and is subsequently updated every other minute.

```javascript
const percentage = fossil.battery();
console.log(Fossil battery level: ${percentage}%);
```

## Conclusion

```javascript

```

###

The Fossil Watch support of Atom remote in MagiScript provides a convenient way for developers to connect their Fossil Watch to Atom and control its functions. By following the steps outlined in this documentation, you can easily connect to your Fossil Watch and set its time using MagiScript.