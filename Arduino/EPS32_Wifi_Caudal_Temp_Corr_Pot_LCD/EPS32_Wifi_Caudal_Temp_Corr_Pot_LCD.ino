/*  PROGRAMACION DEL SENSOR DE CAUDAL
    Pablo Ray 22 de julio de 2025
    Caudalimetro FS300A
    Sensor de Temperatura y Humedad DHT22

    Calibrates the current sensor (SCT013)
    
* Instructions:
1. Set up the hardware, the potentiometer of the voltage sensor should be already adjusted.
2. Find an "almost pure" resistive load (no motors, no reactors, no electromagnets, no LEDs). Examples: heater, boiler, electric shower, electric oven, kettle...
3. Install a voltmeter and ammeter to use as reference.
4. Connect the voltage measurement and current measurement sensors.
5. Edit the sketch *calibrate-vi.ino* and set the correct GPIO pins for the sensors. 
6. Set the calibration coefficients CV1, CV2, CV3, CI1, CI2 and CI3 to 1000 in the same file.
7. Compile and update the code from Arduino IDE.
8. Watch the values in the serial terminal and wait for them to stabilize. Use 115200bps as baud rate.
9. Take a note of the measured current (I) and voltage (V) from the ESP32 and the current and voltage from the reference voltmeter (Vr) and ammeter (Ir).
10. Calculate the calibration factors: CVnew = Vr*CVold/V, CInew = Ir*CIold/I where CVold and CIold are the previous calibrations from the sketch (initially 1000).
11. Change the values under the "Calibration" section of the code to the calculated ones (CInew and CVnew).
12. Compile and upload the code again, watch the serial monitor until the data stabilizes and then check if the measurements are correct.
13. Repeat steps 8 to 12 if necessary.
*/

// Incluye las librerias a utilizar
#include <Arduino.h>
#include <Wire.h>
#include <SoftwareSerial.h>
#include <LiquidCrystal_I2C.h>
#include <DHT.h>
#include "time.h"
#include <ESP32Time.h>

#include <WiFi.h>
#include <WiFiClient.h>
#include <HTTPClient.h>
#include <WiFiClientSecure.h>
#include <WebServer.h>
#include <FlowSensor.h>

// Conexión Wifi
const char* ssid = "Las Victorias 23 2.4GHz";
const char* password = "1448470214";
int cont = 0;
int max_intentos = 100;

WebServer server(80);

void handleRoot() {
  digitalWrite(2, 1);
  server.send(200, "text/plain", "Hello World");
  digitalWrite(2, 0);
}

// Peticiones al servidor
String host = "https://vacana.com.ar/caudal/recibe_datos.php";
const int port = 443;
String device = "tarjeta1";
String cliente = "cliente1";
String request = "Sin envio todavia";
String answer = "Sin respuesta todavia";
String lat = "";
String lng = "";


/* This sample code demonstrates the normal use of a TinyGPS object.
   It requires the use of SoftwareSerial, and assumes that you have a
   4800-baud serial GPS device hooked up on pins 4(rx) and 3(tx).
*/

// Seteo del reloj interno del ESP 32
const char* ntpServer = "pool.ntp.org";
// Set the GMT shift (3600 seconds = 1 hour) i.e. Argentina is -10800, (GMT-3)
const long gmtOffset_sec = -10800;
const int daylightOffset_sec = 0;
struct tm timeinfo;  // Time Structure Definition
ESP32Time rtc;

// Define el sensor de temperatura
#define DHTPIN 4
#define DHTTYPE DHT22
DHT dht(DHTPIN, DHTTYPE);

// Define el caudalimetro
#define type FS300A  // tipo de caudalimetro a utilizar
#define pin 18       // pin donde va conectado el caudalimetro
FlowSensor Sensor(type, pin);

// Define una función para contar
void IRAM_ATTR count() {
  Sensor.count();
}

// Define la pantalla lcd
LiquidCrystal_I2C lcd(0x27, 16, 2);  // set the LCD address to 0x27 for a 16 chars and 2 line display

