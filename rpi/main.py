# Some parts adapted from
# https://learn.adafruit.com/drive-a-16x2-lcd-directly-with-a-raspberry-pi/python-code

from get_ip import ip
from time import sleep
from requests import get

import board
import digitalio
import adafruit_character_lcd.character_lcd as characterlcd

def get_message():
    r = get("https://jdranczewski.cba.pl/YouDecideWhoIAm/get.php")
    if r.status_code == 200:
        return r.text
    else:
        return "request.get encountered an issue\n5"

def main():
    # Set the pins being used
    lcd_rs = digitalio.DigitalInOut(board.D22)
    lcd_en = digitalio.DigitalInOut(board.D17)
    lcd_d4 = digitalio.DigitalInOut(board.D25)
    lcd_d5 = digitalio.DigitalInOut(board.D24)
    lcd_d6 = digitalio.DigitalInOut(board.D23)
    lcd_d7 = digitalio.DigitalInOut(board.D18)

    # Setup the lcd
    lcd = characterlcd.Character_LCD_Mono(lcd_rs, lcd_en, lcd_d4, lcd_d5,
                                          lcd_d6, lcd_d7, 16, 2)

    # Show the IP address and blink cursor
    lcd.clear()
    lcd.message = ip()
    lcd.blink = True
    sleep(1)

    while True:
        pass
        # Get a message
        payload = get_message().split("\n")
        text = "\n".join(payload[:-1])
        try:
            timeout = int(payload[-1])
        except ValueError:
            timeout = 5
        # Display the message
        lcd.clear()
        lcd.message = text
        # Allow 10 seconds to cancel
        # Sleep for the designated amount of time


if __name__ == "__main__":
    main()
