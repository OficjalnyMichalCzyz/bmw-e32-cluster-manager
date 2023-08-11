import RPi.GPIO as GPIO
import time

GPIO.setmode(GPIO.BOARD)

GPIO.setup(18, GPIO.IN)

while True:
    if GPIO.input(18) == GPIO.HIGH:
        with open("VirtualIbus.txt", "w") as file:
            file.write("BC_STALK_BUTTON")
    time.sleep(0.1)
