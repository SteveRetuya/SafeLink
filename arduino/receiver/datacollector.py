import serial

arduino_port = "COM9"  # Replace with your Arduino port
baud_rate = 9600
output_file = "C:/xampp/htdocs/arduino/receiver/logs/log.json"  # Path for XAMPP to serve the data

ser = serial.Serial(arduino_port, baud_rate)

print("Reading data from Arduino...")
while True:
    try:
        line = ser.readline().decode('utf-8').strip()
        print("Raw Data:", line)

        # Parse the data
        if line.startswith("DID:"):
            parts = line.split(", ")
            data = {
                "DID": parts[0].split(": ")[1],
                "Latitude": parts[1].split(": ")[1],
                "Longitude": parts[2].split(": ")[1]
            }

            # Write parsed data to a JSON file
            with open(output_file, "w") as file:
                import json
                json.dump(data, file)

    except KeyboardInterrupt:
        print("\nStopping...")
        ser.close()
        break
    except Exception as e:
        print(f"Error: {e}")

