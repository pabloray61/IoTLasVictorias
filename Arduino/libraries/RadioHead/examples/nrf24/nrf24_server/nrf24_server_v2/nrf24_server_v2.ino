// nrf24_server.pde
// -*- mode: C++ -*-
// Example sketch showing how to create a simple messageing server
// with the RH_NRF24 class. RH_NRF24 class does not provide for addressing or
// reliability, so you should only use RH_NRF24  if you do not need the higher
// level messaging abilities.
// It is designed to work with the other example nrf24_client
// Tested on Uno with Sparkfun NRF25L01 module
// Tested on Anarduino Mini (http://www.anarduino.com/mini/) with RFM73 module
// Tested on Arduino Mega with Sparkfun WRL-00691 NRF25L01 module

#include <SPI.h>
#include <RH_NRF24.h>

// Singleton instance of the radio driver
RH_NRF24 nrf24;
// RH_NRF24 nrf24(8, 7); // use this to be electrically compatible with Mirf
// RH_NRF24 nrf24(8, 10);// For Leonardo, need explicit SS pin
// RH_NRF24 nrf24(8, 7); // For RFM73 on Anarduino Mini

int counter = 0;

// Define output strings
String str_humid;
String str_temp;
String str_flowRate;
String str_volumeMin;
String str_out;

void setup() 
{
  Serial.begin(9600);
  while (!Serial); // wait for serial port to connect. Needed for Leonardo only
  if (!nrf24.init())
    Serial.println("init failed");
  // Defaults after init are 2.402 GHz (channel 2), 2Mbps, 0dBm
  if (!nrf24.setChannel(1))
    Serial.println("setChannel failed");
  if (!nrf24.setRF(RH_NRF24::DataRate2Mbps, RH_NRF24::TransmitPower0dBm))
    Serial.println("setRF failed");    

  Serial.println("**** SETUP DE SENSORES Y RADIO *****");
  Serial.println("Comunicación Serie Iniciada a 9.600");
  Serial.println("Sensor de temperatura DHT22 iniciado");
  Serial.println("Caudalimetro FS300A iniciado");
  Serial.println("Modulo de radio nrf24 iniciado");
  Serial.println("-------------------------------------------");
  delay(10000);
  }

void loop()
{
  if (nrf24.available())
  {
        
    // Should be a message for us now   
    uint8_t buf[RH_NRF24_MAX_MESSAGE_LEN];
    uint8_t len = sizeof(buf);

   //Serial.print("Tamaño del buffer asignado: ");
    //int tamBuf = 21;
    //Serial.println(tamBuf);
  
    //uint8_t buf[tamBuf];
    //uint8_t len = sizeof(tamBuf);
    
    if (nrf24.recv(buf, &len))
    {
      // Message received with valid checksum
      // Get values from string
      // NRF24::printBuffer("request: ", buf, len);
      

      // Convert received data into string
      str_out = String((char*)buf);

      // Split string into for values
        int pos1, pos2, pos3;
        String subcadena1, subcadena2, subcadena3, subcadena4;

        pos1 = str_out.indexOf(',');
        pos2 = str_out.indexOf(',', pos1 + 1);
        pos3 = str_out.indexOf(',', pos2 + 1);

        subcadena1 = str_out.substring(0,pos1);
        subcadena2 = str_out.substring(pos1 +1, pos2);
        subcadena3 = str_out.substring(pos2 +1, pos3);
        subcadena4 = str_out.substring(pos3+1,21);

        str_humid = subcadena1;
        str_temp = subcadena2;
        str_flowRate = subcadena3;
        str_volumeMin = subcadena4;

      // Print values to Serial Monitor
      counter ++;
      Serial.print(" ***** MEDICION # ");
      Serial.print(counter);
      Serial.println(" *****");
      Serial.print("Transmision Vector Datos: ");
      Serial.println((char*)buf);
      
      Serial.print("Tamaño del maximo buffer: ");
      Serial.println(RH_NRF24_MAX_MESSAGE_LEN);
      Serial.println("MEDICIONES TOMADAS");    
      Serial.print("Temperatura: ");
      Serial.print(str_temp);
      Serial.println(" °C");
      Serial.print("Humedad: ");
      Serial.print(str_humid);
      Serial.println(" %");
      Serial.print("Flowrate: ");
      Serial.print(str_flowRate);
      Serial.println(" l/min");
      Serial.print("Volumen: ");
      Serial.print(str_volumeMin);
      Serial.println(" litros");
      Serial.println("");

    }
    else
    {
      Serial.println("recv failed");
    }
  }
}

