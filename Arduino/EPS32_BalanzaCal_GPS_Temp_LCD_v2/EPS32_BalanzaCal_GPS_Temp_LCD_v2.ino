

#include <Arduino.h>
#include <Wire.h>
#include <HX711.h>
#include <EEPROM.h>
#include <SoftwareSerial.h>
#include <TinyGPS.h>
#include <LiquidCrystal_I2C.h>
#include <DHT.h>

/* This sample code demonstrates the normal use of a TinyGPS object.
   It requires the use of SoftwareSerial, and assumes that you have a
   4800-baud serial GPS device hooked up on pins 4(rx) and 3(tx).
*/

#define DHTPIN 4
#define DHTTYPE DHT11
DHT dht (DHTPIN,DHTTYPE);

LiquidCrystal_I2C lcd(0x27,16,2);  // set the LCD address to 0x27 for a 16 chars and 2 line display

const int buttonPin = 23;  // GPIO donde esta conectado el boton de Calibración
const int ledPin = 13;  // led conectado al estado de calibración del boton
volatile int interruptCounter = 0;
volatile bool calibracion = false;
int tiempo = millis()/1000;

void IRAM_ATTR handleInterrupt(){
  interruptCounter++; 
  digitalWrite(ledPin, !digitalRead(ledPin));
  delay(100);
  }

TinyGPS gps;
SoftwareSerial ss(16, 17);

const int DOUT=32;
const int CLK=33;

const long peso_conocido = 820; // gr

int v_ledPin = 0; // estado de calibracion

// Variables Globales
float fcalibracion;
float pesoActual;
int pesoConv;

HX711 balanza;

void calibracionBalanza(){
  long adc_balanza;
  Serial.print("Coloque el peso conocido para calibrar:  ");
  Serial.print(peso_conocido);
  Serial.println(" gr");
  delay(10000);
  adc_balanza = balanza.get_value(100);
  fcalibracion = adc_balanza / peso_conocido;
  Serial.print("Factor de calibración: ");
  Serial.println (fcalibracion);

  // Grabamos en el EEPROM el factor de calibración
  EEPROM.write(0,fcalibracion); // almacena el valor de fcalibracion en la dirección 0
  EEPROM.commit(); // Guarda los cambios en la memoria EEPROM
  Serial.print("");
  Serial.print("Guardando en la EEPROM el nuevo factor de calibración:  ");
  Serial.println(fcalibracion);
  }

void setup() {
  Serial.begin(115200);
  EEPROM.begin(50);
  pinMode(buttonPin, INPUT_PULLDOWN);
  pinMode(ledPin, OUTPUT);
  balanza.begin(DOUT, CLK);
  attachInterrupt(buttonPin,handleInterrupt, RISING);
  ss.begin(9600);
  dht.begin();
  lcd.init();
  lcd.backlight();
  
  Serial.print("Simple TinyGPS library v. "); Serial.println(TinyGPS::library_version());
  Serial.println("by Mikal Hart");
  Serial.println();

  Serial.print("Lectura del valor del ADC:\t");
  Serial.println(balanza.read());
  Serial.println("No ponga ningún objeto sobre la balanza");
  Serial.println("Destarando...");
  Serial.print("Valor del ledPin:  ");
  Serial.println(digitalRead(ledPin));
  balanza.set_scale(); //La escala por defecto es 1
  balanza.tare(20);  //El peso actual es considerado Tara.
  delay(4000);

  if (v_ledPin == 1)
   {
    Serial.println("Calibrando la balanza ... ");
    calibracionBalanza();
    Serial.println("Terminando la Calibración ...");
   }

  // Leemos el valor del EEPROM
  fcalibracion = EEPROM.read(0); // Leemos el valor almacenado en la dirección 0 de la eeprom

  // Establecemos la escala
  balanza.set_scale(fcalibracion);
  Serial.println("");
  Serial.println("****** ESTABLECEMOS LA ESCALA DE LA BALANZA *****");
  Serial.print("Factor de calibración a utilizar (EEPROM): ");
  Serial.println(fcalibracion);
    delay(10000);
   }

