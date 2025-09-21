# Water Flow Sensor Library Arduino
[![arduino-library-badge](https://www.ardu-badge.com/badge/FlowSensor.svg)](https://www.ardu-badge.com/FlowSensor?)
[![PlatformIO Registry](https://badges.registry.platformio.org/packages/hafidh/library/FlowSensor.svg?)](https://registry.platformio.org/libraries/hafidh/FlowSensor)
[![GitHub release](https://img.shields.io/github/release/hafidhh/FlowSensor-Arduino.svg?)](https://github.com/hafidhh/FlowSensor-Arduino/releases)
[![License](https://img.shields.io/github/license/hafidhh/FlowSensor-Arduino.svg?)](https://github.com/hafidhh/FlowSensor-Arduino/blob/master/LICENSE.md)

## 🚀 Description   
Arduino library for Flow Sensor

### Volume Formula   
```math
Volume (L) = {Total Pulse \over Pulse/Liter}
```

### Flow rate Formula   
```math
Q = {Frequency \over Pulse/Liter}60
```
```math
Q = {Pulse/Time \over Pulse/Liter}60
```
Q = Flowrate (Liter/minute)   

## 🔥 Features
* Get Volume in Liter
* Get Flow Rate in Liter/Secound
* Get Flow Rate in Liter/Minute
* Get Flow Rate in Liter/hour
* Count Pulse and get Value

## ✨ Tested Devices
* Arduino Nano ATMega328P
* NodeMCU ESP8266
* NodeMCu ESP32
* LGT8F328P (Logic Green)

## 💻 Installation
### Using Library Manager
#### Arduino
At Arduino IDE, go to menu Sketch -> Include Library -> Manage Libraries...

In Library Manager Window, search "flowsensor" in the search form then select "FlowSensor".

Click "Install" button.  

#### Platform IO
For PlatformIO IDE, using the following command.

Or at PIO Home -> Library -> Registry then search FlowSensor.

### Manual Installation
For Arduino IDE, download zip file from the repository (Github page) by select Code dropdown at the top of repository, select Download ZIP

From Arduino IDE, select menu Sketch -> Include Library -> Add .ZIP Library....

Choose FlowSensor-Arduino-master.zip that previously downloaded.

## 🔥 Sensor
|  Sensor Type  |  Code   | Pulse/Liter |
| ------------- | ------- | ----------: |
| YF-S201       | YFS201  |         450 |
| YF-S401       | YFS401  |        5880 |
| YF-B1         | YFB1    |         660 |
| YF-B1-S       | YFB1S   |        1077 |
| OF10ZAT       | OF10ZAT |         400 |
| OF10ZZT       | OF10ZZT |         400 |
| OF05ZAT       | OF05ZAT |        2174 |
| OF05ZZT       | OF05ZZT |        2174 |

## ✨ Add New Sensor
If you want to add new sensor you can edit [FlowSensor_Type.h](https://github.com/hafidhh/FlowSensor-Arduino/blob/master/src/FlowSensor_Type.h) file in src and create pull request or you can use dynamic declaration.

## 💻 Usages
See [all examples](https://github.com/hafidhh/FlowSensor-Arduino/blob/master/examples)

### Initialization
If your sensor is not available in sensor list you can use dynamic declaration by use sensor pulse/liter in type, example 450 for YF-S201.

```cpp
#include <FlowSensor.h>

uint16_t type = YFS201; // type : Sensor type or pulse/liter
// uint16_t type = 450;
uint8_t pin = D2; // pin : interrupt pin

FlowSensor Sensor(type, pin);
```

if you want to change sensor pin and sensor type you can use setPin and setType.  
if you change the pin with setPin() you have to do sensor.begin() again

```cpp
Sensor.setPin(pin);
Sensor.setType(type);
```


### Sensor begin
param **`userFunc`**  
param **`pullup`**  
if you have an external pull up you can set pull up to true
```cpp
void count()
{
    Sensor.count();
}

void setup()
{
    Sensor.begin(count());
}
```

### Set Sensor Pin
param **`pin`**
```cpp
Sensor.setPin(pin);
```

### Set Sensor Type
param **`type`**
```cpp
Sensor.setType(type);
```

### Sensor Read
```cpp
Sensor.read()
```

### Count Pulse
```cpp
Sensor.count()
```

### Get Total Pulse
return **`total pulse`**
```cpp
Sensor.getPulse()
```

### Reset Pulse
set pulse value to 0
```cpp
Sensor.resetPulse()
```

### Get Flowrate (L/s)
return **`Flowrate`** (L/s)
```cpp
Sensor.getFlowRate_s()
```

### Get Flowrate (L/m)
return **`Flowrate`** (L/m)
```cpp
Sensor.getFlowRate_m() 
```

### Get Flowrate (L/h)
return **`Flowrate`** (L/h)
```cpp
Sensor.getFlowRate_h() 
```

### Get Total Volume (L)
return **`Volume`** (L)
```cpp
Sensor.getVolume()
```  

### Reset Volume (L)
set volume value to 0
```cpp
Sensor.resetVolume()
```  

## 🛡️ License
This project is licensed under the MIT License - see the [`LICENSE`](LICENSE.md) file for details.

## 🙏 Support
We all need support and motivation. Please give this project a ⭐️ to encourage and show that you liked it. Don't forget to leave a star ⭐️ before you move away.

If you found the app helpful, consider supporting us with a coffee.

<a href="https://github.com/sponsors/hafidhh">
    <img src="https://img.shields.io/badge/sponsor-30363D?style=for-the-badge&logo=GitHub-Sponsors&logoColor=#EA4AAA">
</a>
<a href="https://www.buymeacoffee.com/hafidh">
    <img src="https://img.shields.io/badge/Buy%20Me%20a%20Coffee-ffdd00?style=for-the-badge&logo=buy-me-a-coffee&logoColor=black">
</a>
