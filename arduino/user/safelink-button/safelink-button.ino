#include <TinyGPS++.h>         // For NEO6m
#include <SoftwareSerial.h>    // For NEO6m
#include <RH_ASK.h>            // For RF Transmitter
#include <SPI.h>               // Not actually used but needed to compile
#include <Wire.h>              // For I2C communication
// #include <Adafruit_MPU6050.h>  // For MPU6050
// #include <Adafruit_Sensor.h>   // Required for Adafruit sensor library

// GPS Setup
int RXPin = 2;
int TXPin = 3;
int GPSBaud = 9600;

// Pin Setup
int buzzerPin = 7;
int buttonPin = 8;
bool status = false;

// // MPU6050 Setup
// Adafruit_MPU6050 mpu;
// #define THRESHOLD_ACCEL 0.01 // Acceleration threshold (m/s^2)
// #define THRESHOLD_GYRO 1.0   // Gyroscope threshold (degrees/sec)

// Create Objects
TinyGPSPlus gps;
SoftwareSerial gpsSerial(RXPin, TXPin);
RH_ASK driver;

void setup() {
  // Initialize Serial Communication
  Serial.begin(9600);

  // Initialize GPS
  gpsSerial.begin(GPSBaud);

  // Initialize Pins
  pinMode(buzzerPin, OUTPUT);
  pinMode(buttonPin, INPUT);

  // Initialize Transmitter
  if (!driver.init()) {
    Serial.println("RF init failed");
  }

  // // Initialize MPU6050
  // if (!mpu.begin()) {
  //   Serial.println("Failed to find MPU6050 chip");
  //   while (1) delay(10);
  // }
  // mpu.setAccelerometerRange(MPU6050_RANGE_2_G);
  // mpu.setGyroRange(MPU6050_RANGE_250_DEG);
  // mpu.setFilterBandwidth(MPU6050_BAND_21_HZ);

  // Serial.println("System Ready");
}

void loop() {
 

//  Serial.println("Outside Loop");

  // GPS Functionality
  while (gpsSerial.available() > 0) {
    if (gps.encode(gpsSerial.read())) {

    // // MPU6050: Check for Movement
    //   sensors_event_t accel, gyro, temp;
    //   mpu.getEvent(&accel, &gyro, &temp);

    //   // Calculate acceleration magnitude
    //   float accelMagnitude = sqrt(pow(accel.acceleration.x, 2) +
    //                               pow(accel.acceleration.y, 2) +
    //                               pow(accel.acceleration.z, 2)) - 9.81; // Remove gravity
    //   accelMagnitude = abs(accelMagnitude); // Absolute value for movement detection

    //   // Calculate gyroscope magnitude
    //   float gyroMagnitude = sqrt(pow(gyro.gyro.x, 2) +
    //                             pow(gyro.gyro.y, 2) +
    //                             pow(gyro.gyro.z, 2));

    //   // If movement is below thresholds, turn on the buzzer
    //   if (accelMagnitude < THRESHOLD_ACCEL && gyroMagnitude < THRESHOLD_GYRO) {
    //     digitalWrite(buzzerPin, HIGH); // Turn on buzzer
    //     displayInfo();
    //   } else {
    //     digitalWrite(buzzerPin, LOW);  // Turn off buzzer
    //   }

      if (digitalRead(buttonPin) == HIGH) { // Button is pressed
        status = !status;
        digitalWrite(buzzerPin, status); // Turn on buzzer
        Serial.print("Button Pressed");
        if (status == true) {
          displayInfo();
        }
        while (digitalRead(buttonPin) == HIGH){
          delay(50); // Debounce
          }
         
      }
    }
  }

  // No GPS Detected Check
  if (millis() > 5000 && gps.charsProcessed() < 10) {
    Serial.println("No GPS detected");
    while (true);
  }
  
  delay(50);
}

