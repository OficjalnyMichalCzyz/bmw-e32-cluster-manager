import serial
import time
import sys

ser = serial.Serial(
    port='COM9',
    baudrate=9600,
    parity=serial.PARITY_NONE,
    stopbits=serial.STOPBITS_ONE,
    bytesize=serial.EIGHTBITS,
    timeout=1
)

if ser.isOpen():
    print(ser.name + ' is open...')

value = "AAAAAAAAAAAAAAAA"

while True:  # value > -1 and value < 10:
    print(value.ljust(16, ' ').encode('utf-8'))
    ser.write(value.ljust(16, ' ').encode('utf-8'))
    time.sleep(1)
    f = open("VirtualLCD.txt", "r")
    value = (f.readline())
    f.close()