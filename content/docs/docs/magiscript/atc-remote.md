---
title: ATC Remote
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# ATC Remote

## About ATC Remote Support

The ATC Remote support of Atom remote in MagiScript allows developers to connect your ATC to Atom, and control the ATC using commands.

```javascript

```

## Connecting To Your ATC

To connect Atom to a ATC, you need to use the `atc.connect` method.

If Atom is not yet connected to an ATC device, it will start searching for it and then connect. If an ATC device is already connected, but the specified name is different, Atom will disconnect from the ATC device, and start searching for the specified name.

You can use the `*` character to connect to any available ATC device.

The method is flexible regarding its parameters. Let’s review the possible options.

```javascript

```

## Connecting without a Device Name

This is the recommended way to connect, as this way you can share your code and no change will be necessary.

```javascript
atc.connect();
```

You can configure a default ATC device ID in the Atom Editor Settings. By default, it is *, which means it will connect to the first ATC device it finds.

## Connecting by Specifying a Device Name

You can pass an ATC device ID as the first parameter, and Atom will connect to it. For example, to connect to an ATC with the ID “ATC-166666”, you would use the following command:

```javascript
atc.connect('ATC-166666');
```

This is the legacy way, we recommend using it only if you have a specific use case.

## Connecting by Specifying a Device Name and a Callback

As a second parameter, you can specify a callback function. It will be called when Atom successfully connects to the ATC device. It will be called immediately if Atom is already connected to an ATC.

```javascript
atc.connect('ATC-166666', connected);

function connected(event) {
console.log('ATC connected.');
}
```

When an ATC is connected, then an event will be triggered. Both the onEvent function, and the callback will be called with the event details.

```javascript
atc.connect('ATC-166666', connected);

function connected(event) {
console.log('ATC connected.');
}
```

## Using the atc.connect Method

```javascript

```

The best way to connect is by adding this call to the beginning of the `main` function, which runs when the code is loaded.

```javascript
function main() {
atc.connect();
// ...
}
```

## Disconnecting your ATC

To disconnect your ATC, simply call the disconnect method. It will disconnect the active ATC device.

```javascript
atc.disconnect();
```

You can also specify by it’s name which device you would like to disconnect:

```javascript
atc.disconnect('ATC-036666');
```

## Querying the Connected ATC

You can query the Bluetooth name (ID) of the ATC device(s) Atom connected to. The id method gives you the active device’s ID, while the ids method returns an array with the ATC devices Atom connected to.

```javascript
atc.id(); // the active ATC device
atc.ids(); // all the ATC devices Atom connected to
```

You can query the connected ATC devices as a list of device objects as well using the list method.

```javascript
const devs = atc.list();
for (let i = 0; i
```

If more than one ATC device is connected, you can set one of them to active with the select method. Messages will be sent to this unit.

```javascript
atc.select('ATC-036666');
```

## Battery Percentage

```javascript

```

###

The battery level of ATC can be queried with the battery method. It reports a number between 0 and 100. It is checked when Atom connects to the device, and is subsequently updated every other minute.

```javascript
const percentage = atc.battery();
console.log(atc battery level: ${percentage}%);
```

## Blink with the ATC

```javascript

```

###

Makes the LED on the active ATC device blink according to a specified pattern.

```javascript
atc.blink('..-'); // short-short-long
atc.blink('-.-.'); // long-short-long-short
atc.blink('-'); // Single long blink
```

## Conclusion

```javascript

```

###

The ATC support of Atom remote in MagiScript provides a convenient way for developers to connect their ATC to Atom and control its functions. By following the steps outlined in this documentation, you can easily connect to your ATC and set its time using MagiScript.