void displayInfo() {
  if (gps.location.isValid()) {
    Serial.print("Latitude: ");
    Serial.println(gps.location.lat(), 6);

    Serial.print("Longitude: ");
    Serial.println(gps.location.lng(), 6);

    char msg[54];
    String latStr = String(gps.location.lat(), 6);
    String lngStr = String(gps.location.lng(), 6);
    const char* latCStr = latStr.c_str();
    const char* lngCStr = lngStr.c_str();
    snprintf(msg, sizeof(msg), "DID: BAG-202400002, Lat: %s, Lon: %s", latCStr, lngCStr);
    msg[strlen(msg)] = '\0'; // Explicitly null-terminate the string
    driver.send((uint8_t *)msg, strlen(msg) + 1); // Include null terminator
    driver.waitPacketSent();
    Serial.println(msg);
  } else {
    const char *msg = "Location: Not Available";
    driver.send((uint8_t *)msg, strlen(msg));
    driver.waitPacketSent();
    Serial.println("Location: Not Available");
  }
  Serial.println();
}


// #include <TinyGPS++.h> // For NEO6m
// #include <SoftwareSerial.h> // For NEO6m

// #include <RH_ASK.h>
// #include <SPI.h> // Not actually used but needed to compile

// // Choose two Arduino pins to use for software serial
// int RXPin = 2;
// int TXPin = 3;

// int buzzerPin = 7;

// int buttonPin = 8;
// int buttonState = 0;
// int status = false;

// int GPSBaud = 9600;

// // Create a TinyGPS++ object
// TinyGPSPlus gps;

// RH_ASK driver;

// // Create a software serial port called "gpsSerial"
// SoftwareSerial gpsSerial(RXPin, TXPin);

// void setup()
// {
//   // Start the Arduino hardware serial port at 9600 baud
//   Serial.begin(9600);

//   pinMode(buzzerPin, OUTPUT);

//   pinMode(buttonPin, INPUT);

//   if (!driver.init()){ // Checks the Transmitter if Executed
//     Serial.println("init failed");
//   }
//   // Start the software serial port at the GPS's default baud
//   gpsSerial.begin(GPSBaud);
// }

// void loop()
// {
//   // This sketch displays information every time a new sentence is correctly encoded.
//   while (gpsSerial.available() > 0){
//     if (gps.encode(gpsSerial.read())){

//     if(digitalRead(buttonPin) == true){
//       status = !status; 
//       digitalWrite(buzzerPin, status);
//       if(status == true){
//         displayInfo();
//       }
//     } while(digitalRead(buttonPin) == true){
//       delay(50);
//     }

//     }
//   }

//   // If 5000 milliseconds pass and there are no characters coming in
//   // over the software serial port, show a "No GPS detected" error
//   if (millis() > 5000 && gps.charsProcessed() < 10)
//   {
//     Serial.println("No GPS detected");
//     while(true);
//   }
// }

// void displayInfo(){
//   if (gps.location.isValid())
//   {
//     Serial.print("Latitude: ");
//     Serial.println(gps.location.lat(),6);
    
//     Serial.print("Longitude: ");
//     Serial.println(gps.location.lng(),6);

//     char msg[54];

//     String latStr = String(gps.location.lat(), 6);
//     String lngStr = String(gps.location.lng(), 6);


//     const char* latCStr = latStr.c_str();
//     const char* lngCStr = lngStr.c_str();

//     snprintf(msg, sizeof(msg), "DID: BAG-202400002, Lat: %s, Lon: %s", latCStr, lngCStr);
//     msg[strlen(msg)] = '\0'; // Explicitly null-terminate the string
//     driver.send((uint8_t *)msg, strlen(msg) + 1); // Include the null terminator in transmission
//     driver.waitPacketSent();

//     Serial.println(msg);

//     delay(50);
//   }
//   else
//   {
//     const char *msg = "Location: Not Available";
//     driver.send((uint8_t *)msg, strlen(msg));
//     driver.waitPacketSent();
//     delay(1000);

//     Serial.print("Location: Not Available");
//   }
 


//   Serial.println();
//   Serial.println();
//   delay(50);
// }
