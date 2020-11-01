import time
import RPi.GPIO as GPIO
import datetime
import mysql.connector
from pytz import timezone
from mfrc522 import SimpleMFRC522

db = mysql.connector.connect(
    host="localhost",
    user="username",
    passwd="password",
    database="your_database"
)

cursor = db.cursor()
reader = SimpleMFRC522()
buzzer = 23
green_led = 21
yellow_led = 20
red_led = 16
current_time = datetime.datetime.now(timezone('Asia/Jakarta')).hour


def buzz_setup():
  GPIO.setup(buzzer, GPIO.OUT)


def buzz_and_led(color, duration):
  GPIO.cleanup()
  GPIO.setmode(GPIO.BCM)
  GPIO.setup(color, GPIO.OUT)
  buzz_setup()
  GPIO.output(buzzer, GPIO.HIGH)
  GPIO.output(color, GPIO.HIGH)
  time.sleep(duration)
  GPIO.output(color, GPIO.LOW)
  GPIO.output(buzzer, GPIO.LOW)
  time.sleep(duration)

def blink_led(duration, color):
  GPIO.cleanup()
  GPIO.setmode(GPIO.BCM)
  GPIO.setup(color, GPIO.OUT)
  GPIO.output(color, GPIO.HIGH)
  time.sleep(duration)
  GPIO.output(color, GPIO.LOW)


try:
    while True:
        GPIO.cleanup()
        GPIO.setmode(GPIO.BCM)
        GPIO.setup(red_led, GPIO.OUT)
        GPIO.output(red_led, GPIO.HIGH)
        print('Tempel kartu untuk absen')
        id, text = reader.read()

        cursor.execute(f'Select id, nama FROM t_murid WHERE rfid_uid={str(id)}')
        result = cursor.fetchone()

        if cursor.rowcount >= 1:
          cursor.execute(f'select day(date(jam_masuk)) from t_kehadiran where id_siswa={result[0]}')
          existing_data = cursor.fetchall()

          if existing_data == []:
            print("Selamat datang " + result[1])
            cursor.execute(
                f'INSERT INTO t_kehadiran (id_siswa) VALUES ({result[0]})')
            db.commit()
            buzz_and_led(green_led, 0.5)

          elif 12 >= int(current_time) <= 15:
            cursor.execute(f'UPDATE t_kehadiran set jam_keluar = CURRENT_TIMESTAMP(), status_kehadiran="Izin" WHERE id_siswa={result[0]}')
            db.commit()
            print('Terima kasih anda telah checkout')
            buzz_and_led(green_led, 0.5)

          elif int(current_time) >= 15:
            cursor.execute(f'UPDATE t_kehadiran set jam_keluar = CURRENT_TIMESTAMP(), status_kehadiran="Hadir" WHERE id_siswa={result[0]}')
            db.commit()
            print('Terima kasih anda telah checkout')
            buzz_and_led(green_led, 0.5)

          else:
            print('anda sudah absen hari ini silahkan kembali lagi nanti')
            buzz_and_led(yellow_led, 0.5)
            
        else:
          print("Kartu RFID anda belum terdaftar, silahkan daftar ke staf administrasi terlebih dahulu.")
          buzz_and_led(red_led, 0.3)
          buzz_and_led(red_led, 0.3)
          buzz_and_led(red_led, 0.3)
          buzz_and_led(red_led, 0.3)
          
        time.sleep(1)
except KeyboardInterrupt:
    GPIO.cleanup()
finally:
  GPIO.cleanup()