void loop() { 
 
  float t = dht.readTemperature();
  float h = dht.readHumidity();

  int v_led = digitalRead(ledPin);
  int tiempo = millis()/1000;
 
  bool newData = false;
  unsigned long chars;
  unsigned short sentences, failed;

  // For one second we parse GPS data and report some key values
  for (unsigned long start = millis(); millis() - start < 1000;)
  {
    while (ss.available())
    {
      char c = ss.read();
      // Serial.write(c); // uncomment this line if you want to see the GPS data flowing
      if (gps.encode(c)) // Did a new valid sentence come in?
        newData = true;
    }
  }

  if (newData)
  {
    float flat, flon;
    unsigned long age;
    int year;
    byte month, day, hour, minute, second, hundredths;
    gps.crack_datetime(&year, &month, &day, &hour, &minute, &second, &hundredths);
    gps.f_get_position(&flat, &flon, &age);

    byte hourc = hour - 3;

float pesoActual = balanza.get_units(10);
  if (pesoActual<0){
    pesoConv=0;}
    else{
      pesoConv = int (pesoActual);
    }
    Serial.println("***** NUEVA MEDICION *****");
    
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
    lcd.print(hourc);
    lcd.print(":");
    lcd.print(minute);
    lcd.print(":");
    lcd.print(second);

    Serial.println("PANTALLA 1 - Fecha y Hora");
    Serial.print("Fecha: ");
    Serial.print(year);
    Serial.print("/");
    Serial.print(month);
    Serial.print("/");
    Serial.println(day);
    Serial.print("Hora: ");
    Serial.print(hourc);
    Serial.print(":");
    Serial.print(minute);
    Serial.print(":");
    Serial.println(second);
    Serial.println("");

    delay(2000);

    // DISPLAY - Pantalla 2 - Peso Balanza
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("Peso:  ");
    lcd.print(pesoConv);
    lcd.print(" gr");
    lcd.setCursor(0,1);
    lcd.print("FC = ");
    lcd.print(fcalibracion);

    Serial.println("PANTALLA 2 - Peso");
    Serial.print("Peso en la balanza: ");
    Serial.print(pesoConv);
    Serial.println(" gr");
    Serial.print ("Factor Calibracion Utilizado: ");
    Serial.println(fcalibracion);
    
    Serial.println("");

    delay(2000);

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

    delay(2000);
    
    // DISPLAY - Pantalla 4 - Posicionamiento
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("LAT = ");
    lcd.print(flat == TinyGPS::GPS_INVALID_F_ANGLE ? 0.0 : flat, 6);
    lcd.setCursor(0,1);
    lcd.print("LON = ");
    lcd.print(flon == TinyGPS::GPS_INVALID_F_ANGLE ? 0.0 : flon, 6);

    Serial.println("PANTALLA 4 - Posicionamiento");
    Serial.print("LAT = ");
    Serial.print(flat == TinyGPS::GPS_INVALID_F_ANGLE ? 0.0 : flat, 6);
    Serial.print("LON = ");
    Serial.println(flon == TinyGPS::GPS_INVALID_F_ANGLE ? 0.0 : flon, 6);
    Serial.println("");

    Serial.print("Coordenadas para google: ");
    Serial.print(flat == TinyGPS::GPS_INVALID_F_ANGLE ? 0.0 : flat, 6);
    Serial.print(", ");
    Serial.println(flon == TinyGPS::GPS_INVALID_F_ANGLE ? 0.0 : flon, 6);
    Serial.println("");
    delay(2000);

    // DISPLAY - PANTALLA 5 - Estado del Led
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("Led 1: ");
    if (v_led == HIGH){
      lcd.print("Encendido");}
      else {lcd.print("Apagado");}

    Serial.println("PANTALLA 5 - Estado del Led");  
    Serial.print("Tiempo: ");
    Serial.print(tiempo);
    Serial.println(" seg");
    Serial.print("Estado del Led: ");
    Serial.print("\t");
    if (v_led == HIGH){
      Serial.println("Encendido");}
      else {Serial.println("Apagado");}
    Serial.println("");

    delay(2000);

  }

  gps.stats(&chars, &sentences, &failed);
   if (chars == 0)
    Serial.println("** No characters received from GPS: check wiring **");

}
 

/*

void setup()
{
  
}

void loop()
{
  bool newData = false;
  unsigned long chars;
  unsigned short sentences, failed;

  // For one second we parse GPS data and report some key values
  for (unsigned long start = millis(); millis() - start < 1000;)
  {
    while (ss.available())
    {
      char c = ss.read();
      // Serial.write(c); // uncomment this line if you want to see the GPS data flowing
      if (gps.encode(c)) // Did a new valid sentence come in?
        newData = true;
    }
  }

  if (newData)
  {
    float flat, flon;
    unsigned long age;
    gps.f_get_position(&flat, &flon, &age);
    Serial.print("LAT=");
    Serial.print(flat == TinyGPS::GPS_INVALID_F_ANGLE ? 0.0 : flat, 6);
    Serial.print(" LON=");
    Serial.print(flon == TinyGPS::GPS_INVALID_F_ANGLE ? 0.0 : flon, 6);
    Serial.print(" SAT=");
    Serial.print(gps.satellites() == TinyGPS::GPS_INVALID_SATELLITES ? 0 : gps.satellites());
    Serial.print(" PREC=");
    Serial.print(gps.hdop() == TinyGPS::GPS_INVALID_HDOP ? 0 : gps.hdop());
  }
  
  gps.stats(&chars, &sentences, &failed);
  Serial.print(" CHARS=");
  Serial.print(chars);
  Serial.print(" SENTENCES=");
  Serial.print(sentences);
  Serial.print(" CSUM ERR=");
  Serial.println(failed);
  if (chars == 0)
    Serial.println("** No characters received from GPS: check wiring **");
}
 */