// Define las variables globales a utilizar
float h = 0;         // variable de humedad
float t = 0;         // variable de temperatura
float flowRate = 0;  // variable de caudal
float flowRateAvg = 0;
float volumeMin = 0;      // variable de volumen en un minuto
float volumeHora = 0;     // variable de volumen en una hora
float volumeDia = 0;      // variable de volumen en un dia
float volumeMes = 0;      // variable de volumen en un mes
float caudalVirtual = 0;  //variable para generar caudal

int counter = 0;  // contador de las mediciones

// Define las variables de tiempo
int year = 0;
int month = 0;
int day = 0;
int hour = 0;
int minute = 0;
int sec = 0;

int dayAnterior = timeinfo.tm_mday;
int hourAnterior = timeinfo.tm_hour;


// Define los strings de salida
String str_humid;
String str_temp;
String str_flowRate;
String str_volumeMin;
String str_volumeHora;
String str_volumeDia;

String str_day;
String str_month;
String str_year;
String str_hour;
String str_min;
String str_sec;

String str_out;
String str_date;

// DEFINICION DE CONSTANTES PARA LA MEDICION DE CORRIENTE
const int sensorPin = 34;         // Pin analógico del ESP32 conectado al sensor
const float referencia = 3.3;     // Voltaje de referencia del ESP32
const float resolucion = 4096.0;  // Resolución del ADC del ESP32 (12 bits)
const float sensibilidad = 0.1;   // Sensibilidad del ACS712 (en V/A)

// DEFINICION DE LA LIBRERIA DE CORRIENTE
#include "EmonLib.h"  // Include Emon Library
#define ESP32

// Pin configuration
#define V1 34
#define V2 34
#define V3 34

#define I1 35
#define I2 32
#define I3 25

// Calibration settings (allways start with 1000)
#define CV1 575
#define CV2 575
#define CV3 575

#define CI1 1000
#define CI2 1000
#define CI3 1000

EnergyMonitor emon1;  // Phase 1
EnergyMonitor emon2;  // Phase 2
EnergyMonitor emon3;  // Phase 3


void setup() {
  // Seteo la velocidad de la comunicación Serial a 115200
  Serial.begin(115200);

  // Inicio el puerto I2C
  Wire.begin();

  // Inicio el Caudalimetro
  Sensor.begin(count);

  randomSeed(analogRead(0));

  // Inicio el termometro
  dht.begin();

  // Inicio el display lcd
  lcd.init();
  lcd.backlight();

  // Conexión a la red WiFi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED and cont < max_intentos) {
    cont++;
    delay(500);
    Serial.print(".");
  }

  Serial.println("");

  if (cont < max_intentos) {
    Serial.println("**********************************");
    Serial.print("Conectado a la red WiFi:  ");
    Serial.println(WiFi.SSID());
    Serial.print("IP:  ");
    Serial.println(WiFi.localIP());
    Serial.print("macAddress:  ");
    Serial.println(WiFi.macAddress());

    //  Inicio y busco la hora para cotejar en la red
    configTime(gmtOffset_sec, daylightOffset_sec, ntpServer);
    getLocalTime(&timeinfo);
    Serial.println("Busqueda y confirmación de la fecha y hora en la red");
    Serial.print("Fecha: ");
    Serial.println(&timeinfo, "%A, %B %d %Y %H:%M:%S");
    delay(5000);
    Serial.println("***********************************");

    server.on("/", handleRoot);
    server.begin();
    Serial.println("Server HTTP started");
  }

  else {
    Serial.println("----------------------------------");
    Serial.println("Error de Conexión");
    Serial.println("----------------------------------");
  }
  /*
  Analog attenuation:
  ADC_0db: sets no attenuation. ADC can measure up to approximately 800 mV (1V input = ADC reading of 1088).
  ADC_2_5db: The input voltage of ADC will be attenuated, extending the range of measurement to up to approx. 1100 mV. (1V input = ADC reading of 3722).
  ADC_6db: The input voltage of ADC will be attenuated, extending the range of measurement to up to approx. 1350 mV. (1V input = ADC reading of 3033).
  ADC_11db (default): The input voltage of ADC will be attenuated, extending the range of measurement to up to approx. 2600 mV. (1V input = ADC reading of 1575).
  */

  analogSetPinAttenuation(V1, ADC_11db);
  analogSetPinAttenuation(V2, ADC_11db);
  analogSetPinAttenuation(V3, ADC_11db);

  analogSetPinAttenuation(I1, ADC_11db);
  analogSetPinAttenuation(I2, ADC_11db);
  analogSetPinAttenuation(I3, ADC_11db);

  // Phase 1
  emon1.voltage(V1, CV1, 1.732);  // Voltage: input pin, calibration, phase_shift
  emon1.current(I1, CI1);         // Current: input pin, calibration.

  // Phase 2
  emon2.voltage(V2, CV2, 1.732);  // Voltage: input pin, calibration, phase_shift
  emon2.current(I2, CI2);         // Current: input pin, calibration.

  // Phase 3
  emon3.voltage(V3, CV3, 1.732);  // Voltage: input pin, calibration, phase_shift
  emon3.current(I3, CI3);         // Current: input pin, calibration.
}

