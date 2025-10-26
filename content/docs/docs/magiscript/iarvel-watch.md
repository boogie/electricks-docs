---
title: IARVEL Watch
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# IARVEL Watch

## About IARVEL Watch Support

The IARVEL Watch support of Atom remote in MagiScript allows developers to connect your IARVEL Watch to Atom, and control the watch using commands. You can:

- set the time

- reset the time to the current time

```javascript

```

## Connecting To Your IARVEL Watch

To connect Atom to a IARVEL Watch, you need to use the `iarvelwatch.connect` method.

If Atom is not yet connected to an IARVEL Watch device, it will start searching for it and then connect. If an IARVEL Watch device is already connected, but the specified name is different, Atom will disconnect from the IARVEL Watch device, and start searching for the specified name.

You can use the `*` character to connect to any available IARVEL Watch device.

The method is flexible regarding its parameters. Let’s review the possible options.

```javascript

```

## Connecting without a Device Name

This is the recommended way to connect, as this way you can share your code and no change will be necessary.

```javascript
iarvelwatch.connect();
```

You can configure a default IARVEL Watch device ID in the Atom Editor Settings. By default, it is *, which means it will connect to the first IARVEL Watch device it finds.

## Connecting by Specifying a Device Name

You can pass an IARVEL Watch device ID as the first parameter, and Atom will connect to it. For example, to connect to an IARVEL Watch with the ID “IARVEL-166666”, you would use the following command:

```javascript
iarvelwatch.connect('IARVEL-166666');
```

This is the legacy way, we recommend using it only if you have a specific use case.

## Connecting by Specifying a Device Name and a Callback

As a second parameter, you can specify a callback function. It will be called when Atom successfully connects to the IARVEL Watch device. It will be called immediately if Atom is already connected to an IARVEL Watch.

```javascript
iarvelwatch.connect('IARVEL-166666', connected);

function connected(event) {
console.log('IARVEL connected.');
}
```

When an IARVEL Watch is connected, then an event will be triggered. Both the onEvent function, and the callback will be called with the event details.

```javascript
iarvelwatch.connect('IARVEL-166666', connected);

function connected(event) {
console.log('IARVEL connected.');
}
```

## Using the iarvelwatch.connect Method

```javascript

```

The best way to connect is by adding this call to the beginning of the `main` function, which runs when the code is loaded.

```javascript
function main() {
iarvelwatch.connect();
// ...
}
```

## Disconnecting your IARVEL Watch

To disconnect your IARVEL Watch, simply call the disconnect method. It will disconnect the active IARVEL Watch device.

```javascript
iarvelwatch.disconnect();
```

You can also specify by it’s name which device you would like to disconnect:

```javascript
iarvelwatch.disconnect('IARVEL-036666');
```

## Querying the Connected IARVEL Watch

You can query the Bluetooth name (ID) of the IARVEL Watch device(s) Atom connected to. The id method gives you the active device’s ID, while the ids method returns an array with the IARVEL Watch devices Atom connected to.

```javascript
iarvelwatch.id(); // the active IARVEL device
iarvelwatch.ids(); // all the IARVEL devices Atom connected to
```

You can query the connected IARVEL Watch devices as a list of device objects as well using the list method.

```javascript
const devs = iarvelwatch.list();
for (let i = 0; i
```

If more than one IARVEL Watch device is connected, you can set one of them to active with the select method. Messages will be sent to this unit.

```javascript
iarvelwatch.select('IARVEL-036666');
```

## Setting the Time on the IARVEL Watch

You can use the iarvelwatch.setTime() command to set the time on the IARVEL Watch. This will update the watch to display the time. There are many ways to use it, see below:

```javascript
iarvelwatch.setTime(9); // sets 9:00:00
iarvelwatch.setTime(23); // sets 23:00:00
iarvelwatch.setTime(42); // sets 4:02:00
iarvelwatch.setTime(930); // sets 9:30:00
iarvelwatch.setTime('9'); // sets 9:00:00
iarvelwatch.setTime('23'); // sets 23:00:00
iarvelwatch.setTime('42'); // sets 4:02:00
iarvelwatch.setTime('930'); // sets 9:30:00
iarvelwatch.setTime(9, 10); // sets 9:10:00
iarvelwatch.setTime(9, 10, 30); // sets 9:10:30
iarvelwatch.setTime('now'); // sets the current time
iarvelwatch.setTime('7:12'); // sets 7:12:00
iarvelwatch.setTime('7:12:11'); // sets 7:12:11
```

## Setting the Current Time on the IARVEL Watch

You can use the iarvelwatch.setCurrentTime() command to set the current time on the IARVEL Watch. This will update the watch to display the current time according to the system clock of the IARVEL Watch. To use this command, simply call it with no arguments, like this:

```javascript
iarvelwatch.setCurrentTime();
```

## Battery Percentage

```javascript

```

###

The battery level of IARVEL Watch can be queried with the battery method. It reports a number between 0 and 100. It is checked when Atom connects to the device, and is subsequently updated every other minute.

```javascript
const percentage = iarvelwatch.battery();
console.log(Iarvel battery level: ${percentage}%);
```

## Conclusion

```javascript

```

###

The IARVEL Watch support of Atom remote in MagiScript provides a convenient way for developers to connect their IARVEL Watch to Atom and control its functions. By following the steps outlined in this documentation, you can easily connect to your IARVEL Watch and set its time using MagiScript.