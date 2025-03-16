import time
import bambulabs_api as bl  # Note the underscore and the 's'
import sys
import os
print(f"Python version: {sys.version}")
print(f"Python path: {sys.executable}")
print(f"Module search paths: {sys.path}")

IP = os.getenv('BAMBULABS_IP')
SERIAL = os.getenv('BAMBULABS_SERIAL')
ACCESS_CODE = os.getenv('BAMBULABS_ACCESS_CODE')

def main():
    print('Starting bambulab_api example')
    print('Connecting to Bambu Lab 3D printer')
    print(f'IP: {IP}')
    print(f'Serial: {SERIAL}')
    print(f'Access Code: {ACCESS_CODE}')
    
    try:
        # Create a new instance of the API
        printer = bl.Printer(IP, ACCESS_CODE, SERIAL)
        
        # Connect to the Bambu Lab 3D printer
        printer.connect()
        
        time.sleep(2)
        
        # Get the printer status
        status = printer.get_state()
        print(f'Printer status: {status}')
        
        # Turn the light off
        printer.turn_light_off()
        
        time.sleep(2)
        
        # Turn the light on
        printer.turn_light_on()
        
        # Disconnect from the Bambu Lab 3D printer
        printer.disconnect()
        
        return status
    except Exception as e:
        print(f"Error connecting to printer: {str(e)}")
        return None

if __name__ == '__main__':
    main()