void loop() {

  // LECTURA DEL RELOJ INTERNO DEL ESP32
  getLocalTime(&timeinfo);
  day = timeinfo.tm_mday;
  month = timeinfo.tm_mon + 1;
  year = timeinfo.tm_year + 1900;
  hour = timeinfo.tm_hour;
  minute = timeinfo.tm_min;
  sec = timeinfo.tm_sec;

  // MEDICION DE TEMPERATURA Y HUMEDAD
  float t = dht.readTemperature();
  float h = dht.readHumidity();

  // LECTURA DEL CAUDALIMETRO
  Sensor.read();
  //float flowRate = Sensor.getFlowRate_m();
  //float volumeMin = Sensor.getVolume();

  // SIMULO ENTRADA DE AGUA CON UN NUMERO RANDOM
  float num1 = random(0, 400);
  flowRate = num1 / 100;
  volumeMin += flowRate / 60;
  volumeHora += flowRate / 60;
  volumeDia += flowRate / 60;
  delay(1000);

  // MEDICION DE CORRIENTE
  int valorADC = analogRead(sensorPin);
  float voltaje = (valorADC / resolucion) * referencia;
  float corriente = (voltaje - 2.5) / sensibilidad;  // Asumiendo 2.5V para 0A

  // MEDICIO CORRIENTE Y VOLTAJE - FASE 1
  emon1.calcVI(120, 200);  // 0Calculate all. No.of half wavelengths (crossings), time-out
  // emon1.serialprint();           // Print out all variables (realpower, apparent power, Vrms, Irms, power factor)

  float realPower = emon1.realPower;          // extract Real Power into variable
  float apparentPower = emon1.apparentPower;  // extract Apparent Power into variable
  float powerFactor = emon1.powerFactor;      // extract Power Factor into Variable
  float supplyVoltage = emon1.Vrms;           // extract Vrms into Variable
  float Irms = emon1.Irms;                    // extract Irms into Variable

  // IMPRIMO MEDICIONES POR SEGUNDO - Para saber como funcionan las mediciones
  // IMPRIMO EN EL DISPLAY LCD 16x2
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print(day);
  lcd.print("/");
  lcd.print(month);
  lcd.print(" - ");
  lcd.print(hour);
  lcd.print(":");
  lcd.print(minute);
  lcd.print(":");
  lcd.print(sec);
  lcd.setCursor(0, 1);
  lcd.print(flowRate);
  lcd.print(" l/m");
  lcd.setCursor(9, 1);
  lcd.print(volumeHora);
  lcd.print(" lt");
  
  //lcd.print("Real Power1: ");
  //lcd.print(realPower);
  //lcd.print("\tApparent Power1: ");
  //lcd.print(apparentPower, 2);
  //lcd.print("\tPower Factor1: ");
  //lcd.print(powerFactor, 3);
  lcd.setCursor(0,1);
  lcd.print(supplyVoltage,0);
  lcd.print(" V - ");
  lcd.print(Irms, 3);
  lcd.print(" A ");

  // IMPRIMO EN EL MONITOR SERIAL
  Serial.print("Hora: ");
  Serial.print(hour);
  Serial.print(":");
  Serial.print(minute);
  Serial.print(":");
  Serial.print(sec);
  Serial.print("\tCaudal: ");
  Serial.print(flowRate);
  Serial.print("\tVolMin: ");
  Serial.print(volumeMin);
  Serial.print("\tVolHora: ");
  Serial.print(volumeHora);
  Serial.print("\tVolDia: ");
  Serial.print(volumeDia);
  Serial.print("\tTemp: ");
  Serial.print(t);
  Serial.print("\tHume: ");
  Serial.print(h);
  
  Serial.print("\tRPow1: ");
  Serial.print(realPower);
  //Serial.print("\tApparent Power1: ");
  //Serial.print(apparentPower, 2);
  Serial.print("\tPFact1: ");
  Serial.print(powerFactor, 3);
  Serial.print("\tV1: ");
  Serial.print(supplyVoltage,0);
  Serial.print(" - I1: ");
  Serial.println(Irms, 3);

  // PONGO EL CONTADOR DE VOLUMEN x DIA EN CERO - cuando cambia la hora
  if (day - dayAnterior > 0) {
    volumeDia = 0;
    dayAnterior = day;
  }

  // PONGO EL CONTADOR DE VOLUMEN x HORA EN CERO - cuando cambia la horaay
  if (hour - hourAnterior > 0) {
    volumeHora = 0;
    hourAnterior = hour;
  }

  // LOOP DE ENVIOS DE DATOS CADA MINUTO
  if (sec < 1) {
    // Reseteo de los contadores del caudalimetro
    flowRateAvg = volumeMin;
    volumeMin = 0;

    Sensor.resetPulse();
    Sensor.resetVolume();

    /*
    // DISPLAY - Pantalla 1 - Fecha y Hora
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("Fecha: ");
    lcd.print(day);
    lcd.print("/");
    lcd.print(month);
    lcd.print("/");
    lcd.print(year);
    lcd.setCursor(0,1);
    lcd.print("Hora: ");
    lcd.print(hour);
    lcd.print(":");
    lcd.print(minute);
    lcd.print(":");
    lcd.print(sec);

    Serial.println("PANTALLA 1 - Fecha y Hora");
    Serial.print("Fecha: ");
    Serial.print(year);
    Serial.print("/");
    Serial.print(month);
    Serial.print("/");
    Serial.println(day);
    Serial.print("Hora: ");
    Serial.print(hour);
    Serial.print(":");
    Serial.print(minute);
    Serial.print(":");
    Serial.println(sec);
    Serial.println("");

    delay(200);

    // DISPLAY - Pantalla 2 - Caudalimetro
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("Volumen Minuto: ");
    lcd.print(flowRateAvg);
    lcd.print(" l/m");
    lcd.setCursor(0,1);
    lcd.print("Volumen Hora: ");
    lcd.print(volumeHora);
 
    Serial.println("PANTALLA 2 - Caudalimetro");
    Serial.print("Volumen Minuto: ");
    Serial.print(flowRateAvg);
    Serial.println(" l/min");
    Serial.print("Volumen Hora: ");
    Serial.print(volumeHora);
    Serial.println(" lt");
    Serial.println("");

    delay(200);

    // DISPLAY - Pantalla 3 - Temperatura y Humedad
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("Temp: ");
    lcd.print(t,2);
    lcd.print(" C");
    lcd.setCursor(0,1);
    lcd.print("Hume: ");
    lcd.print(h,2);
    lcd.print(" %");
       
    Serial.println("PANTALLA 3 - Temperatura y Humedad");
    Serial.print("Temp: ");
    Serial.print(t,2);
    Serial.println(" °C");
    Serial.print("Hume: ");
    Serial.print(h,2);
    Serial.println(" %");
    Serial.println("");

    delay(200);
    Serial.println("");
    Serial.println("*** NUEVA MEDICION ***");
    */

    // ENVIO DATOS AL SERVIDOR
    HTTPClient https;  // Declaro objeto de la clase HTTP
    WiFiClientSecure client;
    client.setInsecure();  // Desactiva la validación del certificado SSL

    String url = host + "?cliente=" + cliente + "&device_label=" + device + "&caudal=" + String(flowRate) + +"&volMin=" + String(flowRateAvg) + "&volHora=" + String(volumeHora) + "&tempe=" + String(t) + "&hume=" + String(h);

    request = url;

    Serial.println("");
    Serial.println("Enviando Solicitud a: " + url);
    Serial.println("");

    https.begin(client, url);
    int httpCode = https.GET();

    if (httpCode > 0) {
      String payload = https.getString();
      Serial.println("Respuesta: " + payload);
      answer = payload;
      Serial.println("");  // deja un espacio para las nuevas mediciones.
    } else {
      Serial.print("Error en HTTPS:  ");
      Serial.println(https.errorToString(httpCode));
    }
    https.end();
    server.handleClient();
  }
}



