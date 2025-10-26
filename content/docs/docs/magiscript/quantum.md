---
title: Quantum
updated: "2025-10-26"
author: Electricks
category: guides
sidebar: "a93aec4"
---

# Quantum

## About Quantum Support

The Quantum support of Atom remote in MagiScript allows developers to connect your Quantum to Atom, and control the Quantum using commands.

```javascript

```

## Connecting To Your Quantum

To connect Atom to a Quantum, you need to use the `quantum.connect` method.

If Atom is not yet connected to a Quantum device, it will start searching for it and then connect. If a Quantum device is already connected, but the specified name is different, Atom will disconnect from the Quantum device, and start searching for the specified name.

You can use the `*` character to connect to any available Quantum device.

The method is flexible regarding its parameters. Let’s review the possible options.

```javascript

```

## Connecting without a Device Name

This is the recommended way to connect, as this way you can share your code and no change will be necessary.

```javascript
quantum.connect();
```

You can configure a default Quantum device ID in the Atom Editor Settings. By default, it is *, which means it will connect to the first Quantum device it finds.

## Connecting by Specifying a Device Name

You can pass a Quantum device ID as the first parameter, and Atom will connect to it. For example, to connect to a Quantum with the ID “Quantum-166666”, you would use the following command:

```javascript
quantum.connect('Quantum-166666');
```

This is the legacy way, we recommend using it only if you have a specific use case.

## Connecting by Specifying a Device Name and a Callback

As a second parameter, you can specify a callback function. It will be called when Atom successfully connects to the Quantum device. It will be called immediately if Atom is already connected to a Quantum.

```javascript
quantum.connect('Quantum-166666', connected);

function connected(event) {
console.log('Quantum connected.');
}
```

When a Quantum is connected, then an event will be triggered. Both the onEvent function, and the callback will be called with the event details.

```javascript
quantum.connect('Quantum-166666', connected);

function connected(event) {
console.log('Quantum connected.');
}
```

## Using the quantum.connect Method

```javascript

```

The best way to connect is by adding this call to the beginning of the `main` function, which runs when the code is loaded.

```javascript
function main() {
quantum.connect();
// ...
}
```

## Disconnecting your Quantum

To disconnect your Quantum, simply call the disconnect method. It will disconnect the active Quantum device.

```javascript
quantum.disconnect();
```

You can also specify by it’s name which device you would like to disconnect:

```javascript
quantum.disconnect('Quantum-036666');
```

## Querying the Connected Quantum

You can query the Bluetooth name (ID) of the Quantum device(s) Atom connected to. The id method gives you the active device’s ID, while the ids method returns an array with the Quantum devices Atom connected to.

```javascript
quantum.id(); // the active Quantum device
quantum.ids(); // all the Quantum devices Atom connected to
```

You can query the connected Quantum devices as a list of device objects as well using the list method.

```javascript
const devs = quantum.list();
for (let i = 0; i
```

If more than one Quantum device is connected, you can set one of them to active with the select method. Messages will be sent to this unit.

```javascript
quantum.select('Quantum-036666');
```

## Battery Percentage

```javascript

```

###

The battery level of Quantum can be queried with the battery method. It reports a number between 0 and 100. It is checked when Atom connects to the device, and is subsequently updated every other minute.

```javascript
const percentage = quantum.battery();
console.log(Quantum battery level: ${percentage}%);
```

## Conclusion

```javascript

```

###

The Quantum support of Atom remote in MagiScript provides a convenient way for developers to connect their Quantum to Atom and control its functions. By following the steps outlined in this documentation, you can easily connect to your Quantum and set its time using MagiScript.