/*void setup()
{
  Serial.begin(115200);

}

void loop() {

  Serial.println("------------");

  // Phase 1
  emon1.calcVI(120, 2000);  // Calculate all. No.of half wavelengths (crossings), time-out
  // emon1.serialprint();           // Print out all variables (realpower, apparent power, Vrms, Irms, power factor)

  float realPower = emon1.realPower;          // extract Real Power into variable
  float apparentPower = emon1.apparentPower;  // extract Apparent Power into variable
  float powerFactor = emon1.powerFactor;      // extract Power Factor into Variable
  float supplyVoltage = emon1.Vrms;           // extract Vrms into Variable
  float Irms = emon1.Irms;                    // extract Irms into Variable

  Serial.print("Real Power1: ");
  Serial.print(realPower);
  Serial.print("\tApparent Power1: ");
  Serial.print(apparentPower, 2);
  Serial.print("\tPower Factor1: ");
  Serial.print(powerFactor, 3);
  Serial.print("\tV1: ");
  Serial.print(supplyVoltage);
  Serial.print(", I1: ");
  Serial.println(Irms, 3);

  // Phase 2
  emon2.calcVI(120, 2000);  // Calculate all. No.of half wavelengths (crossings), time-out
  // emon2.serialprint();           // Print out all variables (realpower, apparent power, Vrms, Irms, power factor)

  float realPower2 = emon2.realPower;          // extract Real Power into variable
  float apparentPower2 = emon2.apparentPower;  // extract Apparent Power into variable
  float powerFactor2 = emon2.powerFactor;      // extract Power Factor into Variable
  float supplyVoltage2 = emon2.Vrms;           // extract Vrms into Variable
  float Irms2 = emon2.Irms;                    // extract Irms into Variable

  Serial.print("Real Power2: ");
  Serial.print(realPower2);
  Serial.print("\tApparent Power2: ");
  Serial.print(apparentPower2, 2);
  Serial.print("\tPower Factor2: ");
  Serial.print(powerFactor2, 3);
  Serial.print("\tV2: ");
  Serial.print(supplyVoltage2);
  Serial.print(", I2: ");
  Serial.println(Irms2, 3);


  // Phase 3
  emon3.calcVI(120, 2000);  // Calculate all. No.of half wavelengths (crossings), time-out
  // emon2.serialprint();           // Print out all variables (realpower, apparent power, Vrms, Irms, power factor)

  float realPower3 = emon3.realPower;          // extract Real Power into variable
  float apparentPower3 = emon3.apparentPower;  // extract Apparent Power into variable
  float powerFactor3 = emon3.powerFactor;      // extract Power Factor into Variable
  float supplyVoltage3 = emon3.Vrms;           // extract Vrms into Variable
  float Irms3 = emon3.Irms;                    // extract Irms into Variable

  Serial.print("Real Power3: ");
  Serial.print(realPower3);
  Serial.print("\tApparent Power3: ");
  Serial.print(apparentPower3, 2);
  Serial.print("\tPower Factor: ");
  Serial.print(powerFactor3, 3);
  Serial.print("\tV3: ");
  Serial.print(supplyVoltage3);
  Serial.print(", I3: ");
  Serial.println(Irms3, 3);
}

*/
